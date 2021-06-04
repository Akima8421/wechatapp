<template>
	<view class="">
	<view class="body first_warp white form_top">
		<u-form :model="form" label-width="auto" ref="uForm">
			<u-form-item label="真实姓名:" prop="realname" >
				<u-input v-model="form.realname" />
			</u-form-item>
			<u-form-item label="手机号码:" prop="phone">
				<u-input v-model="form.phone" type="number" />
			</u-form-item>
			<u-form-item label="性别:" prop="sex">
				<u-input v-model="form.sex" type="select" @click="s_show=true" placeholder="请选择性别" />
				<u-action-sheet :list="sexlist" v-model="s_show" @click="s_actionSheetCallback"></u-action-sheet>
			</u-form-item>
			<u-form-item label="身份:" prop="role">
				<u-input v-model="form.role" type="select" @click="r_show=true" placeholder="请选择身份" />
				<u-action-sheet :list="rolelist" v-model="r_show" @click="r_actionSheetCallback"></u-action-sheet>
			</u-form-item>
			<u-form-item label="学生姓名:" prop="sname" v-show="isp">
				<u-input v-model="form.sname" />
			</u-form-item>
			<u-form-item label="学生学号:" prop="sid" v-show="isp">
				<u-input v-model="form.sid" type="number" />
			</u-form-item>
			<u-form-item label="担任科目:" prop="sub" v-show="ist">
				<u-input v-model="form.sub" type="select" @click="sub_show=true" placeholder="请选择科目" />
				<u-action-sheet :list="sublist" v-model="sub_show" @click="sub_actionSheetCallback"></u-action-sheet>
			</u-form-item>
		</u-form>
		<u-button size="default" @click="submit">注册</u-button>
	</view></view>
</template>

