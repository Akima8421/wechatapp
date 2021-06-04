<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall"){
    $openid = $_GET['openid'];
    $sql = "select cId from tcinfo where tcOpenid = '$openid' and tcIs = 'true'";//sql语句
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
}elseif($type == "tcadd"){
    $openid = $_GET['openid'];
    $cid = $_GET['cid'];
    $role = $_GET['role'];
    $sql = "insert into tcinfo (tcOpenid,cId,tRole) VALUES ('$openid','$cid','$role')";//sql语句
    $text1 = mysqli_query($conn, $sql);//执行sql语句
}elseif($type == "findsub"){
    $obj = $_GET['obj'];
    $cid = $_GET['cid'];
    $sql = "select * from (select * from teacherinfo where tIs = 'true') t left join (select * from tcinfo where cId = '$cid'and tcIs = 'true') tc on t.tOpenid=tc.tcOpenid where cId = '$cid'and tSub = '$obj'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2));
    echo $text3;
}elseif($type == "find_cid_HT"){
    $openid = $_GET['openid'];
    $role = $_GET['role'];
    $sql = "select cId from tcinfo where tRole = '$role' and tcOpenid = '$openid' and tcIs = 'true'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2));
    echo $text3;
}elseif($type == "find_teacher"){
    $cid = $_GET['cid'];
    $sql = "select * from tcinfo where cId = '$cid' and tcIs = 'true'";//sql语句
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
}elseif($type == "TC_delete"){
    $tcid = $_GET['tcid'];
    $sql = "UPDATE tcinfo set tcIs = 'false' where tcId = '$tcid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}elseif($type == "find_tcid"){
    $openid = $_GET['openid'];
    $sql = "select tcId from tcinfo where tcOpenid = '$openid' and tcIs = 'true'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2));
    echo $text3;
}elseif($type == "find_unteacher"){
    $cid = $_GET['cid'];
    $sql = "select * from (select * from teacherinfo where tIs = 'true') t left join (select * from tcinfo where cId = '$cid'and tcIs = 'true') tc on t.tOpenid=tc.tcOpenid where cid is null";//sql语句
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
}elseif($type == "find_unteacher_sub"){
    $cid = $_GET['cid'];
    $sub = $_GET['sub'];
    $sql = "select * from (select * from teacherinfo where tIs = 'true') t left join (select * from tcinfo where cId = '$cid'and tcIs = 'true') tc on t.tOpenid=tc.tcOpenid where cId is null and tSub = '$sub'";//sql语句
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