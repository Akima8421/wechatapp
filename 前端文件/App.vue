<script>
	export default {
		globalData: {
			list: [], // tabBar
			gradeforselect: [{
					text: '一年级'
				},
				{
					text: '二年级'
				},
				{
					text: '三年级'
				},
				{
					text: '四年级'
				},
				{
					text: '五年级'
				},
				{
					text: '六年级'
				}
			],
			gradeforlabel: [{
					label: '一年级',
					value: 1,
				},
				{
					label: '二年级',
					value: 2,
				},
				{
					label: '三年级',
					value: 3,
				},
				{
					label: '四年级',
					value: 4,
				},
				{
					label: '五年级',
					value: 5,
				},
				{
					label: '六年级',
					value: 6,
				}
			],
			objforselect: [{
					text: '数学'
				},
				{
					text: '语文'
				},
				{
					text: '英语'
				},
				{
					text: '科学'
				},
			],
			objforlabel: [{
					label: '语文',
					value: 1,
				},
				{
					label: '英语',
					value: 2,
				},
				{
					label: '数学',
					value: 3,
				},
				{
					label: '科学',
					value: 4,
				}
			]
		},
		onLaunch: function() {
			uni.clearStorageSync();
			//小程序启动时获取用户openid
			uni.login({
				success: res => {
					uni.request({
						url: 'https://www.sykdesign.xyz/phpbin/openid.php',
						data: {
							"code": res.code
						},
						success: res => {
							uni.setStorageSync("openid", res.data.openid)
						}
					})
				}
			})
			uni.request({
				url: 'https://www.sykdesign.xyz/phpbin/A_T.php',
				success: (res) => {
					uni.setStorageSync("access_token", res.data.access_token)
				}
			})
		},
		onShow: function() {
			console.log('App Show')
		},
		onHide: function() {
			console.log('App Hide')
		}
	}
</script>

<style lang="scss">
	@import "uview-ui/index.scss";
	@import "colorui/main.css";
	@import "colorui/icon.css";
	/*每个页面公共css */
	.warp {
		padding: 10px;
		display: flex;
		align-items: center;
		justify-content: center;
		height: 100%;
	}
	.first_warp{
		padding: 10px;
	}
	.rect {
		padding: 10px;
		width: 200px;
		align-items: center;
		justify-content: center;
		background-color: #fff;
	}

	.body {
		margin: 10rpx 30rpx;
		text-align: center;
	}

	.Appcontent {
		display: flex;
		flex-direction: column;
		align-items: center;
		justify-content: center;
	}

	.badge-icon {
		position: absolute;
		top: 14rpx;
		right: 40rpx;
		width: 30rpx;
		height: 30rpx;
	}

	.grid-text {
		font-size: 28rpx;
		margin-top: 4rpx;
		color: $u-type-info;
	}

	.H_T_button {
		position: fixed;
		width: 100%;
		bottom: 80px;
		display: flex;
	}

	.cardbody {
		height: 400px;
	}
	.table_btn{
		text-align:center;
	}
	.white{
		background-color: #FFFFFF;
	}
	.addbtn{
		margin-top: 10px;
	}
	.ave{
		background-color: #a8df65;
	}
	.tabbar_color{
		background-color: #d2e69c;
	}
	.form_top{
		margin-top: 50px;
	}
	.specialbtn{
		margin-left: 13px;
		margin-right: 13px;
		margin-top: 10px;
		margin-bottom: 10px;
	}
</style>
