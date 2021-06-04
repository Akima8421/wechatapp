<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "firstMess"){
    //获取参数
    $access_token = $_GET["access_token"];
    $data = $_GET["data"];
    //拼接subscribeMessage.send的URL
    $api = "https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token={$access_token}";
    //php post请求网络的方法
    function http_request($url, $data = null, $headers = array())
    {
        $curl = curl_init();
        if (count($headers) >= 1) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
    $str = http_request($api, $data);
    echo $str;
}elseif ($type=="insertHinfo"){
    $name = $_GET['hname'];
    $sub = $_GET['sub'];
    $openid = $_GET['topenid'];
    $text = $_GET['text'];
    $deadline = $_GET['deadline'];
    $cid = $_GET['cid'];
    $time = $_GET['time'];
    $sql = "insert into hinfo (hName,hSub,tOpenid,hText,hDeadline,cId,hTime) VALUES ('$name','$sub','$openid','$text','$deadline','$cid','$time')";//sql语句
    $res=mysqli_query($conn,$sql);
    echo $res;
}elseif ($type=="searchHinfo"){
    $classid = $_GET['classid'];
    $sql = "select * from hinfo where cId = '$classid' and hIs = 'true'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $arr = array();
    // 输出每行数据
    while($row = mysqli_fetch_assoc($text1)) {
        $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for($i=0;$i<$count;$i++){
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr,$row);
    }
    echo stripslashes(json_encode($arr,JSON_UNESCAPED_UNICODE));
}elseif ($type=="H_delete"){
    $hid = $_GET['hid'];
    $sql = "UPDATE hinfo set hIs = 'false' where hId = '$hid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}