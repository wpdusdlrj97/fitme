<?php
$conn = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');


$j_id = $_POST["joinid"];
$j_pw = $_POST['joinpw'];
$j_pw2 = $_POST['joinpw2'];



$j_number = $_POST['joinnumber'];


$j_chkid = $_POST['chk_id2'];
$j_chkphone = $_POST['chk_phone'];
$j_chkagree = $_POST['chk_agree'];


$password_hash = hash("sha256", $j_pw);


//해당 폰 번호로 이미 가입된 계정이 있다면 이미 가입된 계정이 있다고 알려주기
$query_phone="select count(*) from user_information where phone='$j_number'";
$result_phone=mysqli_query($conn,$query_phone);
$row_phone=mysqli_fetch_array($result_phone);




//아이디 중복확인 후에 아이디를 바꿔서 입력할 수 있으니 다시 확인해주기
$query_id="select count(*) from user_information where email='$j_id'";
$result_id=mysqli_query($conn,$query_id);
$row_id=mysqli_fetch_array($result_id);



if($j_chkid==0 or $row_id[0]!=0){
  echo"<script>
        alert('아이디 중복확인을 해주세요.');
        </script>";
  $connect_url = 'http://49.247.136.36/main/register_second.php?agree3='.$j_chkagree;
  echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
}else if ($j_pw != $j_pw2) {
    echo "<script>alert('비밀번호가 일치하지 않습니다.');</script>";
    $connect_url = 'http://49.247.136.36/main/register_second.php?agree3='.$j_chkagree;
    echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
//}else if($j_chkphone==0){
//    echo"<script>alert('문자인증을 해주세요.');</script>";
//    $connect_url = 'http://49.247.136.36/main/register_second.php?agree3='.$j_chkagree;
//    echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";
}else {

    if($row_phone[0]==0){ // 해당 폰번호로 가입된 계정이 없다면 register_success.php로 보내주기

        // resource_owner 테이블에 insert 하는 쿼리
        $query_owner = "insert into resource_owner(account_non_expired, account_non_locked,
            credentials_non_expired, enabled, password, role, username) VALUES(1, 1, 1, 1,'$password_hash','ROLE_USER','$j_id')";
        $result_owner = mysqli_query($conn, $query_owner);

        //광고성 홍보 수신 동의
        if($j_chkagree==1){
            // user_information 테이블에 insert 하는 쿼리 (동의한 사람)
            $query_user = "insert into user_information(email, phone,
              push_consent, sns_consent, email_consent, level) VALUES('$j_id','$j_number', 1, 1, 1, 0)";
            $result_user = mysqli_query($conn, $query_user);
        }else{
            // user_information 테이블에 insert 하는 쿼리 (동의 안한 사람)
            $query_user = "insert into user_information(email, phone,
              push_consent, sns_consent, email_consent, level) VALUES('$j_id','$j_number', 0, 0, 0, 0)";
            $result_user = mysqli_query($conn, $query_user);
        }


        $connect_url = 'http://49.247.136.36/main/member/register_success.php';
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";

    }else{ //이미 해당 폰번호로 가입된 계정이 있다면 register_already.php로 보내주기

        $connect_url = 'http://49.247.136.36/main/member/register_already.php';
        echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";


    }








}

?>
