<template>
	<view>
		<view class="white">
		<u-dropdown>
			<u-dropdown-item v-model="value0" :title=f_obj :options="obj" @change="objchange"></u-dropdown-item>
		</u-dropdown></view>
		<u-table>
			<u-tr>
				<u-th>姓名</u-th>
				<u-th>工号</u-th>
				<u-th>性别</u-th>
				<u-th>科目</u-th>
				<u-th>操作</u-th>
			</u-tr>
			<u-tr v-for="(item,index) in teacherlist" :key="index">
				<u-td v-text="item.tRealname"></u-td>
				<u-td v-text="item.tId"></u-td>
				<u-td v-text="item.tSex"></u-td>
				<u-td v-text="item.tSub"></u-td>
				<u-td>
					<u-button @click="btn_change(index)">加入</u-button>
				</u-td>
			</u-tr>
		</u-table>
		<view>
		<u-button @click="goback" class="H_T_button" size="medium">完成</u-button></view>
	</view>
</template>

<script>
	export default {
		onShow() {
			this.TC_flash()
		},
		data() {
			return {
				value0: 0,
				f_obj: '科目',
				obj: getApp().globalData.objforlabel,
				teacherlist: [],
				tlist: [],
				tclist: [],
			}
		},
		methods: {
			goback(){
				uni.showModal({
					title:'将前往添加学生',
					content:'是否前往',
					cancelText:'返回首页',
					success: (res) => {
						if(res.confirm){
							uni.navigateTo({
								url:"../student/addstudent"
							})
						}if(res.cancel){
							uni.switchTab({
								url:"../class/tclass"
							})
						}
					}
				})
			},
			TC_flash: function() {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_unteacher',
						cid: uni.getStorageSync('mycid')
					},
					success: (res) => {
						this.teacherlist = res.data
					}
				})
			},
			objchange: function(index) {
				this.f_obj = this.obj[index - 1].label;
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'find_unteacher_sub',
						cid: uni.getStorageSync('mycid'),
						sub: this.f_obj
					},
					success: (res) => {
						this.teacherlist = res.data
					}
				})
			},
			btn_change: function(index) {
				uni.request({
					url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
					data: {
						type: 'findsub',
						cid: uni.getStorageSync('mycid'),
						obj: this.teacherlist[index].tSub,
					},
					success: (res) => {
						if (res.data == null) {
							uni.request({
								url: "https://www.sykdesign.xyz/phpbin/TCinfo.php",
								data: {
									type: 'tcadd',
									openid: this.teacherlist[index].tOpenid,
									cid: uni.getStorageSync('mycid'),
									role: '教师',
								},
								success: (res) => {
									this.teacherlist.splice(index, 1)
								}
							})
						} else {
							uni.showToast({
								title: '已有' + this.teacherlist[index].tSub + '老师',
								icon: 'none',
							})
						}
					}
				})
			}
		}
	}
</script>

<style>
	.tm_button{
		text-align: center;
	}
</style>
