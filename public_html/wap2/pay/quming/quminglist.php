<?php

	
	include 'cls_bihua.class.php';
	include 'model.class.php';
	include $_SERVER['DOCUMENT_ROOT'].'/wap2/pay/model.class.php';

	

	try {   
		$ModelController = new ModelController();  
	} catch (Exception $e) {   
		print $e->getMessage();   
		exit();   
	}

	$order_num = $_GET['order_num'];

//判断是够支付过
	$order_info = $ModelController->getOrderStatusByOrderNum($order_num);
	if($order_info['order_status']!=3){
		echo "<script> alert('该订单还未支付！') </script>";return false;
	}

	$user_info_arr = json_decode($order_info['user_info'], true);



	$model = new mod_xingming();

	$xing = urldecode($user_info_arr['xing']);
	$sex = urldecode($user_info_arr['gender'])=='男'?0:1;
	$geshu = $_REQUEST['geshu'];
	
	$re = $ModelController->getBaijiaXing($xing);
	//拿到baijia_xing表对应的id
	if($re['id']!=''){
		
		$xid = $re['id'];
	}

	//没有对应的id，则返回错误
	if($xid == ''){
		echo "<script>alert('姓氏不在列表中');history.go(-1);</script>";
		return false;
	} 

	$where = '`xid`="'.$xid.'"';

	if($geshu){
		$where .= ' and geshu='.$geshu;
	}

	//if($sex){
		$where .= ' and sex='.$sex;
	//}

	//拿到baijia_ming表对应的姓名
	$list = $ModelController->getNameList($where);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>支付成功</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
    <link rel="stylesheet" type="text/css" href="../../css/style.css">
    <link rel="stylesheet" type="text/css" href="../../css/name-list.css">
    <link rel="stylesheet" type="text/css" href="../../css/icons.css">
</head>

<body class="page-name-list">

    <main>
        <div class="top-title">
            <span class="icon iconfont icon-qumingdaquan"></span><i class="icon icon-drop"></i>
            <div class="options">
                <a href="javascript:void(0)"><span>不限</span></a>
                <a href="javascript:void(0)"><span>二字</span></a>
                <a href="javascript:void(0)"><span>三字</span></a>
            </div>
		</div>
		<div class="top-title">
            <span id="addWeixin2">加老师微信咨询人工起名</span>
		</div>

		<p class="item-addWeixin">
			<i class="icon-addWeixin"></i><span>加老师微信：<span id="addWeixin">qiming8886</span> 咨询人工起名</span>
		</p>
        <ul class="name-list-wrapper">
        	<?php foreach($list as $v){?>
            <li class="list-item">
                <a href="name_details.php?name=<?php echo $v['name'];?>&id=<?php echo $v['id'];?>&xid=<?php echo $v['xid'];?>&sex=<?php echo $v['sex'];?>&geshu=<?php echo $v['geshu'];?>&order_num=<?php echo $order_num;?>"><span><?php echo $v['name']?></span><i class="iconfont icon-more"></i></a>
            </li>
            <?php }?>
        </ul>
    </main>
    <div class="form-error"></div>
    <script type="text/javascript" src="../../js/jquery.js"></script>
    <script type="text/javascript">
/*    $('.page-name-list .top-title').on({
        click: function(e) {
            e.stopPropagation();
            $(this).find('.options').fadeIn();
        }
    })*/
    $(document).on({
        click: function() {
            var topTitle = $('#divTop.page-name-list .top-title');
            if(!topTitle.is(event.target) && topTitle.has(event.target).length === 0){
            	$('.page-name-list .options').fadeOut();
            }
        }
    })
	</script>
	
<script>
		var _hmt = _hmt || [];
		(function() {
		  var hm = document.createElement("script");
		  hm.src = "https://hm.baidu.com/hm.js?d6171fc44735066530ba341c3c20049e";
		  var s = document.getElementsByTagName("script")[0]; 
		  s.parentNode.insertBefore(hm, s);
		})();
</script>

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