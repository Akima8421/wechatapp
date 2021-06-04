<template>
	<view>
		<view class="white">
		<u-dropdown>
			<u-dropdown-item v-model="value0" :title= f_Year :options="year" @change="yearclose"></u-dropdown-item>
			<u-dropdown-item v-model="value1" :title= f_Term :options="term" @change="termclose"></u-dropdown-item>
			<u-dropdown-item v-model="value2" :title= f_Type :options="type" @change="typeclose"></u-dropdown-item>
			<u-dropdown-item v-model="value3" :title= f_Sub :options="sub" @change="subclose"></u-dropdown-item>
		</u-dropdown></view>
	<view v-for="(item,index) in examlist" :key="index">
			<u-card :title="item.title" :sub-title="item.sub_title">
				<view slot="body">
					<view>详情:</view>
					<view class="homework1">{{item.text}}</view>
					<view class="homework2">
						<u-row gutter="16">
							<u-col span="4">
								<view>科目:{{item.sub}}</view>
							</u-col>
							<u-col span="4">
								<view style="font-size: 15px;">学生成绩:{{item.grade}}</view>
							</u-col>
							<u-col span="4">
								<view>班级平均分:{{item.aver}}</view>
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
	import nowdate from '../tabbar.js'
	export default{
		onPageScroll(e) {
			this.scrollTop = e.scrollTop;
		},
		onLoad() {
			uni.request({
				url:"https://www.sykdesign.xyz/phpbin/Yinfo.php",
				data:{
					type: 'get_label'
				},
				success: res => {
					this.year = res.data
					console.log(this.year)
				}
			})
		},
		onShow() {
			this.E_flash('')
		},
		data(){
			return{
				scrollTop: 0,
				esql:'',
				year:[],
				term:[
					{
						label: '上学期',
						value: 1,
					},
					{
						label: '下学期',
						value: 2,
					},
				],
				type:[
					{
						label: '月考',
						value: 1,
					},{
						label: '测验',
						value: 2,
					},
				],
				sub:getApp().globalData.objforlabel,
				f_Year: nowdate.getDate().substr(0,4),
				f_Term: this.$dateswitch(nowdate.getDate()),
				f_Type: '全部',
				f_Sub: '全部',
				value0: 0,
				value1: 0,
				value2: 0,
				value3: 0,
				choosecid: uni.getStorageSync('myclass'),
				examlist:[],
			}
		},
		methods:{
			E_goto:function(index){
				uni.navigateTo({
					url:'./Echange?index='+ this.examlist[index].id
				})
			},
			E_enter:function(index){
				uni.navigateTo({
					url:'./grade_T?index='+ this.examlist[index].id
				})
			},
			subclose:function(index){
				
				if(this.f_Type == '全部'){
					this.f_Sub = this.sub[index-1].label
					this.esql = " and eSub = '" + this.f_Sub +"'"
					this.E_flash(this.esql)
				}else{
					this.f_Sub = this.sub[index-1].label
					this.esql = " and eSub = '" + this.f_Sub +"' and eType = '" + this.f_Type +"'"
					this.E_flash(this.esql)
				}
			},
			yearclose:function(index){
				this.f_Year = this.year[index-1].label
				this.E_flash('')
			},
			termclose:function(index){
				this.f_Term = this.term[index-1].label
				this.E_flash('')
			},
			typeclose:function(index){
				if(this.f_Sub == '全部'){
					this.f_Type = this.type[index-1].label
					this.esql = " and eType = '" + this.f_Type +"'"
					this.E_flash(this.esql)
				}else{
					this.f_Type = this.type[index-1].label
					this.esql = " and eType = '" + this.f_Type +"' and eSub = '" + this.f_Sub +"'"
					this.E_flash(this.esql)
				}
			},
			E_delete:function(index){
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type:'try',
						sql: "UPDATE einfo set eIs = 'false' where eId = '"+this.examlist[index].id+"'",
					},
					success: () => {
						uni.showToast({
							title:'成功',
							complete: () => {
								this.E_flash()
							}
						})
					}
				})
			},
			E_flash:function(str){
				this.examlist=[]
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data:{
						type:'array',
						// sql: "select * from einfo where eIs = 'true' and ecId = '" + this.choosecid + "' and etOpenid = '"+uni.getStorageSync('openid')+"'"
						sql: "select * from einfo e left join ginfo g on e.eid =  g.geid  where eIs = 'true' and eYear = '" + this.f_Year + "' and eTerm = '" + this.f_Term + "' and ecId = '" + this.choosecid + "' and gsId = '"+uni.getStorageSync('stuid')+"'" +str
					},
					success: (res) => {
						res.data.sort(this.$arrySort2('eId'))
						console.log(res.data)
							if(res.data.length == 0){
								console.log('没有考试')
								this.examlist.push({
									title:'',
									sub_title: '',
									text: '没有发布过考试',
									sub: '',
									have: true,
									ok: true,
									unok: true,
									is: '无考试',
									year:'',
									term:'',
									id: "",
									aver:0,
									grade: 0,
								})
							}else{
								for(var i=0;i<res.data.length;i++){
									this.examlist.push({
										openid: res.data[i].etOpenid,
										title:'类型:'+res.data[i].eType,
										sub_title: '考试时间:' + res.data[i].eDate,
										text: res.data[i].eText,
										sub: res.data[i].eSub,
										have: false,
										ok: res.data[i].eOk == 'false' ? false:true,
										unok: res.data[i].eOk == 'false' ? true:false,
										is: res.data[i].eOk == 'false' ? '未上传':'已上传',
										year:res.data[i].eYear,
										term:res.data[i].eTerm,
										id: res.data[i].eId,
										aver: res.data[i].eAver,
										grade:res.data[i].gGrade
									})
								}
								for(var i=0;i<res.data.length;i++){
									if(this.examlist[i].openid != uni.getStorageSync('openid')){
										this.examlist[i].have = true
									}
								}
							}
						
					}
				})
			}
		}
	}
</script>

<style>
	.homework1 {
		height: 20px;
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
