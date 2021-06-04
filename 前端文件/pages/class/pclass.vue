<template>
	<view>
		<view>
			<u-tabs-swiper ref="uTabs" :list="tab_list" :is-scroll="false" :current="tab_current" @change="tab_change">
			</u-tabs-swiper>
			<swiper class="cardbody" :autoplay="false"  :current="swiper_current"
				@transition="swiper_change" @animationfinish="animationfinish">
				<swiper-item>
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
											<view>{{item.is}}</view>
										</u-col>
										<u-col span="4">
											<u-button @click="N_num(index)" :disabled="item.nbis">{{item.nis}}
											</u-button>
										</u-col>
										<u-col span="4">
											<u-button @click="N_P">全部公告</u-button>
										</u-col>
									</u-row>
								</view>
							</view>
						</u-card>
					</view>
				</swiper-item>
				<swiper-item >
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
											<view>提交{{item.ok}}</view>
										</u-col>
										<u-col span="4">
											<u-button v-show="item.sub_btn" @click="Hback(index)">提交</u-button>
											<u-button v-show="item.up_btn" @click="Hchange(index)">修改</u-button>
											<u-button @click="H_P">全部</u-button>
										</u-col>
									</u-row>
								</view>
							</view>
						</u-card>
					</view>
				</swiper-item>
				<swiper-item>
					<view class="charts-box">
						<qiun-data-charts :type="uchart_type" :chartData="chartData" background="#FFFFFF"
							:animation="true" reshow="ischoose" />
					</view>
					<view style="font-size: 15px; text-align: center;color: #AAAAAA;">*若成绩显示101分,表示该科目未曾进行过考试</view>
				</swiper-item>
			</swiper>
			<view class="psname">{{classname}}:{{stuname}}</view>
		</view>

		<u-tabbar :list="list"></u-tabbar>
	</view>
</template>