<script>
	import {teacherUser} from'../tabbar.js'
	import {parentUser} from'../tabbar.js'
	let app = getApp()
	var that 
	export default {
		onLoad(options) {	
			this.restu = options.restu
			console.log(this.restu)
			uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Pinfo.php",
					data: {
						type: "searchall",
						"openid": uni.getStorageSync("openid")
					},
					success: res => {
						if (res.data != null) {
							this.p_is = res.data.pRole
							console.log(this.p_is)
						}else{
						this.p_is = ''
						console.log(this.p_is)
					}
					}
				})
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/Tinfo.php",
				data: {
					"type": "searchall",
					"openid": uni.getStorageSync("openid")
				},
				success: res => {
					if (res.data != null) {
						this.t_is = res.data.tRole
						console.log(this.t_is)
					}else{
						this.t_is = ''
						console.log(this.t_is)
					}
				}
			})
		},
		onReady() {
			this.$refs.uForm.setRules(this.rules)
			// if(this.p_is != null){
			// 	if(this.t_is != null){
			// 		uni.showModal({
			// 			title: '您已注册两个身份的账号',
			// 			content: '请选择一个身份进入小程序',
			// 			cancelText: '家长',
			// 			confirmText: '教师',
			// 			success: res => {
			// 			        if (res.confirm) {
			// 						uni.setStorageSync("role", this.t_is),
			// 						app.globalData.list =  teacherUser
			// 			            uni.switchTab({
			// 							url: '/pages/main/main'
			// 						})
			// 			        } else if (res.cancel) {
			// 			            uni.setStorageSync("role", this.p_is),
			// 						app.globalData.list =  parentUser
			// 			            uni.switchTab({
			// 			            	url: '/pages/main/main'
			// 			            })
			// 			        }
			// 			    }
			// 		})
			// 	}else{
			// 		uni.showModal({
			// 			title: '您已注册家长身份',
			// 			content: '点击确定将以家长进入小程序',
			// 			cancelText: '注册教师',
			// 			success: res =>{
			// 				if(res.confirm){
			// 					uni.setStorageSync("role", this.p_is),
			// 					app.globalData.list =  parentUser
			// 					uni.switchTab({
			// 						url: "/pages/main/main"
			// 					})
			// 				}
			// 			}
			// 		})
			// 	}
			// }else{
			// 	if(this.t_is != null){
			// 		uni.showModal({
			// 			title: '您已注册教师身份',
			// 			content: '点击确定将以教师进入小程序',
			// 			cancelText: '注册家长',
			// 			success: res =>{
			// 				if(res.confirm){
			// 					uni.setStorageSync("role", this.t_is),
			// 					app.globalData.list =  teacherUser
			// 					uni.switchTab({
			// 						url: "/pages/main/main"
			// 					})
			// 				}
			// 			}
			// 		})
			// 	}
			// }
		},
		data() {
			return {
				restu:'',
				t_is: '',
				p_is: '',
				isp: false,
				ist: false,
				form: {
					phone: '',
					realname: '',
					role: '',
					sname: '',
					sid: '',
					sex: '',
					sub: ''
				},
				r_show: false,
				s_show: false,
				sub_show: false,
				rolelist: [{
						text: '班主任'
					},
					{
						text: '教师'
					},
					{
						text: '家长'
					}
				],
				sexlist: [{
						text: '男'
					},
					{
						text: '女'
					}
				],
				sublist:app.globalData.objforselect,
				rules: {
					realname: [{
							required: true,
							message: '请输入姓名',
							trigger: ['change', 'blur']
						},
						{
							min: 1,
							max: 5,
							message: '没有人的名字会多于五个字！！！',
							trigger: ['change', 'blur']

						}
					],
					phone: [{
							required: true,
							message: '请输入电话号码',
							trigger: ['change', 'blur'],
						},
						{
							validator: (rule, value, callback) => {
								// 返回true表示校验通过，返回false表示不通过
								// this.$u.test.mobile()就是返回true或者false的
								return this.$u.test.mobile(value);
							},
							message: '手机号码不正确',
							// 触发器可以同时用blur和change
							trigger: ['change', 'blur'],
						}
					],
					role: [{
						required: true,
						message: '请选择身份',
						trigger: ['change', 'blur'],
					}],
					sex: [{
						required: true,
						message: '请选择性别',
						trigger: ['change', 'blur'],
					}],
					sid: [{
						required: true,
						message: '请输入学号',
						trigger: ['change', 'blur'],
					}],
					sname: [{
						required: true,
						message: '请输入孩子姓名',
						trigger: ['change', 'blur'],
					}],
					sub: [{
						required: true,
						message: '请选择科目',
						trigger: ['change', 'blur'],
					}]
				}
			}
		},
		methods: {
			r_actionSheetCallback: function(index) {
				this.form.role = this.rolelist[index].text;
				if (this.form.role == "教师" || this.form.role == "班主任") {
					this.ist = true,
						this.form.sname = '我是老师，不用填',
						this.form.sid = '我是老师，不用填',
						this.isp = false
				} else {
					this.form.sname = '',
						this.form.sid = '',
						this.isp = true,
						this.form.sub = '我是家长，不用填',
						this.ist = false
				}
			},
			s_actionSheetCallback: function(index) {
				this.form.sex = this.sexlist[index].text;
			},
			sub_actionSheetCallback: function(index) {
				this.form.sub = this.sublist[index].text;
			},
			submit: function() {
				this.$refs.uForm.validate(valid => {
					if (valid) {
						console.log('验证通过');
						if (this.form.role == "教师" || this.form.role == "班主任") {
							uni.setStorageSync("role", this.form.role),
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/Tinfo.php",
								data: {
									"type": "regist",
									"realname": this.form.realname,
									"phone": this.form.phone,
									"role": this.form.role,
									"openid": uni.getStorageSync("openid"),
									"sex": this.form.sex,
									"pic": uni.getStorageSync("userPic"),
									"name": uni.getStorageSync("userName"),
									"sub": this.form.sub
								},
								success: res => {
									uni.showModal({
										title: "成功",
										success: res => {
											if (res.confirm) {
												uni.setStorageSync("sub", this.form.sub)
												uni.setStorageSync("name", this.form.realname)
												app.globalData.list = teacherUser
												uni.switchTab({
													url: '/pages/class/tclass'
												})
											}
										}
									})
								}
							})
						} else {
							if(this.restu == 'true'){
								uni.setStorageSync("role", this.form.role),
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/PHP.php",
									data: {
										type: "string",
										sql:"select * from studentinfo where sId = '"+this.form.sid+"'"
									},
									success: res => {
										console.log(res.data)
										if (res.data != null) {
											if (res.data.sName == this.form.sname) {
													if (res.data.pOpenid == null) {
														uni.request({
															url:"https://www.sykdesign.xyz/phpbin/Sinfo.php",
															data:{
																type: "updateS_P",
																name: this.form.realname,
																sid: this.form.sid,
																openid : uni.getStorageSync("openid")
															},
															success:res=>{
																
															}
														})
														uni.request({
															url: "https://www.sykdesign.xyz/phpbin/Pinfo.php",
															data: {
																type: "regist2",
																"realname": this.form.realname,
																"phone": this.form.phone,
																"role": this.form.role,
																"openid": uni.getStorageSync("openid"),
																"sex": this.form.sex,
																"pic": uni.getStorageSync("userPic"),
																"name": uni.getStorageSync("userName"),
															},
															success: res => {
																uni.showModal({
																	title: "成功",
																	success: res => {
																		if (res.confirm) {
																			app.globalData.list = parentUser
																			uni.switchTab({
																				url: '/pages/class/pclass'
																			})
																		}
																	}
																})
															}
														})
													} else {
														uni.showToast({
															title: '学生家长已注册'
														})
													}
											} else {
												uni.showToast({
													title: '学生信息不一致'
												})
											}
										} else {
											uni.showToast({
												title: '学生不存在'
											})
										}
									}
								})
							}else{
								uni.setStorageSync("role", this.form.role),
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/Sinfo.php",
									data: {
										type: "searchall",
										sid: this.form.sid
									},
									success: res => {
										if (res.data != null) {
											if (res.data.sName == this.form.sname) {
													if (res.data.pOpenid == null) {
														uni.request({
															url:"https://www.sykdesign.xyz/phpbin/Sinfo.php",
															data:{
																type: "updateS_P",
																name: this.form.realname,
																sid: this.form.sid,
																openid : uni.getStorageSync("openid")
															},
															success:res=>{
																
															}
														})
														uni.request({
															url: "https://www.sykdesign.xyz/phpbin/Pinfo.php",
															data: {
																type: "regist",
																"realname": this.form.realname,
																"phone": this.form.phone,
																"role": this.form.role,
																"openid": uni.getStorageSync("openid"),
																"sex": this.form.sex,
																"pic": uni.getStorageSync("userPic"),
																"name": uni.getStorageSync("userName"),
															},
															success: res => {
																uni.showModal({
																	title: "成功",
																	success: res => {
																		if (res.confirm) {
																			app.globalData.list = parentUser
																			uni.switchTab({
																				url: '/pages/class/pclass'
																			})
																		}
																	}
																})
															}
														})
													} else {
														uni.showToast({
															title: '学生家长已注册'
														})
													}
											} else {
												uni.showToast({
													title: '学生信息不一致'
												})
											}
										} else {
											uni.showToast({
												title: '学生不存在'
											})
										}
									}
								})
							}
							

						}
					} else {
						console.log('验证失败');
					}
				});
			}
		}
	}
</script>

<style scoped lang="scss">

</style>
