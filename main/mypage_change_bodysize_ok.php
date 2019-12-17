<?php
session_start();

$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}

$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');


// 키
$height = $_POST["height"];
// 몸무게
$weight = $_POST["weight"];
// 허리둘레
$waist = $_POST["waist"];
// 상의 기장
$top = $_POST["top"];
// 어깨길이
$shoulder = $_POST["shoulder"];
// 가슴둘레
$chest = $_POST["chest"];
// 팔 길이
$arm = $_POST["arm"];
// 다리 길이
$leg = $_POST["leg"];
// 엉덩이둘레
$hip = $_POST["hip"];
// 허벅지둘레
$thigh = $_POST["thigh"];
// 발목 둘레
$ankle = $_POST["ankle"];


// 수정된 것을 update 해주기

$query = "UPDATE user_information SET shoulder_length='$shoulder', chest_size='$chest', arm_length='$arm', waist_size='$waist', thigh_size='$thigh', hip_size='$hip', ankle_size='$ankle', height_length='$height', leg_length='$leg', top_length='$top', weight='$weight' WHERE email='$email'";

$result = mysqli_query($connect, $query);

if($result){
    //echo "<script>alert('수정 완료');</script>";
    echo '<script>location.href=\'http://49.247.136.36/main/mypage_userinfo.php\'</script>';
}else{
    //echo "<script>alert('수정 오류');</script>";
}





?>