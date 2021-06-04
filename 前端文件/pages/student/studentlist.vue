<template>
	<view>
		<view>
			<view class="white">
			<u-dropdown>
				<u-dropdown-item v-model="value0" :title= f_Year :options="year" @change="yearchange"></u-dropdown-item>
				<u-dropdown-item v-model="value1" :title= f_Grade :options="grade" @change="gradechange"></u-dropdown-item>
				<u-dropdown-item v-model="value2" :title= f_Number :options="number" @change="numberclose"></u-dropdown-item>
			</u-dropdown></view>
			<u-table>
				<u-tr>
					<u-th>姓名</u-th>
					<u-th>学号</u-th>
					<u-th>性别</u-th>
					<u-th>家长</u-th>
					<u-th>状态</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr v-for="(item,index) in studentlist" :key="index">
					<u-td v-text="item.sName"></u-td>
					<u-td ><text style="word-break:break-all;">{{item.sId}}</text></u-td>
					<u-td v-text="item.sSex"></u-td>
					<u-td v-text="item.sPname"></u-td>
					<u-td v-text="item.sIs =='true'? '可用' :'不可用'"></u-td>
					<u-td>
						<u-button @click="btn_change(index)">修改</u-button>
					</u-td>
				</u-tr>
			</u-table>
			<u-button @click="gotoadd" v-show="btn_add" size="medium" class="H_T_button">新增学生</u-button>
			<u-button @click="gotoadd" v-show="!btn_add" size="medium" class="H_T_button">新增学生</u-button>
		</view>
		<view>
			<u-mask :show="mask_show" @click="is_mask_show">
				<view class="warp">
					<view class="rect" @tap.stop>
						<u-form :model="form" label-width="auto" ref="uForm">
							<u-form-item label="学生姓名:" prop="sname">
								<u-input v-model="form.sname"/>
							</u-form-item>
							<u-form-item label="学生学号:">
								<u-input disabled="true" :placeholder="form.sid" />
							</u-form-item>
							<u-form-item label="学生家长:" prop="pname">
								<u-input v-model="form.pname"/>
							</u-form-item>
							<u-form-item label="学生性别:" prop="ssex">
								<u-input v-model="form.ssex" type="select" @click="sex_show=true" />
								<u-action-sheet :list="ssexlist" v-model="sex_show" @click="sex_sheet"></u-action-sheet>
							</u-form-item>
							<u-form-item label="学生状态:" prop="sis">
								<u-input v-model="form.sis" type="select" @click="is_show=true" />
								<u-action-sheet :list="islist" v-model="is_show" @click="is_sheet"></u-action-sheet>
							</u-form-item>
							<u-form-item>
								<u-button size="medium" @click="submit" type="button">确认修改</u-button>
								<u-button size="medium" @click="submit2" type="button">解除绑定</u-button>
							</u-form-item>
						</u-form>
					</view>
				</view>
			</u-mask>
		</view>
	</view>
</template>

