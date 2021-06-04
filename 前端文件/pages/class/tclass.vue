<template>
	<view>
		<image src="../../static/plist.png" class="tc_img" v-show="tc_img"></image>
		<view v-show="ischoose">
			<view>
				<u-tabs-swiper ref="uTabs" :list="tab_list" :is-scroll="false" :current="tab_current"
					@change="tab_change"></u-tabs-swiper>
				<swiper class="cardbody" :autoplay="false"  :current="swiper_current" 
				@transition="swiper_change" @animationfinish="animationfinish">
					<!-- 公告栏 -->
					<!-- @touchmove.stop='stopTouchMove' -->
					<swiper-item >
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
												<u-button @click="N_delete(index)" :disabled="item.have" v-show="btn_d">删除</u-button>
												<u-button @click="goto_Nadd" v-show="btn_a">发布公告</u-button>
											</u-col>
											<u-col span="4">
												<u-button @click="N_T">全部公告</u-button>
											</u-col>
										</u-row>
									</view>
								</view>
							</u-card>
						</view>
					</swiper-item>
					<!-- 作业栏 -->
					<swiper-item>
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
												<view>状态:{{item.is}}</view>
											</u-col>
											<u-col span="4">
												<view>已查看:{{item.ok}}份</view>
											</u-col>
											<u-col span="4">
												<u-button @click="Hlook(index)" class="t_butn">查看</u-button>
												<!-- <u-button @click="H_delete(index)">删除</u-button> -->
												<u-button @click="H_T">全部</u-button>
											</u-col>
										</u-row>
									</view>
								</view>
							</u-card>
						</view>
					</swiper-item>
					<!-- 成绩栏 -->
					<swiper-item>
						<view class="charts-box">
							<qiun-data-charts :type="uchart_type" :chartData="chartData" background="#FFFFFF"
								:animation="true" reshow="ischoose" />
						</view>
					</swiper-item>
				</swiper>
			</view>
		</view>
		<view>
			<u-popup v-model="n_show" border-radius="14">
				<view class="tc_list">
					<slot>
						<view class="t_listbtn" v-for="(item,index) in clist " :key="index">
						<button @click="setclass(index)" size="medium">{{item.cName}}</button>
						</view>
					</slot>
				</view>
			</u-popup>
			<u-button @click="nbtn_show" class="tc_button" size="medium" type="warning">{{classname}}</u-button>
		</view>
		<u-tabbar :list="list"></u-tabbar>
	</view>
</template>

