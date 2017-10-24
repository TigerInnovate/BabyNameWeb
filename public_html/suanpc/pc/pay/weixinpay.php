<?php

$price = 29.8;

$software_name = "在线算命-PC";

include 'function.php';

function curl_get_pay_url($price='', $software_name=''){
    $time = time();
    $url = 'http://iosdatarecovery.api.huduntech.com/ver2/pc/weixinqrpay';//生成微信支付二维码
    $postArr = array(
        'software_name' => $software_name,//软件名称
        'software_price' => $price,//软件价格
        'software_version' => '官方版',//软件版本
        'mobile' => '12345678911',//联系方式
        'out_trade_no' => $time.strval(rand(1000000,9999999)),//订单号
        'product_id' => 102,//应用ID 自定义
        'client_ip' => '',//客户真实ip
        'expire_time' => 1,//会员到期时间
        'time' => $time,//当前UNIX时间戳
        'token' => strtolower(substr(md5('pc'.$time),0,10)),//token值
        'notify_url' => '',//支付完成异步url
        'return_url' => '',//支付包收银台支付时候需填
        'reserve' => '',//预留字段
    );
    return curl_post($url, $postArr);
}

$re =  curl_get_pay_url($price, $software_name);

$url = json_decode($re, true)['responseData'];

echo $url;