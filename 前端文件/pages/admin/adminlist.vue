<template>
	<view>
		<u-table>
			<u-tr>
				<u-th>姓名</u-th>
				<u-th>手机号</u-th>
				<u-th>操作</u-th>
			</u-tr>
			<u-tr v-for="(item,index) in adminlist" :key="index">
				<u-td v-text="item.aName"></u-td>
				<u-td v-text="item.aPhone"></u-td>
				<u-td>
					<u-button @click="btn_delete(index)">删除</u-button>
				</u-td>
			</u-tr>
		</u-table>
		<u-button @click="gotoAadd" size="medium" class="H_T_button">添加管理员</u-button>
	</view>
</template>

<script>
	export default{
		onShow() {
			this.flash()
		},
		data(){
			return{
				count:-1,
				adminlist:[]
			}
		},
		methods:{
			gotoAadd(){
				uni.navigateTo({
					url:"./Aadd"
				})
			},
			flash(){
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from admininfo where aIs = 'true'"
					},
					success: (res) => {
						this.adminlist =res.data
						this.count = res.data.length
					}
				})
			},
			btn_delete(index){
				if(this.count == 1){
					uni.showModal({
						title:'只有一位管理员无法删除',
					})
				}else{
					uni.showModal({
					title:'是否确认删除',
					success: (res) => {
						if(res.confirm){
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/PHP.php",
								data: {
									type: 'try',
									sql: "UPDATE admininfo set aIs = 'false' where aId = '"+this.adminlist[index].aId+"'"
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
	}
</script>

<style>
</style>
