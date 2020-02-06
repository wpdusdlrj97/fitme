<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once('./mailer.lib.php');


// mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용", "1");
mailer("PHPMailer", "zzxcho11@naver.com", "wpdusdlrj97@gmail.com", "조용한 웹 개발자의 블로그", "내용", 1);

?>
