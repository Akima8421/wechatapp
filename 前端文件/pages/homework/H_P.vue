<template>
	<view class="H_T_body">
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
								<view>{{item.ok}}</view>
							</u-col>
							<u-col span="4">
								<u-button v-show="item.sub_btn" @click="Hback(index)">提交作业完成情况</u-button>
								<u-button v-show="item.up_btn" @click="Hchange(index)">修改作业完成情况</u-button>
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
				sub_btn: true,
				up_btn: false,
				date1: '',
				date2: '',
				deadline: '',
				classname: '',
				homeworklist: []
			}
		},
		methods: {
			Hback(index) {
				uni.navigateTo({
					url: '../homework/Hback?index=' + this.homeworklist[index].id
				})
			},
			Hchange(index){
				uni.navigateTo({
					url:'./Hchange?index='+ this.homeworklist[index].id
				})
			},
			H_flash: function() {
				this.homeworklist = []
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
					data: {
						type: 'find_cid',
						cid: uni.getStorageSync('myclass')
					},
					success: (res) => {
						this.classname = res.data.cName
					}
				})
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from hinfo h left join hpinfo p on h.hid = p.hphid where (hppOpenid = '"+uni.getStorageSync('openid')+"' or hppOpenid is Null ) and cId = '"+uni.getStorageSync('myclass')+"' and hIs = 'true'"
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
								id: '',
								sub_btn: false,
								up_btn : false
							})
						} else {
							res.data.sort(this.$arrySort2('hId'))
							for (var i = 0; i < res.data.length; i++) {
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
									ok: res.data[i].hpIs == 'true' ? '已查看' : '未查看',
									class: this.classname,
									sub: res.data[i].hSub,
									num: res.data[i].hNum,
									text: res.data[i].hText,
									name: res.data[i].hName,
									deadline: '截止日期' + res.data[i].hDeadline,
									is: this.deadline,
									id: res.data[i].hId,
									sub_btn: res.data[i].hpIs == null ? true : false,
									up_btn : res.data[i].hpIs == null ? false : true,
								})
							}
							console.log(this.homeworklist)
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
