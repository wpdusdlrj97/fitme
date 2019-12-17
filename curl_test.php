<?php

$data = array(
    'test' => 'test'
);

$url = "https://www.naver.com";

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch, CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);       //POST data
curl_setopt($ch, CURLOPT_POST, true);              //true시 post 전송

$response = curl_exec($ch);
curl_close($ch);

var_dump($response);        //결과 값 출력
print_r(curl_getinfo($ch)); //모든 정보 출력
echo curl_errno($ch);       //에러 정보 출력
echo curl_error($ch);       //에러 정보 출력


?>
