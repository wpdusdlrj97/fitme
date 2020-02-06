<?php
$conn = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($conn, 'utf8');

/*
 *  페이지 이름 - 회원가입 받아온 정보 DB 저장
 *
 *  페이지 흐름 - join_second.php -> join_okay.php  ->  join_success.php
 *
 *
 *  페이지 설명 - 필수적으로 받는 데이터 - 아이디, 비밀번호, 이름, 이메일, 광고 수신 동의
 *              선택적으로 받는 데이터 - 주소, 일반 전화번호, 핸드폰번호
 *
 */

/*
 *  예외 처리 - 아이디 중복 확인 / 이메일 중복 확인 다시 해주기 (만일을 대비해)
 *             주소, 일반 전화번호, 핸드폰 번호가 입력되지 않았을 때
 */

// 네이버 SMTP 이메일 전송
include_once('./mailer.lib.php');


// 사용자 아이디, 비밀번호, 이름, 이메일
$input_ID = $_POST["input_ID"];
$input_PW1 = $_POST['input_PW1'];
$input_name = $_POST['input_name'];
$input_email = $_POST['input_email'];

// 비밀번호 해시로 저장
$password_hash = hash("sha256", $input_PW1);

//사용자 주소
$buyer_postcode = $_POST['buyer_postcode'];
$buyer_addr1 = $_POST['buyer_addr1'];
$buyer_addr2 = $_POST['buyer_addr2'];

$address = $buyer_postcode."/".$buyer_addr1."/".$buyer_addr2;

//사용자 일반전화번호
$tel_no_1 = $_POST['tel_no_1'];
$tel_no_2 = $_POST['tel_no_2'];
$tel_no_3 = $_POST['tel_no_3'];



//사용자 휴대전화번호
$phone_no_1 = $_POST['phone_no_1'];
$phone_no_2 = $_POST['phone_no_2'];
$phone_no_3 = $_POST['phone_no_3'];

$phone = $phone_no_1 ."-".$phone_no_2 ."-".$phone_no_3 ;

//광고 수신 동의
$chk_agree = $_POST['chk_agree'];


//echo "아이디 : ".$input_ID;
//echo "비밀번호 : ".$input_PW1;
//echo "이름 : ".$input_name;
//echo "이메일 : ".$input_email;

//echo "주소 : ".$address;
//echo "일반전화 : ".$tel;
//echo "휴대전화 : ".$phone;
//echo "광고 수신 동의 : ".$chk_agree;


//아이디 중복확인 후에 아이디를 바꿔서 입력할 수 있으니 다시 확인해주기
$query_id="select * from user_information where id='$input_ID'";
$result_id=mysqli_query($conn,$query_id);
$total_rows_id = mysqli_num_rows($result_id);

//이메일 중복확인 후에 이메일을 바꿔서 입력할 수 있으니 다시 확인해주기
$query_email="select * from user_information where email='$input_email'";
$result_email=mysqli_query($conn,$query_email);
$total_rows_email = mysqli_num_rows($result_email);


// 선택사항 (주소, 집전화번호, 폰번호 -> 구분자로 나누기)
if($buyer_postcode == "" or $buyer_addr1 == "" or $buyer_addr2 == ""){
    $address ="";
}else{
    $address = $buyer_postcode."/".$buyer_addr1."/".$buyer_addr2;
}
if($tel_no_1 == "" or $tel_no_2 == "" or $tel_no_3 == ""){
    $tel ="";
}else{
    $tel = $tel_no_1 ."-".$tel_no_2 ."-".$tel_no_3 ;
}
if($phone_no_1 == "" or $phone_no_2 == "" or $phone_no_3 == ""){
    $phone ="";
}else{
    $phone = $phone_no_1 ."-".$phone_no_2 ."-".$phone_no_3 ;
}




if($total_rows_id != 0){ // 아이디 2차 중복검사
    echo"<script>
        alert('이미 사용중인 아이디입니다');
        </script>";
    echo "<script> history.back(); </script>";
}else if($total_rows_email !=0){ // 이메일 2차 중복검사
    echo"<script>
        alert('해당 이메일로 가입하신 계정이 존재합니다');
        </script>";
    echo "<script> history.back(); </script>";
}else{

    // resource_owner 테이블에 insert 하는 쿼리
    $query_owner = "insert into resource_owner(account_non_expired, account_non_locked,
            credentials_non_expired, enabled, password, role, username) VALUES(1, 1, 1, 1,'$password_hash','ROLE_USER','$input_ID')";
    $result_owner = mysqli_query($conn, $query_owner);

    //광고성 홍보 수신 동의
    if($chk_agree==1){
        // user_information 테이블에 insert 하는 쿼리 (동의한 사람)
        $query_user = "insert into user_information(email, phone, tel, address, name, id, 
              push_consent, sns_consent, email_consent, level) VALUES('$input_email','$phone','$tel','$address','$input_name','$input_ID', 1, 1, 1, 0)";
        $result_user = mysqli_query($conn, $query_user);
    }else{
        // user_information 테이블에 insert 하는 쿼리 (동의 안한 사람)
        $query_user = "insert into user_information(email, phone, tel, address, name, id, 
              push_consent, sns_consent, email_consent, level) VALUES('$input_email','$phone','$tel','$address','$input_name','$input_ID', 0, 0, 0, 0)";
        $result_user = mysqli_query($conn, $query_user);
    }


    // 이메일로 가입 축하 메시지 보내기

    $content = $input_name."님, 안녕하세요!\n 
               FitMe에 가입하신 것을 진심으로 환영합니다\n
               서비스에 대한 문의나 의견은 고객센터를 통해 알려주세요";

    $content = nl2br($content);
    // mailer("보내는 사람 이름", "보내는 사람 메일주소", "받는 사람 메일주소", "제목", "내용", "1");
    mailer("FITME", "zzxcho11@naver.com", $input_email, "FITME 가입을 환영합니다", $content, 1);



    $connect_url = 'http://49.247.136.36/main/member/join_success.php';
    echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";


}



















?>
