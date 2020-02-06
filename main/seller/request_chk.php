<?php
// url 흐름 - seller/request_second.php -> seller/request_chk.php -> seller/request_ok.php

// 로그인 필수
// 판매자의 정보입력이 shop_request_wait 테이블에 저장되는 파일
// 파일이 저장되었을 경우 seller_request_ok.php

session_start();

$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');

//쇼핑몰 판매자 이메일
$shop_email = $_SESSION['email'];
//쇼핑몰 사이트 url
$shop_url =  $_POST['shop_url'];
//쇼핑몰 상호명
$shop_name =  $_POST['shop_name'];
//쇼핑몰 고객관리센터 번호
$shop_phone =  $_POST['shop_phone'];
//쇼핑몰 카톡 아이디
$shop_kakao_id =  $_POST['shop_kakao_id'];


// 입점 신청한 적이 있는 지 조회
$query_id="select count(*) from shop_request_wait where shop_email='$shop_email'";
$result_id=mysqli_query($connect,$query_id);
$row_id=mysqli_fetch_array($result_id);

$query_id2="select count(*) from shop_request_allow where shop_email='$shop_email'";
$result_id2=mysqli_query($connect,$query_id2);
$row_id2=mysqli_fetch_array($result_id2);

if($row_id[0]==0 and $row_id2[0]==0) { // 해당 이메일로 입점 신청 여부 확인, 신청한 적이 없을 경우 계속 진행

    if($shop_url!="" and $shop_name!="" and $shop_phone!="" and $shop_kakao_id!=""){

        // 입점 신청 대기(shop_request_wait)테이블에 insert 하는 쿼리
        $query = "insert into shop_request_wait(shop_email, shop_url,
            shop_name, shop_phone, shop_kakao_id, shop_request_date) VALUES('$shop_email','$shop_url','$shop_name','$shop_phone','$shop_kakao_id',now())";
        $result = mysqli_query($connect, $query);

        if($result){//데이터 저장이 되었을 경우

            echo '<script>location.href=\'http://49.247.136.36/main/seller/request_ok.php\'</script>';

        }else{//데이터 저장에 오류가 있을 경우

            echo "<script>alert('정확한 정보를 입력해주세요9.');history.back();</script>";
        }


    }else{

        echo "<script>alert('정확한 정보를 입력해주세요.');history.back();</script>";
    }

}else{ //해당 계정으로 입점 신청한 적이 있을 경우 alert

    echo "<script>alert('해당 계정으로 이미 입점 신청을 하셨습니다');history.back();</script>";

}









?>