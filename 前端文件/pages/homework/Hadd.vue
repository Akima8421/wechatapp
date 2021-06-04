<template>
	<view class="body white first_warp form_top">
		<u-form :model="form" label-width="auto" ref="uForm">
			<u-form-item label="作业名称:" prop="hname">
				<u-input v-model="form.hname" />
			</u-form-item>
			<u-form-item label="作业内容:" prop="text">
				<u-input v-model="form.text" type="textarea" />
			</u-form-item>
			<u-form-item label="截止时间:" prop="time">
				<u-input v-model="form.choosedate"  type="select" placeholder="请选择日期" @click="show = true" inputAlign="center"/>
				<u-calendar v-model="show" :mode="mode" @change="change"></u-calendar>
			</u-form-item>
			<u-form-item>
				<u-button size="medium" @click="submit">发布作业</u-button>
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
				show: false,
				mode: 'date',
				form:{
					hname:'',
					text:'',
					choosedate: '',
				},
				stulist:[],
				rules: {
					hname: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
					text: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
					time: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}]
				}
			}
		},
		methods: {
			change:function(e){
				this.form.choosedate = e.result
			},
			submit: function() {
				this.$refs.uForm.validate(valid => {
					if (valid) {
						uni.request({
					url:"https://www.sykdesign.xyz/phpbin/Sinfo.php",
					data:{
						type: 'cid_table',
						cid: uni.getStorageSync('choosecid')
					},
					success: (res) => {
						this.stulist = res.data
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Hinfo.php",
							data:{
								type: 'insertHinfo',
								hname: this.form.hname,
								sub: uni.getStorageSync('sub'),
								topenid: uni.getStorageSync('openid'),
								text:this.form.text,
								deadline: this.form.choosedate,
								cid: uni.getStorageSync('choosecid'),
								time: nowdate.getDate()
							},
							success: (res) => {
								console.log(res.data)
							}
						})
						for(var i = 0 ; i<this.stulist.length;i++){
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/Hinfo.php",
								data: {
									type: 'firstMess',
									access_token: uni.getStorageSync("access_token"),
									data: {
										"page":"../index/index",
										"touser": this.stulist[i].pOpenid,
										"template_id": "-T__eY8EIB1OQ2KeUPF3DKXuIAXYZ5PTQzZgdaxUVH4",
										"data": {
											"thing9": {
												"value": this.form.text
											},
											"name10": {
												"value": uni.getStorageSync('sub')
											},
											"thing21": {
												"value": res.data[i].sName
											},
											"thing22": {
												"value": uni.getStorageSync('name')
											},
											"date4": {
												"value": this.form.choosedate
											}
										}
									}
								},
								success: (res) => {
									console.log(res.data)
									uni.showModal({
										title:'成功',
										content:'点击确认返回上页',
										success: (res) => {
											if(res.confirm){
												uni.navigateBack({
													
												})
											}
										}
									})
								}
							})
						}
					}
				})
					}})
				
			}
		}
	}
</script>

<style>
</style>
