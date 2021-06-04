<template>
	<view>
		<u-table>
			<u-tr>
				<u-th>姓名</u-th>
				<u-th>学号</u-th>
				<u-th>成绩</u-th>
			</u-tr>
			<u-tr v-for="(item,index) in stulist" :key="index">
				<u-td v-text="item.sName"></u-td>
				<u-td v-text="item.sId"></u-td>
				<u-td>
					<input type="number" @ placeholder="请输入" @input="getinput(index,$event)"
						style="text-align: center" />
				</u-td>
			</u-tr>
		</u-table>
		<view class="table_btn">
		<u-button @click="G_add" :disabled="nostu" size="medium">提交成绩</u-button>
		<u-button @click="G_back" size="medium">返回</u-button></view>
	</view>
</template>

<script>
	export default {
		onLoad(options) {
			console.log(options.index)
			this.examid = options.index
		},
		onShow() {
			this.G_flash()
		},
		data() {
			return {
				average: 0,
				sum:0,
				stulist: [],
				nonull: true,
				examid: 0,
				nostu: false,
			}
		},
		methods: {
			G_back() {
				uni.navigateBack({

				})
			},
			getinput(index, e) {
				console.log(index)
				this.stulist[index].ishave = true,
					this.stulist[index].grade = e.detail.value,
					console.log(this.stulist[index].ishave)
			},
			G_add: function() {
				this.nonull = true
				for (var i = 0; i < this.stulist.length; i++) {
					if (this.stulist[i].ishave == false) {
						this.nonull = false
						break
					}
				}
				if (this.nonull == true) {
					this.sum = 0
					for (var i = 0; i < this.stulist.length; i++) {
						this.sum = this.sum + parseInt(this.stulist[i].grade)
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/PHP.php",
							data: {
								type: 'try',
								sql: "insert into ginfo (gsId,geId,gGrade) VALUES ('" + this.stulist[i].sId +
									"','" + this.examid + "','" + this.stulist[i].grade + "')"
							},
							success: (res) => {
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/PHP.php",
									data: {
										type: 'try',
										sql: "UPDATE einfo set eOk = 'true' where eId = '"+this.examid+"'"
									},
									success() {
										uni.showModal({
											title: '成功',
											content: '点击确认返回',
											success: (res) => {
												if (res.confirm) {
													uni.navigateBack({

													})
												}
											}
										})
									}
								})
							}
						})
					}
					this.average = this.sum / this.stulist.length
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/PHP.php",
						data: {
							type: 'try',
							sql: "UPDATE einfo set eAver = '"+this.average+"' where eId = '"+this.examid+"'"
						},
						success() {
							
						}
					})
				} else {
					uni.showToast({
						duration: 1000,
						title: '存在未填项'
					})
				}
			},
			G_flash: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from studentinfo where cId = '" + uni.getStorageSync('choosecid') +
							"' and sIs = 'true'"
					},
					success: (res) => {
						if(res.data.length == 0){
							this.nostu = true
						}else{
							for (var i = 0; i < res.data.length; i++) {
								this.stulist.push({
									sName: res.data[i].sName,
									sId: res.data[i].sId,
									grade: -1,
									ishave: false
								})
							}
						}
					}
				})
			}
		}
	}
</script>

<style>
</style>
