<template>
	<view>
		<view>
			<u-table>
				<u-tr>
					<u-th>姓名</u-th>
					<u-th>工号</u-th>
					<u-th>科目</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr>
					<u-td v-text="ht[0].tRealname"></u-td>
					<u-td v-text="ht[0].tId"></u-td>
					<u-td v-text="ht[0].tSub"></u-td>
					<u-td>
						<u-button>班主任</u-button>
					</u-td>
				</u-tr>
				<u-tr v-for="(item,index) in teacherlist" :key="index">
					<u-td v-text="item.tRealname"></u-td>
					<u-td v-text="item.tId"></u-td>
					<u-td v-text="item.tSub"></u-td>
					<u-td>
						<u-button @click="change_T(index)">更换老师</u-button>
					</u-td>
				</u-tr>
			</u-table>
			<u-button @click="gototcadd" size="medium" class="H_T_button">添加老师</u-button>
		</view>
	</view>
</template>

<script>
	export default {
		onShow() {
			this.tclist = [],
				this.teacherlist = [],
				this.ht = [],
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_teacher',
						cid: uni.getStorageSync('mycid')
					},
					success: res => {
						this.tclist = res.data
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Tinfo.php",
							data: {
								type: 'searchfortable',
							},
							success: (res) => {
								for (var i = 0; i < res.data.length; i++) {
									for (var n = 0; n < this.tclist.length; n++) {
										if (res.data[i].tOpenid != uni.getStorageSync('openid')) {
											if (this.tclist[n].tcOpenid == res.data[i].tOpenid) {
												this.teacherlist.push(res.data[i])
											}
										}
										if (res.data[i].tOpenid == uni.getStorageSync('openid')) {
											this.ht.push(res.data[i])
										}
									}
								}
							}
						})
					}
				})
		},
		data() {
			return {
				ht: [],
				form: {
					tis: ''
				},
				is_show: false,
				mask_show: false,
				tclist: [],
				teacherlist: [],
				islist: [{
					text: '可用'
				}, {
					text: '不可用'
				}]
			}
		},
		methods: {
			gototcadd: function() {
				uni.navigateTo({
					url: "./tcadd"
				})
			},
			change_T: function(index) {
				console.log(index)
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_tcid',
						openid: this.teacherlist[index].tOpenid
					},
					success: (res) => {
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
							data: {
								type: 'TC_delete',
								tcid: res.data.tcId
							},
							success: () => {
								uni.navigateTo({
									url: "./tcadd"
								})
							}
						})
					}
				})

			},
			is_mask_show: function() {
				this.mask_show = false
			},
			is_sheet: function(index) {
				this.form.tis == this.islist[index].text
			}
		}
	}
</script>

<style>
</style>
