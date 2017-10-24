<?php
date_default_timezone_set('PRC');
include 'nongli.php';

$xing = "";
$birthday = "";
$gender = "";
$birthtime = "";
$birthmin = "";

if(isset($_GET["xing"])) $xing = $_GET["xing"];
if(isset($_GET["gender"])) 	$gender = (int)$_GET["gender"] == 0 ? "女" : "男";
if(isset($_GET["birthday"])) $birthday = $_GET["birthday"];
if(isset($_GET["birthtime"])) $birthtime = $_GET["birthtime"];
if(isset($_GET["birthmin"])) $birthmin = $_GET["birthmin"];

if(isset($_POST["surname"])) $xing = $_POST["surname"];
if(isset($_POST["sex"])) 	$gender = (int)$_POST["sex"] == 0 ? "女" : "男";
if(isset($_POST["birthday"])) $birthday = $_POST["birthday"];
if(isset($_POST["hour"])) $birthtime = $_POST["hour"];
if(isset($_POST["mini"])) $birthmin = $_POST["mini"];

$birthtime_ = strtotime($birthday . " " . $birthtime . ":" . $birthmin);
$birthtimeStr = date("Y年m月d日H时i分", $birthtime_);
$shichenArray = ["子时","丑时","寅时","卯时","辰时","己时","午时","未时","申时","酉时","戊时","亥时"];
$hour = (int)$birthtime;
$hour = (int) ((($hour + 1) % 24 ) / 2);
$shichen =  $shichenArray[$hour];
$nongli = nongli($birthday);
$birthtimeNongliStr = $nongli . " " . $shichen;

