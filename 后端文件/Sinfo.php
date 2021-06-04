<?php
$type = $_GET['type'];
$mysql_server_name='127.0.0.1';//改成自己的mysql数据库服务器
$mysql_username="root"; //改成自己的mysql数据库用户名
$mysql_password="123456"; //改成自己的mysql数据库密码
$mysql_database="school"; //改成自己的mysql数据库名
$conn=new mysqli($mysql_server_name,$mysql_username,$mysql_password,$mysql_database); //连接数据库
if($type == "searchall") {
    $sid = $_GET['sid'];
    $sql = "select * from studentinfo where sId = '$sid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行失去了语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2,JSON_UNESCAPED_UNICODE));
    echo $text3;
}elseif ($type == "searchP"){
    $openid = $_GET['openid'];
    $sql = "select * from studentinfo where pOpenid = '$openid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
    $text2 = mysqli_fetch_assoc($text1);//转换格式
    $text3 = stripslashes(json_encode($text2,JSON_UNESCAPED_UNICODE));
    echo $text3;
}elseif ($type == "searchfortable"){
    $sql = "select * from studentinfo s,class c where s.cId=c.cId";//sql语句
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
}elseif ($type == "updateStu"){
    $sid = $_GET['sid'];
    $sis = $_GET['sis'];
    $pname = $_GET['pname'];
    $ssex = $_GET['sex'];
    $sname = $_GET['sname'];
    $sql = "UPDATE studentinfo set sPname = '$pname',sName = '$sname',sSex = '$ssex',sIs = '$sis' where sId = '$sid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}elseif ($type == "updateS_P"){
    $openid = $_GET['openid'];
    $sid = $_GET['sid'];
    $name = $_GET['name'];
    $sql = "UPDATE studentinfo set sPname = '$name',pOpenid = '$openid' where sId = '$sid'";//sql语句
    $text1 = mysqli_query($conn,$sql);//执行sql语句
}elseif ($type == "insertStu"){
    $sex = $_GET['ssex'];
    $name = $_GET['sname'];
    $sid = $_GET['sid'];
    $cid = $_GET['cid'];
    $sql = "insert into studentinfo (sName,sSex,sId,cId) VALUES ('$name','$sex','$sid','$cid')";//sql语句
    $res=mysqli_query($conn,$sql);
    echo $res;
}elseif ($type == "cid_table"){
    $cid = $_GET['cid'];
    $sql = "select * from studentinfo where cId = '$cid' and sIs = 'true'";//sql语句
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