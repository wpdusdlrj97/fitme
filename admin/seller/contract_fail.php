<?php

/*
 url 흐름 - shop_request.php -> contract_fail.php -> shop_request.php로 리다이렉트

 이 페이지지는 계약이 실패되었을 시 처리하는 페이지로
 shop_request_fail 테이블에 계약에 실패한 쇼핑몰 정보를 기입한다
 *
 */

session_start(); //세션을 유지한다.

$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.

// FitMe 관리자 이메일
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.

//shop_request로부터 받아온 이메일
$shop_email= $_GET['shop_email'];
//shop_request로부터 받아온 입점 거부 사유
$shop_fail_reason= $_GET['shop_fail_reason'];

if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{

    //csrf 공격에 대응하기 위한 state 값 설정
    function generate_state() {
        $mt = microtime();
        $rand = mt_rand();
        return md5($mt . $rand);
    }

    // 상태 토큰으로 사용할 랜덤 문자열을 생성
    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=".$state;
    echo "<meta http-equiv='refresh' content='0; url=$login_url'>";
    //echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read\'</script>'; //로그인 페이지로 이동한다.
}
else
{
    //로그인이 되어있는 상태
    //접근권한을 DB에서 조회해야 한다.
    $qry = mysqli_query($con,"select * from user_information where email='$email'");
    $row_level = mysqli_fetch_array($qry);
    if($row_level['level']<'1') //접근권한이 일반 사용자인 경우에는 에러페이지로 넘긴다.
    {
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }


    // shop_request_fail 테이블에 해당 정보를 넣어준다
    //쇼핑몰 입점 신청 관련 쿼리
    $query_shop_allow = "SELECT * FROM shop_request_allow where shop_email='$shop_email' and shop_contract_finish=0";
    $result_shop_allow = mysqli_query($con, $query_shop_allow);
    $row_shop_allow=mysqli_fetch_array($result_shop_allow);


    $shop_email = $row_shop_allow['shop_email'];
    $shop_url = $row_shop_allow['shop_url'];
    $shop_name = $row_shop_allow['shop_name'];
    $shop_phone = $row_shop_allow['shop_phone'];
    $shop_kakao_id = $row_shop_allow['shop_kakao_id'];

    // 입점 신청 거부(shop_request_fail)테이블에 insert 하는 쿼리로
    // shop_fail_date - 입점 거부 날짜
    // shop_fail_admin - 입점 거부한 Fitme 관리자
    // shop_fail_reason - 입점 거부 이유
    $query = "insert into shop_request_fail(shop_email, shop_url,
            shop_name, shop_phone, shop_kakao_id, shop_fail_date,shop_fail_admin,shop_fail_reason) VALUES('$shop_email','$shop_url','$shop_name','$shop_phone','$shop_kakao_id',now(),'$email','$shop_fail_reason')";
    $result = mysqli_query($con, $query);

    if($result){//데이터 저장이 되었을 경우


        // 해당 데이터 shop_request_wait 테이블에서 삭제해준다
        $query_allow_delete = "delete from shop_request_allow where shop_email='$shop_email'";
        $result_allow_delete = mysqli_query($con, $query_allow_delete);

        if($result_allow_delete){ // 삭제가 되었을 경우 입점 관리 페이지로 다시 이동

            echo '<script>location.href=\'http://49.247.136.36/admin/seller/shop_request.php\'</script>';

        }else{

            echo "<script>alert('삭제 실패');history.back();</script>";

        }




    }else{//데이터 저장에 오류가 있을 경우

        echo "<script>alert('정확한 정보를 입력해주세요9.');history.back();</script>";
    }




}
?>