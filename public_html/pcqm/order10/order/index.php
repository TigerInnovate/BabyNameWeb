<?php
function getHost() {
    $possibleHostSources = array('HTTP_X_FORWARDED_HOST', 'HTTP_HOST', 'SERVER_NAME', 'SERVER_ADDR');
    $sourceTransformations = array(
        "HTTP_X_FORWARDED_HOST" => function($value) {
            $elements = explode(',', $value);
            return trim(end($elements));
        }
    );
    $host = '';
    foreach ($possibleHostSources as $source)
    {
        if (!empty($host)) break;
        if (empty($_SERVER[$source])) continue;
        $host = $_SERVER[$source];
        if (array_key_exists($source, $sourceTransformations))
        {
            $host = $sourceTransformations[$source]($host);
        } 
    }

    // Remove port number from host
    $host = preg_replace('/:\d+$/', '', $host);

    return trim($host);
}
$companyname = "";
switch(getHost() ){
	case "quming.zirebao.cn":
		$companyname = "重庆道乐堂网络信息服务中心";
		break;
	case "qiming.kijijidns.com":
		$companyname = "百姓网股份有限公司 版权所有 沪ICP备06019413号";
		break;
}


include 'nongli.php';

$xing = "";
$birthday = "";
$gender = "";
$birthtime = "";
$birthmin = "";

if(isset($_GET["xing"])) $xing = $_GET["xing"];
if(isset($_GET["birthday"])) $birthday = $_GET["birthday"];
if(isset($_GET["gender"])) 	$gender = (int)$_GET["gender"] == 0 ? "女" : "男";
if(isset($_GET["birthtime"])) $birthtime = $_GET["birthtime"];
if(isset($_GET["birthmin"])) $birthmin = $_GET["birthmin"];

$birthtime_ = strtotime($birthday . " " . $birthtime . ":" . $birthmin);
$birthtimeStr = date("Y年m月d日 H点m分", $birthtime_);
$shichenArray = ["子时","丑时","寅时","卯时","辰时","己时","午时","未时","申时","酉时","戊时","亥时"];
$hour = (int)$birthtime;
$hour = (int) ((($hour + 1) % 24 ) / 2);
$shichen =  $shichenArray[$hour];
$nongli = nongli($birthday);
$birthtimeNongliStr = $nongli . " " . $shichen;


if(mb_strlen($birthtimeNongliStr) == 14){
	$nongli1 =  mb_substr($birthtimeNongliStr, 0, 6);
	$nongli2 =  mb_substr($birthtimeNongliStr, 7, 2) ; 
	$nongli3 =  mb_substr($birthtimeNongliStr, 9, 2) ;
	$nongli4 =  mb_substr($birthtimeNongliStr, 12, 2) ;
} else {
	$nongli1 =  mb_substr($birthtimeNongliStr, 0, 6) ;
	$nongli2 =  mb_substr($birthtimeNongliStr, 7, 3) ; 
	$nongli3 =  mb_substr($birthtimeNongliStr, 10, 2) ;
	$nongli4 =  mb_substr($birthtimeNongliStr, 13, 2) ;
}


