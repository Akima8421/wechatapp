<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall") {
    $openid = $_GET['openid'];//取前端传递过来的数据
    $sql = "select * from teacherinfo where tOpenid = '$openid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行失去了语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2,JSON_UNESCAPED_UNICODE));
    echo $text3;
}elseif ($type == "regist"){
    $sex = $_GET['sex'];
    $role = $_GET['role'];
    $realname = $_GET['realname'];
    $userphone = $_GET['phone'];
    $username = $_GET['name'];
    $openid = $_GET['openid'];
    $pic = $_GET['pic'];
    $sub = $_GET['sub'];//取前端传递过来的数据
    $sql = "insert into teacherinfo (tName,tOpenid,tPic,tPhone,tRole,tRealname,tSex,tSub) VALUES ('$username','$openid','$pic','$userphone','$role','$realname','$sex','$sub')";//sql语句
    $res=mysqli_query($conn,$sql);
    echo $res;
}elseif ($type == "searchPic"){
    $openid = $_GET['openid'];//取前端传递过来的数据s
    $sql = "select tPic from teacherinfo where tOpenid = '$openid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2));
    echo $text3;
}elseif ($type == "searchfortable"){
    $sql = "select * from teacherinfo where tIs = 'true'";//sql语句
    $text1 = mysqli_query($conn, $sql);//执行sql语句
    $arr = array();
    while ($row = mysqli_fetch_assoc($text1)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr, JSON_UNESCAPED_UNICODE));
}elseif ($type == "sub_table"){
    $obj = $_GET['obj'];//取前端传递过来的数据s
    $sql = "select * from teacherinfo where tSub = '$obj' and tIs = 'true'";//sql语句
    $text1 = mysqli_query($conn, $sql);//执行sql语句
    $arr = array();
    while ($row = mysqli_fetch_assoc($text1)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr, JSON_UNESCAPED_UNICODE));
}