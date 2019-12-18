<?php
// 스켈레톤 결과값 JSON 전송

$default_name = $_POST['name'];
$name = "http://49.247.136.36/yohan/image/".$default_name.".jpg";

$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($con,'utf8');
$qry = "select * from skeleton where image='$name'";
$send = mysqli_query($con,$qry);
$row = mysqli_fetch_array($send);
$value = $row['value'];
if ($value != null)
{
    echo $value;
}
else
{
    echo "NO";
}

?>
