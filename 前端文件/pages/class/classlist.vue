<template>
	<view>
		<view>
			<view class="white">
			<u-dropdown>
				<u-dropdown-item v-model="value0" :title= f_Year :options="year" @change="yearchange"></u-dropdown-item>
				<u-dropdown-item v-model="value1" :title= f_Grade :options="grade" @change="gradeclose"></u-dropdown-item>
			</u-dropdown></view>
			<u-table>
				<u-tr>
					<u-th>名称</u-th>
					<u-th>年级</u-th>
					<u-th>班级</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr v-for="(item,index) in classlist" :key="index">
					<u-td v-text="item.cName"></u-td>
					<u-td v-text="item.cGrade"></u-td>
					<u-td v-text="item.cNumber"></u-td>
					<u-td>
						<u-button @click="btn_change(index)">删除</u-button>
					</u-td>
				</u-tr>
			</u-table>
		</view>
	</view>
</template>

<script>
	export default{
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
		data(){
			return{
				f_Year: '年份',
				f_Grade: '年级',
				value0: 0,
				value1: 0,
				value2: 0,
				year:[],
				mask_show: false,
				is_show:false,
				chooseyearvalue1: -1,
				grade_index: -1,
				form:{
					cname:'',
					cgrade:'',
					cnumber:'',
					cid:'',
					cis:'',
				},
				grade: getApp().globalData.gradeforlabel,
				islist:[
					{
						text: '可用'
					},
					{
						text: '不可用'
					},
				],
				classlist:[],
			}
		},
		methods:{
			yearchange: function(index){
				this.chooseyearvalue1 = index;
				this.f_Year = this.year[index-1].label,
				this.f_Grade = '请选择年级'
			},
			gradeclose: function(index){
				if(this.f_Year == "年份"){
					this.f_Year = "请选择年份"
				}else{
					this.grade_index = index,
					this.f_Grade = this.grade[index-1].label,
					this.classlist = undefined,
					this.classlist = new Array();
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
						data:{
							type: 'searchall_Y_G',
							year: this.f_Year,
							grade: index
						},
						success: res => {
							for (var s = 0; s < res.data.length; s++) {
								if (res.data[s].cYear == this.year[this.chooseyearvalue1-1].label) {
									this.classlist.push(res.data[s])
								}
							}
						}
					})
				}
				
			},
			btn_change: function(e) {
				uni.showModal({
					title:'警告,此操作不可回退',
					success: (res) => {
						if(res.confirm){
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/PHP.php",
								data:{
									type:'try',
									sql:"update class set cIs = 'false' where cId = '"+this.classlist[e].cId+"'"
								},
								success: (res) => {
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/PHP.php",
										data:{
											type:'try',
											sql:"update studentinfo set sIs = 'false' where cId = '"+this.classlist[e].cId+"'"
										},
										success: (res) => {
											uni.request({
												url: "https://www.sykdesign.xyz/phpbin/PHP.php",
												data:{
													type:'try',
													sql:"update tcinfo set tcIs = 'false' where cId = '"+this.classlist[e].cId+"'"
												},
												success: (res) => {
													this.flash()
												}})
										}})
								}
							})
						}
					}
				})
			},
			flash:function(){
				this.f_Grade = this.grade[this.grade_index-1].label,
				this.classlist = undefined,
				this.classlist = new Array();
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
					data:{
						type: 'searchall_Y_G',
						year: this.f_Year,
						grade: this.grade_index
					},
					success: res => {
						for (var s = 0; s < res.data.length; s++) {
							if (res.data[s].cYear == this.year[this.chooseyearvalue1-1].label) {
								this.classlist.push(res.data[s])
							}
						}
					}
				})
			}
		}
	}
</script>

<style>
	.warp {
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
	}
	
	.rect {
		background-color: #fff;
	}
</style>
