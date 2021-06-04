<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall_Y") {
    $year = $_GET['year'];
    $sql = "select * from class where cIs = 'true' and cYear = '$year'";//sql语句
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
}elseif ($type == "searchall_Y_G"){
    $year = $_GET['year'];
    $grade = $_GET['grade'];
    $sql = "select * from class where cYear = '$year' and cGrade = '$grade' and cIs = 'true'";//sql语句
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
}elseif ($type == "search_cid"){
    $year = $_GET['year'];
    $grade = $_GET['grade'];
    $number = $_GET['number'];
    $sql = "select cId from class where cIs = 'true' and cYear = '$year' and cGrade = '$grade' and cNumber = '$number'";//sql语句
    $text1 = mysqli_query($conn, $sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = json_encode($text2);
    echo $text3;
}elseif ($type == "updateClss"){
    $cid = $_GET['cid'];
    $name = $_GET['cname'];
    $cis = $_GET['cis'];
    $sql = "UPDATE class set cName = '$name',cIs = '$cis' where cId = '$cid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}elseif ($type == "classadd"){
    $year = $_GET['year'];
    $grade = $_GET['grade'];
    $number = $_GET['number'];
    $name = $_GET['cname'];
    $sql1 = "insert into class (cName,cGrade,cYear,cNumber) VALUES ('$name','$grade','$year','$number')";//sql语句
    $sql2 = "select cId from class where cIs = 'true' and cYear = '$year' and cGrade = '$grade' and cNumber = '$number'";//sql语句
    $text1 = mysqli_query($conn, $sql1);//执行sql语句
    $text2 = mysqli_query($conn, $sql2);//执行sql语句
    $text3 = mysqli_fetch_assoc($text2);//转换格式
    $text4 = json_encode($text3);
    echo $text4;
}elseif ($type == "find_cid"){
    $cid = $_GET['cid'];
    $sql = "select * from class where cIs = 'true' and cId = '$cid'";//sql语句
    $text1 = mysqli_query($conn, $sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = json_encode($text2);
    echo $text3;
}