<template>
	<view class="body white first_warp form_top">
		<view style="text-align: center;">学生作业完成情况或对作业的建议</view>
		<view class="body">
			<u-form :model="form" label-width="auto" ref="uForm">
				<u-form-item prop="text">
					<u-input v-model="form.text" type="textarea" height="300"border="true" placeholder="字数在五百字以内"/>
				</u-form-item>
				<u-form-item>
					<u-button size="medium" @click="submit">提交</u-button>
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
					sql:"select hNum from hinfo where hId = '"+this.homeworkid+"'"
				},
				success:(res)=>{
					this.count = res.data.hNum,
					console.log(this.count)
				}
			})
		},
		data(){
			return{
				count:0,
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
								sql:"insert into hpinfo (hppOpenid,hphId,hpText) VALUES ('"+uni.getStorageSync('openid')+"','"+this.homeworkid+"' , '"+this.form.text+"')"
							},
							success:(res)=>{
								this.count++
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/PHP.php",
									data:{
										type:'try',
										sql:"UPDATE hinfo set hNum = '"+this.count+"' where hId = '"+this.homeworkid+"'"
									},
									success:(res)=>{
										uni.showModal({
											title:'提交成功',
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
