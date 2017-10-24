// JavaScript Document
//alert( location.search)
//解析参数
var location_str = location.search ;

var quming_data_url = "http://order.7ming.wang/";
//起名测算结果
function suan_result(birthday,orderno){  
	//var datetimeStr = setJqtime(datetime);//year+"年"+parseInt(month)+"月"+day+"日 "+hour+"时"+minute+"分";
	$("div").data("auto_orderno",orderno);
	if(birthday!=""  ){  
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
		   type: "POST",
		   url: quming_data_url+"result/quming/?t="+Math.floor(Math.random() * (13010 + 1)), 
		   data:{"sex":(sex),"name":(name),"page":3,"wxname":(wxname),"orderno": $("div").data("auto_orderno")  } ,
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

	function getQMResult(json_data_obj){ 
		var page_num = 20 ;//每页显示数量
		//alert(json_data_obj);return;
		var xml = loadXMLStr(json_data_obj.result) ;  
		var xml_type = $(xml).find("info").text();   
		var xml_totale = json_data_obj.totale ; 
		var curr_page = 1 ,totale_page =  xml_totale % page_num ==0? parseInt(xml_totale/page_num) : parseInt(xml_totale/page_num)+1;
		
		//console.log("结果总数："+xml_totale+" 当前页："+curr_page+" 总页数："+totale_page);
		//设置当前数和总数
		$("#qmResRefresh").attr("data-val","1").attr("data-totale",totale_page).attr("data-page",page_num).click(function(){
				var currPage = $(this).attr("data-val");
				var totale = $(this).attr("data-totale");
				var page = $(this).attr("data-page");
				
				if(parseInt(currPage)==parseInt(totale)){
					$(this).html("没有更多了哦！");
				}else if(parseInt(currPage)< parseInt(totale)){
					//显示下一页
					currPage = parseInt(currPage)+1;
					for(var j = (currPage*page -20) ;j<=currPage*page;j++){
						$("#res_t"+j).show(300); 
						//console.log("当前页和总页数："+j);
					}
					//更新当前页码
					$("#qmResRefresh").attr("data-val",currPage);
				}
		});
    	var html ="";
		if(xml_type!=""&&xml_type!="0"){
			$(xml).find("user").each(function(i){ 
				var username = $(xml).find("username").eq(i).text();
				var wuxing = $(xml).find("wuxing").eq(i).text(); 
				var pingyin = $(xml).find("pingyin").eq(i).text();
				var xionji = $(xml).find("xionji").eq(i).text();
				var explain1 = $(xml).find("explain1").eq(i).text();  
				var explain2 = $(xml).find("explain2").eq(i).text();
				var show_flag = i>= page_num ?"display:none;":"";  
				html = html+"<tr class='result_tit' id='res_t"+i+"' style='"+show_flag+"'><td class='t1'>"+
				username+"&nbsp;&nbsp;：&nbsp;&nbsp;</td><td class='t2'>"+pingyin+"</td><td class='t2'>"+
				wuxing+"</td><td class='t2'>"+xionji+"</td></tr>"+
				"<tr class='result_txt' id='res_txt_"+i+"' ><td colspan='4'><div>"+
				"	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+explain1+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+explain2+"</span>"+
				"</div></td></tr>";
				/*html = html+"<div class='result_tit' id='res_t"+i+"' style='"+show_flag+"'>"+username+" ： "+pingyin+" "+wuxing+" "+xionji+"</div>"+
				"<div class='result_txt' id='res_txt_"+i+"' >"+
				"	<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+explain1+"<br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"+explain2+"</span>"+
				"</div>"*/
				$(".qmResList tbody").html(html).find("#res_txt_0").show();
				 
				$(".qmResList .result_tit").each(function(index, element) {
					$(this).click(function(){
						 
						var obj = $(this).next();
						//console.log("点击的是"+index+" 内容："+obj.html());
						var state = obj.attr("data-dis");
						if(state!="undefined"&&parseInt(state)==1){
							//隐藏
							obj.hide().attr("data-dis",0);
						}else{
						//关闭之前显示的
						$(".qmResList .result_txt").hide();
						//显示当前名称的详情
						obj.show().attr("data-dis",1);
						}
					});
				});
			});
		}else{
			console.log("没有数据："+xml_type) 
		}
		
	}
//解析处理结果
function getSuanData(json_data_obj){  
    // alert(json_data_obj.result);  
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
			//获取标识许可
			var suan_str = $("#suan_mingzi").val();
			if(suan_str!="no"){
				console.log(nl_xiyong_txt);
				//加载起名列表 
				qm_result(nl_xiyong_txt);
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