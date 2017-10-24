<?php
/* *
 * 功能：微信手机网站支付接口(alipay.trade.wap.pay)接口调试入口页面
 * 版本：2.0
 * 修改日期：2016-11-01
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 请确保项目文件有可写权限，不然打印不了日志。
 */

header("Content-type: text/html; charset=utf-8");

const APPID = 'wx250ad85feba54d35';
const MCHID = '1252010501';
const KEY = 'mkRWV35jGHAYW4ZKdE9fHTNAjORZZF6C';

if (!empty($_POST['WIDout_trade_no'])&& trim($_POST['WIDout_trade_no'])!=""){

    /**
     * 
     * 拼接签名字符串
     * @param array $urlObj
     * [url=home.php?mod=space&uid=67594]@Return[/url] 返回已经拼接好的字符串
     */
    function ToUrlParams($urlObj)
        {
            $buff = "";
            foreach ($urlObj as $k => $v)
            {
                if($k != "sign"){
                    $buff .= $k . "=" . $v . "&";
                }
            }
             
            $buff = trim($buff, "&");
            return $buff;
    }


    /**
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    function getNonceStr($length = 32) 
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }
    /**
     * 输出xml字符
    **/
    function ToXml($datas)
    {   
        $xml = "<xml>";
        foreach ($datas as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml; 
    }
    /**
     * 格式化参数格式化成url参数
     */
    function ToUrlParamss($datas)
    {
        $buff = "";
        foreach ($datas as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     * 以post方式提交xml到对应的接口url
     * 
     * @param string $xml  需要post的xml数据
     * @param string $url  url
     * @param bool $useCert 是否需要证书，默认不需要
     * @param int $second   url执行超时时间，默认30s
     */
    function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {       
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_REFERER, "https://www.huduntech.com");
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        curl_close($ch);
        return $data;
    }
    /**
     * 将xml转为array
     * @param string $xml
     */
    function FromXml($xml)
    {   
        if(!$xml){
            echo "xml数据异常！";
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);       
        return $data;
    }

    /**
     * 统一下单，WxPayUnifiedOrder中out_trade_no、body、total_fee、trade_type必填
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param WxPayUnifiedOrder $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    //function unifiedOrder( $timeOut = 6)
   // {   
        $datas = array();
        $datas['body'] = '宝宝取名';
        $datas['out_trade_no'] = '1234567890123456'.rand(100,999);//订单号
        $datas['total_fee'] = '1';
        $datas['time_start'] = date("YmdHis");
        $datas['time_expire'] = date("YmdHis", time() + 86400);
        $datas['notify_url'] = 'http://59.110.213.67/wx_h5.php';
        $datas['trade_type'] = 'MWEB';
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";  
        $datas['appid'] = APPID;//公众账号ID
        $datas['mch_id'] = MCHID;//商户号
        $datas['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];//ip  
        $datas['nonce_str'] = getNonceStr();//随机字符串 
        $datas['scene_info'] = '{"h5_info": {"type":"Wap","wap_url": "https://pay.qq.com","wap_name": "腾讯充值"}} ';//随机字符串 
        //签名步骤一：按字典序排序参数
        ksort($datas);
        $string = ToUrlParamss($datas);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        $datas['sign'] = $result;//签名 
        $xml = ToXml($datas);
        $response = postXmlCurl($xml, $url, false, $timeOut);
        $data = FromXml($response);
        //var_dump($data);
        //return $data;
   // }

//$data = unifiedOrder();

$mweb_url = $data['mweb_url'];

var_dump($mweb_url);

header('location:'.$mweb_url);




    /**
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @return json数据，可直接填入js函数作为参数
     */
   // function GetJsApiParameters(){
/*        $UnifiedOrderResult = unifiedOrder();
        if(!array_key_exists("appid", $UnifiedOrderResult)
        || !array_key_exists("prepay_id", $UnifiedOrderResult)
        || $UnifiedOrderResult['prepay_id'] == "")
        {
            echo $UnifiedOrderResult['err_code_des'];
            exit;
        }
        $da = array();
        $da['appId'] = $UnifiedOrderResult["appid"];
        $timeStamp = time();
        $da['timeStamp'] = "$timeStamp";
        $da['nonceStr'] = getNonceStr();
        $da['package'] = "prepay_id=" . $UnifiedOrderResult['prepay_id'];
        $da['signType'] = 'MD5';
        //签名步骤一：按字典序排序参数
        ksort($da);
        $string = ToUrlParamss($da);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".KEY;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        $da['paySign'] = $result;
        $parameters = json_encode($da);*/

        //return $parameters;
    //}
    //$da = GetJsApiParameters();
    
}
?>
<!DOCTYPE html>
<html>
    <head>
    <title>微信手机网站支付接口</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style>
    *{
        margin:0;
        padding:0;
    }
    ul,ol{
        list-style:none;
    }
    body{
        font-family: "Helvetica Neue",Helvetica,Arial,"Lucida Grande",sans-serif;
    }
    .hidden{
        display:none;
    }
    .new-btn-login-sp{
        padding: 1px;
        display: inline-block;
        width: 75%;
    }
    .new-btn-login {
        background-color: #02aaf1;
        color: #FFFFFF;
        font-weight: bold;
        border: none;
        width: 100%;
        height: 30px;
        border-radius: 5px;
        font-size: 16px;
    }
    #main{
        width:100%;
        margin:0 auto;
        font-size:14px;
    }
    .red-star{
        color:#f00;
        width:10px;
        display:inline-block;
    }
    .null-star{
        color:#fff;
    }
    .content{
        margin-top:5px;
    }
    .content dt{
        width:100px;
        display:inline-block;
        float: left;
        margin-left: 20px;
        color: #666;
        font-size: 13px;
        margin-top: 8px;
    }
    .content dd{
        margin-left:120px;
        margin-bottom:5px;
    }
    .content dd input {
        width: 85%;
        height: 28px;
        border: 0;
        -webkit-border-radius: 0;
        -webkit-appearance: none;
    }
    #foot{
        margin-top:10px;
        position: absolute;
        bottom: 15px;
        width: 100%;
    }
    .foot-ul{
        width: 100%;
    }
    .foot-ul li {
        width: 100%;
        text-align:center;
        color: #666;
    }
    .note-help {
        color: #999999;
        font-size: 12px;
        line-height: 130%;
        margin-top: 5px;
        width: 100%;
        display: block;
    }
    #btn-dd{
        margin: 20px;
        text-align: center;
    }
    .foot-ul{
        width: 100%;
    }
    .one_line{
        display: block;
        height: 1px;
        border: 0;
        border-top: 1px solid #eeeeee;
        width: 100%;
        margin-left: 20px;
    }
    .am-header {
        display: -webkit-box;
        display: -ms-flexbox;
        display: box;
        width: 100%;
        position: relative;
        padding: 7px 0;
        -webkit-box-sizing: border-box;
        -ms-box-sizing: border-box;
        box-sizing: border-box;
        background: #1D222D;
        height: 50px;
        text-align: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        box-pack: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        box-align: center;
    }
    .am-header h1 {
        -webkit-box-flex: 1;
        -ms-flex: 1;
        box-flex: 1;
        line-height: 18px;
        text-align: center;
        font-size: 18px;
        font-weight: 300;
        color: #fff;
    }
