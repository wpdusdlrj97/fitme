<?php

// url 흐름 - seller_request_first.php -> seller_request_second.php -> seller_request_chk.php

// 로그인 필수
// 입점 신청 2단계 페이지로 판매자의 정보 입력이 이루어지는 화면이다
// Form 태그로 정보입력(사이트 url, 상호명, 고객센터 전화번호, 카카오톡 아이디)후에 seller_request_chk.php로 POST 전송한다

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
    $_SESSION['URL'] = 'http://49.247.136.36/main/seller_request_second.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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

            <!--정보를 입력하는 창으로 모든 정보를 입력해야 다음페이지로 이동이 가능하다-->
            <!--정보 입력이 모두 끝나면 form 태그를 통해 seller_request_chk.php로 POST 전송-->
            <div class="card card-container" style="border:4px solid black; text-align: center;">
                <h1 style="color:#000000; font-weight: bold; font-size: 2.5em; text-align:center;">입점 신청
                    2단계</h1>

                <form method="post" action="seller_request_chk.php" name="loginForm">


                    <h1 style="color:#000000; font-weight: bold; font-size: 1em; text-align:left;">사이트 url</h1>
                            <br>
                            <input type="email" id="inputEmail" maxlength=40
                                   style="width:400px;height:30px;margin-top:20px;padding:2px; font-size:12pt;"
                                   placeholder="사이트 url을 입력해주세요" name="joinid" required autofocus>
                            <br>
                    <h1 style="color:#000000; font-weight: bold; font-size: 1em; text-align:left;">상호명</h1>
                            <br>
                            <input type="email" id="inputEmail" maxlength=40
                                   style="width:400px;height:30px;margin-top:20px;padding:2px; font-size:12pt;"
                                   placeholder="상호명을 입력해주세요" name="joinid" required>
                            <br>
                    <h1 style="color:#000000; font-weight: bold; font-size: 1em; text-align:left;">고객센터 전화번호</h1>
                            <br>
                            <input type="tel" id="number" maxlength=12
                                   style="width:400px;height:30px;margin-top:20px;padding:2px; font-size:12pt;"
                                   name="joinnumber" placeholder="'-'없이 ex.01012345678" required>
                            <br>
                    <h1 style="color:#000000; font-weight: bold; font-size: 1em; text-align:left;">카카오톡 ID</h1>
                            <br>
                            <input type="email" id="inputEmail" maxlength=40
                                   style="width:400px;height:30px;margin-top:20px;padding:2px; font-size:12pt;"
                                   placeholder="카카오톡 ID" name="joinid" required>
                            <br>

                            <br><br><br>
                            <button class="button" type="button"
                                    onclick="location.href='http://49.247.136.36/main/main.php'">
                                취소
                            </button>
                            <button class="button" type="submit">입점 신청 완료</button>

                </form><!-- /form -->
            </div><!-- /card-container -->


        </div>


    </div>
</div>

<br><br><br>


<div id="footer"></div>
</body>
<iframe src="" id="ifrm1" scrolling=no frameborder=no width=0 height=0 name="ifrm1"></iframe>
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-auth.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
<script src="https://www.gstatic.com/firebasejs/7.5.0/firebase-analytics.js"></script>

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyBhVz4BWYChcbtsutz-I87pCzQkyG0N2_w",
        authDomain: "fir-phone-auth-573ca.firebaseapp.com",
        databaseURL: "https://fir-phone-auth-573ca.firebaseio.com",
        projectId: "fir-phone-auth-573ca",
        storageBucket: "fir-phone-auth-573ca.appspot.com",
        messagingSenderId: "1006621985157",
        appId: "1:1006621985157:web:b551c8dc44773e987b9cec",
        measurementId: "G-393F52JTM9"
    };
    // Initialize Firebase

    firebase.initializeApp(firebaseConfig);

    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier("recaptcha-container");

    function phoneAuth() {
        var country = "+82";
        var number = document.getElementById("number").value;
        var country_number = country.concat(number);


        firebase
            .auth()
            .signInWithPhoneNumber(country_number, window.recaptchaVerifier)
            .then(function (confirmationResult) {
                window.confirmationResult = confirmationResult;
                coderesult = confirmationResult;
                console.log(coderesult);
                alert("문자를 전송했습니다");
            })
            .catch(function (error) {
                console.log(error);
                alert("정확한 번호인지 확인해주세요");
            });
    }


    function codeverify() {
        var code = document.getElementById("verificationCode").value;
        coderesult.confirm(code).then(function (result) {
            var user = result.user;
            console.log(user);
            alert("인증에 성공하였습니다");
            document.getElementById("chk_phone").value = 1;
        })
            .catch(function (error) {
                console.log(error);
                alert("인증에 실패하였습니다");
            });
    }


</script>
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
