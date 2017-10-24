var xz_style='<style type="text/css">.gb_footer{width:100%;padding:0.4rem 0;background:#c09d65;text-align: center;}.gb_footer p{line-height:.5rem;font-size:.28rem;}</style>';
var xz_footer='<div class="gb_footer" id="footInfo">'+
 	'<!--p class="gb_footer_txt">起名时间8点到22点 全年无休</p-->'+
 	'<p class="gb_footer_txt" id="web_title"></p>'+
 '</div>';
 document.write(xz_style+xz_footer);
$.ajax({
	url:"/processing/xml/sysDoWebConfigXML.asp",type:"POST",success: function(xml){ 
		var webzizhi = $(xml).find("webzizhi").eq(0).text(); 
		var webcode = $(xml).find("webcode").eq(0).text(); 
		//放置在信息最后
		$("#footInfo").find("#web_title").append(webzizhi ); 
		 
	}	
});