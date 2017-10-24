<?php

include 'function.php';

$action_url = 'http://iosdatarecovery.api.huduntech.com/ver2/wap/paywithWeixin';
//$action_url = 'http://59.110.213.67/ver2/wap/paywithWeixin';

$price = $_POST['software_price'];
//$price = 0.01;

$software_name = $_POST['software_name'];

$time = time();
//订单号
$out_trade_no = $time.strval(rand(1000000,9999999));

$client_ip = get_client_ip();

//$software_name = '宝宝取名-wap';

$software_version = '官方版';
//前一页地址
//$previous_page = getenv('HTTP_REFERER').'&order_num='.$out_trade_no;
$previous_page_str = explode('&amp;order_num', getenv('HTTP_REFERER'));
//前一页地址
$previous_page = $previous_page_str[0].'&order_num='.$out_trade_no;
//$previous_page = str_replace('&','%26',$previous_page);
//token值
$token = strtolower(substr(md5('pc'.$time),0,10));

include 'model.class.php';
$ModelController = new ModelController();
    $user_info = array();
    $user_info['xing'] = urlencode($_POST['xing']);
    $user_info['gender'] = urlencode($_POST['gender']);
    $user_info['birthtimeStr'] = urlencode($_POST['birthtimeStr']);
    $user_info['birthtimeNongliStr'] = urlencode($_POST['birthtimeNongliStr']);
    $user_info = json_encode($user_info);
$referer_kwd = $_COOKIE['referer'];
//插入数据库
if(!$ModelController->insert_order($software_name,103,'12345678910',$out_trade_no,$price,$software_version,2,'wap',$client_ip,$referer_kwd,$user_info)){
  echo"<script>alert('数据写入失败');history.go(-1);</script>";  return false;
}


echo "
          <!DOCTYPE html>
          <html>
          <head>
              <meta charset='utf-8'>
              <title>微信支付跳转</title>
          </head>
          <body>
            <form style='display:none;' id='form1' name='form1' method='post' action='$action_url' accept-charset='UTF-8'>
              <input name='software_name' type='text' value='$software_name' />
              <input name='software_price' type='text' value='$price' />
              <input name='software_version' type='text' value='$software_version' />
              <input name='mobile' type='text' value='12345678910' />
              <input name='out_trade_no' type='text' value='{$out_trade_no}' />
              <input name='product_id' type='text' value='103' />
              <input name='client_ip' type='text' value='$client_ip' />
              <input name='expire_time' type='text' value='0' />
              <input name='time' type='text' value='{$time}' />
              <input name='token' type='text' value='{$token}' />
              
              <input name='notify_url' type='text' value='http://quming.zirebao.cn/wap2/pay/notify.php?' />
              <input name='return_url' type='text' value='' />
              <input name='reserve' type='text' value='' />
              <input name='previous_page' type='text' value='$previous_page' />
            </form>
            <script type='text/javascript'>function load_submit(){document.charset='utf-8';document.form1.submit()}load_submit();</script>
            </body>
            </html>";