<script>
	import getDate from '../tabbar.js'
	let app = getApp()
	export default {
		data() {
			return {
				tc_img: true,
				picsrc:"https://www.sykdesign.xyz/phpbin/pic/plist.png",
				chartDatearry:[],
				chartdate:'',
				btn_a:false,
				btn_d:true,
				uchart_type: 'line',
				chartData: {
					categories: ["一月", "二月", "三月", "四月", "五月", "六月"],
					series: [{
						name: "本班数学平均成绩",
						data: [80, 79, 50, 66, 13, 15]
					}, {
						name: "全年级数学平均成绩",
						data: [88, 45, 50, 77, 18, 85]
					}]
				},
				set_btn: 0,
				ischoose: false,
				noticelist: [],
				homeworklist: [{
					title: "最新作业",
					subtitle: '截止于：2021-04-14'
				}],
				list: app.globalData.list,
				classname: '选择班级',
				n_show: false,
				clist: [],
				cidlist: uni.getStorageSync('allcid'),
				duration: 400,
				tab_list: [{
						name: '公告'
					},
					{
						name: '作业'
					},
					{
						name: '成绩'
					},
				],
				tab_current: 0,
				swiper_current: 0
			}
		},
		onLoad() {
			uni.setStorage({
				key:'choosecid',
				data: ""
			})
		},
		onShow() {
			if (this.set_btn != 0) {
				this.tc_img = false
				this.flash()
			}
		},
		onReady() {
			console.log(this.cidlist)
		},
		methods: {
			Hlook(index){
				uni.navigateTo({
					url:'../homework/Hlook?index='+ this.homeworklist[index].id
				})
			},
			goto_Nadd:function(){
				uni.navigateTo({
					url:"../notice/Nadd"
				})
			},
			nbtn_show: function() {
				this.clist = [],
				this.cidlist = uni.getStorageSync('allcid')
				if(this.cidlist.length == 0){
					uni.showModal({
						title:'您没有加入班级',
						content:'请联系各个班主任',
						success(res) {
							
						}
					})
				}else{
					console.log(this.cidlist)
				console.log(this.cidlist)
				for (var i = 0; i < this.cidlist.length; i++) {
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Cinfo.php",
							data: {
								type: "find_cid",
								cid: this.cidlist[i].cId
							},
							success: (res) => {
								this.clist.push(res.data)
							}
						})
					}
				this.n_show = true
				}
				
			},
			stopTouchMove() {
				return true;
			},
			setclass: function(index) {
				this.classname = this.clist[index].cName,
					uni.setStorageSync('choosecid', this.clist[index].cId)
				this.n_show = false
				this.ischoose = true
				this.set_btn++
				this.tc_img =false
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type:'string',
						sql:"select * from tcinfo where tcOpenid = '"+uni.getStorageSync('openid')+"' and cId = '"+this.clist[index].cId+"'"
					},
					success: (res) => {
						console.log(res.data)
						uni.setStorageSync("crole",res.data.tRole)
						this.flash()
					}
				})
			},
			H_T: function() {
				uni.navigateTo({
					url: "../homework/H_T"
				})
			},
			N_T: function() {
				uni.navigateTo({
					url: "../notice/N_T"
				})
			},
			tab_change: function(index) {
				// this.tab_current = index
				this.swiper_current = index
			},
			swiper_change: function(e) {
				let dx = e.detail.dx;
				this.$refs.uTabs.setDx(dx);
			},
			animationfinish(e) {
							let current = e.detail.current;
							this.$refs.uTabs.setFinishCurrent(current);
							this.swiper_Current = current;
							this.tab_current = current;
						},
			flash: function() {
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
						sql:"select * from ninfo n left join teacherinfo r on n.tOpenid = r.tOpenid where n.cId = '"+uni.getStorageSync('choosecid')+"' and nIs = 'true'"
					},
					success: (res) => {
						console.log(res.data)
						if (res.data.length != 0) {
							res.data.sort(this.$arrySort2('nId'))
							for (var i = 0; i < 1; i++) {
								if(uni.getStorageSync('crole') =='班主任'){
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
								}else{
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
								}}
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
								tname:''
							}],
							this.btn_a = true,
							this.btn_d = false
						}
					}
				})
				this.homeworklist = []
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql:"select * from hinfo h left join teacherinfo r on h.tOpenid = r.tOpenid where h.cId = '"+uni.getStorageSync('choosecid')+"' and h.tOpenid = '"+uni.getStorageSync('openid')+"' and hIs = 'true'"
					},
					success: (res) => {
						console.log(res.data)
						if(res.data.length == 0){
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
						}else{
							res.data.sort(this.$arrySort2('hId'))
						for (var i = 0; i < 1; i++) {
							if(uni.getStorageSync('crole')=='班主任'){
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
									id: res.data[i].hId,
								})
							}else{
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
										id: res.data[i].hId,
									})
							}
						}
						}
						
					}
				})
				this.chartData = {
					categories: [],
					series: [{
						name: "本班"+uni.getStorageSync('sub')+"测验平均成绩(取最近七次)",
						data: []
					}]
				}
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from einfo where ecid = '"+uni.getStorageSync('choosecid')+"' and etOpenid = '"+uni.getStorageSync('openid')+"' and eIs = 'true' and eType = '月考'"
					},
					success: (res) => {
						console.log(res.data)
						if(res.data.length == 0){
							console.log('没有考试信息')
						}if(res.data.length >= 7){
							res.data.sort(this.$dateSort('eDate'))
							for(var i=res.data.length-7;i<res.data.length;i++){
								console.log(res.data[i].eDate)
								this.chartDate = res.data[i].eDate.substr(6,4)
								this.chartData.categories.push(this.chartDate)
								this.chartData.series[0].data.push(res.data[i].eAver)
							}
						}else{
							// this.chartData.categories = [],
							// this.chartData.series = [],
							res.data.sort(this.$dateSort('eDate'))
							for(var i=0;i<res.data.length;i++){
								console.log(res.data[i].eDate)
								this.chartDate = res.data[i].eDate.substr(6,4)
								this.chartData.categories.push(this.chartDate)
								this.chartData.series[0].data.push(res.data[i].eAver)
							}
							
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
								this.flash()
							}
						})
					}
				})
			}
		}
	}
</script>

<style>
	.tc_button {
		position: fixed;
		width: 100%;
		bottom: 100px;
		justify-content: center;
		display: flex;
	}
	.charts-box {
		width: 90%;
		height: 270px;
		margin: 16px;
	}

	.cardtext {
		height: 50px;
		font-size: 15px;
		margin: 30px;
	}

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
	.tc_img{
		width: 100%;
		height: 555px;
	}
	.tc_list{
		margin-top: 50px;
		text-align: center;
	}
	.t_listbtn{
		margin: 20px
	}
</style>
