<?php
// 스켈레톤 결과값 JSON 전송

$default_name = $_POST['name'];
$hi = $_POST['abc'];
$name = "http://49.247.136.36/yohan/image/".$default_name.".jpg";

$json=array("abc"=>$hi,"result"=>$name);
echo json_encode($json);
?>
