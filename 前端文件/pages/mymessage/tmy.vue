<template>
	<view>
		<view v-show="haveclass">
			<view class="u-flex user-box u-p-l-30 u-p-r-20 u-p-b-30">
				<view class="u-m-r-10">
					<u-avatar :src="src" size="140"></u-avatar>
				</view>
				<view class="u-flex-1">
					<view class="u-font-18 u-p-b-20">姓名:{{name}}</view>
					<view class="u-font-14 u-tips-color">身份：{{role}}</view>
				</view>
			</view>
			<u-gap height="50" bg-color="$u-bg-color"></u-gap>
			<u-cell-group v-show="haveclass">
				<u-cell-item icon="setting-fill" title="班级管理" @click="M_C" v-show="is_show"></u-cell-item>
				<u-cell-item icon="setting-fill" title="学生成绩查看" @click="M_ETH" v-show="is_show"></u-cell-item>
			</u-cell-group>
			<u-gap height="50" bg-color="$u-bg-color" v-show="is_show"></u-gap>
			<u-cell-group v-show="haveclass">
				<u-cell-item icon="bag-fill" title="个人信息管理" @click="M_M"></u-cell-item>
				<u-cell-item icon="bag-fill" title="班级信息查看" @click="M_CM"></u-cell-item>
				<u-cell-item icon="bag-fill" title="学生成绩管理" @click="M_E"></u-cell-item>
				<u-cell-item icon="setting-fill" title="注销" @click="outApp"></u-cell-item>
			</u-cell-group>
		</view>
		<view class="tm_button">
		<u-button @click="classadd" v-show="noclass"  size="medium">创建班级</u-button></view>
		<u-modal v-model="modal_show" :content="content" @confirm="goback"></u-modal>
		<u-tabbar :list="list"></u-tabbar>
	</view>
</template>

<script>
	export default {
		onShow() {
			if (uni.getStorageSync("role") == "班主任") {
				this.is_show = true
				if (uni.getStorageSync("mycid") == "") {
					this.noclass = true,
						this.haveclass = false
				} else {
					this.noclass = false,
						this.haveclass = true
				}
			} else {
				this.noclass = false,
					this.haveclass = true
			}
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/Tinfo.php",
				data: {
					type: "searchall",
					openid: uni.getStorageSync("openid")
				},
				success: (res) => {
					this.src = res.data.tPic,
						this.name = res.data.tRealname
				}
			})
		},
		data() {
			return {
				content: '请先选择班级',
				modal_show: false,
				noclass: true,
				haveclass: false,
				Ttitle: '班级管理',
				src: '',
				list: getApp().globalData.list,
				is_show: false,
				name: '',
				role: uni.getStorageSync('role')
			}
		},
		methods: {
			M_CM:function(){
				if (uni.getStorageSync('choosecid') != "") {
					uni.navigateTo({
						url: '../class/class_M?index='+'教师'+'&cid='+uni.getStorageSync('choosecid')
					})
				} else {
					this.modal_show = true
				}
			},
			M_M:function(){
				uni.navigateTo({
					url: "./changemy_T"
				})
			},
			M_ETH: function() {
				uni.navigateTo({
					url: "../exam/exam_HT"
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
			M_C: function() {
				uni.navigateTo({
					url: "cm"
				})
			},
			M_E: function() {
				if (uni.getStorageSync('choosecid') != "") {
					uni.navigateTo({
						url: "../exam/exam_T"
					})
				} else {
					this.modal_show = true
				}
			},
			goback: function() {
				uni.switchTab({
					url: '../class/tclass'
				})
			},
			classadd: function() {
				uni.navigateTo({
					url: "../class/classadd"
				})
			}
		}
	}
</script>

<style >
	.user-box {
		background-color: #fff;
	}
	.tm_button{
		text-align: center;
		margin-top: 50%;
	}
</style>
