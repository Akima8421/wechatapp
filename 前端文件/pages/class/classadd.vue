<template>
	<view class="ca_body body white first_warp form_top">
	<u-form :model="form" label-width="auto" ref="uForm">
		<u-form-item label="年份:" prop="year">
			<!-- <u-input v-model="form.year" type="select" @click="y_show=true" placeholder="请选择年份" />
			<u-action-sheet :list="yearlist" v-model="y_show" @click="y_actionSheetCallback"></u-action-sheet> -->
			<u-input v-model="form.year" disabled="true" inputAlign="center"/>
		</u-form-item>
		<u-form-item label="年级:" prop="grade">
			<u-input v-model="form.grade_text" type="select" @click="g_click" placeholder="请选择年级" @input="getinput(index,$event)" inputAlign="center"/>
			<u-action-sheet :list="gradelist" v-model="g_show" @click="g_actionSheetCallback" ></u-action-sheet>
		</u-form-item>
		<u-form-item label="班级名称:" prop="cname">
			<u-input v-model="form.cname" type="text" placeholder="一年一班" disabled="true" inputAlign="center"/>
		</u-form-item>
		<view class="addbtn">
			<u-row gutter="50">
						<u-col span="6">
							<u-button size="medium" @click="submit" >创建</u-button>
						</u-col>
						<u-col span="6">
							<u-button size="medium" @click="back" >返回</u-button>
						</u-col>
			</u-row>
			</view>
	</u-form>
	</view>
</template>

<script>
	import nowdate from '../tabbar.js'
	let app = getApp()
	export default {
		onShow() {
			this.form.year = nowdate.getDate2().substr(0,4)
			this.form.number = 0
		},
		onLoad() {
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/Yinfo.php",
				data: {
					type: 'get_text'
				},
				success: res => {
					this.yearlist = res.data
					this.form.number = 0
				}
			})
		},
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		data() {
			return {
				fakegrade:'',
				classid:'',
				yearlist: [],
				gradelist:app.globalData.gradeforselect,
				y_show: false,
				g_show: false,
				form:{
					year:'',
					grade_text:'',
					grade_sub:'',
					number: '',
					cname:''
				},
				rules: {
					year: [{
						required: true,
						message: '请选择年份',
						trigger: ['change', 'blur']
					}],
					cname:[{
						required: true,
						message: '请输入',
						trigger: ['change', 'blur']
					}]
				}
			}
		},
		methods: {
			getinput(index, e) {
				if(this.form.number == ''){
					
				}else{
					this.form.cname = this.$cname(this.form.grade_sub,this.form.number)
				}
			},
			// getinput2(index, e) {
			// 	if(this.form.grade_text == ''){
					
			// 	}else{
			// 		this.form.cname = this.$cname(this.form.grade_sub,this.form.number)
			// 	}
			// },
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
			y_actionSheetCallback: function(index) {
				this.form.year = this.yearlist[index].text;
			},
			g_actionSheetCallback: function(index) {
				this.fakegrade = this.$grade(this.gradelist[index].text);
				uni.request({
					url:"https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type: 'array',
						sql:"select * from class where cYear = '"+this.form.year+"' and cGrade = '"+this.fakegrade+"'"
					},
					success: (res) => {
						console.log(res.data)
						this.form.number = res.data.length + 1
						console.log(this.form.number)
						this.form.grade_text = this.gradelist[index].text;
						this.form.grade_sub = this.$grade(this.gradelist[index].text);
					}})
				
			},
			submit: function() {
				this.$refs.uForm.validate(valid => {
					if (valid) {
						uni.request({
							url:"https://www.sykdesign.xyz/phpbin/Cinfo.php",
							data:{
								type: 'search_cid',
								year:this.form.year,
								grade:this.form.grade_sub,
								number:this.form.number,
							},
							success: res => {
								if(res.data == null){
									uni.request({
										url:"https://www.sykdesign.xyz/phpbin/Cinfo.php",
										data:{
											type: 'classadd',
											year:this.form.year,
											grade:this.form.grade_sub,
											number:this.form.number,
											cname:this.form.cname
										},
										success: res => {
											this.classid = res.data.cId
											uni.request({
												url:"https://www.sykdesign.xyz/phpbin/TCinfo.php",
												data:{
													type: 'tcadd',
													openid: uni.getStorageSync("openid"),
													role: uni.getStorageSync("role"),
													cid: this.classid,
													obj: uni.getStorageSync("sub")
												},
												success: res => {
													uni.showModal({
														title:'班级创建成功',
														cancelText: '返回',
														confirmText: '添加教师',
														success: res => {
														        if (res.confirm) {
																	uni.setStorageSync('mycid',this.classid)
																	uni.navigateTo({
																		url:"../teacher/tcadd"
																	})
														        } else if (res.cancel) {
														            uni.navigateBack({
														            	delta: 1
														            })
														        }
														    }
													})
												}
											})
										}
									})
								}else{
									uni.showToast({
										title: "班级存在"
									})
								}
							}
						})
					}
				})
			},
			back:function(){
				uni.navigateBack({
					delta: 1
				})
			}
		},
	}
</script>

<style>
	.ca_body{
		text-align: center;
	}
</style>