</style>
</head>
<body text=#000000 bgColor="#ffffff" leftMargin=0 topMargin=4>
<header class="am-header">
        <h1>微信手机网站支付接口快速通道(接口名：alipay.trade.wap.pay)</h1>
</header>
<div id="main">
        <form name=alipayment action='' method=post target="_blank">
            <div id="body" style="clear:left">
                <dl class="content">
                    <dt>商户订单号
：</dt>
                    <dd>
                        <input id="WIDout_trade_no" name="WIDout_trade_no" />
                    </dd>
                    <hr class="one_line">
                    <dt>订单名称
：</dt>
                    <dd>
                        <input id="WIDsubject" name="WIDsubject" />
                    </dd>
                    <hr class="one_line">
                    <dt>付款金额
：</dt>
                    <dd>
                        <input id="WIDtotal_amount" name="WIDtotal_amount" />
                    </dd>
                    <hr class="one_line">
                    <dt>商品描述：</dt>
                    <dd>
                        <input id="WIDbody" name="WIDbody" />
                    </dd>
                    <hr class="one_line">
                    <dt></dt>
                    <dd id="btn-dd">
                        <span class="new-btn-login-sp">
                            <button class="new-btn-login" type="submit" style="text-align:center;">确 认</button>
                        </span>
                        <span class="note-help">如果您点击“确认”按钮，即表示您同意该次的执行操作。</span>
                    </dd>
                </dl>
            </div>
        </form>
        <div id="foot">
            <ul class="foot-ul">
                <li>
                    微信版权所有 2015-2018 ALIPAY.COM 
                </li>
            </ul>
        </div>
    </div>
</body>
<script language="javascript">
    function GetDateNow() {
        var vNow = new Date();
        var sNow = "";
        sNow += String(vNow.getFullYear());
        sNow += String(vNow.getMonth() + 1);
        sNow += String(vNow.getDate());
        sNow += String(vNow.getHours());
        sNow += String(vNow.getMinutes());
        sNow += String(vNow.getSeconds());
        sNow += String(vNow.getMilliseconds());
        document.getElementById("WIDout_trade_no").value =  sNow;
        document.getElementById("WIDsubject").value = "测试";
        document.getElementById("WIDtotal_amount").value = "0.01";
        document.getElementById("WIDbody").value = "购买测试商品0.01元";
    }
    GetDateNow();
</script>
</html>