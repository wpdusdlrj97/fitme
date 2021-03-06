
<?php
session_start();
//임시리스트
$pic_array = array("1.jpg","2.jpg","3.jpg","4.jpg","5.jpg","6.jpg","7.jpg","8.jpg","9.jpg","10.jpg");
$shop_array = array("모디파이드","에이본","구카","퍼스트플로어","퍼스트플로어","퍼스트플로어","에이본","스튜디오 톰보이","인사일러스","낫앤낫","오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져","3110 wool over jacket charcoal","모던 투피스","빌보 자켓","12/17 배송 EASYGOING CROP","149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135","IN SILENCE X BUND 익스플로러 더블 코트 BLACK","[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙","오버더원 204블레이져 블랙");
$price_array = array("89,000","66,000","254,000","144,000","57,400","119,000","499,000","289,000","79,200","128,000");
$fit_array = array("10.jpg","11.jpg","12.jpg","13.jpg","14.jpg","15.jpg");


$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/mypage/member_withdraw.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}

$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');



?>

<html>
<style type="text/css">
    /*
     * Specific styles of signin component
     */
    /*
     * General styles
     */

    body, html {
        height: 70%;
        background-repeat: no-repeat;

    }

    .card-container.card {
        max-width: 500px;
        padding: 40px 40px;
        margin-top: 100px;
        margin-bottom: 100px;
    }

    .btn {
        font-weight: 700;
        height: 36px;
        -moz-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        cursor: default;
    }

    /*
     * Card component
     */
    .card {
        background-color: #FFFFFF;
        /* just in case there no content*/
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;

    }

    .button {
        background-color: #000000;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }




</style>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="http://49.247.136.36/api/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="http://49.247.136.36/api/swiper.css">
    <link rel="stylesheet" href="http://49.247.136.36/api/swiper.min.css">
    <script src="http://49.247.136.36/api/swiper.js"></script>
    <script src="http://49.247.136.36/api/swiper.min.js"></script>


    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../head_foot.css">
    <title>FITME</title>
</head>
<body>
<div id="fitme_button">
    <div id="fitme_button_icon"></div>
</div>
<div id="header"></div>


<div id="center_box">
    <div id="page-wrapper">

        <div id="main" class="wrapper style1">

            <br><br><br><br>

            <h1 style="color:#000000; font-weight: bold; font-size: 1.5em; text-align:center;">
                회원탈퇴에 앞서 유의사항 및 안내를 반드시 읽고 진행해주세요 </h1>

            <div class="card card-container" style="border:4px solid black;" >
                <h1 style="color:#000000; font-weight: bold; font-size: 1.2em; text-align:left;">
                    FitMe 아이디는 재사용 및 복구 불가 안내</h1>
                    <h1 style="color:#000000; font-size: 1em; text-align:left;">
                        회원탈퇴 진행 시 본인을 포함한 타인 모두 아이디 재사용이나 복구가 불가능합니다.
                    신중히 선택하신 후 결정해주세요.</h1>

                <br>

                <h1 style="color:#000000; font-weight: bold; font-size: 1.2em; text-align:left;">
                    내정보 및 개인형 서비스 이용 기록 삭제 안내</h1>
                <h1 style="color:#000000; font-size: 1em; text-align:left;">
                    내정보 및 개인형 서비스 이용기록이 모두 삭제되며,삭제된 데이터는 복구되지 않습니다.
                    삭제되는 서비스를 확인하시고, 필요한 데이터는 미리 백업을 해주세요.</h1>

                <br>

                <h1 style="color:#000000; font-weight: bold; font-size: 1.2em; text-align:left;">
                    타 쇼핑몰에 등록한 게시글 삭제 불가 안내</h1>
                <h1 style="color:#000000; font-size: 1em; text-align:left;">
                    삭제를 원하는 게시글이 있다면 반드시 회원탈퇴 전 비공개 처리하거나 삭제하시기 바랍니다.
                    탈퇴 후에는 회원정보가 삭제되어 본인 여부를 확인할 수 있는 방법이 없어, 게시글을 임의로 삭제해드릴 수 없습니다.</h1>

                <button class="button" type="button" onclick="location.href='http://49.247.136.36/main/mypage/userinfo.php'">취소</button>
                <button class="button" type="button" onclick="location.href='http://49.247.136.36/main/mypage/member_withdraw_final.php'">계속하기</button>


            </div><!-- /card-container -->


        </div>


    </div>
</div>

<br><br><br>


<div id="footer"></div>
</body>

<script>
    $('#header').load("../head.php");
    $('#footer').load("../foot.php");
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });
    $(window).scroll(function () {
        var scrollValue = $(document).scrollTop();
        var Height = screen.height;
        console.log("페이지높이:"+$( window ).height());
        console.log("현재스크롤:"+scrollValue);
        console.log("화면높이:"+Height);
        console.log("이벤트div"+$("#foot").prop('scrollHeight'));
    });
</script>
</html>
