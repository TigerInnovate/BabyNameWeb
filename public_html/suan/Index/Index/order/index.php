<?php

if(isset($_GET["surname"])) $surname = $_GET["surname"];
if(isset($_GET["birthday"])) $birthday = $_GET["birthday"];
if(isset($_GET["sex"])) $sex = (int)$_GET["sex"] == 0 ? "女" : "男";

?>

<!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="UTF-8" />
		<title>周易算命网</title>
		<meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<meta content="yes" name="apple-mobile-web-app-capable" />
		<meta content="black" name="apple-mobile-web-app-status-bar-style" />
		<meta content="telephone=no" name="format-detection" />
		<link rel="shortcut icon" href="/favicon.ico" />
		<link href="../../../Public/Index/css/wap.min.css?v=0731" rel="stylesheet" type="text/css" />
		<link href="../../../Public/Index/css/bazijingpi.min.css" rel="stylesheet" type="text/css" />
		<script src="../../../Public/Index/js/jquery-1.7.2.min.js"></script>
		<script src="../../../Public/Index/js/require.min.js" data-main="/Public/Index/js/common.min.js?v=0731"></script>
	</head>

	<body>
		<header class="public_header">
			<h1 class="public_h_con">八字精批</h1>
			<a class="public_h_home" href="../../../Index/Index/index.html"></a>
		</header>
		<div class="public_banner"><img src="../../../Public/Index/images/bzzy_banner.jpg" alt="八字精批" /></div>
		<div class="bazi_order">
			<div class="order clear">
				<div class="left"><span>订单号：</span></div>
				<div class="auto" id='ordernumber' types='八字算命'><span>bz2089803</span></div>
			</div>
			<div class="user_test">
				<div class="ut_pic"><img src="../../../Public/Index/images/img_dashi.png" alt="孙弘均" />
					<p>孙弘均</p>
				</div>
				<div class="ut_pic_center"><img src="../../../Public/Index/images/bg_jzcs.jpg" /></div>
				<div class="ut_user"><img src="../../../Public/Index/images/user.png" alt="#" />
					<p id="fullname"><?php echo $surname; ?><span>(<?php echo $sex; ?>)</span></p>
				</div>
			</div>
			<section class="bazi_pay">
				<div class="price_box">
					<p class="original_price">原价：￥198</p>
					<p>优惠价：<span class="red" id="product_price">￥29.8</span></p>
					<p class="gray_words">请选择喜欢的付款方式</p>
					<p class="gray_words">支付后请加老师微信 <span class="red">suan8886</span> 详批命理</p>
				</div>
				<div class="public_pay_box">
					<!-- <a class="weixin" target="_self" href="../../../Index/Pay/inowpay_way/out_trade_no/bz2089803.html">微信安全支付</a>										
					<a class="alipay" target="_self" href="/Index/Pay/alipay_way/out_trade_no/bz2089803.html">支付宝安全支付</a> -->
					<form action="" method="post" name="weixinpay" class="weixinpayFrom">
					<input type="hidden" name="software_name" value="在线算命">
					<input type="hidden" name="software_price" value="29.80">
						<a class="weixin" target="_self" href="javascript:;" onclick="$('.weixinpayFrom').submit()">微信安全支付</a>	
					</form>
					<form action="" method="post" name="alipay" class="alipayFrom">
					<input type="hidden" name="software_name" value="在线算命">
					<input type="hidden" name="software_price" value="29.80">
						<a class="alipay" target="_self" href="javascript:;" onclick="$('.alipayFrom').submit()">支付宝安全支付</a>
					</form>				
				</div>
				<div class="bp_box">
					<p>已有<span class="red">22443727</span>缘主进行在线测算，知悉了自己事业财运、婚姻情感、今年运势上的情况，<span class="red">98.7%</span>用户觉得本测算对人生规划发展有帮助！</p>
				</div>
			</section>
		</div>
		<div class="lock_content">
			<p class="center">支付完成后您将获得以下重要内容</p>
			<dl><dt>八字排盘</dt>
				<dd>
					<p>精准的八字测算能让您预知未来的吉凶福祸，以便采取正确的应对措施。</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>性格分析</dt>
				<dd>
					<p>解读您的性格特征，全方位地认识自己。</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>财运分析</dt>
				<dd>
					<p>一生财运深度解析，让您找到正确的守财、发财之道。</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>姻缘走势</dt>
				<dd>
					<p>剖析您今生姻缘运势，分析当下感情状况和不利因素的破解之法。</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>健康状态</dt>
				<dd>
					<p>未来的健康状况如何？那怎样的生活方式能让你拥有健康的体态？</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>事业成就</dt>
				<dd>
					<p>没有人想一生无所事事，碌碌无为，你的未来有怎样的事业运势？又该如何抓住机会？</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
			<dl><dt>流月运程</dt>
				<dd>
					<p>通过您的流月运势详解，让您把握人生未来走势，趋吉避凶。</p>
					<p class="center"><span class="btn J_payPopupShow">立即解锁</span></p><i class="bg_bottom_left"></i><i class="bg_bottom_right"></i></dd>
			</dl>
		</div>
		<footer class="public_footer_servers">
			<p>周易算命网</p>
			<p>客服7x24小时在线</p>
			<div class="pf_payment"><span>Payment</span><img src="../../../Public/Index/images/payment.png" alt=""></div>
		</footer>
		<div style="display: none">

		</div>
		<div class="public_pay_popup" id="publicPayPopup">
			<div class="public_pp_box">
				<div class="public_pp_close" id="publicPPClose">X</div>
				<div class="public_pp_tit">解锁查看所有测算结果</div>
				<div class="public_pp_price"><span>统一鉴定价：</span><strong>￥29.8元</strong></div>
				<div class="public_pay_box">
										<!-- <a class="weixin" target="_self" href="../../../Index/Pay/inowpay_way/out_trade_no/bz2089803.html">微信安全支付</a>										
										<a class="alipay" target="_self" href="../../../Index/Pay/alipay_way/out_trade_no/bz2089803.html">支付宝安全支付</a> -->
					<form action="" method="post" name="weixinpay" class="weixinpayFrom">
						<input type="hidden" name="software_name" value="在线算命">
						<a class="weixin" target="_self" href="javascript:;" onclick="$('.weixinpayFrom').submit()">微信安全支付</a>	
					</form>
					<form action="" method="post" name="alipay" class="alipayFrom">
						<input type="hidden" name="software_name" value="在线算命">
						<a class="alipay" target="_self" href="javascript:;" onclick="$('.alipayFrom').submit()">支付宝安全支付</a>
					</form>					
				</div>
			</div>
		</div>
		<div style=" height: 25px;"></div>
		<div class="public_pay_bottom" id="publicPayBottom"><span><i></i>付费解锁所有项</span></div>
		<script>
			//底部悬浮
			;
			(function($) {
				$.fn.publicPopup = function(opt) {
					var pp = $('#publicPayPopup');
					var ppClose = $('#publicPPClose');
					var topShow = $(".J_payBottomShow").length > 0 ? $(".J_payBottomShow").offset().top : 200;
					var ppShow = $(".J_payPopupShow").length > 0 ? $(".J_payPopupShow") : '';
					return this.each(function() {
						var $this = $(this);
						$(window).scroll(function() {
							var wt = $(window).scrollTop();
							wt > topShow ? $this.fadeIn() : $this.fadeOut();
						});
						$this.on('click', function() {
							pp.show();
						});
						ppClose.on('click', function() {
							pp.hide();
						})
						ppShow ? ppShow.on('click', function() {
							pp.show()
						}) : '';
					});
				};

			})(jQuery);
			$("#publicPayBottom").publicPopup();

			//动态设置支付from的action地址
			host = window.location.host;//获取域名
			var http = 'http://'+host;
			$(".weixinpayFrom").attr("action", http+'/wap2/pay/weixinpay_suan.php');
			$(".alipayFrom").attr("action", http+'/wap2/pay/alipay_suan.php');

		</script>
		<!--此处js用于保存订单到本地-->
		<script src="../../../Public/Index/js/localdata.js"></script>
	</body>

	<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
	</script>

</html>