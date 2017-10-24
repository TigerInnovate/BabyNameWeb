// JavaScript Document
$(document).ready(function(e) {
	//多选框事件控制
	$("#sm_cs_txt_chk span").each(function(index, element) {
		$(this).click(function(){
			var txt = $(this).text();
			var sm_cs_txt = $("#sm_cs_txt").val();
			//检查当前点击的是否设置了选择值1已选中/0未选中
			var isChk = $(this).attr("data-chk");
			//console.log("ischk="+isChk+" txt="+txt);
			if(typeof isChk!="unbefined"){
				if(parseInt(isChk)==1){
					//取消选中
					$(this).attr("data-chk",0).removeClass("ckh_on").addClass("ckh_un");	
					sm_cs_txt = joinStr(sm_cs_txt,txt,0) ;
				}else{
					//设置选中
					$(this).attr("data-chk",1).removeClass("ckh_un").addClass("ckh_on");	
					sm_cs_txt = joinStr(sm_cs_txt,txt,1) ;
				}
			}else{
				//如果没设置表示没选中
				$(this).attr("data-chk",1).removeClass("ckh_un").addClass("ckh_on");	
				sm_cs_txt = joinStr(sm_cs_txt,txt,1) ;
			}
			$("#sm_cs_txt").val(sm_cs_txt);
			function joinStr(txt,curr_str,flag){
				//已存储的txt,curr_str-当前点击对象的值，flag-标识是取消或是选中
				if(parseInt(flag)==1){
					//添加
					txt = txt!=""&&typeof txt!="undefined"?txt+","+curr_str:curr_str ;	
				}else{
					//删除
					txt = txt.replace(","+curr_str,"").replace(curr_str+",","").replace(curr_str,"");
				}
				return txt ;
			}
				
		});
	});
	
	
    
});
//输入框文字提示
function ipt_txt(obj,t){
	var txt = $(obj).val();
	if(t==0){
		//获得焦点删除提示内容
		if(txt=="选填"||txt=="您可以填写想要咨询的问题"){
		$(obj).val("");	
		}
		 
	}else{
		//失去焦点
		var new_txt = $(obj).val()	;
		if(new_txt.replace(new RegExp(/[ ]/g),"").length <=0){
			$(obj).val("")	;
		}
		
		
	}
}
//算命网表单类型选择、
function smform_click(id){
	var form = ["bzsm_form","bzhh_form","zxds_form"] ;	
	for(var i=0;i<form.length;i++){
		if(id==form[i]){
			$("#"+form[i]).show();		
		}else{
			$("#"+form[i]).hide();	
		}
	}
}
//obj-存储选择的值，cont-单选框容器对象
function rdo_click(obj,cont,click_obj){
	//清理已选择的
	$(cont).find(".qm-rdo").each(function(index, element) {
        $(this).removeClass("rdo_on").addClass("rdo_un"); 
    });
	$(obj).val("");
	//重新更新选中的
	$(click_obj).removeClass("rdo_un").addClass("rdo_on");  
	$(obj).val($(click_obj).attr("data-value"));
}
//导航组件
var pub_nav = {
	init : function(opts){
		//opts ={Container:"导航容器",CurrentBar:"当前标识id或class",Type:"类型（导航的显示效果类型是用数字）",RollTime:"标识条滚动时间"}
		var navContainer = opts.Container ;
		if(opts.Type==1){
			this.navigation_1.create(opts);
		}
		
	},
	navigation_1 : {
		width:0,
		nav_obj:null ,
		nav_child : null,
		nav_bar_left : 0 , /*标识条的原始坐标left值*/
		nav_bar_rollTime: 500, /*标识条滚动时间*/
		create :function(opt){
			var nav = this;
			nav.nav_obj = $(opt.Container);	
			nav.width = $(nav.nav_obj).innerWidth();
			nav.nav_child = $(nav.nav_obj).find("a");
			var nav_bar =   $(opt.CurrentBar);
			//初始化展开的导航页标识条的原始坐标
			nav.nav_bar_left = nav_bar.position().left;
			nav.nav_bar_rollTime = !(new RegExp(/^[1-9]\d+$/g)).test(nav.RollTime)? nav.nav_bar_rollTime:nav.RollTime ;
			var nav_child_len = $(nav.nav_child).length;
			var nav_pj_width = parseFloat((nav.width-1)/nav_child_len); 
			nav_bar.width(nav_pj_width);
			//console.log("宽度："+nav_pj_width);
			$(nav.nav_child).each(function(index, element) {
				if($(this).attr("class")=="nav-active"){
                	$(this).width(nav_pj_width-4);
				}else{
					$(this).width(nav_pj_width);
				}
            }); 
			nav.hover(nav_bar,nav);
			nav.leave(nav_bar,nav);
			nav.click(nav_bar,nav);
		},
		hover:function(nav_bar,curr_nav){
			this.nav_child.each(function(){
				$(this).hover(function(){
					var nav_bar_left = nav_bar.position().left;
					var nav_bar_width = nav_bar.innerWidth();
					var nav_curr_left = $(this).position().left;
					nav_bar.animate({left:nav_curr_left},curr_nav.nav_bar_rollTime);	
					//console.log("nav_bar_left="+nav_bar_left+" nav_bar_width="+nav_bar_width+" nav_curr_left="+nav_curr_left);
				})
			});
		},
		leave:function(nav_bar,curr_nav){
			//this.nav_child.each(function(){
				$(this.nav_obj).mouseleave(function(){
					$(nav_bar).width($(curr_nav.nav_obj).find(".nav-active").width());
					nav_bar.animate({left : curr_nav.nav_bar_left+1.5 },curr_nav.nav_bar_rollTime);	
					 
				})
			//});
		},click:function(nav_bar,curr_nav){
			this.nav_child.each(function(){
				$(this).click(function(){
					$(curr_nav.nav_obj).find(".nav-active").removeClass("nav-active"); 
					curr_nav.nav_bar_left = $(this).position().left;
					$(nav_bar).width($(this).width());
					//console.log("导航宽度："+$(this).width());
					$(this).addClass("nav-active"); 
					
				})
			});
		}
	} 
} 
function sub_smform(){
	sm_check();
	//算命
	function sm_check(){
		var tSval = $("#sm_name").val();
		if( tSval == ""){
			$("#sm_name").focus();
			layer.tips('<font style="color:#fff">姓名不能留空,请填写姓名！</font>', '#sm_name', {
				tips: 3,
				time: 5000
			});
			return false;
		}
		var patrn= /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
		if(!patrn.exec(tSval)){
			$("#sm_name").focus();
			layer.tips('<font style="color:#fff">请输入中文姓名(如:"李某某")！</font>', '#sm_name', {
				tips: 3,
				time: 5000
			});
			return false;
		}
		if($("#sm_cs_txt").val() == "")	{
			$("#sm_cs_txt").focus();
			layer.tips('<font style="color:#fff">请选择您测算的内容哦！</font>', '#sm_cs_txt_chk', {
				tips: 3,
				time: 5000
			});
			return false;
		}
		if($("#email").val() == "")	{
			$("#email").focus();
			layer.tips('<font style="color:#fff">测算结果将发送到您的邮箱，请填写正确！</font>', '#email', {
				tips: 3,
				time: 5000
			});
			return false;
		}
		/*var email = $("#email").val();
		 email = email.replace(/(^\s*)|(\s*$)/g, "");
		 var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/;
		 if(!reg.test(email)){
		 $("#email").focus();
		 layer.open({
		 type: 4,
		 time: 5000,
		 content: ['请输入正确的邮箱格式,如xxxxxx@qq.com', '#email']
		 });
		 return false;
		 }*/
		var cs_year = $("#cs_year option:selected").val();
		var cs_month = $("#cs_month option:selected").val();
		var cs_day = $("#cs_day option:selected").val();
		var cs_hour = $("#cs_hour option:selected").val();
		var cs_gongli = $("#cs_gongli option:selected").val();
		var lbBirthday ="" ;
		if(cs_year!=""&&cs_year!="undefined"){
			lbBirthday = cs_year ;
			if(cs_month!=""&&cs_month!="undefined"){
				lbBirthday = lbBirthday+"-"+cs_month ;
				if(cs_day!=""&&cs_day!="undefined"){
					lbBirthday = lbBirthday+"-"+cs_day ;
					if(cs_hour!=""&&cs_hour!="undefined"){
						lbBirthday = cs_gongli+" "+lbBirthday+" "+cs_hour ;
					}
				}
			}
		}
		$("#sm_birthday").val(lbBirthday);

		var cs_pro = $("#cs_pro option:selected").val();
		var cs_city = $("#cs_city option:selected").val();
		var cs_area = $("#cs_area option:selected").val();
		var lbBirthAddress ="";
		if(cs_pro!="-1"&&cs_pro!=""&&cs_pro!="undefined"){
			lbBirthAddress = cs_pro ;
			if(cs_city!="-1"&&cs_city!=""&&cs_city!="undefined"){
				lbBirthAddress = lbBirthAddress+"-"+cs_city ;
				if(cs_area!="-1"&&cs_area!=""&&cs_area!="undefined"){
					lbBirthAddress = lbBirthAddress+"-"+cs_area ;
				}
			}
		}
		$("#sm_address").val(lbBirthAddress);

		$("[name='bzsm_form']").submit();
	}
	//var cstype = $("#cstype").val();
	//var check_s = false;
	//if(cstype=="sm"){
	//	sm_check();
	//}else if(cstype=="hh"){
	//	hh_check();
	//}else if(cstype=="zxds"){
	//	zxds_check();
	//}
	/*//咨询大师
	function zxds_check(){
		var tSval = $("#zx_name").val();
		if( tSval == ""){
			$("#zx_name").focus();
			layer.tips('<font style="color:#fff">姓名不能留空,请填写姓名！</font>', '#zx_name', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		var patrn= /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
		if(!patrn.exec(tSval)){
			$("#zx_name").focus();
			layer.tips('<font style="color:#fff">请输入中文姓名(如:"李某某")！</font>', '#zx_name', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		if($("#zx_content").val() == ""||$("#zx_content").val()=="您可以填写想要咨询的问题")	{
			$("#zx_content").focus();
			layer.tips('<font style="color:#fff">请填写您咨询的内容哦！</font>', '#zx_content', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		if($("#zx_email").val() == "")	{
			$("#zx_email").focus();
			layer.tips('<font style="color:#fff">咨询结果将发送到您的邮箱，请填写正确！</font>', '#zx_email', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		if($("#zx_phone").val() == "")	{
			$("#zx_phone").focus();
			layer.tips('<font style="color:#fff">请填写您手机号方便大师与您沟通！</font>', '#zx_phone', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		var cs_year = $("#zx_year option:selected").val();
		var cs_month = $("#zx_month option:selected").val();
		var cs_day = $("#zx_day option:selected").val();
		var cs_hour = $("#zx_hour option:selected").val();
		var cs_gongli = $("#zx_gongli option:selected").val();
		var lbBirthday ="" ;
		if(cs_year!=""&&cs_year!="undefined"){
			lbBirthday = cs_year ;
			if(cs_month!=""&&cs_month!="undefined"){
				lbBirthday = lbBirthday+"-"+cs_month ;
				if(cs_day!=""&&cs_day!="undefined"){
				lbBirthday = lbBirthday+"-"+cs_day ;
					if(cs_hour!=""&&cs_hour!="undefined"){
					lbBirthday = cs_gongli+" "+lbBirthday+" "+cs_hour ;
					}
				}
			}
		}
		$("#zx_birthday").val(lbBirthday);

		var cs_pro = $("#zx_pro option:selected").val();
		var cs_city = $("#zx_city option:selected").val();
		var cs_area = $("#zx_area option:selected").val();
		var lbBirthAddress ="";
		if(cs_pro!="-1"&&cs_pro!=""&&cs_pro!="undefined"){
			lbBirthAddress = cs_pro ;
			if(cs_city!="-1"&&cs_city!=""&&cs_city!="undefined"){
				lbBirthAddress = lbBirthAddress+"-"+cs_city ;
				if(cs_area!="-1"&&cs_area!=""&&cs_area!="undefined"){
				lbBirthAddress = lbBirthAddress+"-"+cs_area ;
				}
			}
		}
		$("#zx_address").val(lbBirthAddress);

		$("[name='zxds_form']").submit();
	}
	//合婚
	function hh_check(){
		var hh_wname = $("#hh_wname").val();
		if( hh_wname == ""){
			$("#hh_wname").focus();
			layer.tips('<font style="color:#fff">女方姓名不能留空,请填写女方姓名！</font>', '#hh_wname', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		var patrn= /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
		if(!patrn.exec(hh_wname)){
			$("#hh_wname").focus();
			layer.tips('<font style="color:#fff">请输入中文姓名(如:"李某某")！</font>', '#hh_wname', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		var hh_w_year = $("#hh_w_year option:selected").val();
		var hh_w_month = $("#hh_w_month option:selected").val();
		var hh_w_day = $("#hh_w_day option:selected").val();
		var hh_w_hour = $("#hh_w_hour option:selected").val();
		var hh_w_gongli = $("#hh_w_gongli option:selected").val();
		var hh_w_birthday ="" ;
		if(hh_w_year!=""&&hh_w_year!="undefined"){
			hh_w_birthday = hh_w_year ;
			if(hh_w_month!=""&&hh_w_month!="undefined"){
				hh_w_birthday = hh_w_birthday+"-"+hh_w_month ;
				if(hh_w_day!=""&&hh_w_day!="undefined"){
				hh_w_birthday = hh_w_birthday+"-"+hh_w_day ;
					if(hh_w_hour!=""&&hh_w_hour!="undefined"){
					hh_w_birthday = hh_w_gongli+" "+hh_w_birthday+" "+hh_w_hour ;
					}
				}
			}
		}
		$("#hh_w_birthday").val(hh_w_birthday);
		var hh_m_year = $("#hh_m_year option:selected").val();
		var hh_m_month = $("#hh_m_month option:selected").val();
		var hh_m_day = $("#hh_m_day option:selected").val();
		var hh_m_hour = $("#hh_m_hour option:selected").val();
		var hh_m_gongli = $("#hh_m_gongli option:selected").val();
		var hh_m_birthday ="" ;
		if(hh_m_year!=""&&hh_m_year!="undefined"){
			hh_m_birthday = hh_m_year ;
			if(hh_m_month!=""&&hh_m_month!="undefined"){
				hh_m_birthday = hh_m_birthday+"-"+hh_m_month ;
				if(hh_m_day!=""&&hh_m_day!="undefined"){
				hh_m_birthday = hh_m_birthday+"-"+hh_m_day ;
					if(hh_m_hour!=""&&hh_m_hour!="undefined"){
					hh_m_birthday = hh_m_gongli+" "+hh_m_birthday+" "+hh_m_hour ;
					}
				}
			}
		}
		$("#hh_m_birthday").val(hh_m_birthday);

		var hh_mname = $("#hh_mname").val();
		if( hh_mname == ""){
			$("#hh_mname").focus();
			layer.tips('<font style="color:#fff">男方姓名不能留空,请填写男方姓名！</font>', '#hh_mname', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		var patrn= /[\u4E00-\u9FA5]|[\uFE30-\uFFA0]/gi;
		if(!patrn.exec(hh_mname)){
			$("#hh_mname").focus();
			layer.tips('<font style="color:#fff">请输入中文姓名(如:"李某某")！</font>', '#hh_mname', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		if($("#hh_email").val() == "")	{
			$("#hh_email").focus();
			layer.tips('<font style="color:#fff">测算结果将发送到您的邮箱，请填写正确！</font>', '#hh_email', {
			  tips: 3,
			  time: 5000
			});
			return false;
		}
		$("[name='bzhh_form']").submit();
	}*/

}