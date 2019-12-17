<?php
session_start();

// 이름과 나이를 포스트로 받았다면
if($_POST['name'] and $_POST['age']){

    $_SESSION['email']="yohan@email.com";

    if($_SESSION['email']){
        print_r('success');
    }


}


?>