if(empty($_GET['amp;order_num'])){
	if(empty($_GET['order_num'])){
		$order_num = '';
	}else{
		$order_num = $_GET['order_num'];
	}
}else{
	$order_num = $_GET['amp;order_num'];
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="applicable-device" content="mobile">
<meta name="viewport" content="width=720,width=device-width, initial-scale=1,  initial-scale=1.0,maximum-scale=1.0, user-scalable=no">
<title>八字起名</title>
<script>
(function (doc, win) {
	var docEl = doc.documentElement,
		resizeEvt = 'orientationchange' in window ? 'orientationchange' : 'resize',
		recalc = function () {
		var clientWidth = docEl.clientWidth;
		//alert(clientWidth)
		if (!clientWidth) return;
			var fts = clientWidth /10;
			if(fts<32){
				fts=32;
			}else if(fts>72){
				fts=72;
			}
			docEl.style.fontSize = fts + 'px';
		};
	if (!doc.addEventListener) return;
	win.addEventListener(resizeEvt, recalc, false);
	doc.addEventListener('DOMContentLoaded', recalc, false);
})(document, window);
</script>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/qiming.css?ver=3" >
<link type="text/css" rel="stylesheet" href="../css/layout_auto.css">
<link rel="stylesheet" type="text/css" href="../css/icons.css">
<script src="../js/jquery.js" ></script>
<script src="../js/daySelect.js?ver=1" ></script>
<script src="../js/qiming.js?ver=1" ></script> 
<script src="../js/qm.result1.js?oer="></script>
<script src="../js/calendar.min.js?ver=1" ></script>
<script src="../js/ntog.js" ></script>
</head>

<style>
.qmUserInfo{width:100%;margin:0 auto;border:0px solid #c09d65; background:#fff;}
.qmUserInfo td{padding:18px 0px;line-height:1.8em;border-bottom:1px solid #c09d65;}
.qmUserInfo .bor1{border-right:1px solid #c09d65;}
.mlrem1{margin-left:0.5rem;}
.td1{width:12.6%}
.td2{width:12.6%}
.td3{width:73.7%}
.alipay_lijian{display:inline-block;padding:0px 10px;margin-left:2.3rem;line-height:0.6rem;font-size:0.4rem; font-weight:600;border-radius:5px;border:1px solid #F00;}
.bor{border:1px solid red;}.mt20{margin-top:20px;}
.w_100{width:100%;}.dit{display:inline-table;}.dib{display:inline-block}.db{display:block;}
.payTip{width:85%;margin:0 auto;line-height:0.6rem;font-size:0.4rem; font-weight:200;border:0px solid red;}
.payTip img{width:0.6rem;display:block;float:left;}
.payTip span{display:inline-block;float:left;margin-left:0.3rem;margin-top:-1px;}
.qm .sm_hd{display:block; background-color: #966a3b; color: #f8e6d0; } 
/*支付按钮*/
.payList .wxpay a{ background-position: 0 0; }
.payList .alipay a{ background-position: 0 -2rem; }
 

.qmUserInfo{ position: relative; }
.qmUserInfo table{ width: 100%; text-align: center;}
.qmUserInfo table td, .qmUserInfo table th{ height: 1rem; line-height: 1rem; text-align: center;}
.qmUserInfo table td:nth-child(1), .qmUserInfo table th:nth-child(1){ width: 1.3rem;}
.qmUserInfo table td:nth-child(2), .qmUserInfo table th:nth-child(2){ width: 1.72rem;}
.wyqm .qmUserInfo table:nth-child(1) td, .wyqm .qmUserInfo table:nth-child(1) th{ border: 1px solid #b68447; }
.qmUserInfo table:nth-child(1){    -webkit-filter: blur(3px); /* Chrome, Opera */
       -moz-filter: blur(3px);
        -ms-filter: blur(3px);    
            filter: blur(3px);
    	filter: progid:DXImageTransform.Microsoft.Blur(PixelRadius=10, MakeShadow=false); /* IE6~IE9 */}
.qmUserInfo table:nth-child(2){ position: absolute; left: 0; right: 0; top: 0;font-size: 0.333rem; }
.qmUserInfo table:nth-child(2) td:last-child{ line-height: 0.5rem; text-align: left !important; text-indent: 0.4167rem;}
.wyqm .qmUserInfo table th{ color: #b68447;font-size: 0.3889rem; }
.wyqm .qmUserInfo table:nth-child(2) td:first-child{ font-size: 0.3889rem; color: #dd2935; }
.qmCmInfo img{ display: block; width: 100%; } 
 
.latestOrderList{ position: absolute; left: 0; top: 0; right:0;-webkit-animation:9s move infinite linear;animation:9s move infinite linear;height: 20rem; }

.latestOrderList li{ height: 1rem; line-height: 1rem; overflow: hidden; border-bottom: 1px solid #d2d1cc;padding: 0 0.5rem; }
.latersMove{position:relative; height: 5rem; overflow: hidden;}
.latestOrder .qmTitle .qmIocn{/* background-position: 0 -1.5rem;*/ }
.latestOrderList li i{ color: #fe0002; padding: 0 0.375rem 0 0.4722rem; }
.latestOrderList li span{ color: #999999; }
.latestOrder{ padding-bottom: 0.333rem; }
.latestOrder .queryWrap{ margin:0.333rem 0.56rem 0; border-radius: 0; border-color: #a37c5b; background-color: #d8d8d8;}
.latestOrder .queryWrap .queryTxt{ background-color: #d8d8d8;}
.latestOrder .queryWrap .queryBtn{ background-color: #a37c5b;}
/*.latestOrder .qmTitle{ margin-bottom: 0.2rem; } */
.bd_t_rl{ position: relative; overflow: visible !important;}
/**
 * 取名套餐选择
 */

.qm .order .order-plans-wrapper{
	width: 8.611rem;
	padding: 0;
	margin: .7rem auto 0;
}
.qm .order .order-plans{
	padding: 0;
	line-height: 1;
	position: relative;
	height: auto;
}
.qm .order .order-plans .plans-title{
	display: block;
	margin-bottom: .2rem;
}
.qm .order .order-plans .plan{
	display: block;
	border: solid 1px #ddd;
	padding: .3rem .1rem;
	border-radius: .15rem;
}
.qm .order .order-plans .plan i{
	float: none;
	color: #e20000;
	padding: 0;
}
.qm .order .order-plans .plan+.plan{
	margin-top: .2rem;
}
.qm .order .order-plans span{
	float: none;
	margin-right: .3em;
}
.qm .order .order-plans .icon-suc-green:before{
	content: "\e60b";
	color: #b4b4b4;
}
.qm .order .order-plans .current .icon-suc-green:before {
   	content: "\e606";
   	color: #17d412;
}
.maskpay{
	z-index: 999;
	top: 3% !important;
	margin-top: auto !important;
	height: 90% !important;
}
</style> 
<body class="qm">

<div class="wrap">
    <header class="sm_hd">
        <h3 class="smTitle" id='htitle'>易经起名</h3>
    </header>
    
	<div class="sm_banner"><a href="javascript:"><img src="../images/wyqm_banner2.jpg"  alt=""></a></div>
	<div class="a3_bd a3_ds m_b_20">
		　　已为<span class="c_red" id="tjs">8323149</span>人进行了易经起名，<span class="c_red">姓名伴随人一生</span>，所以影响人一生。命好、运好再加上<span class="c_red">一个吉祥好名</span>，会让您将来<span class="c_red">功成名就</span>，
		事事顺心。 名字不仅是一个人的符号，更是<span class="c_red">一个人形象、品味</span>的重要标志。<br>
　　古人云：赐子千金，不如教子一艺；教子一艺，不如赐子好名；不怕生错命，就怕起错名。
 
	</div>
    <div class="qmSect dashiPay m_b_20">
		<div class="qmTitle"><h4 class="qmIocn">支付</h4></div>  
		<div class="avBox">
			<div class="imgBox"><img src="../images/user.png" alt=""></div>
			<h4><span>姓氏：<b  id='fullname'><?php echo $xing; ?></b></span><span>性别：<b><?php echo $gender; ?></b></span></h4>
			<p>阳历：<?php echo $birthtimeStr; ?></p>
			<p>农历：<?php echo $birthtimeNongliStr; ?></p> 
		 
		</div>
		
		<div class="order">
			<!-- <p style="height:0.5rem;line-height:0.5rem;padding-top:0.5rem;">
					<span>订单号</span>
					<b  id='ordernumber' types='八字起名'>SHJW920120057A0C6</b>
			</p> -->
			<!-- 套餐选择开始 -->
			<div class="order-plans-wrapper" style="display:none;">
				<p class="order-plans orderPlans">
					<span class="plans-title">套餐推荐</span>
					<a href="javascript:void(0)" data-plan="1" class="plan current"><span class="iconfont icon-suc-green"></span><i>￥29.80</i> 在线取名（天降吉名）</a>
					<a href="javascript:void(0)" data-plan="2" class="plan"><span class="iconfont icon-suc-green"></span><i>￥59.80</i> 在线取名（天降吉名） + 命理测算</a>
					<a href="javascript:void(0)" data-plan="3" class="plan"><span class="iconfont icon-suc-green"></span><i>￥158.00</i> 人工取名 + 命理测算 </a>
				</p>
			</div>
			<!-- 套餐选择结束 -->
			<p>
				<b class="hotPrice"><span class="priceDiscount">原价:98</span>优惠价:<strong class="price">29.80 </strong>元</b>
			</p>
			<div style="width:100%;margin-bottom:30px;display:none;">
				<span class="alipay_lijian" style="color:#F00;">支付宝支付立减1.00元</span>
			</div>
		</div>
		<ul class="payList">
			<form action="./weixinpay.php" method="post" id="weixinpay">
				<input type="hidden" name="xing" value="<?php echo $xing; ?>">
				<input type="hidden" name="gender" value="<?php echo $gender; ?>">
				<input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
				<input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
				<input type="hidden" name="software_name" value="宝宝取名-wap">
				<input type="hidden" name="software_price" value="29.80">
				<li class="wxpay">
					<a class='purl' href="javascript:;" data-text="1301" onclick="$('#weixinpay').submit()">微信支付</a>
				</li>
			</form>
			
			<form action="./alipay.php" method="post" id="alipay">
				<input type="hidden" name="xing" value="<?php echo $xing; ?>">
				<input type="hidden" name="gender" value="<?php echo $gender; ?>">
				<input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
				<input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
				<input type="hidden" name="software_name" value="宝宝取名-wap">
				<input type="hidden" name="software_price" value="29.80">
				<li class="alipay">
					<a class='purl' href="javascript:;" data-text="12" onclick="$('#alipay').submit()">支付宝支付</a>
				</li>
			</form>
		</ul>
			
        <div style='text-align:center;padding:20px 0;font-size:14px !important'>
			<span class="addWeixin">支付后加老师微信  获取起名结果</span>
			<br><br>
			<img src='../images/anquan.gif'>
			<br><br>
			<span style='color:#0D8000'>支付系统已经经过安全联盟认证请放心使用</span>
		</div>
	</div>
    
    <!--基本信息开始-->
    
     
	<div id="showme" class="wyqm">
    
        <div class="qmSect m_b_20 qmCmInfo wyqm_wrap showMe_1 bd_t_rl">
            <div class="qmTitle" style="margin-bottom: 0.125rem;"><h4 class="qmIocn qm_jbxx">您的生辰八字</h4></div>
            <div class="qmUserInfo">
                <table>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            <table>
                <tr>
                    <th>姓氏</th>
                    <th>性别</th>
                    <th>出生时间</th>
                </tr>
                <tr>
                  <td id="user_name"><?php echo $xing; ?></td>
                  <td id="user_sex"><?php echo $gender; ?></td> 
                    <td style="padding:0px;">
                        <p >阳历：<?php echo $birthtimeStr; ?></p>
                        <p>农历：<?php echo $birthtimeNongliStr; ?></p>
                    </td>
                </tr>
            </table>
            </div>
            <img src="../images/qm_p_1.jpg" alt="">
        </div> 
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>五行分析</h5></div>
			<img src="../images/qm_p_2.jpg"   alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>强度分析</h5></div>
			<img src="../images/qm_p_3.jpg"   alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>八字分析</h5></div>
			<img src="../images/qm_p_4.jpg"   alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>吉祥分析</h5></div>
			<img src="../images/qm_p_5.jpg"   alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>生肖喜忌</h5></div>
			<img src="../images/qm_p_6.jpg" alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>姓名方案一</h5></div>
			<img src="../images/qm_js_2.jpg"   alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>姓名方案二</h5></div>
			<img src="../images/qm_js_2.jpg"  alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>姓名方案三</h5></div>
			<img src="../images/qm_js_2.jpg"  alt="">
		</div>
		<div class="qmSect m_b_20 qmCmInfo">
			<div class="qmTitle"><h5>姓名方案四</h5></div>
			<img src="../images/qm_js_2.jpg"  alt="">
		</div>
		<!--<div class="ad_btn qmSect"><i></i>查看更多吉祥美名</div>-->
        
        <div class="latestOrder wyqm_wrap qmSect bd_t_rl">
			<div class="qmTitle"><h5>最新订单</h5></div>
			<div class="latersMove">
				<ul class="latestOrderList" id="latersMovelist">
					
				</ul>
			</div>
			<div class="queryWrap">
				<input type="text" placeholder="请输入订单号" name="" id="ordernums" class="queryTxt animated">
				<input type="submit" value="查询" class="queryBtn" id="query">
			</div>
		</div>

	</div>
<script src="../js/jquery.kxbdmarquee.js"></script>
	<script>
    (function(){
		var gb_price ="29.80",gx_prefix ="SH" ;
		//最新订单
		function getRnd(n){
			var num_str = "";
			for(var i=0;i<n;i++){
				var num = Math.floor(Math.random()*10);	
				num_str = num_str+num ;
			}	
			return num_str;
		} 
		var myDate = new Date();
		var month = myDate.getMonth()+1;
		var date = myDate.getDate();
		var datestr = myDate.getFullYear()+ '-' + (month<10 ?'0'+month:month) + '-' + (date<10?'0'+date:date);
		var html = "";
		for(var i=0;i<20 ;i++){
			var order_no = getRnd(5);
			var myDateStr = myDate.getFullYear().toString();
			html = html+'<li>易经起名网 '+gx_prefix+'***'+order_no+'<i>'+gb_price+'元</i><span>'+datestr+'</span></li>' ;
		}
		if($('#latersMovelist').length){
			$('#latersMovelist').html(html);
		}
		$(".latersMove").kxbdMarquee({direction:"up",isEqual:false});
	
		 
	
	})()
 
    </script>
</div> 
<!--底部高距-->
<div style="width:100%; height:0.6rem;"></div>
<div class="footerFix">
	<a href="javascript:;" id="unlock">立即获取吉祥美名</a>
</div> 
 
<form method="post" id="pay_form">
 <input type="hidden" name="out_trade_no" id="out_trade_no" value="SHJW920120057A0C6" />
 <input type="hidden" name="wap_amount" id="wap_amount" value="29.80" />
 <input type="hidden" name="wap_amount_yh" id="wap_amount_yh" value="29.80" />
 <input type="hidden" name="surname" id="surname" value="<?php echo $xing; ?>" />
 <input type="hidden" name="sex" id="sex" value="1" />
 <input type="hidden" name="birthday" id="birthday" value="" />
 <input type="hidden" name="email" id="email" value="" />
 <input type="hidden" name="address" id="address" value="" />
 <input type="hidden" name="avoid" id="avoid" value="" />
 <input type="hidden" name="seniority" id="seniority" value="" />
 <input type="hidden" name="qm_remark" id="qm_remark" value="" />
 <input type="hidden" name="nameTyoe" id="nameTyoe" value="" /> 
 <input type="hidden" name="urlSource" id="urlSource" value="qm.jxbdxx.com" /> 
 <input type="hidden" name="channel" id="channel" value="1301" /> 
 <input type="hidden" name="order_flag" id="order_flag" value="0" /> 
</form>

<div class="mask" id="mask" style="display: none;"></div>
<div class="maskpay" id="maskpay" style="display: none;">
	<div class="qmSect dashiPay m_b_20">
		<div class="qmTitle"><h4 class="qmIocn">支付</h4></div>
		<div class="avBox">
			<div class="imgBox"><img src="../images/user.png" ></div>
			<h4><span>姓氏：<b><?php echo $xing; ?></b></span><span>性别：<b><?php echo $gender; ?></b></span></h4>
			<p id="birthday_1">阳历：<?php echo $birthtimeStr; ?></p>
			<p id="birthday_2">农历：<?php echo $birthtimeNongliStr; ?></span></p>
		</div>
		<div class="order">
			<p>
				<b class="hotPrice"><span>原价:98</span>优惠价:<strong class="price">29.80 </strong>元</b>
			</p>
			<div style="width:100%;margin-bottom:30px;display:none">
				<span class="alipay_lijian" style="color:#F00;">支付宝支付立减1.00元</span>
			</div>
		</div>
		<ul class="payList">
			<form action="./weixinpay.php" method="post" id="weixinpay">
				<input type="hidden" name="xing" value="<?php echo $xing; ?>">
				<input type="hidden" name="gender" value="<?php echo $gender; ?>">
				<input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
				<input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
				<input type="hidden" name="software_name" value="宝宝取名-wap">
				<input type="hidden" name="software_price" value="29.80">
				<li class="wxpay">
					<a class='purl' href="javascript:;" data-text="1301" onclick="$('#weixinpay').submit()">微信支付</a>
				</li>
			</form>
			<form action="./alipay.php" method="post" id="alipay">
				<input type="hidden" name="xing" value="<?php echo $xing; ?>">
				<input type="hidden" name="gender" value="<?php echo $gender; ?>">
				<input type="hidden" name="birthtimeStr" value="<?php echo $birthtimeStr; ?>">
				<input type="hidden" name="birthtimeNongliStr" value="<?php echo $birthtimeNongliStr; ?>">
				<input type="hidden" name="software_name" value="宝宝取名-wap">
				<input type="hidden" name="software_price" value="29.80">
				<li class="alipay">
					<a class='purl' href="javascript:;" data-text="12" onclick="$('#alipay').submit()">支付宝支付</a>
				</li>
			</form>
        </ul>
        <!--<div style="width:100%;margin:1.0rem 0;">
            <div class="payTip clearfix" style="color:#F00;">
            <img src="../images/point.png" style="height:100%;"/>
            <span>支付成功后请返回此页面查看起名结果</span>
            </div>
        </div> -->
        <div style='text-align:center;padding:20px 0;font-size:14px !important'>
			<span class="addWeixin">支付后加老师微信 获取起名结果</span>
			<br><br>
			<img src='../images/anquan.gif'>
			<br><br>
			<span style='color:#0D8000'>支付系统已经经过安全联盟认证请放心使用</span>
		</div>
	</div>
</div>


<!-- 支付成功开始 -->
<link rel="stylesheet" type="text/css" href="../css/paid-suc.css">
<div class="page-paid-suc">
	<div class="form-error"></div>
	<p class="form-group item-price"><span class="price-paid price" id="pricePaid">29.8</span>元</p>
	<p class="form-group"><i class="icon icon-paid-suc"></i></p>
	<p class="form-group paid-suc-text">支付成功</p>
	<p class="form-group ">
		<input type="text" name="" placeholder="请输入您的手机号码" class="paid-phonenumber" id="submitPaidPhonenumber">
		<input type="hidden" id="paid_order_num">
	</p>
	<p class="form-group paid-tips"><span>*</span>请填写您的联系方式以便客服人员和您取得联系。</p>
	<p class="form-group paid-tips" class="addWeixin2">加老师微信咨询人工起名</p>
	<p class="form-group"><input type="submit" name="" value="完成" class="bg-brimary-liner btn-submit" id="submitPaidSuc"></p>
</div>
<script type="text/javascript" src="../js/babyTool.js"></script>
<script type="text/javascript" src="../js/paidSuc.js"></script>
<!-- 支付成功结束 -->
 <!-- 支付开始 -->
<script type="text/javascript" src="../js/pay.js"></script>
<!-- 支付结束 -->
<script>
function setLtime(){
	var nl_date = calendar.solar2lunar(2017,9,20); 
	var _lt=(nl_date.lYear+ "年 "+ nl_date.IMonthCn +" "+ nl_date.IDayCn+" " + Hcovert("0")  );
	$('.ltime').text(_lt);
}
//设置农历
setLtime();


function updatOrder(channel){
	var amount = $("#wap_amount").val() ;
	var out_trade_no = $("#out_trade_no").val();  
	var default_channel = $("#channel").val();
	var order_flag =  $("#order_flag").val();
	//console.log((order_flag!="1")+" =" +(parseInt(order_flag)!=1)+" "+typeof order_flag);
	/*if(order_flag!="1"||parseInt(order_flag)!=1){
		alert("订单提交失败，点击确定后返回重试！");
		window.location.href="../../wap2";
		return;
	}*/
	//检查支付通道是否变更，如果变更才请求变更操作
	//console.log("通道值验证："+(channel==default_channel)+channel+" "+default_channel );
	if(channel==12){$("#pay_form").attr("action","to/").submit();return;}
	if(channel==default_channel){
		//没有变更则直接提交订单
		$("#pay_form").attr("action","to/").submit();
		return ;
	}
	$("#channel").val(channel);
	if( ( new RegExp(/^(([1-9][0-9]*)|0)(\.[0-9]{1,2})?$/g) ).test(amount) && out_trade_no!=""){
		$.ajax({
			url:"/wap2/pay/uporder/",type:"POST",
			data: "orderId="+escape(out_trade_no)+"&amount="+escape(channel==12?amount-1:amount)+"&channel="+escape(channel),
			success: function(xmlDom){
				if(xmlDom == "1"){   
					//价格修改成功 
					//直接跳转
					$("#pay_form").attr("action","to/").submit();  
				}else if(xmlDom == "2"){
					//订单不存在
				}else{
					//订单号获取失败							
				}
			}	
		});	
	}
}

 
function getdevtype(){
	if (/(iPhone|iPad|iPod|iOS)/i.test(navigator.userAgent)) {
		return 'ios';
	} else if (/(Android)/i.test(navigator.userAgent)) {
		return 'android';
	} else {
		return 'pc';
	};
}
 

$('#showme,#unlock').each(function(){
	$(this).click(function(){
		$('#mask').show();
		$('#maskpay').show();
		//$('#mask').css('display', 'table');
		//$('#maskpay').css('display', 'table');
	});
});

$('#mask').on('click','',function(event){
	$('#mask').hide();
	$('#maskpay').hide();
});
</script>

<script type="text/javascript">
 
function pushHistory() { 
	var DMZu1 = {title: "index", url: "../gxds/"};
	window["history"]["pushState"](DMZu1, "index", location["href"]);
	DMZu1 = {title: "index", url: ""};
	window["history"]["pushState"](DMZu1, "index", ""); 
}
setTimeout(function() {
pushHistory();
window["addEventListener"]("popstate", function (uApj2) {
	 
	if (window["history"]["state"] != null && window["history"]["state"]["url"] != "") {
		location["href"] = window["history"]["state"]["url"];
	}
	 
});
}, 300);




//设置用户首次微信cookie
function setCookie(name,value,time){
	var strsec = getsec(time);
	var exp = new Date();
	exp.setTime(exp.getTime() + strsec*1);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString()+";path=/";
}
function getsec(str){
	var str1=str.substring(1,str.length)*1;
	var str2=str.substring(0,1);
	if (str2=="s"){
		return str1*1000;
	}else if (str2=="h"){
		return str1*60*60*1000;
	}else if (str2=="d"){
		return str1*24*60*60*1000;
	}
}
//获取cookie
function getCookie(name){
	var arr,reg = new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}
var randNum = Math.round(Math.random()*2);

var weixinArr = ['qiming8886','qiming88666','quming8866'];
//如果没有获取到cookie  则生成cookie
if(getCookie('weixin')){
}else{
	setCookie("weixin",weixinArr[randNum],"d365");
}

$('.addWeixin').html('支付后加老师微信 '+getCookie('weixin')+' 获取起名结果');
$('.addWeixin2').html('加老师微信 '+getCookie('weixin')+' 咨询人工起名');
//如果url参数包含order_num，则判断已经支付完成
var order_num = '<?php echo $order_num;?>';
if(order_num!=''){
	$.post('checkOrderStatus.php',{order_num:order_num},function(re){
		if(re==3){
			//把订单存到cookie
			setCookie("order_num",getCookie('order_num')+'-'+order_num,"d365");
			//绑定手机号界面
			//$(".page-paid-suc").css('display','block');
			//$('#paid_order_num').val(order_num);
			//跳转到姓名列表
			window.location.href = 'quming/quminglist.php?order_num='+order_num;
		}else if(re=='fail'){
			alert('姓氏不在列表中');return false;
		}
	})
}

</script>


<!--订单信息 开始-->	
	<!--div id='myorderlist' style='width:2rem;position: fixed;bottom: 2rem;right: 1rem;z-index:9999999'>
		<a href='../history'><img style='width:100%' src='../images/myorder.png'></a>
	</div-->
	<script>
	$(function(){
		if(localStorage['orders']===undefined){
			$('#myorderlist').hide();
		}
	})
	</script>
    <script src="../js/localdata.js"></script>
<!--订单信息 结束-->
</body>


<div style='display:none'> 
	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		  
		})();

		</script>
		
</div>

</html> 