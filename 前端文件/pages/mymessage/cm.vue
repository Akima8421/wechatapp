<template>
	<view>
		<u-cell-group>
			<u-cell-item icon="setting-fill" title="班级信息管理" @click="C_C"></u-cell-item>
			<u-cell-item icon="setting-fill" title="教师管理" @click="tl"></u-cell-item>
			<u-cell-item icon="bag-fill" title="学生管理" @click="sl"></u-cell-item>
		</u-cell-group>	
	</view>
</template>

<script>
	export default{
		methods:{
			C_C:function(){
				uni.navigateTo({
					url: '../class/class_M?index='+'班主任'+'&cid='+uni.getStorageSync('mycid')
				})
			},
			tl:function(){
				uni.navigateTo({
					url: "../teacher/teacherlist_T"
				})
			},
			sl:function(){
				uni.navigateTo({
					url: "../student/studentlist_T"
				})
			},
		}
	}
</script>

<style>
</style>