<script>
	import getDate from '../tabbar.js'
	export default {
		onShow() {
			this.flash()
		},
		data() {
			return {
				gradelist: [],
				examlist: [],
				sublist: getApp().globalData.objforselect,
				ischoose: false,
				chartData: {
					categories: [],
					series: [{
						name: '成绩',
						data: []
					}]
				},
				uchart_type: 'radar',
				noticelist: [],
				homeworklist: [],
				stuname: '',
				classname: '',
				list: getApp().globalData.list,
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
		methods: {
			Hchange(index) {
				uni.navigateTo({
					url: '../homework/Hchange?index=' + this.homeworklist[index].id
				})
			},
			Hback(index) {
				uni.navigateTo({
					url: '../homework/Hback?index=' + this.homeworklist[index].id
				})
			},
			H_P: function() {
				uni.navigateTo({
					url: "../homework/H_P"
				})
			},
			ex_change: function() {

			},
			stopTouchMove() {
				return true;
			},
			N_P: function() {
				uni.navigateTo({
					url: "../notice/N_P?classname="+this.classname
				})
			},
			N_num: function(index) {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
					data: {
						type: 'N_num',
						nid: this.noticelist[index].id,
						openid: uni.getStorageSync('openid')
					},
					success: (res) => {
						this.flash()
					}
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
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
					data: {
						type: 'string',
						sql: "select * from class c inner join studentinfo s on c.cid = s.cid where pOpenid = '" +
							uni.getStorageSync('openid') + "' and sIs = 'true' and cis = 'true'"
					},
					success: (res) => {
						console.log(res.data)
						if (res.data == null) {
							uni.showModal({
								title: '没有找到您的孩子',
								content: '请联系管理员',
								success(res) {
									if (res.confirm) {
										uni.navigateTo({
											url: '../index/index'
										})
									} else {
										uni.navigateTo({
											url: '../index/index'
										})
									}
								}
							})
						} else {
							uni.setStorageSync('myclass', res.data.cId)
							uni.setStorageSync('stuid', res.data.sId)
							this.stuname = res.data.sName
							uni.request({
								url: 'https://www.sykdesign.xyz/phpbin/Cinfo.php',
								data: {
									type: 'find_cid',
									cid: uni.getStorageSync('myclass')
								},
								success: (e) => {
									this.classname = e.data.cName,
										this.noticelist = []
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
										data: {
											type: 'searchNinfo_NPinfo',
											classid: uni.getStorageSync('myclass'),
											openid: uni.getStorageSync('openid')
										},
										success: (res) => {
											if(res.data.length == 0){
												this.noticelist.push({
													class: '',
													sub: '',
													num: 0,
													text: '班级内无公告',
													title: '无公告',
													id: '',
													sub_title: '发布于:' + '',
													nis: '确认公告',
													nbis: true,
												})
											}else{
												res.data.sort(this.$arrySort2('nId'))
												for (var i = 0; i < 1; i++) {
													this.noticelist.push({
														class: this.classname,
														sub: res.data[i].nSub,
														num: res.data[i].nNum,
														text: res.data[i]
															.nText,
														title: res.data[i]
															.nName,
														id: res.data[i].nId,
														sub_title: '发布于:' + res
															.data[i].nTime,
														nis: res.data[i]
															.pOpenid ==
															null ? '确认公告' :
															'已确认',
														nbis: res.data[i]
															.pOpenid == null ?
															false : true,
													})
												}
											}
										}
									})
									this.homeworklist = []
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/PHP.php",
										data: {
											type: 'array',
											sql: "select * from hinfo h left join hpinfo p on h.hid = p.hphid where (hppOpenid = '" +
												uni.getStorageSync('openid') +
												"' or hppOpenid is Null ) and cId = '" +
												uni.getStorageSync('myclass') +
												"' and hIs = 'true'"
										},
										success: (res) => {
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
													up_btn: false
												})
											} else {
												res.data.sort(this.$arrySort2(
													'hId'))
												for (var i = 0; i < 1; i++) {
													this.date1 = res.data[i]
														.hDeadline
													this.date2 = getDate.getDate()
													this.date1 = parseInt(this
														.date1.split('-').join(
															''))
													this.date2 = parseInt(this
														.date2.split('-').join(
															''))
													if (this.date1 >= this.date2) {
														this.deadline = '未截止'
													} else {
														this.deadline = '已截止'
													}
													this.homeworklist.push({
														ok: res.data[i]
															.hpIs ==
															'true' ?
															'已查看' : '未查看',
														class: this
															.classname,
														sub: res.data[i]
															.hSub,
														num: res.data[i]
															.hNum,
														text: res.data[i]
															.hText,
														name: res.data[i]
															.hName,
														deadline: '截止日期' +
															res.data[i]
															.hDeadline,
														is: this.deadline,
														id: res.data[i]
															.hId,
														sub_btn: res.data[
																i].hpIs ==
															null ? true :
															false,
														up_btn: res.data[i]
															.hpIs == null ?
															false : true,
													})
												}
											}

										}
									})
									this.chartData = {
										categories: [],
										series: [{
											name: "成绩",
											data: []
										}]
									}
									uni.request({
										url: "https://www.sykdesign.xyz/phpbin/PHP.php",
										data: {
											type: 'array',
											sql: "select * from einfo e left join ginfo g on e.eId = g.geId where ecId = '" +
												uni.getStorageSync('myclass') +
												"' and eIs = 'true' and gsId = '" + uni
												.getStorageSync('stuid') + "'"
										},
										success: (res) => {
											console.log(res.data)
											res.data.push({
												eAver: 0,
												eDate: "0000-00-00",
												eId: 0,
												eIs: "true",
												eOk: "false",
												eSub: "数学",
												eTerm: "上学期",
												eText: "",
												eType: "测验",
												eYear: "0000",
												ecId: uni.getStorageSync(
													'myclass'),
												etOpenid: uni
													.getStorageSync(
														'openid'),
												gGrade: 101,
												gId: 0,
												gIs: "true",
												geId: 0,
												gsId: uni.getStorageSync(
													'stuid')
											}, {
												eAver: 0,
												eDate: "0000-00-00",
												eId: 0,
												eIs: "true",
												eOk: "false",
												eSub: "科学",
												eTerm: "上学期",
												eText: "",
												eType: "测验",
												eYear: "0000",
												ecId: uni.getStorageSync(
													'myclass'),
												etOpenid: uni
													.getStorageSync(
														'openid'),
												gGrade: 101,
												gId: 0,
												gIs: "true",
												geId: 0,
												gsId: uni.getStorageSync(
													'stuid')
											}, {
												eAver: 0,
												eDate: "0000-00-00",
												eId: 0,
												eIs: "true",
												eOk: "false",
												eSub: "英语",
												eTerm: "上学期",
												eText: "",
												eType: "测验",
												eYear: "0000",
												ecId: uni.getStorageSync(
													'myclass'),
												etOpenid: uni
													.getStorageSync(
														'openid'),
												gGrade: 101,
												gId: 0,
												gIs: "true",
												geId: 0,
												gsId: uni.getStorageSync(
													'stuid')
											}, {
												eAver: 0,
												eDate: "0000-00-00",
												eId: 0,
												eIs: "true",
												eOk: "false",
												eSub: "语文",
												eTerm: "上学期",
												eText: "",
												eType: "测验",
												eYear: "0000",
												ecId: uni.getStorageSync(
													'myclass'),
												etOpenid: uni
													.getStorageSync(
														'openid'),
												gGrade: 101,
												gId: 0,
												gIs: "true",
												geId: 0,
												gsId: uni.getStorageSync(
													'stuid')
											})
											res.data.sort(this.$dateSort2('eDate'))
											for (var i = 0; i < 4; i++) {
												for (var n = 0; n < res.data
													.length; n++) {
													if (res.data[n].eSub == this
														.sublist[i].text) {
														this.chartData.categories
															.push(this.sublist[i]
																.text)
														this.chartData.series[0]
															.data.push(res.data[n]
																.gGrade)
														break
													}
												}
											}
										}
									})
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

	.psname {
		text-align: center;
		font-size: 40px;
	}
</style>
