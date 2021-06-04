<template>
	<view>
		<view class="u-flex user-box u-p-l-30 u-p-r-20 u-p-b-30 ">
			<view class="u-m-r-10">
				<u-avatar :src="src" size="140"></u-avatar>
			</view>
			<view class="u-flex-1">
				<view class="u-font-18 u-p-b-20">{{name}}</view>
				<view class="u-font-14 u-tips-color">身份：{{role}}</view>
			</view>
		</view>
		<u-gap height="50" bg-color="$u-bg-color"></u-gap>
		<u-cell-group>
			<u-cell-item icon="bag-fill" title="个人信息管理" @click="M_M"></u-cell-item>
			<u-cell-item icon="bag-fill" title="班级信息查看" @click="M_CM"></u-cell-item>
			<u-cell-item icon="bag-fill" title="学生成绩查看" @click="M_E"></u-cell-item>
			<u-cell-item icon="setting-fill" title="注销" @click="outApp"></u-cell-item>
		</u-cell-group>
		<u-tabbar :list="list"></u-tabbar>
	</view>
</template>

<script>
	export default {
		onLoad() {
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/PHP.php",
				data: {
					type: 'string',
					sql: "select * from parentinfo where pOpenid = '" + uni.getStorageSync('openid') + "'"
				},
				success: (res) => {
					this.src = res.data.pPic,
						this.name = res.data.pRealname

				}
			})
		},
		data() {
			return {
				name: '',
				role: '家长',
				src: '',
				list: getApp().globalData.list
			}
		},
		methods: {
			M_CM: function() {
				uni.navigateTo({
					url: '../class/class_M?index=' + '家长' + '&cid=' + uni.getStorageSync('myclass')
				})
			},
			M_M: function() {
				uni.navigateTo({
					url: './changemy_P'
				})
			},
			M_E: function() {
				uni.navigateTo({
					url: '../exam/exam_P'
				})
			},
			outApp: function() {
				uni.showModal({
					title: '注销并返回至登陆界面',
					content: '是否确认',
					success: (res) => {
						if (res.confirm) {
							uni.clearStorageSync();
							uni.login({
								success: res => {
									uni.request({
										url: 'https://www.sykdesign.xyz/phpbin/openid.php',
										data: {
											"code": res.code
										},
										success: res => {
											uni.setStorageSync("openid", res.data
												.openid)
										}
									})
								}
							})
							uni.request({
								url: 'https://www.sykdesign.xyz/phpbin/A_T.php',
								success: (res) => {
									uni.setStorageSync("access_token", res.data.access_token)
								}
							})
							uni.reLaunch({
								url: '../index/index',
							})
						}
					}
				})
			},
		}
	}
</script>

<style>
	.user-box {
		background-color: #fff;
	}
</style>
