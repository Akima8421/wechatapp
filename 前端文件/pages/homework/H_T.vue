<template>
	<view class="H_T_body">
		<view class="specialbtn">
		<u-button @click="Hadd" size="default" type="warning" >发布新作业+</u-button></view>
		<view v-for="(item,index) in homeworklist" :key="index">
			<u-card :title="item.name" :sub-title="item.deadline">
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
								<view>已提交:{{item.num}}人</view>
							</u-col>
						</u-row>
					</view>
					<view class="homework2">
						<u-row gutter="16">
							<u-col span="4">
								<view>{{item.is}}</view>
							</u-col>
							<u-col span="4">
								<view>已查看:{{item.ok}}份</view>
							</u-col>
							<u-col span="4">
								<u-button @click="Hlook(index)">查看</u-button>
								<u-button @click="H_delete(index)">删除</u-button>
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
	import getDate from '../tabbar.js'
	export default {
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		},
		onShow() {
			this.H_flash()
		},
		data() {
			return {
				scrollTop: 0,
				date1: '',
				date2: '',
				deadline: '',
				classname: '',
				homeworklist: []
			}
		},
		methods: {
			Hlook(index){
				uni.navigateTo({
					url:'../homework/Hlook?index='+ this.homeworklist[index].id
				})
			},
			Hadd: function() {
				uni.navigateTo({
					url: "./Hadd"
				})
			},
			H_flash: function() {
				this.homeworklist = []
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
						sql:"select * from hinfo h left join teacherinfo r on h.tOpenid = r.tOpenid where h.cId = '"+uni.getStorageSync('choosecid')+"' and hIs = 'true'"
					},
					success: (res) => {
						console.log(res.data)
						if (res.data.length == 0) {
							this.homeworklist.push({
								ok: '',
								class: '',
								sub: '',
								num: '',
								text: '未发布作业',
								name: '未发布作业',
								deadline: '',
								is: '',
								id: ''
							})
						} else {
							res.data.sort(this.$arrySort2('hId'))
							for (var i = 0; i < res.data.length; i++) {
								if(uni.getStorageSync('crole') == '班主任'){
									this.date1 = res.data[i].hDeadline
									this.date2 = getDate.getDate()
									this.date1 = parseInt(this.date1.split('-').join(''))
									this.date2 = parseInt(this.date2.split('-').join(''))
									if (this.date1 >= this.date2) {
										this.deadline = '未截止'
									} else {
										this.deadline = '已截止'
									}
									this.homeworklist.push({
										ok: res.data[i].hLook,
										class: this.classname,
										sub: res.data[i].hSub,
										num: res.data[i].hNum,
										text: res.data[i].hText,
										name: res.data[i].hName,
										deadline: '截止日期' + res.data[i].hDeadline,
										is: this.deadline,
										id: res.data[i].hId
									})
								}else{
									if(res.data[i].tOpenid==uni.getStorageSync('openid')){
										this.date1 = res.data[i].hDeadline
										this.date2 = getDate.getDate()
										this.date1 = parseInt(this.date1.split('-').join(''))
										this.date2 = parseInt(this.date2.split('-').join(''))
										if (this.date1 >= this.date2) {
											this.deadline = '未截止'
										} else {
											this.deadline = '已截止'
										}
										this.homeworklist.push({
											ok: res.data[i].hLook,
											class: this.classname,
											sub: res.data[i].hSub,
											num: res.data[i].hNum,
											text: res.data[i].hText,
											name: res.data[i].hName,
											deadline: '截止日期' + res.data[i].hDeadline,
											is: this.deadline,
											id: res.data[i].hId
										})
									}
								}
							}
						}

					}
				})
			},
			H_delete: function(index) {
				uni.showModal({
					title: '将删除这份作业',
					content: '是否确认',
					success: (res) => {
						if (res.confirm) {
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/Hinfo.php",
								data: {
									type: 'H_delete',
									hid: this.homeworklist[index].id
								},
								success: () => {
									this.H_flash()
								}
							})
						}
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
