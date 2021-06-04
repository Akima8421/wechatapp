// 教师
export const teacherUser = [{
		iconPath: "grid",
		selectedIconPath: "grid-fill",
		pagePath: "/pages/class/tclass",
		text: "班级"
	},
	{
		iconPath: "account",
		selectedIconPath: "account-fill",
		pagePath: "/pages/mymessage/tmy",
		text: "个人中心",
	}
]

// 家长
export const parentUser = [{
		iconPath: "grid",
		selectedIconPath: "grid-fill",
		pagePath: "/pages/class/pclass",
		text: "学生"
	},
	{
		iconPath: "account",
		selectedIconPath: "account-fill",
		pagePath: "/pages/mymessage/pmy",
		text: "我的"
	}

]
//获取时间
const getDate = function() {
	var date = new Date();
	var year = date.getFullYear(); //年 ,从 Date 对象以四位数字返回年份
	var month = date.getMonth() + 1; //月 ,从 Date 对象返回月份 (0 ~ 11) ,date.getMonth()比实际月份少 1 个月
	var day = date.getDate(); //日 ,从 Date 对象返回一个月中的某一天 (1 ~ 31)
	var hours = date.getHours(); //小时 ,返回 Date 对象的小时 (0 ~ 23)
	var minutes = date.getMinutes(); //分钟 ,返回 Date 对象的分钟 (0 ~ 59)
	var seconds = date.getSeconds(); //秒 ,返回 Date 对象的秒数 (0 ~ 59)   
	//获取当前系统时间  
	var currentDate = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
	// alert(currentDate);
	//修改月份格式
	if (month >= 1 && month <= 9) {
		month = "0" + month;
	}
	//修改日期格式
	if (day >= 0 && day <= 9) {
		day = "0" + day;
	}
	//修改小时格式
	if (hours >= 0 && hours <= 9) {
		hours = "0" + hours;
	}
	//修改分钟格式
	if (minutes >= 0 && minutes <= 9) {
		minutes = "0" + minutes;
	}
	//修改秒格式
	if (seconds >= 0 && seconds <= 9) {
		seconds = "0" + seconds;
	}
	//获取当前系统时间  格式(yyyy-mm-dd hh:mm:ss)
	var currentFormatDate = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
	var currentFormatDate2 = year + "-" + month + "-" + day
	return currentFormatDate2;
}
const getDate2 = function() {
	var date = new Date();
	var year = date.getFullYear(); //年 ,从 Date 对象以四位数字返回年份
	var month = date.getMonth() + 1; //月 ,从 Date 对象返回月份 (0 ~ 11) ,date.getMonth()比实际月份少 1 个月
	var day = date.getDate(); //日 ,从 Date 对象返回一个月中的某一天 (1 ~ 31)
	var hours = date.getHours(); //小时 ,返回 Date 对象的小时 (0 ~ 23)
	var minutes = date.getMinutes(); //分钟 ,返回 Date 对象的分钟 (0 ~ 59)
	var seconds = date.getSeconds(); //秒 ,返回 Date 对象的秒数 (0 ~ 59)   
	//获取当前系统时间  
	var currentDate = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
	// alert(currentDate);
	//修改月份格式
	if (month >= 1 && month <= 9) {
		month = "0" + month;
	}
	//修改日期格式
	if (day >= 0 && day <= 9) {
		day = "0" + day;
	}
	//修改小时格式
	if (hours >= 0 && hours <= 9) {
		hours = "0" + hours;
	}
	//修改分钟格式
	if (minutes >= 0 && minutes <= 9) {
		minutes = "0" + minutes;
	}
	//修改秒格式
	if (seconds >= 0 && seconds <= 9) {
		seconds = "0" + seconds;
	}
	//获取当前系统时间  格式(yyyy-mm-dd hh:mm:ss)
	var currentFormatDate = year + "-" + month + "-" + day + " " + hours + ":" + minutes + ":" + seconds;
	var currentFormatDate2 = year + "-" + month + "-" + day
	return currentFormatDate;
}
export default {
	getDate,
	getDate2
}
