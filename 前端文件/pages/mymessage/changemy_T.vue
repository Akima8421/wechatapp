<template>
	<view class="body ct_body">
		<view class="ave first_warp">
			<u-avatar :src="form.src" size="140"></u-avatar>
		</view>
	<view class="white first_warp">
		<view class="ct_form">
		<u-form :model="form" label-width="auto" ref="uForm">
			<u-form-item label="姓名:" prop="name">
				<input class="ct_intput" v-model="form.name" :disabled="is" :style="redback"/>
			</u-form-item>
			<u-form-item label="手机号:" prop="phone">
				<input class="ct_intput" v-model="form.phone" :disabled="is" :style="redback"/>
			</u-form-item>
			<u-form-item label="性别:" prop="sex">
				<input v-model="form.sex" type="select" @click="sex_click" class="ct_intput" :style="redback" disabled="true"/>
				<u-action-sheet :list="sexlist" v-model="sex_show" @click="sex_sheet"></u-action-sheet>
			</u-form-item>
			<u-form-item label="科目:" prop="sub">
				<input v-model="form.sub" type="select" @click="sub_click" class="ct_intput" :style="redback" disabled="true"/>
				<u-action-sheet :list="sublist" v-model="sub_show" @click="sub_sheet"></u-action-sheet>
			</u-form-item>
			<u-form-item label="身份:" prop="role">
				<input v-model="form.role" type="select" @click="role_click" class="ct_intput" :style="redback" disabled="true"/>
				<u-action-sheet :list="rolelist" v-model="role_show" @click="role_sheet"></u-action-sheet>
			</u-form-item>
		</u-form>
		</view>
		<view class="ct_btn">
		<u-row gutter="16">
					<u-col span="6">
						<button @click="change" v-show="btn_show">编辑</button>
						<button @click="submit" v-show="!btn_show">完成</button>
					</u-col>
					<u-col span="6">
						<button @click="avatar">同步头像</button>
					</u-col>
			</u-row></view>
	</view></view>
</template>

<script>
	export default{
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		onShow() {
			this.flash()
		},
		data(){
			return{
				sex_show: false,
				sub_show:false,
				role_show:false,
				sexlist: [{
						text: '男'
					},
					{
						text: '女'
					}
				],
				rolelist: [{
						text: '班主任'
					},
					{
						text: '教师'
					}
				],
				sublist: getApp().globalData.objforselect,
				btn_show:true,
				redback:{},
				is:true,
				form:{
					name:'',
					phone:'',
					src:'',
					sex:'',
					sub:'',
					role:''
				},
				rules: {
					name: [{
						required: true,
						message: '请输入家长姓名',
						trigger: ['change', 'blur']
					}],
					phone: [{
							required: true,
							message: '请输入电话号码',
							trigger: ['change', 'blur'],
						},
						{
							validator: (rule, value, callback) => {
								// 返回true表示校验通过，返回false表示不通过
								// this.$u.test.mobile()就是返回true或者false的
								return this.$u.test.mobile(value);
							},
							message: '手机号码不正确',
							// 触发器可以同时用blur和change
							trigger: ['change', 'blur'],
						}
					]
				}
			}
		},
		methods:{
			sex_click(){
				if(this.btn_show == false){
					this.sex_show = true
				}
			},
			sub_click(){
				if(this.btn_show == false){
					this.sub_show = true
				}
			},
			role_click(){
				if(this.btn_show == false){
					this.role_show = true
				}
			},
			sex_sheet(index){
				this.form.sex = this.sexlist[index].text
			},
			sub_sheet(index){
				this.form.sub = this.sublist[index].text
			},
			role_sheet(index){
				this.form.role = this.rolelist[index].text
			},
			avatar(){
				wx.getUserProfile({
					desc: '用于完善会员资料', // 声明获取用户个人信息后的用途，后续会展示在弹窗中，请谨慎填写
					success: (res) => {
						console.log(res.userInfo)
						if(this.form.src == res.userInfo.avatarUrl){
							
						}else{
							this.form.src = res.userInfo.avatarUrl
							uni.request({
								url:'https://www.sykdesign.xyz/phpbin/PHP.php',
								data:{
									type:'try',
									sql:"update teacherinfo set tPic = '"+this.form.src+"' where tOpenid = '"+uni.getStorageSync('openid')+"'"
								},
								success: (res) => {
									uni.showToast({
										title:'成功',
										duration:1000,
										success:(res) =>{
											this.btn_show = true,
											this.is = true,
											this.redback ="background-color: #ffffff"
										}
									})
								}
							})
						}
					}
				})
			},
			change(){
				this.btn_show = false,
				this.is = false,
				this.redback ="background-color: #efb960"
			},
			submit(){
				this.$refs.uForm.validate(valid => {
					if(valid){
						uni.request({
							url:'https://www.sykdesign.xyz/phpbin/PHP.php',
							data:{
								type:'try',
								sql:"update teacherinfo set tRealname = '"+this.form.name+"' ,tPhone = '"+this.form.phone+"' ,tSub = '"+this.form.sub+"' ,tSex = '"+this.form.sex+"' ,tRole = '"+this.form.role+"' where tOpenid = '"+uni.getStorageSync('openid')+"'"
							},
							success: (res) => {
								uni.showToast({
									title:'成功',
									duration:1000,
									success:(res) =>{
										this.btn_show = true,
										this.is = true,
										this.redback ="background-color: #ffffff"
									}
								})
							}
						})
					}
				})
			},
			flash(){
				uni.request({
					url:'https://www.sykdesign.xyz/phpbin/PHP.php',
					data:{
						type:'string',
						sql:"select * from teacherinfo where tOpenid = '"+uni.getStorageSync('openid')+"'"
					},
					success: (res) => {
						console.log(res.data)
						this.form.name = res.data.tRealname,
						this.form.phone = res.data.tPhone,
						this.form.src = res.data.tPic,
						this.form.sex = res.data.tSex,
						this.form.sub = res.data.tSub,
						this.form.role = res.data.tRole
					}
				})
			}
		}
	}
</script>

<style>
	.ct_body{
		text-align: center;
		 margin-top: 50px;
		 }
	.ct_form{
		margin-left: 50px;
		margin-right: 50px;
	}
	.ct_intput{
		border: #909399;
		height: 30px;
		background-color: #ffffff;
	}
	.ct_btn{
		margin-top: 10px;
	}
	.ct_color{
		background-color: #edf492;
	}
</style>
