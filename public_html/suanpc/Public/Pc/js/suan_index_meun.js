//导航

$(document).ready(function(e) {
	//设置微信图标自动居中
	var win_h = $(window).height();
	var wxewm_h = $(".weixinerwei").height();
	var wxerw_top = (parseInt(win_h)-parseInt(wxewm_h))/2 ;
	
	var t=0;
	$(window).scroll(function(){
		t = $(document).scrollTop();
		if(meun.sTop <= t){
			$(".weixinerwei").show();//alert(t)
			if($.browser.msie){
				//处理ie6不兼容问题 
				if($.browser.version=="6.0"){
				$(".weixinerwei").css({"top":t+185});
				}
			}
		}else{
			$(".weixinerwei").hide();
		}
	});		
	$(".weixinerwei").click(function(){
		var img = $(this).find("img"); 
		var win_h = $(window).height();
		if($(img[0]).css('display') != 'none'){
			$(img[0]).css('display', 'none');
			$(img[1]).css('display', 'block');
			var wxewm_h = $(this).height();
			var wxerw_top = (parseInt(win_h)-parseInt(wxewm_h))/2 ;
			$(this).css('top',wxerw_top+'px');
		}else{
			$(img[0]).css('display', 'block');
			$(img[1]).css('display', 'none');
			var wxewm_h = $(this).height();
			var wxerw_top = (parseInt(win_h)-parseInt(wxewm_h))/2 ;
			$(this).css('top',wxerw_top+'px');
		}
	}).css("top",wxerw_top+"px").hide();
	
    
	$(".s-menu li").each(function(index, element) {
		$(this).hover(function(){
			$(this).find("a").css("background-color","#CEA35F").css("color","#fff");
			$(this).find(".hr").hide();
		}).mouseleave(function(){
			$(this).find("a").css("background-color",""); 
			$(this).find(".hr").show();
			
		});
	});
}); 


/**
 * 左侧挂件
 * TanLin,Email:50140137@qq.com,tel:18677197764
 * 2015/11/19
 */
var meun = {
	url:null,
	top:0,
	sTop:0,
	bg:null,
	body:function(){
		return document.getElementsByTagName("body")[0];
	},	
	run:function(url,top,sTop,bg){	
		this.url = url;
		this.top = top;
		this.sTop = sTop;
		this.bg = bg;
		this.label(),this.style(),this.jsapt(),this.scrolls();
	},
	label:function(){ 
		$(this.body()).append("<dl id='m_uri_div'  class='db'>" +
				"<dd><a href='"+this.url.url1+"'>算命优势</a></dd>" +
				"<dd><a href='"+this.url.url3+"'>常见问题</a></dd>" +
				"<dd><a href='"+this.url.url4+"'>客户好评</a></dd>" +
				"<dd><a href='"+this.url.url5+"'>开始算命</a></dd>" +
				"<dd><a>老师微信</a></dd>" +
				"<dd><a>suan8886</a></dd>" +
				// "<dd id='qqzx'><a href='http://tb.53kf.com/code/client/10147745/3' target='_blank'><img src='/Public/BaziWeb/images/qqtb.png' alt='图标' />在线咨询</a></dd>" +
				"</dl>");	
	},
	style:function(){
		$("dl,dd").css({"margin":0,"padding":0});
//		$("#m_uri_div").css({'z-index':"1000","display":"none","width":"122px","background":this.bg,"position":"fixed","top":this.top+"px","right":0,"_position":"absolute","_top":"expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight)","overflow":"hidden"});
		$("#m_uri_div").css({'z-index':"1000","width":"122px","background":this.bg,"position":"fixed","top":this.top+"px","right":0,"_position":"absolute","_top":"expression(documentElement.scrollTop+documentElement.clientHeight-this.offsetHeight)","overflow":"hidden"});
		//$("#m_uri_div").css({"background":this.bg,"top":this.top+"px"});
		$("#m_uri_div dd").css({"border-bottom":"1px solid #FFFFFF","height":"42px","text-align":"center","line-height":"42px","font-family":"微软雅黑","font-size":"18px"});
		$("#m_uri_div dd:last").css({"border":"none"});
		$("#m_uri_div a").css({"display":"block","color":"#FFFFFF","text-decoration":"none"});
		$(".action").css({"background":"#DBA858"});
		$(".action2").css({"background":"#DBA858"});
	},	
	jsapt:function(){
		$("#m_uri_div a").each(function(index){			
			$(this).click(function(){
				$("#m_uri_div a").removeClass("action");
				$("#m_uri_div a").css({"background-color":""});
				$(this).addClass("action");
				meun.style();
			});
		});
	},
	scrolls:function(){
		var t=0;
		$(window).scroll(function(){
			t = $(document).scrollTop();
			if(meun.sTop <= t){
				$("#m_uri_div").show();//alert(t)
				if($.browser.msie){
					//处理ie6不兼容问题 
					if($.browser.version=="6.0"){
					$("#m_uri_div").css({"top":t+185});
					}
				}
			}else{
				$("#m_uri_div").hide();
			}
		});		
	}
}
/*BizQQWPA.addCustom({aty: '0', a: '0', nameAccount: 800097105, selector: 'qqzx'});*/
