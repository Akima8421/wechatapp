import Vue from 'vue'
import App from './App'
import uView from "uview-ui";

Vue.use(uView);

Vue.config.productionTip = false

App.mpType = 'app'

const app = new Vue({
    ...App
})
app.$mount()

Vue.prototype.$grade = function (e){
	if(e == '一年级'){
		return 1
	}if(e == '二年级'){
		return 2
	}if(e == '三年级'){
		return 3
	}if(e == '四年级'){
		return 4
	}if(e == '五年级'){
		return 5
	}if(e == '六年级'){
		return 6
	}
},
Vue.prototype.$cname = function (a,b){
	if(a == 1){
		if(b==1){
			return "一年一班"
		}if(b==2){
			return "一年二班"
		}if(b==3){
			return "一年三班"
		}if(b==4){
			return "一年四班"
		}if(b==5){
			return "一年五班"
		}if(b==6){
			return "一年六班"
		}if(b==7){
			return "一年七班"
		}if(b==8){
			return "一年八班"
		}if(b==9){
			return "一年九班"
		}if(b==10){
			return "一年十班"
		}
		
	}if(a == 2){
		if(b==1){
			return "二年一班"
		}if(b==2){
			return "二年二班"
		}if(b==3){
			return "二年三班"
		}if(b==4){
			return "二年四班"
		}if(b==5){
			return "二年五班"
		}if(b==6){
			return "二年六班"
		}if(b==7){
			return "二年七班"
		}if(b==8){
			return "二年八班"
		}if(b==9){
			return "二年九班"
		}if(b==10){
			return "二年十班"
		}
	}if(a == 3){
		if(b==1){
			return "三年一班"
		}if(b==2){
			return "三年二班"
		}if(b==3){
			return "三年三班"
		}if(b==4){
			return "三年四班"
		}if(b==5){
			return "三年五班"
		}if(b==6){
			return "三年六班"
		}if(b==7){
			return "三年七班"
		}if(b==8){
			return "三年八班"
		}if(b==9){
			return "三年九班"
		}if(b==10){
			return "三年十班"
		}
	}if(a == 4){
		if(b==1){
			return "四年一班"
		}if(b==2){
			return "四年二班"
		}if(b==3){
			return "四年三班"
		}if(b==4){
			return "四年四班"
		}if(b==5){
			return "四年五班"
		}if(b==6){
			return "四年六班"
		}if(b==7){
			return "四年七班"
		}if(b==8){
			return "四年八班"
		}if(b==9){
			return "四年九班"
		}if(b==10){
			return "四年十班"
		}
	}if(a == 5){
		if(b==1){
			return "五年一班"
		}if(b==2){
			return "五年二班"
		}if(b==3){
			return "五年三班"
		}if(b==4){
			return "五年四班"
		}if(b==5){
			return "五年五班"
		}if(b==6){
			return "五年六班"
		}if(b==7){
			return "五年七班"
		}if(b==8){
			return "五年八班"
		}if(b==9){
			return "五年九班"
		}if(b==10){
			return "五年十班"
		}
	}if(a == 6){
		if(b==1){
			return "六年一班"
		}if(b==2){
			return "六年二班"
		}if(b==3){
			return "六年三班"
		}if(b==4){
			return "六年四班"
		}if(b==5){
			return "六年五班"
		}if(b==6){
			return "六年六班"
		}if(b==7){
			return "六年七班"
		}if(b==8){
			return "六年八班"
		}if(b==9){
			return "六年九班"
		}if(b==10){
			return "六年十班"
		}
	}
},
Vue.prototype.$arrySort = function (property){
	return function(a, b) {
		var value1 = a[property]
		var value2 = b[property]
		return value1 - value2
	}
},
Vue.prototype.$arrySort2 = function (property){
	return function(a, b) {
		var value1 = a[property]
		var value2 = b[property]
		return value2 - value1
	}
},
Vue.prototype.$dateSort = function (property){
	return function(a, b) {
		var value1 = parseInt(a[property].split('-').join(''))
		var value2 = parseInt(b[property].split('-').join(''))
		return value1 - value2
	}
},
Vue.prototype.$dateSort2 = function (property){
	return function(a, b) {
		var value1 = parseInt(a[property].split('-').join(''))
		var value2 = parseInt(b[property].split('-').join(''))
		return value2 - value1
	}
},
Vue.prototype.$dateswitch = function (e){
	var term
	term = parseInt(e.substr(5,2))
	if(term >= 2 && term <= 7){
		return '上学期'
	}else{
		return '下学期'
	}
}