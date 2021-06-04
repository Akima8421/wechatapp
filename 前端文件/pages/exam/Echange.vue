<template>
	<view>
		<u-table>
			<u-tr>
				<u-th>姓名</u-th>
				<u-th>学号</u-th>
				<u-th>成绩</u-th>
				<u-th>操作</u-th>
			</u-tr>
			<u-tr v-for="(item,index) in stulist" :key="index">
				<u-td v-text="item.sName"></u-td>
				<u-td v-text="item.sId"></u-td>
				<u-td>
					<input type="number" v-model="item.grade" @input="getinput(index,$event)" :disabled="item.isinput"
						:style="item.inputStyle" style="text-align: center" />
				</u-td>
				<u-td>
					<u-button v-show="item.change_btn" @click="show_ok(index)">修改</u-button>
					<u-button v-show="item.ok_btn" @click="submit(index)" custom-style="color: red">确定</u-button>
				</u-td>
			</u-tr>
			<u-tr>
				<u-td></u-td>
				<u-td></u-td>
				<u-td>{{average}}</u-td>
				<u-td>平均分</u-td>
			</u-tr>
		</u-table>
	</view>
</template>

<script>
	export default {
		onLoad(options) {
			console.log(options.index)
			this.examid = options.index,
				this.choosecid = options.cid
		},
		onShow() {
			this.G_flash()
		},
		data() {
			return {
				choosecid: '',
				average: 0,
				sum: 0,
				change_btn: true,
				ok_btn: false,
				stulist: [],
				nonull: true,
				examid: 0,
				nostu: false,
			}
		},
		methods: {
			submit(index) {
				if(this.stulist[index].have == true){
				var that = this
				console.log(index)
				if (that.stulist[index].grade == null) {
					uni.showToast({
						duration: 1000,
						title: '未输入'
					})
				} else {
					console.log(index)
					uni.request({
						url: "https://www.sykdesign.xyz/phpbin/PHP.php",
						data: {
							type: 'try',
							sql: "update ginfo set gGrade = '" + that.stulist[index].grade + "'where gsId = '" +
								that.stulist[index].sId + "' and geId = '" + that.examid + "'"
						},
						success: (res) => {
							this.sum = 0
							for (var i = 0; i < this.stulist.length; i++) {
								this.sum = this.sum + parseInt(this.stulist[i].grade)
							}
							this.average = this.sum / this.stulist.length
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/PHP.php",
								data: {
									type: 'try',
									sql: "UPDATE einfo set eAver = '" + this.average +
										"' where eId = '" + this.examid + "'"
								},
								success() {

								}
							})
							console.log(index)
							uni.showToast({
								duration: 1000,
								title: '成功',
								success() {
									console.log(index)
									that.stulist[index].change_btn = true,
										that.stulist[index].ok_btn = false,
										that.stulist[index].isinput = true,
										that.stulist[index].inputStyles = {
											"background-color": "#ffffff"
										}
								}
							})
						}
					})
				}
				}else{
					var that = this
					console.log(index)
					if (that.stulist[index].grade == null) {
						uni.showToast({
							duration: 1000,
							title: '未输入'
						})
					} else {
						console.log(index)
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/PHP.php",
							data: {
								type: 'try',
								sql: "insert into ginfo (gsId,geId,gGrade) VALUES ('" + this.stulist[index].sId +
									"','" + this.examid + "','" + this.stulist[index].grade + "')"
							},
							success: (res) => {
								this.sum = 0
								for (var i = 0; i < this.stulist.length; i++) {
									this.sum = this.sum + parseInt(this.stulist[i].grade)
								}
								this.average = this.sum / this.stulist.length
								uni.request({
									url: "https://www.sykdesign.xyz/phpbin/PHP.php",
									data: {
										type: 'try',
										sql: "UPDATE einfo set eAver = '" + this.average +
											"' where eId = '" + this.examid + "'"
									},
									success() {
					
									}
								})
								console.log(index)
								uni.showToast({
									duration: 1000,
									title: '成功',
									success() {
										console.log(index)
										that.stulist[index].change_btn = true,
											that.stulist[index].ok_btn = false,
											that.stulist[index].isinput = true,
											that.stulist[index].inputStyles = {
												"background-color": "#ffffff"
											}
									}
								})
							}
						})
				}}
			},
			show_ok(index) {
				this.stulist[index].change_btn = false,
					this.stulist[index].ok_btn = true,
					this.stulist[index].isinput = false,
					this.stulist[index].inputStyles = {
						"background-color": "#efb960"
					}
			},
			G_back() {
				uni.navigateBack({

				})
			},
			getinput(index, e) {
				this.stulist[index].ishave = true,
					this.stulist[index].grade = e.detail.value,
					console.log(this.stulist[index].grade)
			},

			G_flash: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from studentinfo where cId = '" + this.choosecid +
							"' and sIs = 'true'"
					},
					success: (res) => {
						if (res.data.length == 0) {
							this.nostu = true
						} else {
							for (var i = 0; i < res.data.length; i++) {
								this.stulist.push({
									have: false,
									gid: -1,
									sName: res.data[i].sName,
									sId: res.data[i].sId,
									grade: -1,
									ishave: false,
									isinput: true,
									change_btn: true,
									ok_btn: false,
									inputStyle: {
										"background-color": "#ffffff"
									}
								})
							}
						}
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/PHP.php",
							data: {
								type: 'array',
								sql: "select * from ginfo where geId = '" + this.examid +
									"' and gIs = 'true'"
							},
							success: (res) => {
								console.log(res.data)
								this.sum = 0
								for (var i = 0; i < res.data.length; i++) {
									for (var n = 0; n < this.stulist.length; n++) {
										if (this.stulist[n].sId == res.data[i].gsId) {
											this.stulist[n].gid = res.data[i].gid
											this.stulist[n].grade = res.data[i].gGrade
											this.stulist[n].have = true
											this.sum = this.sum + parseInt(this.stulist[i]
												.grade)
										}
									}
								}
								this.average = parseInt(this.sum / this.stulist.length)
							}
						})
					}
				})
			}
		}
	}
</script>

<style>
</style>
