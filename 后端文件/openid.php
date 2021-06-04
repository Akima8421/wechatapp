<?php
//声明CODE，获取小程序传过来的CODE
$code = $_GET['code'];
//配置appid
$appid = "wx174cbe7ce426d805";
//配置appscret
$secret = "3215c6400b9d0b99a8e77423d3e2498d";
//api接口
$api = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$secret}&js_code={$code}&grant_type=authorization_code";
//获取GET请求
function httpGet($url)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 2);
    curl_setopt($curl, CURLOPT_TIMEOUT, 500);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_URL, $url);
    $res = curl_exec($curl);
    curl_close($curl);
    return $res;
}
//发送
$str = httpGet($api);
echo $str;
?>
