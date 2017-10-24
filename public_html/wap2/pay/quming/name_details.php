<?php
	include 'cls_bihua.class.php';
	include 'model.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/wap2/pay/model.class.php';
$ModelController = new ModelController();
$model = new mod_xingming();
	$order_num = $_GET['order_num'];

//判断是够支付过
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info['order_status']!=3){
		//echo "<script> alert('该订单还未支付！') </script>";return false;
	}

    	$name = $_GET['name'];
    	$xing = substr($name,0,3);
    	$ming = substr($name,3,9);

    	$xing1 = substr($xing,0,3);	
    	$ming1 = substr($ming,0,3);
    	//五行
    	$wh_bh_arr = $ModelController->getBihua($xing1);

    	$bihua1 = $wh_bh_arr['bihua'];
    	$hzwh1 = $wh_bh_arr['hzwh'];
    	$tiange = $bihua1 + 1;
    	$tiangee = $bihua1 + 1;
    	$renge1 = $bihua1;

    	$xing2 = substr($xing,3,3);
    	if($xing2!=''){
    		$wh_bh_arr2 = $ModelController->getBihua($xing2);
    		$bihua2 = $wh_bh_arr2['bihua'];
    		$hzwh2 = $wh_bh_arr2['hzwh'];
    		$xing22 = $xing2;
    		$tiange = $bihua1+$bihua2;
    		$tiangee = $bihua1+$bihua2;
    		$renge1 = $bihua2; 
    		
    		$xing2py = $model->Pinyin_sm($xing2,1);
    		$xing2gb = $model->gb_big5($xing2);
    	}


    	$ming_wh_bh_arr = $ModelController->getBihua($ming1);
    	$bihua3 = $ming_wh_bh_arr['bihua'];
    	$hzwh3 = $ming_wh_bh_arr['hzwh'];
    	$dige = $bihua3 + 1;
    	$digee = $bihua3 + 1;
    	$renge2 = $bihua3;

    	$ming2 = substr($ming,3,3);

    	if($ming2!=''){
    		$ming_wh_bh_arr2 = $ModelController->getBihua($ming2);
    		$bihua4 = $ming_wh_bh_arr2['bihua'];
    		$hzwh4 = $ming_wh_bh_arr2['hzwh'];
    		
    		$dige = $bihua3 + $bihua4;
    		$digee = $bihua3 + $bihua4;
    		
    		$ming2py = $model->Pinyin_sm($ming2,1);
    		$ming2gb = $model->gb_big5($ming2);
    	}

		//gb_big5
		$xm_arr = array('xing1'=>$xing1,'xing1py'=>$model->Pinyin_sm($xing1,1),'xing1gb'=>$model->gb_big5($xing1),'xing2'=>$xing2,'xing2py'=>$xing2py,'xing2gb'=>$xing2gb,'ming1'=>$ming1,'ming1py'=>$model->Pinyin_sm($ming1,1),'ming1gb'=>$model->gb_big5($ming1),'ming2'=>$ming2,'ming2py'=>$ming2py,'ming2gb'=>$ming2gb);

		$bh_wh_arr = array('bihua1'=>$bihua1,'bihua2'=>$bihua2,'bihua3'=>$bihua3,'bihua4'=>$bihua4,'hzwh1'=>$hzwh1,'hzwh2'=>$hzwh2,'hzwh3'=>$hzwh3,'hzwh4'=>$hzwh4);

		$zhongge = $bihua1 + $bihua2 + $bihua3 + $bihua4;
		$zhonggee = $bihua1 + $bihua2 + $bihua3 + $bihua4;

		//计算三才
		$renge = $renge1 + $renge2;
		$rengee = $renge1 + $renge2;
		$waige = $zhongge - $renge;
		$waigee = $zhonggee - $rengee;
		if($xing2==''){
			$waige = $waige + 1;
			$waigee = $waigee + 1;
		}
		if($ming2==''){
			$waige = $waige + 1;
			$waigee = $waigee + 1;
		}

			
		//天格
		$tiangearr = $ModelController->getGe($tiangee);
		$tiangearr['tiangee'] = $tiangee;

		//人格
		$rengearr = $ModelController->getGe($rengee);
		$rengearr['rengee'] = $rengee;
		
		//地格
		$digearr = $ModelController->getGe($digee);
		$digearr['digee'] = $digee;
		
		//外格
		$waigearr = $ModelController->getGe($waigee);
		$waigearr['waigee'] = $waigee;
		
		//总格
		$zonggearr = $ModelController->getGe($zhongge);
		$zonggearr['waigee'] = $zhongge;

		//天地人三才
		$tian_sancai = $model->getsancai($tiange);
		$ren_sancai = $model->getsancai($renge);
		$di_sancai = $model->getsancai($dige);

		//三才吉凶
		$sancai = $tian_sancai.$ren_sancai.$di_sancai;
		$rssancai = $ModelController->getSancai($sancai);
		$rssancai['sancai'] = $sancai;
		
		$tdr_ge = array('renge'=>$renge,'tiange'=>$tiange,'dige'=>$dige,'tian_sancai'=>$tian_sancai,'ren_sancai'=>$ren_sancai,'di_sancai'=>$di_sancai,'waige'=>$waige,'waige_sancai'=>$model->getsancai($waige),'zhongge'=>$zhongge,'zongge_sancai'=>$model->getsancai($zhongge));
		//姓名得分
		$xmdf = $model->getpf($tiangearr['jx'])/10+$model->getpf($rengearr['jx'])+$model->getpf($digearr['jx'])+$model->getpf($zonggearr['jx'])+$model->getpf($waigearr['jx'])/10+$model->getpf($rssancai['jx'])/4+$model->getpf($rssancai['jx1'])/4+$model->getpf($rssancai['jx2'])/4+$model->getpf($rssancai['jx3'])/4;
		
		if($zhonggee>60){
			  $xmdf = $xmdf - 4;
		}
		$xmdf = 58 + $xmdf;
		//最终得分大于100 统一为100
		if($xmdf > 100){
			$xmdf = 100;
		}

