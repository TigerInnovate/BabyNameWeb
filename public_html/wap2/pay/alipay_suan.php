<?php

include 'function.php';
$client_ip = get_client_ip();

// $price = $_POST['software_price'];
$price = 29.8;
$software_name = $_POST['software_name'];
$time = time();
$out_trade_no = $time.strval(rand(1000000,9999999));//订单号
$token = strtolower(substr(md5('pc'.$time),0,10));

    $previous_page = "http://suan.w897.cn/suan/Index/Index/order/done.html?order_num=".$out_trade_no;
    //$previous_page = str_replace('&','%26',$previous_page);

    function curl_get_pay_url($price='', $previous_page='', $software_name, $out_trade_no='' ,$client_ip='' ,$token='', $time=''){
        
        //$url = 'http://59.110.213.67/ver2/wap/paywithAlipay';//
        $url = 'http://iosdatarecovery.api.huduntech.com/ver2/wap/paywithAlipay';//
        $postArr = array(
            'software_name' => '在线算命',//软件名称
            'software_price' => $price,//软件价格
            'software_version' => '官方版',//软件版本
            'mobile' => '12345678910',//联系方式
            'out_trade_no' => $out_trade_no,
            'product_id' => 103,//应用ID 自定义
            'client_ip' => $client_ip,//客户真实ip
            'expire_time' => 1,//会员到期时间
            'time' => $time,//当前UNIX时间戳
            'token' => $token,//token值
            'notify_url' => 'http://quming.zirebao.cn/wap2/pay/notify.php?',//支付完成异步url
            'return_url' => $previous_page,//支付完成之后的跳转页面
            'reserve' => '',//预留字段      
        );

        return curl_post($url, $postArr);
    }

    $re_json = curl_get_pay_url($price, $previous_page, $software_name,$out_trade_no,$client_ip,$token,$time);

    $url = json_decode($re_json, true)['responseData'];
    header('location:'.$url);