<?php

//curl-post进行http请求
  function curl_post($url='', $postArr=array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST' );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postArr );
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close ($ch);
        return $result;
    }

/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
 function get_client_ip($type = 0) {
  $type       =  $type ? 1 : 0;
  static $ip  =   NULL;
  if ($ip !== NULL) return $ip[$type];
  if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      $pos    =   array_search('unknown',$arr);
      if(false !== $pos) unset($arr[$pos]);
      $ip     =   trim($arr[0]);
  }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
      $ip     =   $_SERVER['HTTP_CLIENT_IP'];
  }elseif (isset($_SERVER['REMOTE_ADDR'])) {
      $ip     =   $_SERVER['REMOTE_ADDR'];
  }
  // IP地址合法验证
  $long = sprintf("%u",ip2long($ip));
  $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
  return $ip[$type];
}