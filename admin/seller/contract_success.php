<?php

/*
 url 흐름 - shop_request.php -> contract_success.php -> shop_request.php로 리다이렉트

 이 페이지지는 계약이 성사되었을 시 입점에 성공했을 때 처리하는페이지로
 shop_request_allow 테이블에 shop_contract_finish(계약 성사여부)를 0에서 1로 바꿔주고
 shop_contract_date(계약 성사 날짜)를 기입한다.
 *
 */

session_start(); //세션을 유지한다.

$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.

// FitMe 관리자 이메일
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.

//shop_request로부터 받아온 이메일
$shop_email= $_GET['shop_email'];


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


    // shop_request_allow 테이블에 UPDATE를 시켜준다
    //    -shop_contract_finish(계약 성사여부)를 0에서 1로 바꿔주고
    //    -shop_contract_date(계약 성사 날짜)를 기입한다.
    //쇼핑몰 입점 신청 관련 쿼리

    $query_finish = "UPDATE shop_request_allow set shop_contract_date=now(), shop_contract_finish=1 where shop_email='$shop_email'";
    $result_finish = mysqli_query($con, $query_finish);

    if($result_finish){//데이터 저장이 되었을 경우

        echo '<script>location.href=\'http://49.247.136.36/admin/seller/shop_request.php\'</script>';



    }else{//데이터 저장에 오류가 있을 경우

        echo "<script>alert('정확한 정보를 입력해주세요9.');history.back();</script>";
    }





}
?>