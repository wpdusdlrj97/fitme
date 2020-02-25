<?php
session_start();
// 1. OAuth로 부터 넘어온 이메일 정보가 있는지
// 2. Get을 State 값을 받아왔는지
// 3. Get으로 받아온 md5난수와 세션에 저장한 md5난수가 같은지

$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect,'utf8');




if (!isset($_SESSION['oauth_email'])) {
    echo "잘못된 접근입니다 - state 오류";
}else{
    //fitme_login_callback으로부터 받은 사용자정보(아이디)를  받고
    //OAuth로부터의 이메일을 변수(이메일)에 저장


    $id = $_SESSION['oauth_email'];

    $query_id ="SELECT * FROM user_information where id = '$id'";
    $result_id = mysqli_query($connect, $query_id);
    $row_id = mysqli_fetch_assoc($result_id);


    $_SESSION['id'] = $id;
    $_SESSION['email'] = $row_id['email'];

    if ($_SESSION['URL']) {
        $URL = $_SESSION['URL'];
        $_SESSION['URL'] = null;
        echo "<meta http-equiv='refresh' content='0; url=$URL'>";
    } else {
        $connect_url = 'http://49.247.136.36/main/main.php';
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
    }


}

?>
