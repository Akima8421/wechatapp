<template>
	<view>
		<view class="u-flex user-box u-p-l-30 u-p-r-20 u-p-b-30" v-for="(item,index) in parentlist" :key="index">
			<view class="u-m-r-10">
				<u-avatar :src="item.src" size="140"></u-avatar>
			</view>
			<view class="u-flex-1">
				<view class="u-font-18 u-p-b-20">姓名:{{item.name}}</view>
				<view class="u-font-14 u-tips-color">性别：{{item.sex}}</view>
				<view class="u-font-14 u-tips-color">手机号：{{item.phone}}</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default{
		onLoad(options) {
			this.cid = options.cid
			this.parentlist = []
			this.flash()
		},
		onShow() {
			
		},
		data(){
			return{
				parentlist:[]
			}
		},
		methods:{
			flash(){
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/PHP.php',
					data: {
						type: 'array',
						sql: "select * from parentinfo p left join studentinfo s on p.pOpenid = s.pOpenid where cId = '" + this.cid + "' and pIs = 'true'"
					},
					success: (res) => {
						for (var i = 0; i < res.data.length; i++) {
							this.parentlist.push({
							name: res.data[i].pRealname,
							sex: res.data[i].pSex,
							phone: res.data[i].pPhone,
							src: res.data[i].pPic
						})
						}
						console.log(this.parentlist)
					}
				})
			}
		}
	}
</script>

<style>
	.user-box {
		background-color: #fff;
		margin: 20px;
		padding-top: 10px;
	}
</style>
