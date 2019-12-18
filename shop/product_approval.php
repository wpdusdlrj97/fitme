<?php
session_start();
/*
이 페이지에서 가장 먼저 해야할것은 접속한 사용자가 일반사용자인지 관리자, 즉 쇼핑몰 인지를 확인 하여야한다.
DB에서 user_information테이블에서 level이 사용자 권한을 나타낸다.
level이 0이라면 일반사용자이며 1 이상이라면 이 페이지를 이용할 권한을 가지고 있는것이다.
 */
$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/shop/shop_main.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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
    if($row_level['level']!='1') //접근권한이 일반 사용자인 경우에는 에러페이지로 넘긴다.
    {
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }
}
?>
<html>
<head>
</head>
<body>

</body>
</html>
