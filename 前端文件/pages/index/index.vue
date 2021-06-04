<template>
	<view>
		<!-- <u-button @click="getUserProfile" v-show="btnshow">授权</u-button> -->
		<view class="index_btn">
			<view class="index_btn_item"><button v-show="TPA_btnshow" @click="T_enter" class="btn_item">教师入口</button></view>
			<view class="index_btn_item"><button v-show="TPA_btnshow" @click="P_enter" class="btn_item">家长入口</button></view>
			<view class="index_btn_item"><button v-show="TPA_btnshow" @click="A_enter" class="btn_item">管理员入口</button></view>
			<view class="index_btn_item"><button v-show="my_btnshow" @click="mask" class="btn_item">切换用户</button></view>
			<view class="index_btn_item"><button v-show="!my_btnshow" @click="mybtnshow" class="btn_item">开发者按钮</button></view>
		</view>
		<view>
			<u-mask :show="mask_show" @click="mask_show = false">
				<view class="warp">
					<view class="rect" @tap.stop>
						<u-table>
							<u-tr>
								<u-th>姓名</u-th>
								<u-th>操作</u-th>
							</u-tr>
							<u-tr v-for="(item,index) in Tlist" :key="index">
								<u-th v-text="item.tRealname"></u-th>
								<u-th>
									<u-button @click="Tbtn_change(index)">使用</u-button>
								</u-th>
							</u-tr>
						</u-table>
						<u-table>
							<u-tr>
								<u-th>姓名</u-th>
								<u-th>操作</u-th>
							</u-tr>
							<u-tr v-for="(item,index) in Plist" :key="index">
								<u-th v-text="item.pRealname"></u-th>
								<u-th>
									<u-button @click="Pbtn_change(index)">使用</u-button>
								</u-th>
							</u-tr>
						</u-table>
					</view>
				</view>
			</u-mask>
		</view>
	</view>
</template>

