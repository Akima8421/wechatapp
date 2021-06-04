<template>
	<view>
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
								<u-button @click="N_num(index)" :disabled="item.nbis">{{item.nis}}</u-button>
							</u-col>
							<u-col span="4">
								
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
	export default{
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		},
		onLoad(options) {
			this.classname = options.classname
		},
		onShow() {
			this.N_P_flash()
		},
		data(){
			return{
				scrollTop: 0,
				classname:'',
				noticelist:[],
			}
		},
		methods:{
			N_P_flash:function(){
				this.noticelist = []
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/Ninfo.php",
					data: {
						type: 'searchNinfo_NPinfo',
						classid: uni.getStorageSync('myclass'),
						openid: uni.getStorageSync('openid')
					},
					success: (res) => {
						console.log(res.data)
						if (res.data.length != 0) {
							res.data.sort(this.$arrySort2('nId'))
							for (var i = 0; i < res.data.length; i++) {
								this.noticelist.push({
									class: this.classname,
									sub: res.data[i].nSub,
									num: res.data[i].nNum,
									text: res.data[i].nText,
									title: res.data[i].nName,
									id: res.data[i].nId,
									sub_title: '发布于:'+res.data[i].nTime,
									nis: res.data[i].pOpenid == null ? '确认公告' : '已确认',
									nbis: res.data[i].pOpenid == null ? false : true,
								})
							}
						}else {
							this.noticelist = [{
								class: '',
								sub: '',
								num: 0,
								text: '未发布任何公告',
								title: '公告不存在',
								id: '',
								sub_title: '',
								nis: '确认公告',
								nbis: true,
							}]
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
	
	.H_T_body{
		margin-bottom: 70px;
	}
</style>
