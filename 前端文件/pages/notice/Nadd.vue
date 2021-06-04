<template>
	<view class="body white first_warp form_top">
		<u-form :model="form" label-width="auto" ref="uForm">
			<u-form-item label="公告名称" prop="nname">
				<u-input v-model="form.nname" />
			</u-form-item>
			<u-form-item label="公告内容" prop="text">
				<u-input v-model="form.text" type="textarea" />
			</u-form-item>
			<u-form-item>
				<u-button size="medium" @click="submit">发布公告</u-button>
				<u-button size="medium" @click="returnback">返回首页</u-button>
			</u-form-item>
		</u-form>
	</view>
</template>

<script>
	import nowdate from '../tabbar.js'
	export default {
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		data() {
			return {
				form: {
					nname: '',
					text: '',
				},
				stulist: [],
				rules: {
					nname: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
					text: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
				}
			}
		},
		methods: {
			returnback: function() {
				uni.switchTab({
					url: '../class/tclass'
				})
			},
			submit: function() {
				this.$refs.uForm.validate(valid => {
					if (valid) {
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Sinfo.php",
							data: {
								type: 'cid_table',
								cid: uni.getStorageSync('choosecid')
							},
							success: (res) => {
								console.log(res.data)
								this.stulist = res.data
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
									data: {
										type: 'insertNinfo',
										nname: this.form.nname,
										topenid: uni.getStorageSync('openid'),
										text: this.form.text,
										cid: uni.getStorageSync('choosecid'),
										time: nowdate.getDate2(),
										sub: uni.getStorageSync('sub')
									},
									success: (res) => {
										console.log(res.data)
										uni.showModal({
											title: '发布成功',
											content: '是否返回首页',
											success: (res) => {
												if (res.confirm) {
													uni.switchTab({
														url: '../class/tclass'
													})
												}
											}
										})
									}
								})
								for (var i = 0; i < this.stulist.length; i++) {
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
										data: {
											type: 'firstMess',
											access_token: uni.getStorageSync(
												"access_token"),
											data: {
												"page": "../index/index",
												"touser": this.stulist[i].pOpenid,
												"template_id": "fSG34IIe3aVmqzaDqoqB1J0dpzAiWDBVbA7Ampaoznk",
												"data": {
													"thing1": {
														"value": this.form.nname
													},
													"thing5": {
														"value": this.form.text
													},
													"time3": {
														"value": nowdate.getDate2()
													},
													"thing2": {
														"value": uni.getStorageSync('name')
													}
												}
											}
										},
										success: (res) => {
											console.log(res.data)
										}
									})
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
</style>
