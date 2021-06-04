<template>
	<view>
		<!-- <view class="">
			<u-checkbox-group @change="checkboxGroupChange">
				<u-checkbox @change="checkboxChange" v-model="item.checked" v-for="(item, index) in checklist"
					:key="index" :name="item.name">{{item.name}}</u-checkbox>
			</u-checkbox-group>
		</view> -->
		<view class="specialbtn">
		<u-button @click="Nadd" size="default" type="warning" >发布新公告+</u-button></view>
		<view v-for="(item,index) in noticelist" :key="index">
			<u-card :title="item.title" :sub-title="item.sub_title">
				<view slot="body">
					<view>内容:</view>
					<view class="homework1">{{item.text}}</view>
					<view class="homework2">
						<u-row gutter="16">
							<u-col span="4">
								<view>班级:{{item.class}}</view>
							</u-col>
							<u-col span="4">
								<view>科目:{{item.sub}}</view>
							</u-col>
							<u-col span="4">
								<view>已确认:{{item.num}}人</view>
							</u-col>
						</u-row>
					</view>
					<view class="homework2">
						<u-row gutter="16">
							<u-col span="4">
								<view>教师:{{item.tname}}</view>
							</u-col>
							<u-col span="4">

							</u-col>
							<u-col span="4">
								<u-button @click="N_delete(index)" :disabled="item.have">删除</u-button>
							</u-col>
						</u-row>
					</view>
				</view>
			</u-card>
		</view>
		<u-back-top :scroll-top="scrollTop"></u-back-top>
	</view>
</template>

<script>
	export default {
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		},
		onShow() {
			this.N_flash()
		},
		data() {
			return {
				scrollTop: 0,
				mask_show: false,
				noticelist: [{
					title: '公告',
					sub_title: '发布于:2014-04-12',
					text: 'buzhunqj',
					class: '五年二班',
					sub: '数学',
					num: '5'
				}]
			}
		},
		methods: {
			is_mask_show: function() {
				this.mask_show = false
			},
			Nadd: function() {
				uni.navigateTo({
					url: "./Nadd"
				})
			},
			N_flash: function() {
				this.noticelist = []
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
					data: {
						type: 'find_cid',
						cid: uni.getStorageSync('choosecid')
					},
					success: (res) => {
						this.classname = res.data.cName
					}
				})
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from ninfo n left join teacherinfo r on n.tOpenid = r.tOpenid where n.cId = '" +
							uni.getStorageSync('choosecid') + "' and nIs = 'true'"
					},
					success: (res) => {
						console.log(res.data)
						if (res.data.length != 0) {
							res.data.sort(this.$arrySort2('nId'))
							for (var i = 0; i < res.data.length; i++) {
								if (uni.getStorageSync('crole') == '班主任') {
									this.noticelist.push({
										class: this.classname,
										sub: res.data[i].nSub,
										num: res.data[i].nNum,
										text: res.data[i].nText,
										title: res.data[i].nName,
										id: res.data[i].nId,
										sub_title: '发布于:' + res.data[i].nTime,
										have: false,
										tname: res.data[i].tRealname,
									})
								} else {
									if (res.data[i].tOpenid == uni.getStorageSync('openid')) {
										this.noticelist.push({
											class: this.classname,
											sub: res.data[i].nSub,
											num: res.data[i].nNum,
											text: res.data[i].nText,
											title: res.data[i].nName,
											id: res.data[i].nId,
											sub_title: '发布于:' + res.data[i].nTime,
											have: false,
											tname: res.data[i].tRealname,
										})
									} else {
										this.noticelist.push({
											class: this.classname,
											sub: res.data[i].nSub,
											num: res.data[i].nNum,
											text: res.data[i].nText,
											title: res.data[i].nName,
											id: res.data[i].nId,
											sub_title: '发布于:' + res.data[i].nTime,
											have: true,
											tname: res.data[i].tRealname,
										})
									}
								}
							}
						} else {
							this.noticelist = [{
								class: '',
								sub: '',
								num: 0,
								text: '未发布任何公告',
								title: '公告不存在',
								id: '',
								sub_title: '',
								have: true,
								tname: ''
							}]
						}
					}
				})
			},
			N_delete: function(index) {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
					data: {
						type: 'N_delete',
						nid: this.noticelist[index].id
					},
					success: (res) => {
						uni.showToast({
							title: '删除成功',
							complete: () => {
								this.N_flash()
							}
						})
					}
				})
			}
		}
	}
</script>

<style>
	.homework1 {
		height: 50px;
		font-size: 15px;
		margin: 30px;
	}

	.homework2 {
		height: 30px;
		font-size: 12px;
	}

	.H_T_body {
		margin-bottom: 70px;
	}
</style>
