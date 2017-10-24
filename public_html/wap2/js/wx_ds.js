// JavaScript Document

var getCookie=function(name){
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg)){
		if(!arr[2]){
			 return null ;
		}else if(arr[2] !='null'){
			 return unescape(arr[2]) ;
		}else{
			 return null ;
		};
	}else{
		return null;
	}

}
//存储Cookie
var setCookie=function(name, value, time){
	var strsec = getsec(time);
	var exp = new Date();
	exp.setTime(exp.getTime() + strsec * 1); 
	document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString()+";path=/";
}
var getsec=function(str) {
	var str1 = str.substring(1, str.length) * 1;
	var str2 = str.substring(0, 1);
	if (str2 == "s") {
		return str1 * 1000;
	} else if (str2 == "h") {
		return str1 * 60 * 60 * 1000;
	} else if (str2 == "d") {
		return str1 * 24 * 60 * 60 * 1000;
	}
}

var wap_wxds = function(){};
/**
 *弹出层开启关闭
 */
wap_wxds.prototype.togglesT=function(){  
  $(".mask").toggle();
  $(".layouts").toggle();
};
wap_wxds.prototype.init_wx=function(){
	//var wx_data = new Array("qiming88666", "qiming88666");  
	//var index_wx = Math.floor(Math.random()*39999 ) % 6;
	 //$(".kfwxhao").text(getCookie('weixin'));

var randNum = Math.round(Math.random()*2);

var weixinArr = ['qiming8886','qiming88666','quming8866'];
//如果没有获取到cookie  则生成cookie
if(getCookie('weixin')){
	$(".kfwxhao").text(getCookie('weixin'));
}else{
	setCookie("weixin",weixinArr[randNum],"d365");
	$(".kfwxhao").text(getCookie('weixin'));
}



	/*try{ 
		if(window.localStorage){
			//存储到本地 
			try{
				var lswx = localStorage.getItem("order_wx");
				if(lswx!=""&& typeof lswx!="undefined"&& lswx!=null){
					$(".kfwxhao").text(wx_data[lswx]);  
				}else{
					localStorage.removeItem("order_wx"); //防止iphone/ipad中报异常错误QUOTA_EXCEEDED_ERR
					localStorage.setItem("order_wx",index_wx);
					$(".kfwxhao").text(wx_data[index_wx]);  
				}
			}catch(e){
				 
				var lswx = getCookie("order_wx");  
				if(lswx!=""&& typeof lswx!="undefined"&& lswx!=null){
					$(".kfwxhao").text(wx_data[lswx]);  
				}else{
					setCookie("order_wx",index_wx,"d365");
					$(".kfwxhao").text(wx_data[index_wx]); 
				} 
			}  
		}
	}catch(e){
		//alert("请关闭无痕模式再浏览") 
	}	*/
}


/**
 *desc:构造函数实例化
 */
var wxwap = new wap_wxds();
//初始化微信
wxwap.init_wx();

