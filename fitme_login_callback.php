<?php
//php 에러 출력하기
session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Fitme 콜백 uri 예제
$client_id = "ddb9468d-313f-42d7-a584-f7dd91696040";
$client_secret = "4f8033d3-2b50-4149-ad08-b423bd441a40";
// 인증서버로부터 코드 발급
$code = $_GET["code"];;
// 다른 서버로부터 전달받고 싶은 값 state로 전달
$state = $_GET["state"];;
//리다이렉트 uri
$redirectURI = urlencode("http://49.247.136.36/fitme_login_callback.php");

//curl을 통해 인증서버로 접근해 액세스토큰을 발급받는 과정
$url = "http://15.165.80.29/oauth/token";

$stored_state = $_SESSION['state'];

//세션에 저장된 state 값과 get으로 받아온 state 값을 비교해 같으면 사용자 정보 조회가능
if ($state != $stored_state) {
    echo "access denied";
    echo $stored_state;
    echo "access denied";
    echo $state;

} else {
    // curl 세션 초기화
    $ch = curl_init();

    // curl 초기 옵션 설정
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "code=" . $code . "&grant_type=authorization_code&redirect_uri=" . $redirectURI . "&scope=read");
    curl_setopt($ch, CURLOPT_USERPWD, $client_id . ':' . $client_secret);

    // curl 헤더 설정
    $headers = array();
    $headers[] = 'Content-Type: application/x-www-form-urlencoded';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    // curl 실행
    $response = curl_exec($ch);

    // curl 에러가 있을 시 에러 출력
    if (curl_errno($ch)) {
        //echo 'Error:' . curl_error($ch);
    }
    // curl 상태 정보를 리턴한다.
    $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    //echo "status_code:".$status_code."<br>";

    // curl 세션 종료
    curl_close($ch);

    // curl 실행시 값 출력
    //echo $response;


    // 만약 curl 상태정보가 200(정상)이라면
    if ($status_code == 200) {

        // json으로된 $response를 json 디코딩을 통해 Accesstoken과 Refreshtoken만 출력해 세션 설정
        $responseArr = json_decode($response, true);
        $_SESSION['fitme_access_token'] = $responseArr['access_token'];
        $_SESSION['fitme_refresh_token'] = $responseArr['refresh_token'];

        //echo "access_token:".$_SESSION['fitme_access_token'];
        //echo " refresh_token:".$_SESSION['fitme_refresh_token'];


        //curl을 통해 발급된 액세스토큰을 가지고 자원서버에서 이메일을 꺼내오는 과정

        $fitme_ch = curl_init();

        curl_setopt($fitme_ch, CURLOPT_URL, 'http://13.209.60.58/api/profile');
        curl_setopt($fitme_ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($fitme_ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $fitme_headers = array();
        $fitme_headers[] = 'Authorization: Bearer ' . $_SESSION['fitme_access_token'];
        curl_setopt($fitme_ch, CURLOPT_HTTPHEADER, $fitme_headers);

        $fitme_ch_reponse = curl_exec($fitme_ch);
        if (curl_errno($fitme_ch)) {
            echo 'Error:' . curl_error($fitme_ch);
        }

        $fitme_status_code = curl_getinfo($fitme_ch, CURLINFO_HTTP_CODE);
        //echo "status_code:".$fitme_status_code."<br>";

        curl_close($fitme_ch);

        //echo  "  출력 값 :".$fitme_ch_reponse;


        // 제이슨 디코딩을 통해 유저 이름 출력
        $fitme_ch_responseArr = json_decode($fitme_ch_reponse, true);
        $username = $fitme_ch_responseArr['name'];;

        // 유저 이메일을 세션에 저장 (이전의 get 방식은 보안적으로 매우 위험)
        $_SESSION['oauth_email'] = $username;

        //FitMe 로그인을 인증하는 페이지로 사용자정보(이메일)를 넘긴다 (나중에 post 방식으로 변경하기)
        $connect_url = "http://49.247.136.36/fitme_login_ok.php";
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";


    } else { // 만약 curl 상태정보가 200(정상)이 아니라면 에러코드 출력
        echo "Error 내용:" . $response;
    }
}


?>
