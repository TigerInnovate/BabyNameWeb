// JavaScript Document
//alert( location.search)
//解析参数
var location_str = location.search ;

var quming_data_url = "http://order.7ming.wang/";
//提交订单-加载测算数据
/*function saveorder_result(birthday,orderno){  
	$("div").data("auto_orderno",orderno);
	if(birthday!=""  ){  
		$.ajax({
		   type: "POST",
		   url: quming_data_url+"result/2/?t="+Math.floor(Math.random() * (12323 + 1)), 
		   data:{"date":(birthday)} ,
		   dataType : 'jsonp',   
           jsonpCallback: 'getSuanFunc',   //回调函数  
		   success: function(data){},
		   error:  function(XMLHttpRequest, textStatus, errorThrown) {
				 console.log(XMLHttpRequest.status);
				 console.log(XMLHttpRequest.readyState);
				 console.log(textStatus);

			}  
		}); 
	}
}*/
//起名结果页面-处理
function suan_result(birthday,orderno){  
	//存储订单号
	$("div").data("auto_orderno",orderno);
	//数据加载 
	if(window.sessionStorage){
		if(sessionStorage['QMbasicInfo'+orderno]!==undefined && sessionStorage['QMbasicInfo'+orderno]!==""){ 
			var local_data = sessionStorage["QMbasicInfo"+orderno];
			getSuanData( JSON.parse(local_data));
			return ;
		}
	}
	if(birthday!="" ){  
		$.ajax({
		   type: "POST",
		   url: quming_data_url+"result/1/?t="+Math.floor(Math.random() * (12323 + 1)), 
		   data:{"date":(birthday)} ,
		   dataType : 'jsonp',   
           jsonpCallback: 'getSuanData',   //回调函数  
		   success: function(data){},
		   error:  function(XMLHttpRequest, textStatus, errorThrown) {
				 console.log(XMLHttpRequest.status);
				 console.log(XMLHttpRequest.readyState);
				 console.log(textStatus);

			}  
		}); 
	}
}
//读取起名结果
function qm_result(wxname){
	var sex = $("#user_sex").text();
	var name = $("#user_name").text();
	if(name!=""&&sex!=""  ){  
		$.ajax({
		   type: "get",
		   url: "/config/pro/do/qm/?t="+Math.floor(Math.random() * (13010 + 1)), 
		   data:{"sex":(sex),"name":(name),"page":3,"wxname":(wxname),"orderno": $("div").data("auto_orderno"),"rettype":"json"  } ,
		   dataType : 'jsonp',   
           jsonpCallback: 'getQMResult',   //回调函数  
		   success: function(data){},
		   error:  function(XMLHttpRequest, textStatus, errorThrown) {
				 console.log(XMLHttpRequest.status);
				 console.log(XMLHttpRequest.readyState);
				 console.log(textStatus);

			}  
		}); 
	}
}

