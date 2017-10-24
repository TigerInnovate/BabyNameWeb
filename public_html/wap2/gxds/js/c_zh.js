//轮播图
//function lunbo() {
//	var li = document.querySelectorAll(".lunbo>ul>li"),
//		dian = document.querySelectorAll(".lunbo>list>i"),
//		num = 0,
//		wut = document.querySelector(".lunbo");
//	//	console.log(wut)
//	function xun(n) { //循环控制图片显示和小圆点的当前位置
//		for(var j = 0, len = li.length; j < len; j++) { //让之前的图片消失，让当前的图片显示
//			if(j == n) {
//				dian[j].style.background = "red"
//				li[j].classList.add("xianshi")
//			} else {
//				dian[j].style.background = "#fff"
//				li[j].classList.remove("xianshi")
//			}
//		}
//	}
//	var timer = setInterval(function() {
//		num++;
//		if(num > li.length - 1) num = 0;
//		xun(num);
//	}, 1500)
//
//	for(var i = 0, len = dian.length; i < len; i++) { //循环所有小圆点，一共循环3此
//
//		dian[i].setAttribute("index", i); //每循环一次，给每个小圆点添加一个 index属性，属性值等于当前循环的次数
//
//		dian[i].addEventListener("click", function() { //给每一个小圆点绑定点击事件
//			var index = this.getAttribute("index"); //获取到当前小圆点的index值
//			num = index;
//			xun(num)
//		})
//
//	}
//}
//lunbo();

//滚屏轮播
//function gunPin(){
//	var li = document.querySelectorAll(".leave > .leave_A > .gunLun>ul > li"),
//		ul = document.querySelector(".leave > .leave_A >.gunLun> ul"),
//		num = 0,
//		wut = document.querySelector(".gunLun");
//	console.log(wut)
//	
//	var timer = setInterval(function() {
//		num--;
//		ul.style.top = num*0.3 + "rem";
//		
//	}, 1500)
//	
//	li.addEventListener("touchstart",function(){
//		clearTimeout(timer)
//	})
//}
//gunPin()

//向上滚屏
//function dun(){
//	var Li = $(".Rs_Cs:eq(0)").height();	 
//	var total = $(".Rs_Cs").length;
//	var boxLen = Li*total;
//	var seep = -3,t;
//	$(".Rs_Gun").append($(".Rs_Gun").html());
//	function scrollUp()
//	{
//		t = parseInt($(".Rs_Gun").css("top"));
//		$(".Rs_Gun").css("top",t+seep+"px");
//		if( t <= -boxLen )
//		{
//			$(".Rs_Gun").css("top","0");
//		}
//	}
//	scrollUp();
//	var upScr = setInterval(scrollUp,100);
//	$(".Rs_Gun").mouseover(function(){
//		clearInterval(upScr);								   
//	}).mouseout(function(){
//		upScr = setInterval(scrollUp,100);	
//	});
//};
//dun();
$.fn.imgscroll = function(o){
	var defaults = {
		speed: 40,
		amount: 0,
		width: 1,
		dir: "left"
	};
	o = $.extend(defaults, o);
	return this.each(function(){
		var _li = $("li", this);
		_li.parent().parent().css({overflow: "hidden", position: "relative"}); //div
		_li.parent().css({margin: "0", overflow: "hidden", position: "relative", "list-style": "none"}); //ul

		_li.css({position: "relative", overflow: "hidden"}); //li
		if(o.dir == "left") _li.css({float: "left"});
		var _li_size = 0;
		for(var i=0; i<_li.size(); i++)
			_li_size += o.dir == "left" ? _li.eq(i).outerWidth(true) : _li.eq(i).outerHeight(true);
		if(o.dir == "left") _li.parent().css({width: (_li_size*3)+"px"});
		_li.parent().empty().append(_li.clone()).append(_li.clone()).append(_li.clone());
		_li = $("li", this);
		var _li_scroll = 0;
		function goto(){
			_li_scroll += o.width;
			if(_li_scroll > _li_size)
			{
				_li_scroll = 0;
				_li.parent().css(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll });
				_li_scroll += o.width;
			}
				_li.parent().animate(o.dir == "left" ? { left : -_li_scroll } : { top : -_li_scroll }, o.amount);
		}
		var move = setInterval(function(){ goto(); }, o.speed);
		_li.parent().hover(function(){
			clearInterval(move);
		},function(){
			clearInterval(move);
			move = setInterval(function(){ goto(); }, o.speed);
		});
	});
};
$("#demoa1").imgscroll({speed: 30,amount: 1,dir: "up"});
$("#demoa2").imgscroll({speed: 30,amount: 1,dir: "up"});


//点击显示
$(function(){
	if($('.comProItem').length){
		$('.comProItem').each(function(){
			$(this).click(function(){
				$('.comProItem dd').hide();
				$(this).find('dd').slideToggle();
			});
		});
	}
})

//订单号
function dindan(){
	var ding=document.getElementById("dingdan");
//	console.log(ding)
	if(!ding.value==""){
//		alert("订单号")
	}else{
		alert("请输入订单号")
	}
}

