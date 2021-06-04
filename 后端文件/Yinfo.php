<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "get_label"){
    $sql = "select label,value from yearinfo";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $arr = array();
    while($row = mysqli_fetch_assoc($text1)) {
        $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for($i=0;$i<$count;$i++){
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr,$row);
    }
    echo stripslashes(json_encode($arr,JSON_UNESCAPED_UNICODE));
}elseif($type == "get_text"){
    $sql = "select text from yearinfo";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $arr = array();
    while($row = mysqli_fetch_assoc($text1)) {
        $count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for($i=0;$i<$count;$i++){
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr,$row);
    }
    echo stripslashes(json_encode($arr,JSON_UNESCAPED_UNICODE));
}
