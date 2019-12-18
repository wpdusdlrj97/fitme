<?php
// url 흐름 - main의 head.php -> seller/inquire.php -> seller/request_first.php ->

// 입점 신청 버튼을 누를 시 신청 1단계로 이동



session_start();
//임시리스트
$pic_array = array("1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg", "6.jpg", "7.jpg", "8.jpg", "9.jpg", "10.jpg");
$shop_array = array("모디파이드", "에이본", "구카", "퍼스트플로어", "퍼스트플로어", "퍼스트플로어", "에이본", "스튜디오 톰보이", "인사일러스", "낫앤낫", "오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져", "3110 wool over jacket charcoal", "모던 투피스", "빌보 자켓", "12/17 배송 EASYGOING CROP", "149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135", "IN SILENCE X BUND 익스플로러 더블 코트 BLACK", "[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙", "오버더원 204블레이져 블랙");
$price_array = array("89,000", "66,000", "254,000", "144,000", "57,400", "119,000", "499,000", "289,000", "79,200", "128,000");
$fit_array = array("10.jpg", "11.jpg", "12.jpg", "13.jpg", "14.jpg", "15.jpg");


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

    .mySlides {
        display: none;
    }

    .card-container.card {
        max-width: 1000px;
        padding: 20px 20px;
        margin-top: 50px;
        margin-bottom: 30px;
    }

    .userinfo_box {
        width: 70%;
        margin-left: 15%;
        margin-right: 15%;
        margin-top: 5%;
        margin-bottom: 5%;
    }


    .info_box {
        float: left;
        width: 23%;
        margin-left: 1%;
        margin-right: 1%;
        margin-bottom: 5%;
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


    @media only screen and (max-width: 620px) {
        /* For mobile phones: */
        .info_box {
            width: 70%;
            margin-left: 15%;
            margin-right: 15%;
            margin-top: 5%;
            margin-bottom: 5%;
        }
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
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../head_foot.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <title>FITME</title>
</head>
<body>
<div id="fitme_button">
    <div id="fitme_button_icon"></div>
</div>
<div id="header"></div>




<div id="center_box">
    <div id="page-wrapper">

        <div id="main" class="wrapper style1" style="text-align:center;">

            <div class="userinfo_box" style="text-align:center;">

                <h1 style="color:#000000;  font-size: 2em; text-align:center;">입점문의</h1>
                <hr style="border-color:#000000; size:3px;"/>
                <br><br><br>

                <img style="width:100%" src="http://49.247.136.36/main/seller/seller_inquire.png"/>

                <br>
            </div>


            <button class="button" type="button"
                    onclick="location.href='http://49.247.136.36/main/seller/request_first.php'">
                입점신청
            </button>

            <br><br>
        </div>
        <br><br>

    </div>
</div>


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
        console.log("페이지높이:" + $(window).height());
        console.log("현재스크롤:" + scrollValue);
        console.log("화면높이:" + Height);
        console.log("이벤트div" + $("#foot").prop('scrollHeight'));
    });
</script>

</html>
