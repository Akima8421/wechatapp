<template>
	<view class="body white first_warp form_top">
		<u-form :model="form" label-width="auto" ref="uForm">
			<u-form-item label="考试类型:" prop="etype">
				<u-input v-model="form.etype" type="select" @click="type_show=true" placeholder="请选择考试类型" />
				<u-action-sheet :list="typelist" v-model="type_show" @click="type_sheet"></u-action-sheet>
			</u-form-item>
			<u-form-item label="考试详情:" prop="etext">
				<u-input v-model="form.etext" type="textarea" />
			</u-form-item>
			<u-form-item label="考试日期:" >
				<u-input v-model="form.choosedate"  type="select" placeholder="请选择日期" @click="t_show = true" inputAlign="center"/>
				<u-calendar v-model="t_show" :mode="mode" @change="change"></u-calendar>
			</u-form-item>
			<u-form-item>
				<u-button size="medium" @click="submit">添加考试</u-button>
				<u-button size="medium" @click="returnback">返回首页</u-button>
			</u-form-item>
		</u-form>
	</view>
</template>

<script>
	import nowdate from '../tabbar.js'
	export default {
		onReady() {
			this.$refs.uForm.setRules(this.rules)
		},
		data() {
			return {
				mode:'date',
				t_show:false,
				stulist:[],
				type_show: false,
				typelist: [{
						text: '月考'
					},
					{
						text: '测验'
					}
				],
				form: {
					etype: '',
					etext: '',
					cid: uni.getStorageSync('choosecid'),
					data:'',
					choosedate:'',
				},
				rules: {
					etype: [{
						required: true,
						message: '请选择类型',
						trigger: ['change', 'blur']
					}],
					etext: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}],
					time: [{
						required: true,
						message: '必填',
						trigger: ['change', 'blur']
					}]
				}
			}
		},
		methods: {
			change:function(e){
				this.form.choosedate = e.result
				console.log(e.result)
				console.log(this.form.choosedate)
			},
			type_sheet: function(index) {
				this.form.etype = this.typelist[index].text;
			},
			returnback: function() {
				uni.switchTab({
					url: '../class/tclass'
				})
			},
			submit: function() {
				this.form.data = nowdate.getDate()
				this.$refs.uForm.validate(valid => {
					if (valid) {
						console.log('111')
						uni.request({
							url: "https://www.sykdesign.xyz/phpbin/Einfo.php",
							data: {
								type: 'Eadd',
								sub:uni.getStorageSync('sub'),
								cid:uni.getStorageSync('choosecid'),
								openid:uni.getStorageSync('openid'),
								etype: this.form.etype,
								date: this.form.choosedate,
								year: this.form.data.substr(0,4),
								term: this.$dateswitch(this.form.data),
								text: this.form.etext
							},
							success:(res)=> {
								uni.showModal({
									title:'添加成功',
									content:'点击确认返回',
									success: (res) => {
										if(res.confirm){
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
		}
	}
</script>

<style>
</style>
