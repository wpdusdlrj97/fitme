<?php
session_start();
// 1. OAuth로 부터 넘어온 이메일 정보가 있는지
// 2. Get을 State 값을 받아왔는지
// 3. Get으로 받아온 md5난수와 세션에 저장한 md5난수가 같은지


if (!isset($_SESSION['oauth_email'])) {
    echo "잘못된 접근입니다9";
}else{
    //fitme_login_callback으로부터 받은 사용자정보(이메일)를 GET으로 받고
    //OAuth로부터의 이메일을 변수(이메일)에 저장
    $email = $_SESSION['oauth_email'];
    /* If success */
    $_SESSION['email'] = $email;
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
