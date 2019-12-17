<?php
session_start();
//임시리스트
$pic_array = array("1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg", "6.jpg", "7.jpg", "8.jpg", "9.jpg", "10.jpg");
$shop_array = array("모디파이드", "에이본", "구카", "퍼스트플로어", "퍼스트플로어", "퍼스트플로어", "에이본", "스튜디오 톰보이", "인사일러스", "낫앤낫", "오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져", "3110 wool over jacket charcoal", "모던 투피스", "빌보 자켓", "12/17 배송 EASYGOING CROP", "149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135", "IN SILENCE X BUND 익스플로러 더블 코트 BLACK", "[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙", "오버더원 204블레이져 블랙");
$price_array = array("89,000", "66,000", "254,000", "144,000", "57,400", "119,000", "499,000", "289,000", "79,200", "128,000");
$fit_array = array("10.jpg", "11.jpg", "12.jpg", "13.jpg", "14.jpg", "15.jpg");


$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/mypage.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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
        max-width: 1000px;
        padding: 20px 20px;
        margin-top: 50px;
        margin-bottom: 30px;
    }

    .menu_box {
        float: left;
        width: 21%;
        margin-right: 4%;
        text-align: center;
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

    img {
        border-radius: 50%;
    }


</style>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <script src="https://unpkg.com/swiper/js/swiper.js"></script>
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./main.css">
    <link rel="stylesheet" type="text/css" href="./head_foot.css">
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

            <div class="card card-container" style="font-weight: bold;">
                <h1 style="color:#000000;  font-size: 2em; text-align:center;">마이페이지</h1>

            </div><!-- /card-container -->

            <div class="card card-container" style="border:1px solid black;height: 230px;">

                <div class="menu_box">
                    <h4 style="font-weight: bold;"><a href="http://49.247.136.36/main/mypage_userinfo.php">회원정보</a>
                    </h4>
                    <br>
                    <a href="http://49.247.136.36/main/mypage_userinfo.php">
                        <img src="./mypage_icon/mypage_icon_member.png" alt="Avatar" style="width:110px">
                    </a>
                </div>

                <div class="menu_box">
                    <h4 style="font-weight: bold;"><a href="#">배송관리</a></h4>
                    <br>
                    <a href="#">
                        <img src="./mypage_icon/mypage_icon_cart.png" alt="Avatar" style="width:110px">
                    </a>
                </div>

                <div class="menu_box">
                    <h4 style="font-weight: bold;"><a href="#">찜한 상품/쇼핑몰</a></h4>
                    <br>
                    <a href="#">
                        <img src="./mypage_icon/mypage_icon_item.png" alt="Avatar" style="width:110px">
                    </a>
                </div>

                <div class="menu_box">

                    <h4 style="font-weight: bold;"><a href="http://49.247.136.36/web/mainpage.php">FitMe 기능</a></h4>
                    <br>
                    <a href="http://49.247.136.36/web/mainpage.php">
                        <img src="./mypage_icon/mypage_icon_fitme.png" alt="Avatar" style="width:110px">
                    </a>
                </div>

            </div><!-- /card-container -->

            <br>

            <div class="card card-container" style="font-weight: bold; text-align: left;">
                <h1 style="color:#000000;  font-size: 2em; text-align:left;">고객 센터</h1>

                <hr style="border-color:#000000; size:3px;"/>

                <br>
                대표번호 : 1577-7777
                <br><br>
                <hr style="border-color:#808080;"/>
                <br>
                영업시간 : AM 10:00 ~ PM 17:00
                (주말 및 공휴일 휴무)
                <br><br>
                <hr style="border-color:#808080;"/>
                <br>
                점심시간 : PM 12:30 ~ PM 13:30
                <br><br>
                <hr style="border-color:#808080;"/>
                <br>
                카톡문의 : fitme_ask@gmail.com
                <br><br>
            </div><!-- /card-container -->


        </div>


    </div>
</div>



<div id="footer"></div>
</body>

<script>
    $('#header').load("./head.php");
    $('#footer').load("./foot.php");
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
        console.log("페이지높이:" + $(window).height());
        console.log("현재스크롤:" + scrollValue);
        console.log("화면높이:" + Height);
        console.log("이벤트div" + $("#foot").prop('scrollHeight'));
    });
</script>
</html>