?>
 
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="/pcqm/pstyle/paystyle10/css/style.css?ver=2"/>
		<script src="/pcqm/pstyle/paystyle10/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<title><?php echo $xing; ?>姓起名方案-起名网</title>		
	</head>
	<body>
		<div class="header">
			<div class="container">
			<?php
				switch(getHost()){
					case "qiming.kijijidns.com":
						echo '<a href="http://www.baixing.com/" target="_blank" ><img src="/pcqm/pstyle/paystyle10/images/logo_baixing.png"/></a>';
						break;
					default:
						echo '<img src="/pcqm/pstyle/paystyle10/images/logo.png"/>';

				}
			?>
				<img src="/pcqm/pstyle/paystyle10/images/m.png" class="m"/>
			</div>
		</div>
		<div class="nav">
			<div class="container">
				<a href="/pcqm" class="active">首页</a>
				<a href="/pcqm#main">马上起名</a>
				<a href="/pcqm#img">起名优势</a>
				<a href="/pcqm#explain">客户评价</a>
				<a href="/pcqm#cjwn">常见问答</a>
				<a href="/order/pchistory">历史订单</a>
			</div>
		</div><style>
	.scheme_l2{ padding: 21px 0 0 22px; }
	.scheme_l2 span{ display: block; width: 101px; height: 40px; line-height: 40px; text-align: center; background: #f08128; font-size: 18px; font-weight:bold; color: #fff; border-radius: 3px; }
	.bins{padding: 19px 0 20px 32px; background: #f8f4e7; border-bottom: 1px solid #cca177;}
	.bins_line{ height: 32px; line-height: 32px; overflow: hidden; font-size: 14px; color: #333333; }
	.line_1{ font-weight: bold; margin-right: 6px;}
	.line_2{ width: 456px; padding-top: 10px; margin-right: 10px;}
	.line_2 span{ display: block; position: relative; width: 100%; height: 12px; background: #d8d1ba; }
	.line_2 span i{ display: block; height: 100%; background: #976a3c; }
	.g_line{ background:#f08128 !important; }
	.line_3{ color: #ff0000; width: 48px; }
	.bins_img img{ display: block; width: 100%; }
	.bins_img{ position: relative; padding: 22px 18px 23px 24px; background: #f8f4e7; }
	.bins_btn{ display: block; width: 382px; height: 78px; background-image: url(/pcqm/pstyle/paystyle10/images/btn.png); background-repeat: no-repeat; background-position: 0 0; position: absolute; left: 50%; top: 50%; margin-left: -191px; margin-top: -39px;}
	.bins_btn:hover{ display: block; width: 382px; height: 78px; background-image: url(/pcqm/pstyle/paystyle10/images/btn.png); background-repeat: no-repeat; background-position: 0 bottom; position: absolute; left: 50%; top: 50%; margin-left: -191px; margin-top: -39px;}
	.sPay{ width: 100%; border:1px solid #966a3b; padding-bottom: 90px; background:#fff;}
	.sPayTitle{ width: 100%;padding:10px 0; text-align: center; color: #fff; font-size: 20px; background:#cc0001; }
	.spayInfo{ text-align: center; border-bottom: 1px solid #ebebed; line-height: 38px; padding: 20px 0 20px; font-size: 18px;}
	.spayInfo strong{ font-weight: normal; color: #be0000; }
	.spayUser i{color: #bebebe; padding: 0 5px}
	.oldPrice{ text-decoration: line-through; }
	.newPrice strong{ font-size: 26px; margin-right: 5px;}
	.spayPrice span{padding: 0 15px;}
	.spayBtn li{ border:none 0; margin: 0; }
	.spayBtn li:hover{ padding: 0; margin:0;}
	.page_pay{ border:none !important; }
	.spayerC{ display: none; }
	.spayBtn{width: 462px; margin: 20px auto 20px; overflow: hidden;}
	.spayBtn li{ width: 210px; height: 48px; border:1px solid #e7e7e7; text-indent: -9999em; position: relative; background-image: url(/pcqm/pstyle/paystyle10/images/spayBtn.jpg); background-repeat: no-repeat; cursor: pointer;}
	.spayBtn li i{ width: 0; height: 0; position: absolute; right: 2px; bottom: 2px; border:5px solid #16d17a; border-left-color: transparent; border-top-color: transparent; display: none;}
	.spayBtn .active, .spayBtn li:hover{ border:1px solid #16d17a !important; }
	.spayBtn .active i{ display: block; }
	.spayBtn .fl{ background-position: center 0;  }
	.spayBtn .fr{ background-position: center -48px;  }
	.spayerC{ width: 478px; margin:0 auto; }
	.spayEr{ width: 206px; }
	.spayEr .imgBox{position: relative;}
	.spayEr .imgBox img{ display: block; width: 100%; height: 100%; }
	.spayEr .imgBox{ display: block; height: 201px; border:2px solid #efefef;}
	.spayImg img{ display: block; }
	.sPay .pTips{ padding-left: 69px; background-image: url(/pcqm/pstyle/paystyle10/images/zf1.png); background-repeat: no-repeat; background-position: left center; margin-top: 26px; font-size: 16px; color: #136ab1; line-height: 28px; height: 56px;}

</style>

<script>
	function removeQcode(){
		 setTimeout(function(){$('.qcode').remove();},4000)
	}
</script>


<div class="main" id="boxa">
				<div class="container">
				<table border="0" cellspacing="0" cellpadding="0" class="table">
						<tr>
							<td colspan="5" class="title"></td>
						</tr>
						<tr>
							<td class="tinct">起名姓氏</td>
							<td colspan="2"><?php echo $xing; ?></td>
							<td class="tinct">性别</td>
							<td><?php echo $gender; ?></td>
						</tr>
						<tr>
							<td class="tinct">出生日期</td>
							<td colspan="4"><?php echo $birthtimeStr; ?></td>
						</tr>
						<tr>
							<td class="tinct">出生公历</td>

							<td><?php echo mb_substr($birthtimeStr, 0, 5); ?></td>
							<td><?php echo mb_substr($birthtimeStr, 5, 3); ?></td>
							<td><?php echo mb_substr($birthtimeStr, 8, 3); ?></td>
							<td><?php echo mb_substr($birthtimeStr, 12, 3); ?></td>
						</tr>
						<tr>
							<td class="tinct">出生农历</td>
							<td ><?php echo $nongli1; ?></td>
							<td ><?php echo $nongli2; ?></td>
							<td ><?php echo $nongli3; ?></td>
							<td ><?php echo $nongli4; ?></td>
						</tr>
					</table>
					<br>
					<ul id="btns">
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案一</p>
								</div>
								<div class="scheme_l2 fl">
									<span>财运极佳</span>
								</div>
								<div class="scheme_c fl">
									<p>文化占比54%  八字占比35% <br>生肖五格卦象各占比11%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>100</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 96%;" class="g_line"></i></span></p>
									<p class="fl line_3">96分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img1.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案二</p>
								</div>
								<div class="scheme_l2 fl">
									<span>三才极佳</span>
								</div>
								<div class="scheme_c fl">
									<p>文化占比51%  八字占比36% <br>生肖五格卦象各占比13%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>98</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 89%;"></i></span></p>
									<p class="fl line_3">89分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 95%;" class="g_line"></i></span></p>
									<p class="fl line_3">95分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img2.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案三</p>
								</div>
								<div class="scheme_c fl">
									<p>文化占比53%  八字占比33% <br>生肖五格卦象各占比14%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>95</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 85%;"></i></span></p>
									<p class="fl line_3">85分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;" class="g_line"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 89%;"></i></span></p>
									<p class="fl line_3">89分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img3.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案四</p>
								</div>
								<div class="scheme_c fl">
									<p>文化占比50%  八字占比30% <br>生肖五格卦象各占比20%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>95</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 93%;" class="g_line"></i></span></p>
									<p class="fl line_3">93分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 81%;"></i></span></p>
									<p class="fl line_3">81分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img4.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案五</p>
								</div>
								<div class="scheme_c fl">
									<p>文化占比50%  八字占比30% <br>生肖五格卦象各占比20%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>95</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 95%;" class="g_line"></i></span></p>
									<p class="fl line_3">95分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 91%;"></i></span></p>
									<p class="fl line_3">91分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img5.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>

						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案六</p>
								</div>
								<div class="scheme_l2 fl">
									<span>三才极佳</span>
								</div>
								<div class="scheme_c fl">
									<p>文化占比51%  八字占比36% <br>生肖五格卦象各占比13%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>98</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 89%;"></i></span></p>
									<p class="fl line_3">89分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 95%;" class="g_line"></i></span></p>
									<p class="fl line_3">95分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img2.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案七</p>
								</div>
								<div class="scheme_c fl">
									<p>文化占比53%  八字占比33% <br>生肖五格卦象各占比14%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>95</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 85%;"></i></span></p>
									<p class="fl line_3">85分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;" class="g_line"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 89%;"></i></span></p>
									<p class="fl line_3">89分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img3.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
						<li>
							<div class="scheme_title clearfix">
								<div class="scheme_l fl">
									<p><?php echo $xing; ?>姓<span>|</span>取名方案八</p>
								</div>
								<div class="scheme_c fl">
									<p>文化占比50%  八字占比30% <br>生肖五格卦象各占比20%</p>
								</div>
								<div class="scheme_r fr">
									<p>评分：<span>95</span></p>
								</div>
							</div>
							<div class="bins">
								<div class="bins_line">
									<span class="fl line_1">名字吉祥度：</span>
									<p class="fl line_2"><span><i style="width: 93%;" class="g_line"></i></span></p>
									<p class="fl line_3">93分</p>
									<p class="fl line_4">基于名字与生辰八字五行吉祥度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">内涵流行度：</span>
									<p class="fl line_2"><span><i style="width: 90%;"></i></span></p>
									<p class="fl line_3">90分</p>
									<p class="fl line_4">基于好听，好写，内涵，流行度打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">生肖开运度：</span>
									<p class="fl line_2"><span><i style="width: 87%;"></i></span></p>
									<p class="fl line_3">87分</p>
									<p class="fl line_4">基于名字与生肖宜忌开运助运打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">三才五格分：</span>
									<p class="fl line_2"><span><i style="width: 92%;"></i></span></p>
									<p class="fl line_3">92分</p>
									<p class="fl line_4">基于名字三才五格和理吉凶打分</p>
								</div>
								<div class="bins_line">
									<span class="fl line_1">财运卦象分：</span>
									<p class="fl line_2"><span><i style="width: 81%;"></i></span></p>
									<p class="fl line_3">81分</p>
									<p class="fl line_4">基于名字财运事业卦象易数打分</p>
								</div>
							</div>
							<div class="bins_img"><img src="/pcqm/pstyle/paystyle10/images/img4.jpg" alt=""><a href="javascript:;" class="bins_btn"></a></div>
						</li>
					</ul>


					<div class="sPay" id="sPay">
						<div class="sPayTitle">付款后查看全部取名方案</div>
						<div class="spayInfo">
							<p class="spayPrice">
								<span class="oldPrice">原价：88元</span>
								<span class="newPrice">优惠价：<strong>29.8</strong>元</span>
							</p>
							<p class="spayOrder">支付单号：<strong><span id='ordernumber' types='八字起名'>CS170919221318189</span></strong></p>
							<p class="spayUser">
								<span >姓氏：<font id='fullname'><?php echo $xing; ?></font></span>
								<i>/</i>
								<span>性别：<?php echo $gender; ?></span>
								<i>/</i>
								<span>生辰：
								公历:<?php echo $birthtimeStr; ?></span>
								农历:<?php echo $birthtimeNongliStr ; ?>
							</p>
						</div>
						<ul class="spayBtn">
							<li paytype="wx" class="fl active"><i></i>微信支付</li>
							<li paytype="zfb" class="fr"><i></i>支付宝</li>
						</ul>
						
						<div class="spayerC clearfix" data-pay="wx" style="display: block;">
							<div class="fl spayEr">
								<div class="imgBox">
						        	<div style='width:201px;height:201px;' id='wx'  url="">
										
											
										
									</div>
								</div>
								<div class="pTips">请用<span class="typeName">微信</span>扫一扫<br>扫描二维码支付</div>
							</div>
							<div class="fr spayImg"><img src="/pcqm/pstyle/paystyle10/images/wx1.png" alt=""></div>
						</div>
						
						
						<div class="spayerC clearfix" data-pay ="zfb">
							<div class="fl spayEr">
								<div class="imgBox">
						        	<div style='width:201px;height:201px;' id='ali'  url="">
									</div>
								</div>
								<div class="pTips">请用<span class="typeName">支付宝</span>扫一扫<br>扫描二维码支付</div>
							</div>
							<div class="fr spayImg"><img src="/pcqm/pstyle/paystyle10/images/zfb1.jpg" alt=""></div>
						</div>

						<div style='text-align:center;margin-top:20px;'>
							支付完成后，加老师微信获取起名结果<br><br>
								<div style='cursor:pointer; padding:10px 20px;border-radius:5px;width:250px;margin:0 auto;background:#CB0000;color:#fff;font-size:18px' id="addWeixin">老师微信：</div>
								<div class="imgBox">
						        	<div style="padding:10px 20px;margin:0 auto;width:201px;height:201px;"><canvas width="128" height="128" style="display: none;"></canvas><img style="display: block;" src="/pcqm/pstyle/paystyle10/images/wx.png"></div>
								</div>
						</div>

						<div class="bor_b" id='payend' style='display:none;background:#fff;'>
							<div style='width:600px;margin:0 auto'>
									<div class='payresult' style='cursor:pointer;width:250px;padding:15px;background:#4AA21B;color:#fff;text-align:center;float:left'>我已支付成功</div>
									<div class='payresult' style='cursor:pointer;width:250px;padding:15px;background:#B1B1B1;color:#fff;text-align:center;float:right'>支付失败</div>

							</div>
						</div>
					</div>
					


					<style>
						.xpay h4{font-weight:normal;color:#8D0100;margin:0px 0 0px 0;}
						.xpay h5{font-weight:normal;color:#333;margin:15px 0 30px 0;}
					</style>
					<div class="sPay xpay" style='margin-top:10px;padding-bottom:0'>
						<img src="/pcqm/pstyle/paystyle12/bg/pj.png" alt="" style='width:100%'>
						<div style='height:415px;overflow:hidden;position: relative;padding:0 20px'>
							<div id='scro' style='position:absolute'>
									<h4>订单号：CS170***90294</h4>
									<h5>八字起名网的名字大气时尚，寓意很好，非常喜欢小名叫起来朗朗上口，现在小孩还太小，
									但是一家人都是拿着小名在逗他，好像宝宝已经会听懂话似的，这种感觉真的非常好；客服也非常敬业，非常有耐心，非常非常感谢你们！</h5>
									<h4>订单号：CS170***28295</h4>
									<h5>必须好评，服务很到位，开始我自己搞错日期了，回复邮件以后帮我改过来了！谢谢，值得信赖。 </h5>
									<h4>订单号：CS170***20975</h4>
									<h5>我亲算起名，名字确实好听，也有很有寓意，老师非常专业！写这么多不只是想夸夸这家网站，
									只是给有起名苦恼的人一些参考，自己起名确实费劲脑汁也不一定悟得好名字，还是专业的人做专业的事，五星好评！  </h5>
									<h4>订单号：CS170***88523 </h4>
									<h5>有八字分析，五行喜忌一目了然，很专业的感觉！</h5>
									<h4>订单号：CS170***22335</h4>
									<h5>这是我第二次来这里取名了，儿子的名字是美名网起的，这次女儿因为名字不太好，所以购买了人工起名，目前已经选好要用的名字了，
									非常感谢老师不厌其烦的解答，老师人真的非常好，很有耐心。</h5>
									<h4>订单号：CS170***22145</h4>
									<h5>非常感谢老师能够不厌其烦的解答我的提问,最后我选了一个我非常满意的名字,非常感谢老师,希望儿子以后能够快快乐乐的成长。</h5>
									<h4>订单号：CS170***20975</h4>
									<h5>名字很多，希望网站不断改进。</h5>
									<h4>订单号：CS170***25473</h4>
									<h5>出结果很快，从众多名字中选了两个，一个当大名，一个做网名，哈哈哈哈。</h5>
									<h4>订单号：CS170***28469</h4>
									<h5>名字评分都很高，原来好名字是那么多的，先前还想半天。</h5>
									<h4>订单号：CS170***22833</h4>
									<h5>高分名字太多，选得头晕脑胀，希望客服多指导一点，不过客服有点忙。</h5>
							</div>
						</div>
					</div>
					<script>
						$(function(){
							scrolls()
						})
						function scrolls(){
							$("#scro").animate({top:'0px'},0);
							$("#scro").animate({top:'-585px'},25000,'linear',function(){
								setTimeout(function() {
									scrolls();
								}, 0);
							});
						}
					
					</script>

















<br>

					
				</div>
</div>
			
 


<script src="/pcqm/pstyle/paystyle6/js/ntog.js"></script>
<script src="/pcqm/pstyle/product/localdata.js"></script>
 
 
<script src="/pcqm/public/js/jquery.min.js"></script>
<script src="/pcqm/public/js/qrcode.min.js"></script>



<script type="text/javascript">
	$('.spayBtn li').each(function(){
    	$(this).click(function(){
    		$(this).addClass('active').siblings().removeClass('active');
            payType = $(this).attr('paytype');
            $('.spayerC').hide();
            $('.spayerC[data-pay|="'+payType+'"]').show();
            if(payType=='zfb'){
            	getQRCode('ali');
            }else if(payType=='wx'){
            	getQRCode('wx');
            }
    	});
    });
	if($('#sPay').length){	
    	$('.bins_btn,#btns li').click(function(){
            $('html, body').animate({  
                scrollTop:  $('#sPay').offset().top
            }, 1000);  
    	});
    }

	 


	function showqrcode( ){
		var wx=$('#wx').attr('url')+"&device="+getdevtype()+"&time="+(getrnd());
		
		$('#wx').find('iframe').attr('src',wx); 
		 showqrcode2();
		
	}
	function showqrcode2(){
		var ali=$('#ali').attr('url')+"&device="+getdevtype()+"&time="+(getrnd());

		$('#ali').find('iframe').attr('src',ali);
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
	function getrnd(){
		return (+new Date())+Math.random();
	}
	
 
	function setLtime(){
		var _s = calendar.solar2lunar(2017,09,19);
		$('.l1').html(_s.gzYear+'年');
		$('.l2').html(_s.IMonthCn);
		$('.l3').html(_s.IDayCn);
		$('.l4').html(Hcovert("22"));
	}
	$(function(){

		setLtime();
		 
		//showqrcode();
		/*setTimeout(function() {
			checkorder();
			//$('#payend').show();
		}, 10000);*/
		 

		$('.payresult').click(function(){
			location.reload();
		})
		$(".pays").click(function(){
			$("html,body").animate({scrollTop: $("#pays").offset().top}, 500);
		})

		$('#showdetail').click(function(){
			location.href='./read?ordernum=CS170919221318189';
		})
		
	})
	 
	function checkorder(){
		
		$.get('check_order_state/CS170919221318189',function(d){
			if(d.code==200){
				setTimeout(function() {
					location.href='./read?ordernum=CS170919221318189';
				}, 3000);
			}
			setTimeout(function() {
				checkorder();
			}, 3000);
		},'json');
	}

//得到支付的二维码
function getQRCode(payType){
	var url='';
	if(payType=='wx'){
		url = 'weixinpay.php';
	}else if(payType=='ali'){
		url = 'alipay.php';
	}else{
		url = 'weixinpay.php';
	}
	$.post('/pcqm/pay/'+url,{price:29.8,software_name:'宝宝取名-pc'},function(re){
		$("#" + payType).empty(); // 清空当前二维码
		var qrcode = new QRCode(document.getElementById(payType), {
			url: re,
			width: 128,
			height: 128,
			colorDark : "#000000",
			colorLight : "#ffffff",
			correctLevel : QRCode.CorrectLevel.H
		});
		qrcode.clear(); // clear the code.
		qrcode.makeCode(re); // make another code.
	})
}

getQRCode('wx');



</script>


<!--右边定位-->
	<div class="fix_right" style="top:37%">
		<a href="/pcqm#main">老师微信</a>
		<a href="/pcqm#main" id="weixin"></a>
		<a href="/pcqm#main">马上起名</a>
		<a href="/pcqm#img">起名优势</a>
		<a href="/pcqm#explain">客户评价</a>
		<a href="/pcqm#cjwn">常见问答</a>
		<a href="/order/pchistory">历史订单</a> 
	</div>
        <div class="footer">
            <p>
				<?php echo $companyname; ?>			</p>
		</div>
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

//设置用户首次微信cookie
function setCookie(name,value,time){
	var strsec = getsec(time);
	var exp = new Date();
	exp.setTime(exp.getTime() + strsec*1);
	document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
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
	var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
	if(arr=document.cookie.match(reg))
		return unescape(arr[2]);
	else
		return null;
}
var randNum = Math.round(Math.random()*2);

var weixinArr = ['qiming8886','qiming88666','quming8866'];
//如果没有获取到cookie  则生成cookie
if(getCookie('weixin')){
	$('#addWeixin').html('老师微信：'+getCookie('weixin'));
	$('#weixin').html(getCookie('weixin'));
}else{
	setCookie("weixin",weixinArr[randNum],"d365");
	$('#addWeixin').html('老师微信：'+getCookie('weixin'));
	$('#weixin').html(getCookie('weixin'));
}



		</script>
		
</div>

</html>



 