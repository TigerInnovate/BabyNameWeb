
<?php
date_default_timezone_set("Asia/Shanghai");
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="keywords" content="">
	<meta name="description" content="中国民族品牌在线算命平台，资深国学大师指导，易学文化最具影响力大师取名，周易取名，小孩婴儿算命，奥斯卡“金典奖”算命服务平台，权威算命网站。">
	<title>周易算命网-收银台</title>
	<link rel="stylesheet" type="text/css" href="../Public/Pc/css/style2.css"/>
	<script type="text/javascript" src="../Public/Pc/js/jquery-1.7.2.min.js" ></script>
	<script src="../Public/Pc/js/homepage.js"></script>
	<script src="../Public/Pc/js/layer.js" ></script>
	<script src="../Public/Pc/js/suan_index_meun.js" ></script>

	
	<script src="../Public/Pc/js/qrcode.min.js"></script>

	<script type="text/javascript">

		function getQRCode(payType){
			var url='';
			if(payType=='wx'){
				url = 'weixinpay.php';
			}else if(payType=='ali'){
				url = 'alipay.php';
			}else{
				url = 'weixinpay.php';
			}
			$.get('pay/'+url,function(re){
				$("#" + payType).empty(); // 清空当前二维码
				var qrcode = new QRCode(document.getElementById(payType), {
					url: re,
					width: 252,
					height: 252,
					colorDark : "#000000",
					colorLight : "#ffffff",
					correctLevel : QRCode.CorrectLevel.H
				});
				qrcode.clear(); // clear the code.
				qrcode.makeCode(re); // make another code.
			})
		}


		$(document).ready(function(e) {
			getQRCode("wx");
			$("#channel").val('微信支付');
			$("#weixin_Id").show();
			$("#alipay_id").hide();
			/*收藏*/
			$("#sc_id").bind("click",function(){HomepageFavorite.Favorite(window.location.href, document.title);});
			$("#sc_youli").bind("click",function(){HomepageFavorite.Favorite(window.location.href, document.title);});

			$(".hed_table_5d1v").each(function(index){
				$(this).click(function(){
					$(".HedAction_p1").hide();
					$(".hed_table_5d1v").removeClass('HedAction');
					$(this).addClass('HedAction'),$(".HedAction_p1:eq("+index+")").show();
					var type = $(this).attr("data-type"),url="";
					//alert("支付类型："+type);
					if(type == "alipay"){
						$("#channel").val('支付宝');
						$("#alipay_id").show();
						$("#weixin_Id").hide();
						getQRCode("ali");
						//选择支付宝付款就停止微信支付检查支付状态程序
						//clearInterval($("div").data("wxpay_statecheck_time"));
					}else{
						$("#channel").val('微信支付');
						$("#weixin_Id").show();
						$("#alipay_id").hide();
						getQRCode("wx");
					}
				});
			});
			$("#pay_btn").click(function(){
				//alert($("#channel").val())
				if($("#channel").val()==''){
					layer.alert('请选持支付方式', {icon: 0,title:'提示'});
					return false;
				}else{
					$(".mengcheng").show();
					$("#qu_form_pay").submit();
				}
			});

			//保存支付数据
//			save_pay_data();
			//设置微信支付二维码
//			//						/**********************支付方式切换**************************************************/
			//支付弹窗功能
			var mh = $(window).height();
			$(".mengcheng01").css("height",mh+"px");
			$(".ppcs").each(function(index){
				$(this).click(function(){
					$(".ppcs").removeClass("mc-paction"),$(this).addClass("mc-paction");
					var out_trade_no="bz00002572934";
					$.ajax({
						url: "/Pc/Index/order_state.html",
						type:"POST",
						data: {out_trade_no:out_trade_no,type:'alipay'},
						success: function(data){
							   //index==0时表示用户点击的是“更改支付方式”按钮
								if(parseInt(data.status)==1){
									//已付款
									//如果点击的是“更改支付方式”按钮则要弹出提示，其他不弹提示直接显示支付结果页面。
									if(index==0){
									alert("此订单已支付");
									window.location.href=data.info ;
									}else if(index==1){
									window.location.href=data.info ;
									}
								}else{
									if(parseInt(data.info)==0){
										//没有付款，如果用户点击的是已支付按钮，则弹出提示，其他直接关闭弹窗
										if(index==1){
											alert("此订单未支付");
										}else{
											$(".mengcheng").hide();
										}
									}else if(parseInt(data.info)==-1){
										//订单不存在
										alert("此订单不存在，请联系客服！！");
										$(".mengcheng").hide();
										//window.location.reload();
									}
								}
						}
					});

				});
			});
			//订单弹出关闭时处理
			$(".xx-xx").click(function(){
                $('#mc-p').click();
//				var order = $("input[name='orderNo']").val(),url = "";
//				alert("此订单未支付");
//				$(".mengcheng").hide();
			});
			/************************************************************************/
		});
		/*//本地支付数据生成sub_type-提交类型
		function save_pay_data(sub_type){
			var channel = $("#channel").val();
			var param ="" ,url="";//参数
			if(sub_type=="1"){

				var qm_remark = $("#qm_remark").val();
				param = "channel="+ escape(channel)+"&amount="+escape("29.8")+"&orderId="+escape("bz00002572934")+"&orderType=pc"
						+"&sex=女" +"&birthday="+escape("1990-01-01 00:00:00");
				url = "pay/jump.asp" ;
			}/!*else if(sub_type=="2"){
				//合婚
				param = "channel="+ escape(channel)+"&amount="+escape("<%=amount%>")+"&orderId="+escape("<%=orderId%>")+"&hh_wname="+escape("<%=hh_wname%>")+"&urlSource="+escape("<%=UrlSource%>")+"&hh_w_birthday="+ escape("<%=hh_w_birthday%>")+"&orderType=pc"
						+"&hh_mname="+escape("<%=hh_mname%>")+"&hh_m_birthday="+escape("<%=hh_m_birthday%>")+"&hh_email="+escape("<%=hh_email%>")+"&ipSource="+escape("<%=visitors_ip%>") +"&hh_remark="+escape("<%=hh_remark%>");
				url = "pay/hh_jump.asp";
			}else{
				//咨询大师
				param = "channel="+ escape(channel)+"&amount="+escape("<%=amount%>")+"&orderId="+escape("<%=orderId%>")+"&zx_name="+escape("<%=zx_name%>")+"&urlSource="+escape("<%=UrlSource%>")+"&zx_email="+ escape("<%=zx_email%>")+"&orderType=pc"
						+"&zx_sex=<%=zx_sex%>&zx_birthday="+escape("<%=zx_birthday%>")+"&zx_address="+escape("<%=zx_address%>")+"&ipSource="+escape("<%=visitors_ip%>") +"&zx_content="+escape("<%=zx_content%>")+"&zx_phone="+escape("<%=zx_phone%>") ;
				url = "pay/zxds_jump.asp";
			}*!/
			$.ajax({
				url: url,
				type:"POST",
				data: param ,
				success: function(xmlDom){
					if(xmlDom == "1"){
						//订单生成后才显示支付按钮。
						//$(".shouyin_box3").show();
						//给客户发送通知邮件
						var order_num = $("input[name='orderNo']").val();
						sendOrderEmail(order_num);
					}else if(xmlDom == "2"){
						window.location.href="/";
					}else{
						alert("支付订单生成失败，返回重试！");
						//支付状态码：28002 表示支付平台数据插入失败。
						//window.location.href  = "../" ;
					}

				}
			})
		}*/

		var wx_check=true;
		var out_trade_no="bz00002572934";
		//检查订单是否支付成功
		function CheckOrderState(order_num){
		
		}
		/*//发送通知邮件
		function sendOrderEmail(order_num){
			//订单类型
			var cstype = $("[name='cstype']").val();
			if(typeof order_num!="undefined"&&order_num!=""&&order_num!=null){
				$.ajax({
					url:"pay/processing/doToQumingEmail.asp",
					type:"POST",
					data:"orderno="+order_num+"&cstype="+cstype ,
					success: function(txt){
						var msg = txt.split("=");
						console.log("email："+msg[1]);
					}
				})
			}
		}*/

	</script>
