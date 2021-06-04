<template>
	<view>
		<view>
		<view class="white">
		<u-dropdown>
			<u-dropdown-item v-model="value0" :title= f_Is :options="t_is" @change="ischange"></u-dropdown-item>
		</u-dropdown></view>
		
			<u-table>
				<u-tr>
					<u-th>姓名</u-th>
					<u-th>手机号</u-th>
					<u-th>科目</u-th>
					<u-th>状态</u-th>
					<u-th>操作</u-th>
				</u-tr>
				<u-tr v-for="(item,index) in teacherlist" :key="index">
					<u-td v-text="item.tRealname"></u-td>
					<u-td><text style="word-break:break-all;">{{item.tPhone}}</text></u-td>
					<u-td v-text="item.tSub"></u-td>
					<u-td v-text="item.tIs =='true'? '可用':'不可用'"></u-td>
					<u-td>
						<u-button @click="btn_change(index)">修改</u-button>
					</u-td>
				</u-tr>
			</u-table>
		</view>
		<view>
			<u-mask :show="mask_show" @click="is_mask_show">
				<view class="warp">
					<view class="rect" @tap.stop>
						<u-form :model="form" label-width="auto" ref="uForm">
							<u-form-item label="姓名:" prop="name">
								<u-input v-model="form.tname" />
							</u-form-item>
							<u-form-item label="手机号:">
								<u-input  v-model="form.tphone" />
							</u-form-item>
							<u-form-item label="状态:" prop="is">
								<u-input v-model="form.tis" type="select" @click="is_show=true" />
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
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		onShow() {
			this.flash()

		},
		data() {
			return {
				value0: 1,
				f_Is:'全部',
				t_is:[{
						label: '全部',
						value: 1,
					},
					{
						label: '可用',
						value: 2,
					},
					{
						label: '不可用',
						value: 3,
					}],
				tis2:'',
				tis:'',
				rules: {
					tname: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
					phone: [{
							required: true,
							message: '请输入电话号码',
							trigger: ['change', 'blur'],
						},
						{
							validator: (rule, value, callback) => {
								// 返回true表示校验通过，返回false表示不通过
								// this.$u.test.mobile()就是返回true或者false的
								return this.$u.test.mobile(value);
							},
							message: '手机号码不正确',
							// 触发器可以同时用blur和change
							trigger: ['change', 'blur'],
						}
					]
				},
				form: {
					tis: '',
					tname: '',
					tphone: '',
					openid: ''
				},
				is_show: false,
				mask_show: false,
				teacherlist: [],
				islist: [{
					text: '可用'
				}, {
					text: '不可用'
				}]
			}
		},
		methods: {
			ischange: function(index){
				this.f_Is = this.t_is[index-1].label
				this.tis = this.f_Is
				if(this.tis == '全部'){
					this.flash()
				}else{
					this.is = this.t_is[index-1].label == '可用' ? true : false
					uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from teacherinfo where tIs = '" +this.is+"'"
					},
					success: res => {
						this.teacherlist = res.data
						console.log(this.teacherlist)
					}
				})
				}
				
			},
			flash: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/PHP.php",
					data: {
						type: 'array',
						sql: "select * from teacherinfo"
					},
					success: res => {
						this.teacherlist = res.data
						console.log(this.teacherlist)
					}
				})
			},
			btn_change: function(index) {
				this.mask_show = true,
					this.form.tname = this.teacherlist[index].tRealname,
					this.form.tphone = this.teacherlist[index].tPhone,
					this.form.tis = this.teacherlist[index].tIs == 'true' ? '可用' : '不可用',
					this.form.openid = this.teacherlist[index].tOpenid,
					this.tis = this.teacherlist[index].tIs
					console.log(this.form)
			},
			is_mask_show: function() {
				this.mask_show = false
			},
			is_sheet: function(index) {
				this.form.tis = this.islist[index].text,
				this.is = this.form.tis == '可用' ? true : false
			},
			submit: function() {
				console.log(this.form)
				this.$refs.uForm.validate(valid => {
					if (valid) {
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/PHP.php",
							data: {
								type: 'try',
								sql: "update teacherinfo set tRealname = '" + this.form.tname +
									"' , tPhone = '" + this.form.tphone + "' ,tIs = '"+this.is+"' where tOpenid = '" + this.form
									.openid + "'"
							},
							success: () => {
								uni.showToast({
									title:'成功',
									duration:1000
								})
								this.mask_show = false,
									this.flash()
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
