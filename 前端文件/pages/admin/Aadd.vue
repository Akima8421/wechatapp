<template>
	<view>
		<view>
			<u-table>
				<u-tr>
					<u-th>姓名</u-th>
					<u-th>手机号</u-th>
					<u-th>科目</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr v-for="(item,index) in teacherlist" :key="index">
					<u-td v-text="item.tRealname"></u-td>
					<u-td><text style="word-break:break-all;">{{item.tPhone}}</text></u-td>
					<u-td v-text="item.tSub"></u-td>
					<u-td>
						<u-button @click="btn_change(index)">添加</u-button>
					</u-td>
				</u-tr>
			</u-table>
		</view>
	</view>
</template>

<script>
	export default {
		onShow() {
			this.flash()
		},
		data() {
			return {
				form: {
					tis: '',
					tname: '',
					tphone: '',
					openid: ''
				},
				teacherlist: [],
			}
		},
		methods: {
			flash: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from teacherinfo t left join admininfo a on t.tOpenid = a.aOpenid where tIs ='true' and aName is null"
					},
					success: res => {
						this.teacherlist = res.data
						console.log(this.teacherlist)
					}
				})
			},
			btn_change: function(index) {
				uni.showModal({
					title:'是否确认添加',
					success: (res) => {
						if(res.confirm){
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/PHP.php",
								data: {
									type: 'try',
									sql: "insert into admininfo (aName,aPhone,aOpenid) values ('"+this.teacherlist[index].tRealname+"','"+this.teacherlist[index].tPhone+"','"+this.teacherlist[index].tOpenid+"')"
								},
								success: (res) => {
									this.flash()
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
</style>