</head>
<body style="min-width:1062px;">

<div class="cn"><img src="../Public/Pc/images/cn.png" class="db mra0" /></div>
<div class="header">
	<div class="cont father">
		<a href="#"  class="logo dib fl"><img src="../Public/Pc/images/logo.png" alt=""></a>
		<div class="fr" style="position:relative;">
			<div class="sc fr">
				<div class="" title="收藏本站" id="sc_id"></div>
			</div>
		</div>
	</div><!--end cont-->
</div>
<div class="nav">
	<ul>
		<li class="item active"><a href="./#" >首页</a><span class="hr"></span></li>
		<li class="item"><a href="./#J" >算命优势</a><span class="hr"></span></li>
		<li class="item"><a href="./#K" >马上算命</a><span class="hr"></span></li>
		<li class="item"><a href="./#Q" >常见问答</a><span class="hr"></span></li>
		<li class="item"><a href="./#U" >客户评价</a><span class="hr"></span></li>
		<!-- <li class="item"><a href='http://tb.53kf.com/code/client/10147745/3' target='_blank'>联系我们</a><span class="hr"></span></li>
		<li class="item cur"><a id='sc_youli'>收藏有礼</a><span class="hr"></span></li> -->
	</ul>
</div>
<div class="qm-main">
	<div class="content">

		<link rel="stylesheet" type="text/css" href="../Public/Pc/css/shouyintai.css"/>
		<div class="hed_box">
			<span class="hed_box_s1">订单详情</span>
		</div>
		<div>支付完成后，加老师微信 <span style="color:red">suan8886</span> 获取算命结果</div>
		<table class="shouyin_box">
			<tr><td colspan='2' style="height:20px;"></td></tr>
			<tr>
				<td  class="shouyin_d1">订 &nbsp;单&nbsp;号 :&nbsp;</td><td  id='ordernumber' types='八字算命'>bz00002572934</td>
                <span style="display:none;" id="fullname">王(女)</span>
			</tr>
			<tr>
				<td class="shouyin_d1">下单时间  :&nbsp;</td><td><?php echo  date("Y-m-d H:i:s"); ?></td>
			</tr>
			<!--<tr>-->
				<!--<td class="shouyin_d1">联系方式  :&nbsp;</td><td><%=email%>  </td>-->
			<!--</tr>-->
			<tr>
				<td class="shouyin_d1">订单金额 :&nbsp;</td><td>29.8元</td>
			</tr>
			<tr><td colspan='2' style="height:20px;"></td></tr>
		</table>
		<table class="shouyin_box2">
			<tr><td colspan='4' style="height:20px;"></td></tr>
			<tr>
				<td colspan='4' class="shouyin_box2j1">支付方式 :</td>
			</tr>
			<tr>
				<td >
					<div class="hed_table_5d1" style="float:left;">
							<div class="hed_table_5d1v g5D2VR HedAction" data-type="wxpay" style="background:url(../Public/Pc/images/pay_img_weix.jpg) no-repeat;">
							<p class="HedAction_p1" style="display: block;"><img src="../Public/Pc/images/red_Img_gou.png"/></p>
						</div>
					</div>
					<div class="hed_table_5d1" style="float:left;margin-left:10px;">
						<div class="hed_table_5d1v" data-type="alipay" style="background:url(../Public/Pc/images/pay_img_zfb.jpg) no-repeat;">
							<p class="HedAction_p1" style="display:none;"><img src="../Public/Pc/images/red_Img_gou.png"/></p>
						</div>
					</div>
				</td>

			</tr>
			<tr><td colspan='4' style="height:45px;"></td></tr>
			<tr>
				<td colspan='4' align="right">
					<form id="qu_form_pay" method="post" target="_blank" action="">
						<input type="hidden" name="mode" id="bkan"/>
						<input type="hidden" name="orderNum" value="bz00002572934"/>
						<input type="hidden" name="type" id="channel" value="2"/>
						<input type="hidden" name="amount" value="29.8"/>
						<div class="shouyin_box3 father" id="alipay_id" style="display:none;">
							<div class="weixin_t">请用<span style="color:red">支付宝</span>扫描以下二维码 :</div>
							<div class="father" style="width:60%;margin:0 auto;padding:25px 0px;">
								<div class="father fl" style="width:252px;">
									<div class="w_100 father " style="height:252px;">
										<!--<img src="<%=wx_ewm_url %>" style="width:252px;height:252px;" class="db wx_ewm_img"/>-->
										<div style="width:252px;height:252px;" class="db wx_ewm_img" id="ali"> </div>
										<div class="w_100 wx_ewm_zq_bg dn"></div>
										<div class="wx_ewm_zq father cor4 dn"><img src="../Public/Pc/images/correct.png" class="db fl mrt5"/><span class="db fl mrl5" style="width:150px;font-size:16px;">支付成功3秒后跳转</span></div>
									</div>
									<div class="w_100 mrt10 pd0"><img src="../Public/Pc/images/ali_ewm_ot.png" class="db" /></div>
								</div>
							</div>
						</div>
						<style type="text/css">
							.weixin_t{font-size:18px;width:100%;line-height:60px;text-align:left;text-indent:50px;border:1px solid #E8E8E8;color:#858585;}

							.cor4{color:#ffffff;}/*白色*/
							.dn{display:none}.pd0{padding:0px;}
							.db{display:block;}.mrt5{margin-top:5px;}.mrl5{margin-left:5px;}.mrt10{margin-top:10px;}
							.father:after {content:"."; display:block; height:0; clear:both; visibility:hidden;}
							.cur{cursor:pointer;}
							.fl{ float:left;}
							.fr{ float:right;}
							.w_100{width:100%;}
							.wx_ewm_img{z-index:1;position:relative;margin:0 auto;}
							.wx_ewm_zq{width:80%;margin:-55% 0px 0px 10%;z-index:4;position:relative;border:0px solid red;}
							.wx_ewm_zq_bg{height:252px;margin-top:-252px;opacity:0.8; background:#666;filter:alpha(opacity=80);z-index:2;position:relative;}
							.wxpay_ts{width:40%;line-height:30px;margin-left:5%;}
						</style>
						<div class="shouyin_box3 father" id="weixin_Id" style="display:none;">
							<div class="weixin_t">请用<span style="color:red">微信</span>扫描以下二维码 :</div>
							<div class="father" style="width:60%;margin:0 auto;padding:25px 0px;">
								<div class="father fl" style="width:252px;">
									<div class="w_100 father " style="height:252px;">
										<!--<img src="<%=wx_ewm_url %>" style="width:252px;height:252px;" class="db wx_ewm_img"/>-->
										<div style="width:252px;height:252px;" class="db wx_ewm_img" id="wx"> </div>
										<div class="w_100 wx_ewm_zq_bg dn"></div>
										<div class="wx_ewm_zq father cor4 dn"><img src="../Public/Pc/images/correct.png" class="db fl mrt5"/><span class="db fl mrl5" style="width:150px;font-size:16px;">支付成功3秒后跳转</span></div>
									</div>
									<div class="w_100 mrt10 pd0"><img src="../Public/Pc/images/wx_ewm_ot.png" class="db" /></div>
								</div>
							</div>
						</div>
					</form>

				</td>
			</tr>

			<tr><td colspan='4' style="height:30px;">  </td></tr>

			<tr><td colspan='4' > 
			<div style="text-align:center;margin-top:20px;" class="hed_box_s1">
							支付完成后，加老师微信获取算命结果<br><br>
							<div style="cursor:pointer; padding:10px 20px;border-radius:5px;width:180px;margin:0 auto;background:#CB0000;color:#fff;font-size:18px" id="addWeixin">老师微信：suan8886</div>
						</div>
				
				<div class="imgBox">
					<div style="padding:10px 20px;margin:0 auto;width:201px;height:201px;">
						<canvas width="128" height="128" style="display: none;"></canvas>
						<img style="display: block;" src="../Public/Pc/images/wx.png">
					</div>
				</div>
			</td></tr>
			
		</table>
		

	</div>
</div>

<div class="mengcheng">
	<div class="mengcheng01"></div>
	<div class="mengcheng02">
		<h1 style="background:url(../Public/Pc/images/mc.jpg) no-repeat;"><p class="xx-xx"></p></h1>
		<p id="mc-p" class="ppcs mc-paction">更改支付方式</p>
		<p class="ppcs">已付款</p>
	</div>
</div>

<div class="s-footer">
	<div class="cont">
		<p>版权所有  Copyright &copy; 2005 - 2016 ALL Rights Reserved  </p>
		<p>

		</p>
	</div><!--end cont-->
</div>
<!-- 微信二维码  -- >
<div class="weixinerwei" style="position:fixed;left:0px;top:50px;z-index:9999;_position: absolute;_bottom: auto;_top:expression(eval(document.documentElement.scrollTop+50));">
	<img style="display:none;" src="/weixinerwei.png"  alt="微信二维码" />
	<img src="/images/weixinerwei_s.png"  alt="微信二维码" />
</div>	
<!-- 微信二维码  -->
<!-- 联系客服 -->
<!-- <div style="width:50%;position:fixed;height:67px;left:0px;bottom:36px;_position:absolute;_top:expression(eval(document.documentElement.scrollTop+440));">
	<a href="http://tb.53kf.com/code/client/10147745/3" target="_blank" style="display:inline-table" >
		<img src="/Public/Pc/images/clickbtn_7.png" />
	</a>
</div> -->
<!-- 联系客服 -->
<!--此处js用于保存订单到本地-->
<script src="../Public/Pc/js/localdata.js"></script>
<script>
	var _hmt = _hmt || [];
	(function() {
	  var hm = document.createElement("script");
	  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
	  var s = document.getElementsByTagName("script")[0]; 
	  s.parentNode.insertBefore(hm, s);
	})();
</script>
</body>
</html>