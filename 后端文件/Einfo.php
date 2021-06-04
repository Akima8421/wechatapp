<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall") {
    $cid = $_GET['cid'];
    $year = $_GET['year'];
    $term = $_GET['term'];
    $sql = "select * from elass where eIs = 'true' and eYear = '$year' and eTerm = '$term' and ecId = '$cid'";//sql语句
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
}if($type == "Eadd") {
    $cid = $_GET['cid'];
    $year = $_GET['year'];
    $term = $_GET['term'];
    $sub = $_GET['sub'];
    $openid = $_GET['openid'];
    $etype = $_GET['etype'];
    $text = $_GET['text'];
    $date = $_GET['date'];
    $sql = "insert into einfo (ecId,eYear,eTerm,eSub,etOpenid,eType,eText,eDate) VALUES ('$cid','$year','$term','$sub','$openid','$etype','$text','$date')";//sql语句
    $res=mysqli_query($conn,$sql);
    echo $res;
}if($type == "four") {
    $cid = $_GET['cid'];
    $text1 = $_GET['text1'];
    $text2 = $_GET['text2'];
    $text3 = $_GET['text3'];
    $text4 = $_GET['text4'];
    $sql1 = "select * from einfo where eSub = '$text1' and ecId = '$cid' and eIs = 'true'";//sql语句
    $sql2 = "select * from einfo where eSub = '$text2' and ecId = '$cid' and eIs = 'true'";//sql语句
    $sql3 = "select * from einfo where eSub = '$text3' and ecId = '$cid' and eIs = 'true'";//sql语句
    $sql4 = "select * from einfo where eSub = '$text4' and ecId = '$cid' and eIs = 'true'";//sql语句
    $con1 = mysqli_query($conn, $sql);//执行sql语句
    $arr1 = array();
    while ($row = mysqli_fetch_assoc($con1)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr1, JSON_UNESCAPED_UNICODE));
    $con2 = mysqli_query($conn, $sql);//执行sql语句
    $arr2 = array();
    while ($row = mysqli_fetch_assoc($con2)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr2, JSON_UNESCAPED_UNICODE));
    $con3 = mysqli_query($conn, $sql);//执行sql语句
    $arr3 = array();
    while ($row = mysqli_fetch_assoc($con3)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr3, JSON_UNESCAPED_UNICODE));
    $con4 = mysqli_query($conn, $sql);//执行sql语句
    $arr4 = array();
    while ($row = mysqli_fetch_assoc($con4)) {
        $count = count($row);//不能在循环语句中，由于每次删除row数组长度都减小
        for ($i = 0; $i < $count; $i++) {
            unset($row[$i]);//删除冗余数据
        }
        array_push($arr, $row);
    }
    echo stripslashes(json_encode($arr4, JSON_UNESCAPED_UNICODE));
}