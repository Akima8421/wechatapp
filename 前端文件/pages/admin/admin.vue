<template>
	<view class="index_btn">
		<view class="index_btn_item"><button @click="gotoclasslist" class="btn_item">班级管理</button></view>
		<view class="index_btn_item"><button @click="gototeacherlist" class="btn_item">教师管理</button></view>
		<view class="index_btn_item"><button @click="gotostudentlist" class="btn_item">学生管理</button></view>
		<view class="index_btn_item"><button @click="gotoadminlist" class="btn_item">管理员管理</button></view>
		<view class="index_btn_item"><button @click="yearadd" class="btn_item">增加年份</button></view>
		<view class="index_btn_item"><button @click="out" class="btn_item">退出</button></view>
	</view>
</template>

<script>
	import getDate from '../tabbar.js'
	export default{
		data(){
			return{
				adddate:'',
				addvalue:0,
				count:0,
			}
		},
		methods:{
			out(){
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
			yearadd(){
				uni.request({
					url:'https://www.sykdesign.xyz/phpbin/PHP.php',
					data:{
						type: 'array',
						sql: "select * from yearinfo"
					},
					success:(res) =>{
						this.count = res.data.length - 1
						this.adddate = res.data[this.count].label
						this.addvalue = res.data[this.count].value
						if(this.adddate == getDate.getDate().substr(0,4)){
							uni.showToast({
								title:'年份已增加'
							})
						}else{
							while(this.adddate != getDate.getDate().substr(0,4))
						{
							this.adddate = String(parseInt(this.adddate) + 1)
							this.addvalue++
							uni.request({
								url:'https://www.sykdesign.xyz/phpbin/PHP.php',
								data:{
									type: 'try',
									sql: "insert yearinfo (label , text , value) values ('"+this.adddate+"','"+this.adddate+"' , '"+this.addvalue+"')"
								},
								success:(res) =>{
									uni.showToast({
										title:'成功'
									})
								}
							})
						}
						}
						
					}
				})
			},
			gotoadminlist(){
				uni.navigateTo({
					url:"./adminlist"
				})
			},
			gotostudentlist:function(){
				uni.navigateTo({
					url:"../student/studentlist"
				})
			},
			gotoclasslist:function(){
				uni.navigateTo({
					url:"../class/classlist"
				})
			},
			gototeacherlist:function(){
				uni.navigateTo({
					url:"../teacher/teacherlist"
				})
			},
			gototeacher:function(){
				uni.navigateTo({
					url:"../class/classlist"
				})
			}
		}
	}
</script>

<style>
	.index_btn{
		margin-top: 20%;
		text-align: center;
		
	}
	.index_btn_item{
		margin: 10%;
	}
	.btn_item{
		width: 200px;
	}
</style>
