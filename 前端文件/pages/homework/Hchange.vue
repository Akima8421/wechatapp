<template>
	<view class="body white first_warp form_top">
		<view style="text-align: center;">学生作业完成情况或对作业的建议</view>
		<view class="body">
			<u-form :model="form" label-width="auto" ref="uForm">
				<u-form-item prop="text">
					<u-input v-model="form.text" type="textarea" height="300"border="true"/>
				</u-form-item>
				<u-form-item>
					<u-button size="medium" @click="submit">提交修改</u-button>
				</u-form-item>
			</u-form>
		</view>
	</view>
</template>

<script>
	export default{
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		onLoad(options) {
			console.log(options.index)
			this.homeworkid = options.index
		},
		onShow() {
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/PHP.php",
				data:{
					type:'string',
					sql:"select * from hpinfo where hphId = '"+this.homeworkid+"' and hppOpenid = '"+uni.getStorageSync('openid')+"'"
				},
				success:(res)=>{
					this.form.text = res.data.hpText
				}
			})
		},
		data(){
			return{
				hlook: 0,
				form:{
					text:''
				},
				homeworkid:'',
				rules: {
					text: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}]
				}
			}
		},
		methods:{
			submit:function(){
				this.$refs.uForm.validate(valid => {
					if (valid) {
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/PHP.php",
							data:{
								type:'try',
								sql:"UPDATE hpinfo set hpIs = 'false', hpText = '"+this.form.text+"' where hphId = '"+this.homeworkid+"' and hppOpenid = '"+uni.getStorageSync('openid')+"'"
							},
							success:(res)=>{
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/PHP.php",
									data:{
										type:'string',
										sql:"select * from hinfo where hId = '"+this.homeworkid+"'"
									},
									success:(res)=>{
										this.hlook = res.data.hLook - 1
										uni.request({
											url: "https://www.sykdesign.xyz/phpbin/PHP.php",
											data:{
												type:'try',
												sql:"UPDATE hinfo set hLook = '"+this.hlook+"' where hId = '"+this.homeworkid+"'"
											},
											success:(res)=>{
												uni.showModal({
									title:'修改成功',
									content:'返回上一页',
									cancelText:'首页',
									success: (res) => {
										if(res.confirm){
											uni.navigateBack({
												
											})
										}if(res.cancel){
											uni.switchTab({
												url:'../class/pclass'
											})
										}
									}
								})
											}
										})
									}})
								
							}
						})
					}
					
				})
			}
		}
	}
</script>

<style>
	.hc_body{
		margin-top: 20%;
	}
</style>

