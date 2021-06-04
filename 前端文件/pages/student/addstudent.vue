<template>
	<view class="body white first_warp form_top">
	<u-form :model="form" label-width="auto" ref="uForm">
		<u-form-item label="年份:" prop="year">
			<u-input v-model="form.year" type="select" @click="y_show=true" placeholder="请选择年份"/>
			<u-action-sheet :list="yearlist" v-model="y_show" @click="y_actionSheetCallback"></u-action-sheet>
		</u-form-item>
		<u-form-item label="年级:" prop="grade">
			<u-input v-model="form.grade" type="select" @click="g_click" placeholder="请选择年级"/>
			<u-action-sheet :list="gradelist" v-model="g_show" @click="g_actionSheetCallback"></u-action-sheet>
		</u-form-item>
		<u-form-item label="班级:" prop="class">
			<u-input v-model="form.class" type="select" @click="c_click" placeholder="请选择班级"/>
			<u-action-sheet :list="classlist" v-model="c_show" @click="c_actionSheetCallback"></u-action-sheet>
		</u-form-item>
		<u-form-item label="姓名:" prop="sname">
			<u-input v-model="form.sname" />
		</u-form-item>
		<u-form-item label="性别:" prop="ssex">
			<u-input v-model="form.ssex" type="select" @click="s_show=true" placeholder="请选择性别" />
			<u-action-sheet :list="ssexlist" v-model="s_show" @click="s_actionSheetCallback"></u-action-sheet>
		</u-form-item>
		<u-form-item>
			<u-button size="medium" @click="submit">提交</u-button>
			<u-button size="medium" @click="back">返回首页</u-button>
		</u-form-item>
	</u-form></view>
</template>

<script>
	let app = getApp()
	export default {
		onLoad() {
			uni.request({
				url:"https://www.sykdesign.xyz/phpbin/Yinfo.php",
				data:{
					type: 'get_text'
				},
				success: res => {
					this.yearlist = res.data
					console.log(this.year)
				}
			})
		},
		onShow() {
			this.form.cid = uni.getStorageSync('mycid'),
			console.log(this.form.cid)
			if(this.form.cid == ''){
				
			}else{
				uni.request({
					url:"https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type:'string',
						sql: "select * from class where cIs = 'true' and cId = '"+this.form.cid+"'"
					},
					success: (res) => {
						console.log(res.data)
						this.form.year = res.data.cYear,
						this.form.grade = this.gradelist[res.data.cGrade-1].text,
						this.form.class = res.data.cNumber
					}
				})
			}
		},
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		data() {
			return {
				ssexlist: [{
						text: '男'
					},
					{
						text: '女'
					}
				],
				scount:0,
				makeid:'',
				yearlist: [],
				gradelist:app.globalData.gradeforselect,
				classlist:[],
				g_index: -1,
				s_show: false,
				y_show: false,
				g_show: false,
				c_show: false,
				form: {
					year: '',
					grade: '',
					class: '',
					cid: '',
					sid: '',
					sname: '',
					ssex: ''
				},
				rules: {
					cid: [{
						required: true,
						message: '请输入班级',
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
			g_click:function(){
				if(this.form.year== '')
				{
					uni.showToast({
						title: "请先选择年份",
						icon: 'none',
						duration: 1000
					})
				}else{
					this.g_show=true
				}
			},
			c_click:function(){
				if(this.form.year!= '' && this.form.grade!='')
				{
					this.c_show=true
				}else{
					uni.showToast({
						title: "请选择年份和年级",
						icon: 'none',
						duration: 1000
					})
				}
			},
			s_actionSheetCallback: function(index) {
				this.form.ssex = this.ssexlist[index].text;
			},
			g_actionSheetCallback: function(index){
					this.form.grade = this.gradelist[index].text;
					this.g_index = index+1,
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
						data: {
							type: "searchall_Y",
							year: this.form.year,
						},
						success: res => {
							var count = 1;
							this.classlist = [],
							res.data.sort(this.$arrySort('cNumber'))
							console.log(res.data)
							for (var i = 0; i < res.data.length; i++) {
								if (res.data[i].cGrade == index+1) {
									this.classlist.push({
											text: res.data[i].cNumber + '班',
											value: count
										}),
										count++
								}
							}
						},
					})
			},
			c_actionSheetCallback: function(index){
					this.form.class = this.classlist[index].text;
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
						data: {
							type:'search_cid',
							year: this.form.year,
							grade: this.g_index,
							number: this.form.class.substr(0,1),
						},
						success: res =>{
							this.form.cid = res.data.cId
						}
					})	
			},
			y_actionSheetCallback: function(index){
				this.form.year = this.yearlist[index].text;
			},
			sid_make:function(){
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from studentinfo where cId = '" + this.form.cid +
							"'"
					},
					success: (res) => {
						console.log(res.data)
						this.scount = res.data.length+1,
						this.scount = this.scount/1000+'',
						this.scount = this.scount.split('.').join('')
						this.makeid = this.form.year.substr(2,4) + this.$grade(this.form.grade) + this.form.class.substr(0,1) +uni.getStorageSync('mycid').substr(2,2)+ this.scount,
						console.log(this.makeid)
					}
				})
				
			},
			submit: function() {
				this.$refs.uForm.validate(valid => {
					if (valid) {
						this.sid_make()
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Sinfo.php",
							data: {
								type: "searchall",
								sid: this.makeid
							},
							success: res => {
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/PHP.php",
										data: {
											type: "try",
											sql : "insert into studentinfo (sName,sSex,sId,cId) VALUES ('" +this.form.sname+"','"+this.form.ssex+"','"+this.makeid+"','"+this.form.cid+"')"
										},
										success: res => {
											uni.showToast({
													title: "成功"
												}),
												this.form.sname = '',
												this.form.sid = '',
												this.form.ssex = ''
										}
									})
							}
						})
					}
				})
			},
			back: function() {
				uni.switchTab({
					url:"../class/tclass",
					success: () => {
						///获取作为教师的班级id
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
							data: {
								type: 'searchall',
								openid: uni.getStorageSync('openid')
							},
							success: (res) => {
								uni.setStorageSync("allcid", res.data)
							}
						})
					}
				})
			}
		}
	}
</script>

<style>
</style>