<script>
	export default {
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		onLoad() {
			uni.request({
				url:"https://www.sykdesign.xyz/phpbin/Yinfo.php",
				data:{
					type: 'get_label'
				},
				success: res => {
					this.year = res.data
					console.log(this.year)
				}
			})
		},
		data() {
			return {
				choosegrade:0,
				choosenumber:0,
				num_index: -1,
				btn_add: false,
				f_Year: '年份',
				f_Grade: '年级',
				f_Number: '班级',
				form: {
					cid: '',
					sid: '',
					sname: '',
					ssex: '',
					pname:'',
					sis:'',
					openid:''
				},
				mask_show: false,
				sex_show:false,
				is_show:false,
				value0: 0,
				value1: 0,
				value2: 0,
				choosegradevalue1: 1,
				chooseyearvalue1: 1,
				studentlist: [],
				number: [],
				year: [],
				grade: getApp().globalData.gradeforlabel,
				ssexlist: [{
						text: '男'
					},
					{
						text: '女'
					}
				],
				islist:[
					{
						text: '可用'
					},
					{
						text: '不可用'
					},
				],
				rules: {
					pname: [{
						required: true,
						message: '请输入家长姓名',
						trigger: ['change', 'blur']
					}],
					sname: [{
						required: true,
						message: '请输入姓名',
						trigger: ['change', 'blur']
					}],
					ssex: [{
						required: true,
						message: '请选择性别',
						trigger: ['change', 'blur']
					}],
				}
			}
		},
		methods: {
			yearchange: function(index){
				this.chooseyearvalue1 = index;
				this.f_Year = this.year[index-1].label,
				this.f_Grade = '请选择年级'
				this.f_Number = '请选择班级'
			},
			gradechange: function(index) {
				this.number = undefined,
					this.number = new Array();
				this.choosegradevalue1 = index;
				this.f_Grade = this.grade[index-1].label,
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
					data: {
						type: "searchall_Y",
						year: this.f_Year,
					},
					success: res => {
						console.log(this.f_Year)
						var count = 1;
						this.classlist = [],
						res.data.sort(this.$arrySort('cNumber'))
						for (var i = 0; i < res.data.length; i++) {
							if (res.data[i].cGrade == index) {
								this.number.push({
										label: res.data[i].cNumber + '班',
										value: count
									}),
									count++
							}
						}
					},
				})
				this.studentlist = undefined,
				this.studentlist = new Array();
				this.f_Number = '请选择班级'
			},
			numberclose: function(index) {
				this.studentlist = undefined,
					this.studentlist = new Array();
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Sinfo.php",
					data: { type: "searchfortable" },
					success: res => {
						for (var s = 0; s < res.data.length; s++) {
							if (res.data[s].cGrade == this.choosegradevalue1) {
								if (res.data[s].cNumber == index) {
									this.studentlist.push(res.data[s])
								}
							}
						}
					}
				})
				this.num_index = index,
				this.f_Number = this.number[index-1].label,
				this.btn_add = true
				this.choosegrade = this.$grade(this.f_Grade)
				this.choosenumber = parseInt(this.f_Number.substr(0,1))
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type:'string',
						sql: "select * from class where cYear = '"+this.f_Year+"' and cGrade ='"+this.choosegrade+"' and cNumber = '"+this.choosenumber+"'"
					},
					success:(res) =>{
						console.log(res.data)
						console.log(this.f_Year)
						console.log(this.$grade(this.f_Grade))
						console.log(parseInt(this.f_Number.substr(0,1)))
						this.form.cid = res.data.cId
					}
				})
			},
			btn_change: function(e) {
				this.mask_show = true,
				this.form.sname = this.studentlist[e].sName,
				this.form.sid = this.studentlist[e].sId,
				this.form.pname = this.studentlist[e].sPname,
				this.form.ssex = this.studentlist[e].sSex,
				this.form.sis = this.studentlist[e].sIs == 'true'? '可用':'不可用',
				this.form.openid = this.studentlist[e].pOpenid
				
			},
			sex_sheet: function(index) {
				this.form.ssex = this.ssexlist[index].text;
			},
			is_sheet: function(index){
				this.form.sis = this.islist[index].text;
			},
			is_mask_show:function(){
				this.mask_show = false
			},
			gotoadd:function(){
				uni.setStorageSync('mycid',this.form.cid)
				uni.navigateTo({
					url:"./addstudent"
				})
			},
			flash:function(){
				this.studentlist = undefined,
					this.studentlist = new Array();
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Sinfo.php",
					data: { type: "searchfortable" },
					success: res => {
						for (var s = 0; s < res.data.length; s++) {
							if (res.data[s].cGrade == this.choosegradevalue1) {
								if (res.data[s].cNumber == this.num_index) {
									this.studentlist.push(res.data[s])
								}
							}
						}
					}
				})
			},
			submit:function(){
				this.$refs.uForm.validate(valid => {
					if(valid){
						console.log("suc")
						uni.request({
							url:"https://www.sykdesign.xyz/phpbin/Sinfo.php",
							data:{
								type: "updateStu",
								sname: this.form.sname,
								pname: this.form.pname,
								sex: this.form.ssex,
								sis: this.form.sis == '可用'?'true':'false',
								sid: this.form.sid,
							},
							success: res => {
								uni.showModal({
									title: "成功",
									success: res => {
										if (res.confirm) {
											this.is_mask_show()
										}
									}
								})
							}
						})
					}
				}),
				this.flash()
			},
			submit2:function(index){
				uni.showModal({
					title:'警告',
					content:'解除绑定将删除该家长全部信息',
					success: (res) => {
						if(res.confirm){
							uni.request({
								url:"https://www.sykdesign.xyz/phpbin/PHP.php",
								data:{
									type:'try',
									sql:"update studentinfo set sPname = NULL , pOpenid = NULL where sId = '"+this.form.sid+"'"
								},
								success: () => {
									this.mask_show = false
									this.flash()
									uni.request({
										url:"https://www.sykdesign.xyz/phpbin/PHP.php",
										data:{
											type:'try',
											sql:"update parentinfo set pIs = 'false' where pOpenid = '"+this.form.openid+"'"
										},
										success: () => {
											this.mask_show = false,
											this.flash()
										}
										})
								}
							})
						}
					}
				})
			}
		}
	}
</script>

<style>

</style>