<script>
	import {
		teacherUser
	} from '../tabbar.js'
	import {
		parentUser
	} from '../tabbar.js'
	let app = getApp()
	export default {
		data() {
			return {
				my_btnshow: false,
				btnshow: false,
				TPA_btnshow: true,
				mask_show: false,
				Tlist: [],
				Plist: [],
			}
		},
		onShow() {
			console.log('11')
		},
		onLoad() {
			
			// // 判断是否已经授权
			// uni.getSetting({
			// 	success: (res) => {
			// 		console.log(res.data)
			// 		if (res.authSetting['scope.userInfo']) { //授权了
			// 			this.TPA_btnshow = true
			// 		} else { //未授权
			// 			this.btnshow = true,
			// 				uni.showToast({
			// 					icon: 'none',
			// 					title: '请登录'
			// 				})
			// 		}
			// 	}
			// })
		},
		methods: {
			mybtnshow(){
				if(uni.getStorageSync('openid') == 'o25NJ40dOqIUttSOuwaAgkXQEyzU')
				{
					this.my_btnshow = true
				}
			},
			// getUserProfile: function(e) {
			// 	wx.getUserProfile({
			// 		desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
			// 		success: (res) => {
			// 			console.log(res.data)
			// 			uni.setStorageSync("userName", res.userInfo.nickName),
			// 			uni.setStorageSync("userPic", res.userInfo.avatarUrl)
			// 			// uni.redirectTo({
			// 			// 	url: "../regist/regist"
			// 			// })
			// 		}
			// 	})
			// },
			T_enter: function() {
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/Tinfo.php',
					data: {
						type: "searchall",
						"openid": uni.getStorageSync("openid"),
					},
					success: res => {
						if (res.data != null) {
							if (res.data.tIs == "true") {
								///获取作为班主任的班级id
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
									data: {
										type: 'find_cid_HT',
										role: '班主任',
										openid: uni.getStorageSync('openid')
									},
									success: (res) => {
										if (res.data == null) {
											uni.setStorageSync("mycid", '')
										} else {
											uni.setStorageSync("mycid", res.data.cId)
										}
									}
								})
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
								uni.setStorageSync("role", res.data.tRole)
								uni.setStorageSync("sub", res.data.tSub)
								uni.setStorageSync("name", res.data.tRealname)
								app.globalData.list = teacherUser
								uni.switchTab({
									url: "/pages/class/tclass"
								})
							} else {
								uni.showModal({
									title: '教师账号不可用',
									content: '请联系管理员',
								})
							}
						} else {
							uni.showModal({
								title: '未注册教师账号',
								content: '点击确认前往注册',
								success: res => {
									if (res.confirm) {
										wx.getUserProfile({
											desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
											success: (res) => {
												console.log(res.userInfo)
												uni.setStorageSync("userName", res.userInfo.nickName),
												uni.setStorageSync("userPic", res.userInfo.avatarUrl)
												uni.redirectTo({
													url: "../regist/regist"
												})
											}
										})
									}
								}
							})
						}
					}
				})
			},
			// P_into:function(){
			// 	uni.request({
			// 		url: 'https://www.sykdesign.xyz/phpbin/Pinfo.php',
			// 		data: {
			// 			type: "searchall",
			// 			"openid": uni.getStorageSync("openid"),
			// 		},
			// 		success: res => {
			// 			if (res.data != null) {
			// 				if (res.data.pIs == "true") {
			// 					uni.setStorageSync("role", res.data.pRole)
			// 					app.globalData.list = parentUser
			// 					uni.switchTab({
			// 						url: "/pages/main/main"
			// 					})
			// 				} else {
			// 					uni.showModal({
			// 						title: '家长账号不可用',
			// 						content: '请联系管理员',
			// 					})
			// 				}
			// 			} else {
			// 				uni.showModal({
			// 					title: '未注册家长账号',
			// 					content: '点击确认前往注册',
			// 					success: res => {
			// 						if (res.confirm) {
			// 							uni.redirectTo({
			// 								url: '../regist/regist'
			// 							})
			// 						}
			// 					}
			// 				})
			// 			}
			// 		}
			// 	})
			// },
			P_enter: function() {
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
					data: {
						type: "string",
						sql:"select * from parentinfo p inner join studentinfo s on p.pOpenid = s.pOpenid where p.pOpenid = '"+uni.getStorageSync('openid')+"'"
					},
					success: res => {
						console.log(res.data)
						if (res.data != null) {
							if (res.data.sIs == "true") {
								uni.setStorageSync("role", res.data.pRole)
								// 获取用户的当前设置，判断是否点击了“总是保持以上，不在询问”
								wx.getSetting({
									withSubscriptions: true, //是否获取用户订阅消息的订阅状态，默认false不返回
									success(res) {
										console.log(res)
										if (res.authSetting['scope.subscribeMessage']) {
											app.globalData.list = parentUser
											uni.switchTab({
												url: "/pages/class/pclass"
											})
										} else { // 用户没有点击“总是保持以上，不再询问”则每次都会调起订阅消息
											uni.requestSubscribeMessage({
												tmplIds: [
													'-T__eY8EIB1OQ2KeUPF3DKXuIAXYZ5PTQzZgdaxUVH4',
													'fSG34IIe3aVmqzaDqoqB1J0dpzAiWDBVbA7Ampaoznk'
												],
												success(res) {
													if (res[
															'-T__eY8EIB1OQ2KeUPF3DKXuIAXYZ5PTQzZgdaxUVH4'] ==
														"accept") { // 字段就是tmplIds模板id
														app.globalData.list = parentUser
														uni.switchTab({
															url: "/pages/class/pclass"
														})
													}
												}
											})
										}
									}
								})
							} else {
								uni.showModal({
									title: '学生不可用',
									content: '请重新注册绑定学生',
									success: (res) => {
										if(res.confirm){
											wx.getUserProfile({
												desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
												success: (res) => {
													console.log(res.data)
													uni.setStorageSync("userName", res.userInfo.nickName),
													uni.setStorageSync("userPic", res.userInfo.avatarUrl)
													uni.navigateTo({
														url: "../regist/regist?restu=true"
													})
												}
											})
										}
									}
								})
							}
						} else {
							uni.showModal({
								title: '未注册家长账号',
								content: '点击确认前往注册',
								success: res => {
									if (res.confirm) {
										wx.getUserProfile({
											desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
											success: (res) => {
												console.log(res.data)
												uni.setStorageSync("userName", res.userInfo.nickName),
												uni.setStorageSync("userPic", res.userInfo.avatarUrl)
												uni.navigateTo({
													url: "../regist/regist?restu=false"
												})
											}
										})
									}
								}
							})
						}
					}
				})
			},
			A_enter: function() {
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/Ainfo.php',
					data: {
						type: 'searchall',
						openid: uni.getStorageSync("openid")
					},
					success: res => {
						if (res.data != null) {
							uni.navigateTo({
								url: "../admin/admin"
							})
						} else {
							uni.showModal({
								title: '宁不是管理员',
							})
						}
					}
				})
			},
			mask: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Tinfo.php",
					data: {
						type: 'searchfortable'
					},
					success: (res) => {
						this.Tlist = res.data
					}
				})
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Pinfo.php",
					data: {
						type: 'searchfortable'
					},
					success: (res) => {
						this.Plist = res.data
					}
				})
				this.mask_show = true
			},
			Tbtn_change: function(index) {
				uni.setStorageSync("name", this.Tlist[index].tRealname)
				uni.setStorageSync("openid", this.Tlist[index].tOpenid)
				uni.setStorageSync("role", this.Tlist[index].tRole)
				uni.setStorageSync("sub", this.Tlist[index].tSub)
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_cid_HT',
						role: '班主任',
						openid: uni.getStorageSync('openid')
					},
					success: (res) => {
						if (res.data == null) {
							uni.setStorageSync("mycid", '')
						} else {
							uni.setStorageSync("mycid", res.data.cId)
						}
					},
				})
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
				app.globalData.list = teacherUser
				uni.switchTab({
					url: "/pages/class/tclass"
				})
			},
			Pbtn_change: function(index) {
				uni.setStorageSync("name", this.Plist[index].pRealname)
				uni.setStorageSync("openid", this.Plist[index].pOpenid)
				uni.setStorageSync("role", this.Plist[index].pRole)
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_cid_HT',
						role: '班主任',
						openid: uni.getStorageSync('openid')
					},
					success: (res) => {
						uni.setStorageSync("mycid", res.data.cId)
					},
				})
				app.globalData.list = parentUser
				uni.switchTab({
					url: "/pages/class/pclass"
				})
			},
		}
	}
</script>

<style scoped>
	.index_btn{
		margin-top: 35%;
		text-align: center;
		
	}
	.index_btn_item{
		margin: 10%;
	}
	.btn_item{
		width: 200px;
	}
</style>
