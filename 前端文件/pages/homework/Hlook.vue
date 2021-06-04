<template>
	<view class="mycard">
		<view v-for="(item,index) in hplist" :key="index" class="card-item">
			<view class="card-name">家长:{{item.name}}</view>
			<view class="card-re">回复:</view>
			<view class="card-text">
				<u-read-more show-height="200" :toggle="true"> 
					<rich-text :nodes="item.text"></rich-text>
				</u-read-more>
			</view>
		</view>
	</view>
</template>

<script>
	export default{
		onLoad(options) {
			console.log(options.index)
			this.homeworkid = options.index
		},
		onShow() {
			uni.request({
				url: "https://www.sykdesign.xyz/phpbin/PHP.php",
				data:{
					type:'array',
					sql:"select * from hpinfo hp left join parentinfo p on hp.hppOpenid = p.pOpenid where hphId = '"+this.homeworkid+"'"
				},
				success:(res)=>{
					console.log(res.data)
					for(var i = 0;i<res.data.length;i++){
						this.hplist.push({
						name: res.data[i].pRealname,
						text: res.data[i].hpText
					})
					}
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/PHP.php",
						data:{
							type:'try',
							sql:"UPDATE hpinfo set hpIs = 'true' where hphId = '"+this.homeworkid+"'"
						},
						success:(res)=>{
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/PHP.php",
								data:{
									type:'try',
									sql:"UPDATE hinfo set hLook = '"+this.hplist.length+"' where hId = '"+this.homeworkid+"'"
								},
								success:(res)=>{
									
								}
							})
						}
					})
				}
			})
			
		},
		data(){
			return{
				homeworkid:'',
				hplist:[],
			}
		},
		methods:{
			
		}
	}
</script>

<style>
	.mycard {
		text-align: center;
		width: 100%;
		height: auto;
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: space-between;
		margin: 0;
		padding: 0 20rpx;
		box-sizing: border-box;
	}
	.card-item {
		background-color: #FFFFFF;
		width: 48%;
		border: 1px solid #007AFF;
		margin-top: 20rpx;
	}
	.card-name{
		margin: 10px;
	}
	.card-re{
		text-align: left;
		margin-left: 10px;
	}
	.card-text{
		word-break:break-all;
		margin: 20px;
	}
</style>