//提交订单-解析处理结果
function getSuanFunc(json_data_obj){  
    // alert(json_data_obj.result);  
	var xml = loadXMLStr(json_data_obj.result) ; 
	var xml_type = $(xml).find("info").text();  
	var trim_str = function(str){
		return str.replace(new RegExp(/】【/g)," ").replace(new RegExp(/(】|【)/g),"");
	}
	var trim_str1 = function(str){
		str = str.replace(".00","");//删除两个0的； 
		str = parseInt(str.substring(str.length-1,str.length) )==0?str.substring(0,str.length-1):str//删除一个0的；
		//console.log("str2="+str+" "+  parseInt(str.substring(str.length-1,str.length) ));
		return str;
	}
	if(xml_type!=""&&xml_type!="0"){
		$(xml).find("sj_time").each(function(i){ 
			var sj_time = $(xml).find("sj_time").eq(i).text();
			var nlyl_time = $(xml).find("nlyl_time").eq(i).text(); 
			var nl_bazisizhu_txt = $(xml).find("nl_bazisizhu_txt").eq(i).text();
			var nl_baziwx_txt = $(xml).find("nl_baziwx_txt").eq(i).text();
			var nl_nayin_txt = $(xml).find("nl_nayin_txt").eq(i).text();
			var nl_rizhutg_txt = $(xml).find("nl_rizhutg_txt").eq(i).text();
			//var nl_baziwx_txt = $(xml).find("nl_baziwx_txt").eq(i).text();
			var nl_qimingbu_txt = $(xml).find("nl_qimingbu_txt").eq(i).text();
			var nl_bzpd_txt = $(xml).find("nl_bzpd_txt").eq(i).text();
			var nl_xiyong_txt = $(xml).find("nl_xiyong_txt").eq(i).text();
			var j_num = nl_baziwx_txt.split("金").length-1;
			var m_num = nl_baziwx_txt.split("木").length-1;
			var s_num = nl_baziwx_txt.split("水").length-1;
			var h_num = nl_baziwx_txt.split("火").length-1;
			var t_num = nl_baziwx_txt.split("土").length-1;
			//五行总量
			var wx_total = j_num + m_num + s_num + h_num + t_num ; 
			//五行解读
			var wxjd_txt = "";
			if(j_num!=0&&m_num!=0&&s_num!=0&&h_num!=0&&t_num!=0){
				wxjd_txt = "五行齐全";
			}else{
				wxjd_txt = "五行缺"+(j_num==0?"金":"" )+(m_num==0?"木":"" )
				+(s_num==0?"水":"" )+(h_num==0?"火":"" )+(t_num==0?"土":"" );
			}
			var wuxingfx = "金"+( (j_num!=0? trim_str1((Math.round((j_num / wx_total)*100 * 100) / 100).toFixed(2)):"0") +"%")+
			"  木"+( (m_num!=0? trim_str1((Math.round((m_num / wx_total)*100 * 100) / 100).toFixed(2)):"0") +"%")+
			"  水"+( (s_num!=0? trim_str1((Math.round((s_num / wx_total)*100 * 100) / 100).toFixed(2)):"0") +"%")+
			"  火"+( (h_num!=0? trim_str1((Math.round((h_num / wx_total)*100 * 100) / 100).toFixed(2)):"0") +"%")+
			"  土"+( (t_num!=0? trim_str1((Math.round((t_num / wx_total)*100 * 100) / 100).toFixed(2)):"0") +"%") ; 
			wuxingfx = wuxingfx +"<br/>五行解读 : "+wxjd_txt ;
			$("#birthdayID").html( "阳历 : "+setJqtime(sj_time)+" <br/>农历 : "+ (nlyl_time)  );
			//八字分析
			$("#bazifx").html( "八字四柱 : "+trim_str(nl_bazisizhu_txt)+"<br/>八字五行 : "+trim_str(nl_baziwx_txt)+"<br/> 四柱纳音 : "+ trim_str(nl_nayin_txt) );
			//五行分析
			$("#wuxingfx").html(wuxingfx);
			//日主天干
			$("#rizhutg").html("日主天干 "+nl_rizhutg_txt.replace(new RegExp(/【/g)," [").replace(new RegExp(/】/g),"] ")
			+"<br>"+nl_bzpd_txt+"，起名补"+nl_qimingbu_txt); 
			 
			
			 
		
		});
	}else{
		console.log("没有数据："+xml_type) 
	}
}  
//解析处理取名结果页面显示
function getQMResult(json_data_obj){
	//解析xml 
	//parseQMXml(json_data_obj);
	//解析json
	parseQMJson(json_data_obj);
	
}
//解析起名结果xml类型
/*function parseQMXml(json_data_obj){
	var page_num = 30 ;//每页显示数量
	//alert(json_data_obj);return;
	var xml = loadXMLStr(json_data_obj.result) ;  
	var xml_type = $(xml).find("info").text();   
	var xml_totale = json_data_obj.totale ; 
	var curr_page = 1 ,totale_page =  xml_totale % page_num ==0? parseInt(xml_totale/page_num) : parseInt(xml_totale/page_num)+1;
	$("div").data("qm_res_xml",xml);
	var read_xml = function(xml,t){
		var username = $(xml).find("username").eq(t).text();
		var name_id = $(xml).find("name_id").eq(t).text();   
		var $txt = "<span data-val='"+name_id+"'>"+username+"</span>" ;
		return $txt ;
	}
	xml = $("div").data("qm_res_xml");
	//console.log("结果总数："+xml_totale+" 当前页："+curr_page+" 总页数："+totale_page); 
	var html ="";
	if(xml_type!=""&&xml_type!="0"){
		$(xml).find("user").each(function(i){ 
			if(i<=30){
			html = html+""+read_xml(xml,i);
			}else{return;}
		});
		$("#qmResList").html(html).find("span").click(function(){
			var name = $(this).text(),name_id = $(this).attr("data-val");
			console.log("选择结果："+name+" "+name_id);
		}) ;  
	}else{
		console.log("没有数据："+xml_type) 
	}
	$(".huanyihuan").click(function(){
		//刷新	
		$(".ask").show();
		$(".res_load").show();
	});
}*/
//解析起名结果json类型
function parseQMJson(json_data_obj){
	var read_json = function(obj){
		var username = obj.name;
		var name_id = obj.id;   
		var $txt = "<span data-val='"+name_id+"'>"+username+"</span>" ;  
		return $txt ;
	}
	var html ="";
	var page_num = 150 ;//每页显示数量
	var qmdata = eval(json_data_obj.result) ; 
		try{
	if(window.localStorage){
		//存储到本地
		var orderno = $("div").data("auto_orderno");
		localStorage.removeItem("order_name_data"+orderno);//clear();//防止iphone/ipad中报异常错误QUOTA_EXCEEDED_ERR
		localStorage.setItem("order_name_data"+orderno,JSON.stringify(json_data_obj));
		
	}
	}catch(e){
			//alert("请点击右下角图标关闭无痕浏览模式，再刷新页面查看起名结果体验更好哦！");
	}
	var xml_totale = json_data_obj.totale ;   
	var curr_page = 1 ,totale_page =  xml_totale % page_num ==0? parseInt(xml_totale/page_num) : parseInt(xml_totale/page_num)+1; 
	$("div").data("qm_res_xml",qmdata);
	for(var i in qmdata){
		if(i< page_num){
		 html = html+""+read_json( qmdata[i] ); 
		}else{break;}
	} 
	 
	//console.log("结果总数："+xml_totale+" 当前页："+curr_page+" 总页数："+totale_page);
	$("#qmResList").html(html).attr("data-val","1").attr("data-totale",totale_page).attr("data-page",page_num).find("span").click(function(){
		var name = $(this).text(),name_id = $(this).attr("data-val");
		window.location.href="detail/?name="+escape(name)+"&flag="+escape(name_id)+"&sex="+escape( $("#user_sex").text() ) ;
		//console.log("选择结果："+name+" "+name_id);
	}) ;  
	 
	$(".huanyihuan").click(function(){
		//刷新	
		$(".ask").show();
		$(".res_load").show();
		var html ="";
		var curr_page = parseInt($("#qmResList").attr("data-val") );
		var totale_page = parseInt($("#qmResList").attr("data-totale") );
		var page_num = parseInt($("#qmResList").attr("data-page") );
		var qmdata = $("div").data("qm_res_xml");
		curr_page = curr_page>=totale_page ? 1 : parseInt(curr_page) +1 ; 
		var min_num = curr_page*page_num - parseInt(page_num) ;
		var max_num = curr_page*page_num ;
		for(var i= min_num;i < max_num;i++){  
			if(typeof qmdata[i]=="object"){ 
			 html = html+""+read_json( qmdata[i] );
			}else{break;}
		}
		 
		$("#qmResList").html(html).attr("data-val",curr_page).find("span").click(function(){
			var name = $(this).text(),name_id = $(this).attr("data-val");
			window.location.href="detail/?name="+escape(name)+"&flag="+escape(name_id)+"&sex="+escape( $("#user_sex").text() ) ;
		}) ;  
			
		$(".ask").hide();
		$(".res_load").hide();
	});
}
//解析处理结果
function getSuanData(json_data_obj){  
    // alert(json_data_obj.result);  
	if(window.sessionStorage){
		//存储到本地
		var orderno = $("div").data("auto_orderno");
		window.sessionStorage.clear();
		window.sessionStorage.setItem("QMbasicInfo"+orderno,JSON.stringify(json_data_obj));
	}
	var xml = loadXMLStr(json_data_obj.result) ; 
	var xml_type = $(xml).find("info").text(); 
    
	var trim_str = function(str){
		return str.replace(new RegExp(/】【/g)," ").replace(new RegExp(/(】|【)/g),"");
	}
	var trim_str1 = function(str){
		str = str.replace(".00","");//删除两个0的；
		//console.log("str="+str);
		str = parseInt(str.substring(str.length-1,str.length) )==0?str.substring(0,str.length-1):str//删除一个0的；
		//console.log("str2="+str+" "+  parseInt(str.substring(str.length-1,str.length) ));
		return str;
	}
	//计算五行强度
	var wxqd_pub = function(types,data){
		//types = 五行名称（金、木。。。。。）
		//console.log("types="+types+" data="+data)
		var data_arr = data.split(" ");
		var qd_num = 0;
		for(var i=0;i<data_arr.length;i++){
			if(data_arr[i].indexOf(types)>=0){
				 
				qd_num = parseFloat(qd_num) + parseFloat(data_arr[i].toLowerCase().replace(types+"x",""))
			}
		}
		return Math.round(parseFloat(qd_num)*100)/100; ;
	}
	if(xml_type!=""&&xml_type!="0"){
		$(xml).find("sj_time").each(function(i){ 
			var sj_time = $(xml).find("sj_time").eq(i).text();
			var nlyl_time = $(xml).find("nlyl_time").eq(i).text(); 
			var nl_bazisizhu_txt = $(xml).find("nl_bazisizhu_txt").eq(i).text();
			var nl_baziwx_txt = $(xml).find("nl_baziwx_txt").eq(i).text();
			var nl_nayin_txt = $(xml).find("nl_nayin_txt").eq(i).text();
			var nl_rizhutg_txt = $(xml).find("nl_rizhutg_txt").eq(i).text();
			var nl_baziwx_txt = $(xml).find("nl_baziwx_txt").eq(i).text();
			var nl_qimingbu_txt = $(xml).find("nl_qimingbu_txt").eq(i).text();
			var nl_bzpd_txt = $(xml).find("nl_bzpd_txt").eq(i).text();
			var nl_xiyong_txt = $(xml).find("nl_xiyong_txt").eq(i).text();
			var nl_jinji_txt = $(xml).find("nl_jinji_txt").eq(i).text();
			var nl_sxfx_txt = $(xml).find("nl_sxfx_txt").eq(i).text();
			var bmfo_txt = $(xml).find("bmfo_txt").eq(i).text();
			var nl_szzg_txt = $(xml).find("nl_szzg_txt").eq(i).text();
			var nl_zgwuxing_txt = $(xml).find("nl_zgwuxing_txt").eq(i).text();
			var nl_gzwxhz_txt = $(xml).find("nl_gzwxhz_txt").eq(i).text();
			var nl_mingli_txt = $(xml).find("nl_mingli_txt").eq(i).text();
			
			var jq_pretime = $(xml).find("jq_pretime").eq(i).text();
			var jq_prename = $(xml).find("jq_prename").eq(i).text();
			var jq_nexttime = $(xml).find("jq_nexttime").eq(i).text(); 
			var jq_nextname = $(xml).find("jq_nextname").eq(i).text();
			var nl_tgqd_txt = $(xml).find("nl_tgqd_txt").eq(i).text();
			var zgqd_year_txt = $(xml).find("zgqd_year_txt").eq(i).text();
			var zgqd_month_txt = $(xml).find("zgqd_month_txt").eq(i).text();
			var zgqd_day_txt = $(xml).find("zgqd_day_txt").eq(i).text();
			var zgqd_hours_txt = $(xml).find("zgqd_hours_txt").eq(i).text(); 
			var nl_yileiqd_txt = $(xml).find("nl_yileiqd_txt").eq(i).text(); 
			var nl_tongleiqd_txt = $(xml).find("nl_tongleiqd_txt").eq(i).text();
			var nl_zongheqd_txt = $(xml).find("nl_zongheqd_txt").eq(i).text();
			var nl_nlcc_txt = $(xml).find("nl_nlcc_txt").eq(i).text(); 
			var nl_jjys_txt = $(xml).find("nl_jjys_txt").eq(i).text(); 
			var nl_jxfw_txt = $(xml).find("nl_jxfw_txt").eq(i).text(); 
			var nl_jxys_txt = $(xml).find("nl_jxys_txt").eq(i).text(); 
			var nl_xysz_txt = $(xml).find("nl_xysz_txt").eq(i).text(); 
			var nl_xyhd_txt = $(xml).find("nl_xyhd_txt").eq(i).text(); 
			var nl_jjsz_txt = $(xml).find("nl_jjsz_txt").eq(i).text(); 
			
			 
			
			var jqsy1 = (jq_prename==""?"0":jq_prename) +" = "+setJqtime(jq_pretime);
			var jqsy2 = (jq_nextname==""?"0":jq_nextname)+" = "+setJqtime(jq_nexttime);
			var jqsy3 = jqsy1+"<br/>"+ jqsy2 +"<br/>"+"生于"+jqsy1.split("=")[0]+"和"+jqsy2.split("=")[0]+"之间<br>" ; 
			
			$("#mz_info_jqsyTime").html( jqsy3 );
			$("#mz_info_sxfx").html( nl_sxfx_txt );
			$("#mz_info_bmfo").html( "本命佛："+bmfo_txt );
			$('.ltime').text(nlyl_time);
			$("#birthdayID").html( "阳历 : "+setJqtime(sj_time)+" <br/>农历 : "+ (nlyl_time)  );
			//八字分析
			var nl_bazisizhu_arr = nl_bazisizhu_txt.split("】【");
			var bz_h = '<td class="f">八字</td><td class="color">'+trim_str(nl_bazisizhu_arr[0])+'</td><td class="color">'+(nl_bazisizhu_arr[1])+'</td> <td class="color">'+(nl_bazisizhu_arr[2])+'</td><td class="color">'+trim_str(nl_bazisizhu_arr[3])+'</td>'
			$("#mz_info_bz").html(bz_h);
			//八字五行
			var nl_baziwx_arr = nl_baziwx_txt.split("】【");
			var bzwx_h = '<td class="f">八字<br/>五行</td><td>'+trim_str(nl_baziwx_arr[0])+'</td><td >'+(nl_baziwx_arr[1])+'</td> <td >'+(nl_baziwx_arr[2])+'</td><td >'+trim_str(nl_baziwx_arr[3])+'</td>'
			$("#mz_info_bzwx").html(bzwx_h);
			//纳音
			var nl_nayin_arr = nl_nayin_txt.split("】【");
			var ny_h = '<td class="f">纳音</td><td class="color">'+trim_str(nl_nayin_arr[0])+'</td><td class="color">'+(nl_nayin_arr[1])+'</td> <td class="color">'+(nl_nayin_arr[2])+'</td><td class="color">'+trim_str(nl_nayin_arr[3])+'</td>'
			$("#mz_info_ny").html(ny_h);
			//藏干
			var nl_szzg_arr = nl_szzg_txt.split("】【");
			var zg_h = '<td class="f">臧干</td><td>'+trim_str(nl_szzg_arr[0])+'</td><td >'+(nl_szzg_arr[1])+'</td> <td >'+(nl_szzg_arr[2])+'</td><td >'+trim_str(nl_szzg_arr[3])+'</td>'
			$("#mz_info_zg").html(zg_h);
			
			//藏干五行
			var nl_zgwx_arr = nl_zgwuxing_txt.split("】【");
			var zgwx_h = '<td class="f">臧干<br/>五行</td><td>'+trim_str(nl_zgwx_arr[0])+'</td><td >'+(nl_zgwx_arr[1])+'</td> <td >'+(nl_zgwx_arr[2])+'</td><td >'+trim_str(nl_zgwx_arr[3])+'</td>'
			$("#mz_info_zgwx").html(zgwx_h);
			//命理分析
			$("#mz_info_ml").html("命理分析：【"+nl_mingli_txt+"】");
			//××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
			//五行分析不包含藏干
			
			var j_num = nl_baziwx_txt.split("金").length-1;
			var m_num = nl_baziwx_txt.split("木").length-1;
			var s_num = nl_baziwx_txt.split("水").length-1;
			var h_num = nl_baziwx_txt.split("火").length-1;
			var t_num = nl_baziwx_txt.split("土").length-1;
			//五行总量
			var wx_total = j_num + m_num + s_num + h_num + t_num ; 
			$("#mz_info_wxgs").text( "【金】"+(j_num)+"【木】"+(m_num)+"【水】"+(s_num)+"【火】"+(h_num)+"【土】"+(t_num) );
						
			//五行解读
			var wxjd_txt = "";
			if(j_num!=0&&m_num!=0&&s_num!=0&&h_num!=0&&t_num!=0){
				wxjd_txt = "五行齐全";
			}else{
				wxjd_txt = "五行缺"+(j_num==0?"金":"" )+(m_num==0?"木":"" )
				+(s_num==0?"水":"" )+(h_num==0?"火":"" )+(t_num==0?"土":"" );
			}
			//五行分析
			$("#wuxingfx").html("五行解读 : "+wxjd_txt);
			var j_num_b = (j_num!=0?  ((Math.round((j_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			var m_num_b = (m_num!=0?  ((Math.round((m_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			var s_num_b = (s_num!=0?  ((Math.round((s_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			var h_num_b = (h_num!=0?  ((Math.round((h_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			var t_num_b = (t_num!=0?  ((Math.round((t_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			var bf_b_arr = new Array(j_num_b,m_num_b,s_num_b,h_num_b,t_num_b); 
			var bf_bs_arr =  new Array("金"+j_num_b,"木"+m_num_b,"水"+s_num_b,"火"+h_num_b,"土"+t_num_b); 
			//设置百分比
			$("#mz_info_wxgs_b").find(".jdt").each(function(index, element) {
                $(this).find(".z").css("width",bf_b_arr[index] );
                $(this).find(".t").text(bf_bs_arr[index]);
            });
			//××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
			//五行分析包含藏干
			var zgj_num = nl_zgwuxing_txt.split("金").length-1 + (nl_gzwxhz_txt.split("金").length-1) ;
			var zgm_num = nl_zgwuxing_txt.split("木").length-1 + (nl_gzwxhz_txt.split("木").length-1) ;
			var zgs_num = nl_zgwuxing_txt.split("水").length-1 + (nl_gzwxhz_txt.split("水").length-1) ;
			var zgh_num = nl_zgwuxing_txt.split("火").length-1 + (nl_gzwxhz_txt.split("火").length-1) ;
			var zgt_num = nl_zgwuxing_txt.split("土").length-1 + (nl_gzwxhz_txt.split("土").length-1) ;
			//五行总量
			var zgwx_total = zgj_num + zgm_num + zgs_num + zgh_num + zgt_num ;
			j_num_b = (zgj_num!=0?  ((Math.round((zgj_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			m_num_b = (zgm_num!=0?  ((Math.round((zgm_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			s_num_b = (zgs_num!=0?  ((Math.round((zgs_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			h_num_b = (zgh_num!=0?  ((Math.round((zgh_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			t_num_b = (zgt_num!=0?  ((Math.round((zgt_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
			bf_b_arr = new Array(j_num_b,m_num_b,s_num_b,h_num_b,t_num_b); 
			bf_bs_arr =  new Array("金"+j_num_b,"木"+m_num_b,"水"+s_num_b,"火"+h_num_b,"土"+t_num_b); 
			//设置百分比
			$("#mz_info_wxgsbh_b").find(".jdt").each(function(index, element) {
                $(this).find(".z").css("width",bf_b_arr[index] );
                $(this).find(".t").text(bf_bs_arr[index]);
            });
			 
			//日主天干
			$("#mz_info_rztg").html("日主天干 :  "+nl_rizhutg_txt.replace(new RegExp(/【/g),"").replace(new RegExp(/】/g)," , ").substring(0,nl_rizhutg_txt.length)	 ); 
			//天干强度
			var wx_qd_str = nl_tgqd_txt+" "+zgqd_year_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_month_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_hours_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_day_txt.replace(new RegExp(/,/g)," ")
			html = "天干强度："+nl_tgqd_txt+"</br>"+
				"年臧强度："+zgqd_year_txt.replace(new RegExp(/,/g)," ")+"</br>"+
				"月臧强度："+zgqd_month_txt.replace(new RegExp(/,/g)," ")+"</br>"+
				"时臧强度："+zgqd_hours_txt.replace(new RegExp(/,/g)," ")+"</br>"+
				"日藏强度："+zgqd_day_txt.replace(new RegExp(/,/g)," ")+"</br>"+
				"五行强度：金"+ wxqd_pub('金',wx_qd_str) +"</br>"+
				"五行强度：木"+ wxqd_pub('木',wx_qd_str) +"</br>"+
				"五行强度：水"+ wxqd_pub('水',wx_qd_str) +"</br>"+
				"五行强度：火"+ wxqd_pub('火',wx_qd_str) +"</br>"+
				"五行强度：土"+ wxqd_pub('土',wx_qd_str) +"</br>"+
				"↓同类强度↓<br/>"+ nl_tongleiqd_txt +"</br>"+
				"↓异类强度↓<br/>"+ nl_yileiqd_txt +"</br>"
			$("#mz_info_qdfx").html(html);
			$("#mz_info_zhqd").html("综合强度："+nl_zongheqd_txt );
			var bzpd_des = nl_bzpd_txt=="日主弱"?"日主过弱":"日主过强";
			$("#mz_info_bazipd").html("八字判定："+nl_bzpd_txt+"</br>八字喜用："+nl_xiyong_txt+"</br>八字禁忌："+nl_jinji_txt+"</br><p class='color'>根据命主八字综合判定，命主八字"+nl_bzpd_txt+"，八字五行喜用"+nl_xiyong_txt+"，起名建议补"+nl_qimingbu_txt+"，可以调节命理五行平衡，让人生更加平顺。</p>");
			//能量判定
			var nlcc_array = nl_nlcc_txt.split(",");
			for(var i=0;i<nlcc_array.length;i++){
				
				nl_nlcc_txt = i==0? nlcc_array[i]:nl_nlcc_txt+"<br> "+nlcc_array[i] ;
			}
			$("#mz_info_nlpd").html(nl_nlcc_txt);
			$("#mz_info_jxfx").html("吉祥方位："+nl_jxfw_txt+"</br>吉祥颜色："+nl_jxys_txt+"</br>禁忌颜色："+nl_jjys_txt+"</br>吉祥数字："+nl_xysz_txt+"</br>禁忌数字："+nl_jjsz_txt+"</br>幸运花："+nl_xyhd_txt+"</br>");
			//获取标识许可
			var suan_str = $("#suan_mingzi").val();
			 
			if(suan_str!="no"){ 
				var orderno = $("div").data("auto_orderno");
				//console.log("当前订单号："+orderno);
				if(window.localStorage){
					//检查数据 
					if(localStorage['order_name_data'+orderno]!==undefined && localStorage['order_name_data'+orderno]!==""){
						var local_data = JSON.parse(localStorage['order_name_data'+orderno] ); 
						getQMResult(local_data);
						return ;
					}
				}
				//加载起名列表 
				qm_result(nl_xiyong_txt.replace("、","") );
			}
			
			 
		
		});
	}else{
		console.log("没有数据："+xml_type) 
	}
}  

function setJqtime(time){ 
	function getHouer24(val){
		val = parseInt(val)<10?"0"+parseInt(val):val;
		return val; 
	}
	time = time==""||typeof time=="undefined"? "0-0-0 0:0:0" :time ;
	time = time.replace(new RegExp(/:| /g),"-");
	var time_arr = time.split("-"); 
	time = time_arr[0]+"年"+getHouer24(time_arr[1])+"月"+getHouer24(time_arr[2])+"日"+" "+getHouer24(time_arr[3])+"时"+getHouer24(time_arr[4])+"分" ;
	return time;
}
//解析xml字符串
var loadXMLStr = function(xmlString){
	var xmlDoc=null;
	//判断浏览器的类型
	//支持IE浏览器 
	if(!window.DOMParser && window.ActiveXObject){   //window.DOMParser 判断是否是非ie浏览器
		var xmlDomVersions = ['MSXML.2.DOMDocument.6.0','MSXML.2.DOMDocument.3.0','Microsoft.XMLDOM'];
		for(var i=0;i<xmlDomVersions.length;i++){
			try{
				xmlDoc = new ActiveXObject(xmlDomVersions[i]);
				xmlDoc.async = false;
				xmlDoc.loadXML(xmlString); //loadXML方法载入xml字符串
				break;
			}catch(e){
			}
		}
	}
	//支持Mozilla浏览器
	else if(window.DOMParser && document.implementation && document.implementation.createDocument){
		try{
			/* DOMParser 对象解析 XML 文本并返回一个 XML Document 对象。
			 * 要使用 DOMParser，使用不带参数的构造函数来实例化它，然后调用其 parseFromString() 方法
			 * parseFromString(text, contentType) 参数text:要解析的 XML 标记 参数contentType文本的内容类型
			 * 可能是 "text/xml" 、"application/xml" 或 "application/xhtml+xml" 中的一个。注意，不支持 "text/html"。
			 */
			domParser = new  DOMParser();
			xmlDoc = domParser.parseFromString(xmlString, 'text/xml');
		}catch(e){
		}
	}
	else{
		return null;
	}

	return xmlDoc;
}
	
/***************************************************************/
//起名详情
function loadQmInfo(name,flag,sex){
	/*var name = $("#surname").val();
	var flag = $("#surnameflag").val();
	var sex = $("#surnamesex").val();
	*/
	//console.log("surname="+name+" flag="+flag+" sex="+sex);
	var callbackFun = name.length==4?"getQMInfoFunc_Surname":"getQMInfoFunc";
	if(name!="" && flag!="" && sex!=""){
		$.ajax({
		   type: "POST",
		   url: "/config/pro/do/result/3/?t="+Math.floor(Math.random() * (12323 + 1)), 
		   data:{"surname":(name),"flag":(flag),"sex":(sex) } ,
		   dataType : 'jsonp',   
		   jsonpCallback: callbackFun,   //回调函数  
		   success: function(data){},
		   error:  function(XMLHttpRequest, textStatus, errorThrown) {
				 console.log(XMLHttpRequest.status);
				 console.log(XMLHttpRequest.readyState);
				 console.log(textStatus);
	
		   }  
		});
	}
} 

//解析起名详情
function getQMInfoFunc_Surname(json_obj){ 
	var qmdata = eval(json_obj.result) ; 
	var data1 = qmdata[0];
	var data2 = qmdata[1];
	var data3 = qmdata[2];
	var data4 = qmdata[3]; 
	var html_1 ="";
	html_1 = '<dr><dd>姓名</dd><dd>'+data1.surname+'</dd><dd>'+data2.surname1+'</dd><dd>'+data3.name1+'</dd><dd>'+data4.name2+'</dd></dr>'+
	'<dr><dd>繁体</dd><dd>'+data1.ftsurname+'</dd><dd>'+data2.ftsurname1+'</dd><dd>'+data3.ftname1+'</dd><dd>'+data4.ftname2+'</dd></dr>'+
	'<dr><dd>拼音</dd><dd>'+data1.pysurname+'</dd><dd>'+data2.pysurname1+'</dd><dd>'+data3.pyname1+'</dd><dd>'+data4.pyname2+'</dd></dr>'+
	'<dr><dd>偏旁</dd><dd>'+data1.bssurname+'</dd><dd>'+data2.bssurname1+'</dd><dd>'+data3.bsname1+'</dd><dd>'+data4.bsname2+'</dd></dr>'+
	'<dr><dd>部首笔画</dd><dd>'+data1.bsbhsurname+'</dd><dd>'+data2.bsbhsurname1 +'</dd><dd>'+data3.bsbhname1+'</dd><dd>'+data4.bsbhname2+'</dd></dr>'+
	'<dr><dd>简体笔画</dd><dd>'+data1.jtbhsurname+'</dd><dd>'+data2.jtbhsurname1 +'</dd><dd>'+data3.jtbhname1+'</dd><dd>'+data4.jtbhname2+'</dd></dr>'+
	'<dr><dd>康熙笔画</dd><dd>'+data1.ftbhsurname+'</dd><dd>'+data2.ftbhsurname1 +'</dd><dd>'+data3.ftbhname1+'</dd><dd>'+data4.ftbhname2+'</dd></dr>'+
	'<dr><dd>五行属性</dd><dd>'+data1.wxsurname+'</dd><dd>'+data2.wxsurname1 +'</dd><dd>'+data3.wxname1+'</dd><dd>'+data4.wxname2+'</dd></dr>'+
	'<dr><dd>汉字凶吉</dd><dd>'+data1.jxsurname+'</dd><dd>'+data2.jxsurname1 +'</dd><dd>'+data3.jxname1+'</dd><dd>'+data4.jxname2+'</dd></dr>';
 	$("#name_wgmphd_analysis").removeAttr("class").attr("class","name1_analysis").html(html_1);
	
	//尾部数据
	setQMInfo_public(json_obj) ;
}
//解析起名详情
function getQMInfoFunc(json_obj){ 
	var qmdata = eval(json_obj.result) ; 
	var data1 = qmdata[0];
	var data2 = qmdata[1];
	var data3 = qmdata[2]; 
	var html_1 ="";
	html_1 = '<dr><dd>姓名</dd><dd>'+data1.surname+'</dd><dd>'+data2.name1+'</dd><dd>'+data3.name2+'</dd></dr>'+
	'<dr><dd>繁体</dd><dd>'+data1.ftsurname+'</dd><dd>'+data2.ftname1+'</dd><dd>'+data3.ftname2+'</dd></dr>'+
	'<dr><dd>拼音</dd><dd>'+data1.pysurname+'</dd><dd>'+data2.pyname1+'</dd><dd>'+data3.pyname2+'</dd></dr>'+
	'<dr><dd>偏旁</dd><dd>'+data1.bssurname+'</dd><dd>'+data2.bsname1+'</dd><dd>'+data3.bsname2+'</dd></dr>'+
	'<dr><dd>部首笔画</dd><dd>'+data1.bsbhsurname+'</dd><dd>'+data2.bsbhname1+'</dd><dd>'+data3.bsbhname2+'</dd></dr>'+
	'<dr><dd>简体笔画</dd><dd>'+data1.jtbhsurname+'</dd><dd>'+data2.jtbhname1+'</dd><dd>'+data3.jtbhname2+'</dd></dr>'+
	'<dr><dd>康熙笔画</dd><dd>'+data1.ftbhsurname+'</dd><dd>'+data2.ftbhname1+'</dd><dd>'+data3.ftbhname2+'</dd></dr>'+
	'<dr><dd>五行属性</dd><dd>'+data1.wxsurname+'</dd><dd>'+data2.wxname1+'</dd><dd>'+data3.wxname2+'</dd></dr>'+
	'<dr><dd>汉字凶吉</dd><dd>'+data1.jxsurname+'</dd><dd>'+data2.jxname1+'</dd><dd>'+data3.jxname2+'</dd></dr>';
 	$("#name_wgmphd_analysis").removeAttr("class").attr("class","name_analysis").html(html_1);
	//尾部数据
	setQMInfo_public(json_obj) ;
}
//起名详情后部数据
function setQMInfo_public(json_obj){
	var qmdata = eval(json_obj.result) ;
	var len = qmdata.length ; 
	var data4 = qmdata[len-6];
	var data5 = qmdata[len-5];
	var data6 = qmdata[len-4];
	var data7 = qmdata[len-3];
	var data8 = qmdata[len-2];
	var data9 = qmdata[len-1];
	$("#totale_score").text(data9.name_score);
	$(".score_content").text(data9.zong_pj);
	var html_2 ='<dr><dd class="first">五格</dd><dd>天格</dd><dd>地格</dd><dd>人格</dd><dd>外格</dd><dd>总格</dd></dr>'+
	'<dr><dd class="first">五格数理</dd><dd>'+data4.tgsu+'</dd><dd>'+data6.dgsu+'</dd><dd>'+data5.rgsu+'</dd><dd>'+data7.wgsu+'</dd><dd>'+data8.zgsu+'</dd></dr>'+
	'<dr><dd class="first">数理尾数</dd><dd>'+data4.tgws+'</dd><dd>'+data6.dgws+'</dd><dd>'+data5.rgws+'</dd><dd>'+data7.wgws+'</dd><dd>'+data8.zgws+'</dd></dr>'+
	'<dr><dd class="first">物理五行</dd><dd>'+data4.tgwx+'</dd><dd>'+data6.dgwx+'</dd><dd>'+data5.rgwx+'</dd><dd>'+data7.wgwx+'</dd><dd>'+data8.zgwx+'</dd></dr>'+
	'<dr><dd class="first">吉凶判定</dd><dd>'+data4.tgjx+'</dd><dd>'+data6.dgjx+'</dd><dd>'+data5.rgjx+'</dd><dd>'+data7.wgjx+'</dd><dd>'+data8.zgjx+'</dd></dr>'+
	'<dr><dd class="first">五格评分</dd><dd>'+data4.tgpf+'</dd><dd>'+data6.dgpf+'</dd><dd>'+data5.rgpf+'</dd><dd>'+data7.wgpf+'</dd><dd>'+data8.zgpf+'</dd></dr>' ;
	//console.log("html_2="+html_2)
 	$("#sancai_wgfx").html(html_2);
	//{name_score:,zong_pj:,name1_info:,name2_info:,rg_info:,dg_info:,zg_info:}9
	$("#name1_info").html(data9.name1_info);
	$("#name2_info").html(data9.name2_info);
	//$("#renge_info").html(data9.rg_info);
	//$("#dige_info").html(data9.dg_info);
	//$("#zongge_info").html(data9.zg_info);
}

function sendNotice(orderno,ipt_obj){
	var mobile = $(ipt_obj).val();
	if( (new RegExp(/^(13[0-9]|15[012356789]|17[012356789]|18[012356789]|14[57])[0-9]{8}$/g)).test(mobile) ){
	$(".ask").show();
	$(".res_load").show();
		$.ajax({
		   type: "POST",
		   url: "/wap2/pro/txt/sms/order_notice.asp?t="+Math.floor(Math.random() * (12323 + 1)), 
		   data:{"mobile":(mobile),"orderno":(orderno)  } ,  
		   success: function(data){
			   var msg = data.split("=");
			   if(parseInt(msg[0])==1){$(ipt_obj).val("");}
			   alert(msg[1]);
			   $(".ask").hide();
			   $(".res_load").hide();
			} 
		});
	}else{alert("请填写正确手机号！");}
}
 
function qmjsresult(nl_baziwx_txt,nl_zgwuxing_txt,nl_gzwxhz_txt,nl_rizhutg_txt,nl_nlcc_txt,nl_tgqd_txt,zgqd_year_txt,zgqd_month_txt,zgqd_hours_txt,zgqd_day_txt,nl_tongleiqd_txt,nl_yileiqd_txt,nl_zongheqd_txt
,nl_bzpd_txt,nl_xiyong_txt,nl_jinji_txt,nl_qimingbu_txt){
//××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××

	//计算五行强度
	var wxqd_pub = function(types,data){
		//types = 五行名称（金、木。。。。。）
		//console.log("types="+types+" data="+data)
		var data_arr = data.split(" ");
		var qd_num = 0;
		for(var i=0;i<data_arr.length;i++){
			if(data_arr[i].indexOf(types)>=0){
				 
				qd_num = parseFloat(qd_num) + parseFloat(data_arr[i].toLowerCase().replace(types+"x",""))
			}
		}
		return Math.round(parseFloat(qd_num)*100)/100; ;
	}
	//五行分析不包含藏干
	
	var j_num = nl_baziwx_txt.split("金").length-1;
	var m_num = nl_baziwx_txt.split("木").length-1;
	var s_num = nl_baziwx_txt.split("水").length-1;
	var h_num = nl_baziwx_txt.split("火").length-1;
	var t_num = nl_baziwx_txt.split("土").length-1;
	//五行总量
	var wx_total = j_num + m_num + s_num + h_num + t_num ; 
	$("#mz_info_wxgs").text( "【金】"+(j_num)+"【木】"+(m_num)+"【水】"+(s_num)+"【火】"+(h_num)+"【土】"+(t_num) );
				
	//五行解读
	var wxjd_txt = "";
	if(j_num!=0&&m_num!=0&&s_num!=0&&h_num!=0&&t_num!=0){
		wxjd_txt = "五行齐全";
	}else{
		wxjd_txt = "五行缺"+(j_num==0?"金":"" )+(m_num==0?"木":"" )
		+(s_num==0?"水":"" )+(h_num==0?"火":"" )+(t_num==0?"土":"" );
	}
	//五行分析
	$("#wuxingfx").html("五行解读 : "+wxjd_txt);
	var j_num_b = (j_num!=0?  ((Math.round((j_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	var m_num_b = (m_num!=0?  ((Math.round((m_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	var s_num_b = (s_num!=0?  ((Math.round((s_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	var h_num_b = (h_num!=0?  ((Math.round((h_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	var t_num_b = (t_num!=0?  ((Math.round((t_num / wx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	var bf_b_arr = new Array(j_num_b,m_num_b,s_num_b,h_num_b,t_num_b); 
	var bf_bs_arr =  new Array("金"+j_num_b,"木"+m_num_b,"水"+s_num_b,"火"+h_num_b,"土"+t_num_b); 
	//设置百分比
	$("#mz_info_wxgs_b").find(".jdt").each(function(index, element) {
		$(this).find(".z").css("width",bf_b_arr[index] );
		$(this).find(".t").text(bf_bs_arr[index]);
	});
	//××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××××
	//五行分析包含藏干
	var zgj_num = nl_zgwuxing_txt.split("金").length-1 + (nl_gzwxhz_txt.split("金").length-1) ;
	var zgm_num = nl_zgwuxing_txt.split("木").length-1 + (nl_gzwxhz_txt.split("木").length-1) ;
	var zgs_num = nl_zgwuxing_txt.split("水").length-1 + (nl_gzwxhz_txt.split("水").length-1) ;
	var zgh_num = nl_zgwuxing_txt.split("火").length-1 + (nl_gzwxhz_txt.split("火").length-1) ;
	var zgt_num = nl_zgwuxing_txt.split("土").length-1 + (nl_gzwxhz_txt.split("土").length-1) ;
	//五行总量
	var zgwx_total = zgj_num + zgm_num + zgs_num + zgh_num + zgt_num ;
	j_num_b = (zgj_num!=0?  ((Math.round((zgj_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	m_num_b = (zgm_num!=0?  ((Math.round((zgm_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	s_num_b = (zgs_num!=0?  ((Math.round((zgs_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	h_num_b = (zgh_num!=0?  ((Math.round((zgh_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	t_num_b = (zgt_num!=0?  ((Math.round((zgt_num / zgwx_total)*100 * 100) / 100).toFixed(2)):"0.00") +"%" ;
	bf_b_arr = new Array(j_num_b,m_num_b,s_num_b,h_num_b,t_num_b); 
	bf_bs_arr =  new Array("金"+j_num_b,"木"+m_num_b,"水"+s_num_b,"火"+h_num_b,"土"+t_num_b); 
	//设置百分比
	$("#mz_info_wxgsbh_b").find(".jdt").each(function(index, element) {
		$(this).find(".z").css("width",bf_b_arr[index] );
		$(this).find(".t").text(bf_bs_arr[index]);
	});
	 
	//日主天干
	$("#mz_info_rztg").html("日主天干 :  "+nl_rizhutg_txt.replace(new RegExp(/【/g),"").replace(new RegExp(/】/g)," , ").substring(0,nl_rizhutg_txt.length)	 ); 
	//天干强度
	var wx_qd_str = nl_tgqd_txt+" "+zgqd_year_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_month_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_hours_txt.replace(new RegExp(/,/g)," ")+" "+zgqd_day_txt.replace(new RegExp(/,/g)," ")
	html = "天干强度："+nl_tgqd_txt+"</br>"+
		"年臧强度："+zgqd_year_txt.replace(new RegExp(/,/g)," ")+"</br>"+
		"月臧强度："+zgqd_month_txt.replace(new RegExp(/,/g)," ")+"</br>"+
		"时臧强度："+zgqd_hours_txt.replace(new RegExp(/,/g)," ")+"</br>"+
		"日藏强度："+zgqd_day_txt.replace(new RegExp(/,/g)," ")+"</br>"+
		"五行强度：金"+ wxqd_pub('金',wx_qd_str) +"</br>"+
		"五行强度：木"+ wxqd_pub('木',wx_qd_str) +"</br>"+
		"五行强度：水"+ wxqd_pub('水',wx_qd_str) +"</br>"+
		"五行强度：火"+ wxqd_pub('火',wx_qd_str) +"</br>"+
		"五行强度：土"+ wxqd_pub('土',wx_qd_str) +"</br>"+
		"↓同类强度↓<br/>"+ nl_tongleiqd_txt +"</br>"+
		"↓异类强度↓<br/>"+ nl_yileiqd_txt +"</br>"
	$("#mz_info_qdfx").html(html);
	$("#mz_info_zhqd").html("综合强度："+nl_zongheqd_txt );
	var bzpd_des = nl_bzpd_txt=="日主弱"?"日主过弱":"日主过强";
	$("#mz_info_bazipd").html("八字判定："+nl_bzpd_txt+"</br>八字喜用："+nl_xiyong_txt+"</br>八字禁忌："+nl_jinji_txt+"</br><p class='color'>根据命主八字综合判定，命主八字"+nl_bzpd_txt+"，八字五行喜用"+nl_xiyong_txt+"，起名建议补"+nl_qimingbu_txt+"，可以调节命理五行平衡，让人生更加平顺。</p>");
	//能量判定
	var nlcc_array = nl_nlcc_txt.split(",");
	for(var i=0;i<nlcc_array.length;i++){
		
		nl_nlcc_txt = i==0? nlcc_array[i]:nl_nlcc_txt+"<br> "+nlcc_array[i] ;
	}
	$("#mz_info_nlpd").html(nl_nlcc_txt);
		
}
