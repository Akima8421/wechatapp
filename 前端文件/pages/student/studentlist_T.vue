<template>
	<view>
		<view>
			<u-table font-size="100rpx">
				<u-tr>
					<u-th>姓名</u-th>
					<u-th>学号</u-th>
					<u-th>性别</u-th>
					<u-th>家长</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr v-for="(item,index) in studentlist" :key="index">
					<u-td v-text="item.sName"></u-td>
					<u-td><text style="word-break:break-all;">{{item.sId}}</text></u-td>
					<u-td v-text="item.sSex"></u-td>
					<u-td v-text="item.sPname"></u-td>
					<u-td>
						<u-button @click="btn_change(index)" size="mini">修改</u-button>
					</u-td>
				</u-tr>
			</u-table>
			<u-button @click="gotoadd" size="medium" class="H_T_button">新增学生</u-button>
		</view>
		<view>
			<u-mask :show="mask_show" @click="is_mask_show">
				<view class="warp">
					<view class="rect" @tap.stop>
						<u-form :model="form" label-width="auto" ref="uForm">
							<u-form-item label="学生姓名" prop="sname">
								<u-input v-model="form.sname" />
							</u-form-item>
							<u-form-item label="学生学号">
								<u-input disabled="true" :placeholder="form.sid" />
							</u-form-item>
							<u-form-item label="学生家长" prop="pname">
								<u-input v-model="form.pname" />
							</u-form-item>
							<u-form-item label="学生性别" prop="ssex">
								<u-input v-model="form.ssex" type="select" @click="sex_show=true" />
								<u-action-sheet :list="ssexlist" v-model="sex_show" @click="sex_sheet"></u-action-sheet>
							</u-form-item>
							<u-form-item label="学生状态" prop="sis">
								<u-input v-model="form.sis" type="select" @click="is_show=true" />
								<u-action-sheet :list="islist" v-model="is_show" @click="is_sheet"></u-action-sheet>
							</u-form-item>
							<u-form-item>
								<u-button size="medium" @click="submit" type="button">确认修改</u-button>
							</u-form-item>
						</u-form>
					</view>
				</view>
			</u-mask>
		</view>
	</view>
</template>

<script>
	export default {
		onShow() {
			uni.request({
				url: 'https://www.sykdesign.xyz/phpbin/Sinfo.php',
				data: {
					type: 'cid_table',
					cid: uni.getStorageSync('mycid')
				},
				success: (res) => {
					this.studentlist = res.data
				}
			})
		},
		data() {
			return {
				is_show:false,
				sex_show:false,
				ssexlist: [{
						text: '男'
					},
					{
						text: '女'
					}
				],
				islist:[
					{
						text: '可用'
					},
					{
						text: '不可用'
					},
				],
				mask_show: false,
				studentlist: [],
				form: {
					cid: '',
					sid: '',
					sname: '',
					ssex: '',
					pname:'',
					sis:''
				},
			}
		},
		methods: {
			sex_sheet: function(index) {
				this.form.ssex = this.ssexlist[index].text;
			},
			is_sheet: function(index){
				this.form.sis = this.islist[index].text;
			},
			flash: function() {
				this.studentlist = undefined,
					this.studentlist = new Array();
				uni.request({
					url: 'https://www.sykdesign.xyz/phpbin/Sinfo.php',
					data: {
						type: 'cid_table',
						cid: uni.getStorageSync('mycid')
					},
					success: (res) => {
						this.studentlist = res.data
					}
				})
			},
			gotoadd: function() {
				uni.navigateTo({
					url: "./addstudent"
				})
			},
			is_mask_show: function() {
				this.mask_show = false
			},
			btn_change: function(e) {
				this.mask_show = true,
				this.form.sname = this.studentlist[e].sName,
				this.form.sid = this.studentlist[e].sId,
				this.form.pname = this.studentlist[e].sPname,
				this.form.ssex = this.studentlist[e].sSex,
				this.form.sis = this.studentlist[e].sIs == 'true' ? '可用' : '不可用'
			},
			submit:function(){
				this.$refs.uForm.validate(valid => {
					if(valid){
						console.log("suc")
						uni.request({
							url:"https://www.sykdesign.xyz/phpbin/Sinfo.php",
							data:{
								type: "updateStu",
								sname: this.form.sname,
								pname: this.form.pname,
								sex: this.form.ssex,
								sis: this.form.sis == '可用'?'true':'false',
								sid: this.form.sid
							},
							success: res => {
								uni.showModal({
									title: "成功",
									success: res => {
										if (res.confirm) {
											this.is_mask_show()
										}
									}
								})
							}
						})
					}
				}),
				this.flash()
			}
		}
	}
</script>

<style scoped>
  .u-td{
		width: 50%;
	}
</style>
