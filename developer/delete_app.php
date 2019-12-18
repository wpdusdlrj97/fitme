<!DOCTYPE HTML>
<?php
session_start();

$email = $_SESSION['email'];
$client_id = $_GET['client_id'];

if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{

    // 상태 토큰으로 사용할 랜덤 문자열을 생성
    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.


}

$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect,'utf8');


$query ="DELETE FROM oauth_client_details where client_id='$client_id'";

if (mysqli_query($connect, $query)) {
    //echo "Record deleted successfully";
    echo '<script>location.href=\'http://49.247.136.36/developer/myapplication.php\'</script>'; //나의 어플리케이션 목록으로 이동
} else {
    echo "Error deleting record: " . mysqli_error($connect);
}

mysqli_close($connect);
?>
