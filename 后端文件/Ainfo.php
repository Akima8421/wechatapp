<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall"){
    $openid = $_GET['openid'];
    $sql = "select * from admininfo where aOpenid = '$openid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行失去了语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = json_encode($text2);
    echo $text3;
}