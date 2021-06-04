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
}elseif ($type=="insertNinfo"){
    $name = $_GET['nname'];
    $openid = $_GET['topenid'];
    $text = $_GET['text'];
    $cid = $_GET['cid'];
    $time = $_GET['time'];
    $sub = $_GET['sub'];
    $sql = "insert into ninfo (nName,tOpenid,nText,cId,nTime,nSub) VALUES ('$name','$openid','$text','$cid','$time','$sub')";//sql语句
    $res=mysqli_query($conn,$sql);
    echo $res;
}elseif ($type=="searchNinfo"){
    $classid = $_GET['classid'];
    $sql = "select * from ninfo where cId = '$classid' and nIs = 'true'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $arr = array();
    // 输出每行数据
    while($row = mysqli_fetch_assoc($text1)) {
        $openid = $row['tOpenid'];
        $sql2 = "select tRealname from teacherinfo where tOpenid = '$openid'";
        $text2 = mysqli_query($conn,$sql2);//执行sql语句
        $text3 = mysqli_fetch_assoc($text2);//转换格式
        $row = $row + $text3;
        $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for($i=0;$i<$count;$i++){
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr,$row);
    }
    echo stripslashes(json_encode($arr,JSON_UNESCAPED_UNICODE));
}elseif ($type=="searchNinfo_NPinfo"){
    $classid = $_GET['classid'];
    $openid = $_GET['openid'];
    $sql = "select * from ninfo n left join npinfo p on n.nid = p.npid where (pOpenid = '$openid' or pOpenid is Null ) and cId = '$classid' and nIs = 'true' ";//sql语
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $arr = array();
    // 输出每行数据
    while($row = mysqli_fetch_assoc($text1)) {
        $openid = $row['tOpenid'];
        $sql2 = "select tRealname from teacherinfo where tOpenid = '$openid'";
        $text2 = mysqli_query($conn,$sql2);//执行sql语句
        $text3 = mysqli_fetch_assoc($text2);//转换格式
        $row = $row + $text3;
        $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for($i=0;$i<$count;$i++){
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr,$row);
    }
    echo stripslashes(json_encode($arr,JSON_UNESCAPED_UNICODE));
}elseif ($type=="N_delete"){
    $nid = $_GET['nid'];
    $sql = "UPDATE ninfo set nIs = 'false' where nId = '$nid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}elseif ($type=="N_num"){
    $nid = $_GET['nid'];
    $openid = $_GET['openid'];
    $sql1 = "select nNum from Ninfo where nId = '$nid'";//sql语句
    $text1 = mysqli_query($conn,$sql1);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text4 = (int)$text2['nNum'] + 1;
    $sql2 = "UPDATE ninfo set nNum = '$text4' where nId = '$nid'";//sql语句
    $text5 = mysqli_query($conn,$sql2);//执行sql语句
    $sql3 = "insert into npinfo (pOpenid,npId) VALUES ('$openid','$nid')";//sql语句
    $text6 = mysqli_query($conn,$sql3);//执行sql语句
    echo $text4;
    print_r($text2['nNum']);
    echo $text6;
}