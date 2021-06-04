<template>
	<view>
		<view>
			<view class="ct_btn">
				<u-row gutter="16">
					<u-col span="4">
						<button @click="change" v-show="btn_show&&liu">升学年</button>
						<button @click="cdelete" v-show="btn_show&&!liu">班级毕业</button>
					</u-col>
					<u-col span="4">
						<button @click="avatar" v-show="btn_show">删除班级</button>
					</u-col>
					<u-col span="4">
						<button @click="plist" v-show="btn_show">家长列表</button>
					</u-col>
				</u-row>
			</view>
			<view class="ct_btn2">
				<button @click="plist" v-show="!btn_show">家长列表</button>
			</view>
		</view>

		<view class="body ct_body cm_green">
			<u-form :model="form" label-width="auto" ref="uForm">
				<u-form-item label="班级名称:" prop="name">
					<input class="ct_intput" v-model="form.name" disabled="true" />
				</u-form-item>
				<u-row gutter="16">
					<u-col span="6" text-align="center">
						<u-form-item label="年级:">
							<input class="ct_intput" v-model="form.grade" disabled="true" />
						</u-form-item>
					</u-col>
					<u-col span="6" text-align="center">
						<u-form-item label="班级:">
							<input class="ct_intput" v-model="form.class" disabled="true" />
						</u-form-item>
					</u-col>
				</u-row>
			</u-form>
		</view>

		<view class="u-flex user-box u-p-l-30 u-p-r-20 u-p-b-30">
			<view class="u-m-r-10">
				<u-avatar :src="htmes.src" size="140"></u-avatar>
			</view>
			<view class="u-flex-1">
				<view class="u-font-18 u-p-b-20">姓名:{{htmes.name}}</view>
				<view class="u-font-14 u-tips-color">身份：{{htmes.role}} {{htmes.sub}}</view>
				<view class="u-font-14 u-tips-color">手机号：{{htmes.phone}}</view>
			</view>
		</view>

		<view class="u-flex user-box u-p-l-30 u-p-r-20 u-p-b-30" v-for="(item,index) in teacherlist" :key="index">
			<view class="u-m-r-10">
				<u-avatar :src="item.src" size="140"></u-avatar>
			</view>
			<view class="u-flex-1">
				<view class="u-font-18 u-p-b-20">姓名:{{item.name}}</view>
				<view class="u-font-14 u-tips-color">身份：{{item.role}}老师</view>
				<view class="u-font-14 u-tips-color">手机号：{{item.phone}}</view>
			</view>
		</view>
	</view>
</template>

<script>
	import nowdate from '../tabbar.js'
	export default {
		onLoad(options) {
			console.log(options)
			this.role = options.index
			this.cid = options.cid
			if (this.role == '班主任') {

			} else {
				this.btn_show = false
			}
			this.teacherlist = []
			this.flash()
		},
		data() {
			return {
				liu:true,
				role: '教师',
				changeGrade: 0,
				changeName: '',
				cid: '',
				btn_show: true,
				form: {
					name: '',
					grade: 0,
					class: 0,
					year: '',
				},
				htmes: {
					name: '',
					role: '',
					phone: '',
					src: '',
				},
				teacherlist: []
			}
		},
		methods: {
			cdelete(){
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
													uni.showModal({
														title:'班级已毕业',
														content:'将返回登陆页面',
														success:(res) =>{
															if(res.cancel){
																uni.navigateTo({
																	url:"../index/index"
																})
															}if(res.confirm){
																uni.navigateTo({
																	url:"../index/index"
																})
															}
														}
													})
												}})
										}})
								}
							})
						}
					}
				})
			},
			plist:function(){
				uni.navigateTo({
					url: '../class/plist?cid='+this.cid
				})
			},
			avatar() {
				uni.showModal({
					title: '警告',
					content: '将删除班级并返回登录界面,此操作无法退回',
					success: (res) => {
						if (res.confirm) {
							uni.request({
								url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
								data: {
									type: 'try',
									sql: "update class set cIs = 'false' where cId = '" + this.cid +
										"'"
								},
								success: (res) => {
									uni.request({
										url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
										data: {
											type: 'try',
											sql: "update studentinfo set sIs = 'false' where cId = '" +
												this.cid + "'"
										},
										success: (res) => {
											uni.request({
												url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
												data: {
													type: 'try',
													sql: "update tcinfo set tcIs = 'false' where cId = '" +
														this.cid + "'"
												},
												success: (res) => {
													uni.clearStorageSync();
													uni.login({
														success: res => {
															uni.request({
																url: 'https://www.sykdesign.xyz/phpbin/openid.php',
																data: {
																	"code": res
																		.code
																},
																success: res => {
																	uni.setStorageSync(
																		"openid",
																		res
																		.data
																		.openid
																	)
																}
															})
														}
													})
													uni.request({
														url: 'https://www.sykdesign.xyz/phpbin/A_T.php',
														success: (
															res
														) => {
															uni.setStorageSync(
																"access_token",
																res
																.data
																.access_token
															)
														}
													})
													uni.reLaunch({
														url: '../index/index',
													})
												}
											})
										}
									})
								}
							})
						}
					}
				})
			},
			change() {
				this.changeGrade = parseInt(this.form.grade) + 1
				this.changeName = this.$cname(this.changeGrade, this.form.class)
				if (this.form.year == nowdate.getDate2().substr(0, 4)) {
					uni.showToast({
						title: '无需升学年'
					})
				} else {
					uni.request({
						url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
						data: {
							type: 'try',
							sql: "update class set cYear = '" + nowdate.getDate2().substr(0, 4) + "' ,cGrade = '" +
								this.changeGrade + "' ,cName ='" + this.changeName + "' where cId = '" + this.cid +
								"'"
						},
						success: (res) => {

						}
					})
				}
			},
			flash() {
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
					data: {
						type: 'string',
						sql: "select * from class where cId = '" + this.cid + "'"
					},
					success: (res) => {
						console.log(res.data)
						this.form.name = res.data.cName
						this.form.grade = res.data.cGrade
						this.form.class = res.data.cNumber,
							this.form.year = res.data.cYear
							if(this.form.grade == 6){
								this.liu = false
							}
						uni.request({
							url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
							data: {
								type: 'array',
								sql: "select * from teacherinfo t inner join tcinfo c on t.tOpenid = c.tcOpenid where cId = '" +
									this.cid + "' and tIs = 'true' and tcIs ='true'"
							},
							success: (res) => {
								console.log(res.data)
								for (var i = 0; i < res.data.length; i++) {
									if (res.data[i].tRole == '班主任') {
										this.htmes.name = res.data[i].tRealname
										this.htmes.role = res.data[i].tRole
										this.htmes.phone = res.data[i].tPhone
										this.htmes.src = res.data[i].tPic
										this.htmes.sub = res.data[i].tSub
									} else {
										this.teacherlist.push({
											name: res.data[i].tRealname,
											role: res.data[i].tSub,
											phone: res.data[i].tPhone,
											src: res.data[i].tPic
										})
									}
								}
							}
						})
					}
				})
			}
		}
	}
</script>

<style>
	.ct_body {
		text-align: center;
	}

	.ct_form {
		margin-left: 50px;
		margin-right: 50px;
	}

	.ct_intput {
		border: #909399;
		height: 30px;
		background-color: #FFFFFF;
	}

	.ct_btn {
		margin-top: 10px;
	}

	.ct_btn2 {
		margin: 10px;
	}

	.user-box {
		background-color: #fff;
		margin: 20px;
		padding-top: 10px;
	}
</style>
