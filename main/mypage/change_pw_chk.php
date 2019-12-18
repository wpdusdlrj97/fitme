<?php
session_start();

$conn = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');

// 이메일
$email = $_SESSION['email'];
// 기존 비밀번호
$original_pw = $_POST["original_pw"];
// 새로운 비밀번호
$new_pw = $_POST['new_pw'];
// 새로운 비밀번호 재입력
$new_pw2 = $_POST['new_pw2'];


//기존 비밀번호 암호화 -> DB값과 비교하기 위해서
$original_password_hash = hash("sha256", $original_pw);


//해당 폰 번호로 이미 가입된 계정이 있다면 이미 가입된 계정이 있다고 알려주기
$query="select * from resource_owner where username='$email'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);




if($row['password']!=$original_password_hash){ // 기존 비밀번호를 잘못 입력한 경우
  echo"<script>
        alert('입력하신 기존 비밀번호가 틀렸습니다');history.back();
        </script>";
}else if ($new_pw != $new_pw2) { // 새로운 비밀번호가 일치하지 않는 경우
    echo "<script>alert('새로운 비밀번호와 확인이 일치하지 않습니다.');history.back();</script>";
}else { // 새로운 비밀번호 DB에 업데이트

  //임시 비밀번호 암호화
  $new_password_hash = hash("sha256", $new_pw);

  //임시 비밀번호 DB에 넣기
  $query_pw ="UPDATE resource_owner set password='$new_password_hash' where username = '$email'";

  //쿼리 실행
  mysqli_query($conn, $query_pw);

  //바로 메인페이지로 넘기기
  $connect_url = 'http://49.247.136.36/main/main.php';
  echo "<meta http-equiv='refresh' content='0; url=$connect_url'>";


}

?>
