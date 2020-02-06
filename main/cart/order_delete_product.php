<?php

session_start(); //세션을 유지한다.

$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($connect,'utf8'); //문자셋을 지정한다.

//현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
$email = $_SESSION['email'];

//purchase_html.php에서 받아온 order_key
$order_key= $_GET['order_key'];

// 해당 데이터 shop_request_wait 테이블에서 삭제해준다
$query_delete = "delete from order_form where order_key='$order_key'";
$result_delete = mysqli_query($connect, $query_delete);

if($result_delete){ // 삭제가 되었을 경우 다시 주문 페이지로 이동

    echo '<script>location.href=\'http://49.247.136.36/main/cart/purchase_html.php\'</script>';

}else{

    echo "<script>alert('삭제 실패');history.back();</script>";

}




?>