/*		$data = array();

		$data['xm_arr'] = $xm_arr;
		$data['bh_wh_arr'] = $bh_wh_arr;
		$data['tiangearr'] = $tiangearr;
		$data['rengearr'] = $rengearr;
		$data['digearr'] = $digearr;
		$data['waigearr'] = $waigearr;
		$data['zonggearr'] = $zonggearr;
		$data['rssancai'] = $rssancai;
		$data['tdr_ge'] = $tdr_ge;
		$data['xmdf'] = $xmdf;
		$data['name'] = $name;
		var_dump($data);*/

if($xmdf<60){
	$pinyu = '<p>你的名字可能不是很好。强烈建议你换个名字试试，也许人生会因此而改变的。</p>
<p>如果有条件，改个名字也未尝不可。</p>';
}elseif($xmdf>=60 && $xmdf<70){
	$pinyu = '<p>你的名字可能不太好，如果可能的话，不妨尝试改变一下，也许会有事半功倍之效。</p>
<p>如果有条件，改个名字也未尝不可。</p>';
}elseif($xmdf>=70 && $xmdf<80){
	$pinyu = '<p>你的名字可能不太理想，要想赢得成功，必须比别人付出更多的艰辛和汗水。如果有条件，改个名字也未尝不可。</p>
<p>如果有条件，改个名字也未尝不可。</p>';
}elseif($xmdf>=80 && $xmdf<90){
	$pinyu = '<p>你的名字取得不错，如果与命理搭配得当，相信它会助你一生顺利的，祝你好运！</p>';
}elseif($xmdf>=90){
	$pinyu = '<p>你的名字取得非常棒，如果与命理搭配得当，成功与惊喜将会伴随你的一生。但千万注意不要失去上进心。</p>';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title><?php echo $name?>名字五格算命,<?php echo $name?>测姓名打分</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
	<link rel="stylesheet" type="text/css" href="../../css/style.css">
	<link rel="stylesheet" type="text/css" href="../../css/icons.css">
	<link rel="stylesheet" type="text/css" href="../../css/name-details.css">
</head>
<body class="page-names-detail">
	<p class="item-addWeixin">
		<i class="icon-addWeixin"></i><span>加老师微信：<span id="addWeixin">qiming8886</span> 咨询人工起名</span>
	</p>
	<main>
		<div class="top-tite">
			<span class="iconfont icon-top-title"></span>
			<a href="" class="my-order">我的订单</a>
		</div>
		<div class="details-item my-name">
			<i class="icon icon-figure top-left"></i>
			<i class="icon icon-figure top-right"></i>
			<i class="icon icon-figure bottom-left"></i>
			<i class="icon icon-figure bottom-right"></i>
			<p>
				<span class="name-title"><?php echo $name?></span>
				<span class="nama-score"><?php echo $xmdf?><i>分</i></span>
			</p>
		</div>

		<div class="details-item my-name">
			<i class="icon icon-figure top-left"></i>
			<i class="icon icon-figure top-right"></i>
			<i class="icon icon-figure bottom-left"></i>
			<i class="icon icon-figure bottom-right"></i>
			<p>
				<span class="nama-score" id="addWeixin2">加老师微信咨询人工起名</span>
			</p>
		</div>

		<div class="details-item">
			<i class="icon icon-figure top-left"></i>
			<i class="icon icon-figure top-right"></i>
			<i class="icon icon-figure bottom-left"></i>
			<i class="icon icon-figure bottom-right"></i>
			<div class="name-detail-box">
				<div class="detai-box-warpper">
					<ul class="row-item type-1 title">
						<li>姓名</li>
						<li>繁体</li>
						<li>拼音</li>
						<li>康熙笔画</li>
						<li>字意五行</li>
					</ul>
					<ul class="row-item type-1 info">
						<li><?php echo $xm_arr['xing1'];?></li>
						<li><?php echo $xm_arr['xing1gb'];?></li>
						<li><?php echo $xm_arr['xing1py'];?></li>
						<li><?php echo $bh_wh_arr['bihua1'].$bh_wh_arr['bihua2'];?></li>
						<li><?php echo $bh_wh_arr['hzwh1'].$bh_wh_arr['hzwh2']?></li>
					</ul>
					<ul class="row-item type-1 info">
						<li><?php echo $xm_arr['ming1'];?></li>
						<li><?php echo $xm_arr['ming1gb'];?></li>
						<li><?php echo $xm_arr['ming1py'];?></li>
						<li><?php echo $bh_wh_arr['bihua3'];?></li>
						<li><?php echo $bh_wh_arr['hzwh3']?></li>
					</ul>
					<ul class="row-item type-1 info">
						<li><?php echo $xm_arr['ming2'];?></li>
						<li><?php echo $xm_arr['ming2gb'];?></li>
						<li><?php echo $xm_arr['ming2py'];?></li>
						<li><?php echo $bh_wh_arr['bihua4'];?></li>
						<li><?php echo $bh_wh_arr['hzwh4']?></li>
					</ul>
				</div>
				<div class="detai-box-warpper">
					<ul class="row-item type-1 info">
						<li><span>天格</span></li>
						<li></li>
						<li></li>
						<li></li>
						<li><span><i class="score"><?php echo $tiangearr['num'];?></i><em>分</em></span></li>
					</ul>
					<ul class="row-item type-1 info">
						<li><span>人格</span></li>
						<li></li>
						<li></li>
						<li></li>
						<li><span><i class="score"><?php echo $rengearr['num'];?></i><em>分</em></span></li>
					</ul>

					<ul class="row-item type-1 info">
						<li><span>地格</span></li>
						<li></li>
						<li></li>
						<li></li>
						<li><span><i class="score"><?php echo $digearr['num'];?></i><em>分</em></span></li>
					</ul>
					<ul class="row-item type-1 info">
						<li><span>总格</span></li>
						<li></li>
						<li></li>
						<li></li>
						<li><span><i class="score score-total"><?php echo $zonggearr['num'];?></i><em>&nbsp</em></span></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="details-item">
			<div class="name-detail-box name-advice">
				<i class="icon icon-figure top-left"></i>
				<i class="icon icon-figure top-right"></i>
				<i class="icon icon-figure bottom-left"></i>
				<i class="icon icon-figure bottom-right"></i>
				<div class="detai-box-warpper">
					<p class="content-title advice-title">姓名总评及建议<a href="">我想改名>></a></p>
					<p class="advice-score">姓名五格评分<span><i class="score"><?php echo $xmdf;?></i><em>分</em></span></p>
					<p class="advice-content">
						<?php echo $pinyu;?>
					</p>
				</div>
			</div>
		</div>

		<div class="details-item">
			<div class="name-detail-box name-explain">
				<i class="icon icon-figure top-left"></i>
				<i class="icon icon-figure top-right"></i>
				<i class="icon icon-figure bottom-left"></i>
				<i class="icon icon-figure bottom-right"></i>
				<div class="detai-box-warpper">
					<p class="content-title explain-title">详细解释</p>
					<?php echo $rssancai['content'];?>
				</div>
			</div>
		</div>

		<div class="details-item">
			<div class="name-detail-box name-influence">
				<i class="icon icon-figure top-left"></i>
				<i class="icon icon-figure top-right"></i>
				<i class="icon icon-figure bottom-left"></i>
				<i class="icon icon-figure bottom-right"></i>
				<div class="detai-box-warpper">
					<p class="content-title influence-title">对基础运的影响</p>
					<p class="influence-content"><?php echo $rssancai['jcy'];?></p>
					<p class="influence-content result"><span><?php echo $rssancai['jx1'];?></span></p>
				</div>
			</div>
		</div>
		<a href="javascript:void(0)" class="bg-brimary-liner btn-retest">重新测算</a>
	</main>

<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
</script>

<script type="text/javascript" src="../../js/jquery.js"></script>

<script>
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

/**********************设置微信cookie*******************************/
var randNum = Math.round(Math.random()*2);
	var weixinArr = ['qiming8886','qiming88666','quming8866'];
	//如果没有获取到cookie  则生成cookie
	if(getCookie('weixin')){
	
	}else{
		setCookie("weixin",weixinArr[randNum],"d365");
		
	}
	$('#addWeixin').html(getCookie('weixin'));
	$('#addWeixin2').html('加老师微信：'+getCookie('weixin')+' 咨询人工起名');
	jQuery(document).ready(function($) {
		function addWxServicePadding(){
		    if($('.item-addWeixin').length>0){
		        var height = $('.item-addWeixin').outerHeight();
		        $('body').css({
		            'padding-bottom':height+'px'
		        })
		    }
		}
		addWxServicePadding();
		$(window).resize(function(event) {
		    addWxServicePadding()
		});
	});
</script>

</body>

</html>