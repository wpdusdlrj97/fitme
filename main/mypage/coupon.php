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
    $_SESSION['URL'] = 'http://49.247.136.36/main/mypage/coupon.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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

<style>
    html{ scroll-behavior: smooth; }
    body{ padding:0; margin:0; font-family: 'Noto Sans KR', sans-serif; }
    .no-js { display:none; }

    ul {
        list-style-type: none;
        margin: 5%;
        padding: 0;
        width: 200px;
        background-color: #F5F6F7;
    }
    li a {
        font-size: 15px;
        display: block;
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
    }
    li a.active {
        font-size: 15px;
        color: black;
        font-weight: bold;
        text-decoration: underline;
        text-underline-position: under;

    }


    .verticalLine {
        border-left: thick solid #ff0000;
    }


    #center_box{ margin:0 auto; width:100%; float:left; background-color: #F5F6F7}
    #before_footer{ margin:0 auto; width:100%; float:inside; height: 100px; background-color: #F5F6F7}
    #mypage_box{ margin:0 auto; width:1320px; float: inside;  background-color: #F5F6F7}
    #menu_box{ margin:0 auto; width:250px; float: left;  background-color:  #F5F6F7}

    #content_box{ margin:0 auto; width:75.5%; float: left; background-color: #F5F6F7}


    #member_box{ margin:50px auto; width:90%; float: inside; height:180px; background-color: white}
    #member_box_full{ margin:30px; auto; width:95%; float: left; height:120px; background-color: white}

    #member_box_image{ margin:0 auto; width:120px; float: left; height:120px; background-color: white}

    #member_box_info{ margin:0 auto; width:70%; float: left; height:120px; background-color:white}

    #member_box_name{ margin:0 auto; width:250px; float: left;  height:120px; background-color:lightyellow}

    #member_box_name1{ margin:0 auto; width:250px; float: left;  height:60px; background-color:white}
    #member_box_name2{ margin:0 auto; width:250px; float: left;  height:60px; background-color:white}




    #member_box_coupon{ margin:0 auto; width:120px; float: left; height:120px; background-color: white; border-left: 2px solid #F5F6F7;}

    #member_box_coupon1{ margin:0 auto; width:120px; float: left; height:45px; background-color: white;}
    #member_box_coupon2{ margin:0 auto; width:120px; float: left; height:75px; background-color: white;}





    #category_content_box{ margin:0 auto; width:90%; padding-top: 70px; padding-bottom: 70px; float: inside;  background-color: #F5F6F7}




    #category_footer_box{ margin:0 auto; width:90%; float: inside;  height: 250px; background-color: #F5F6F7}





    @media (max-width:1320px)
    {
        #center_box{ }
        #mypage_box{ width:100%; }
        #menu_box{ width:20%;}
        #member_box_info{ width:60%;}
        #content_box{ width:75%;}


    }
    @media (max-width:990px)
    {
        #mypage_box{ width:100%; }
        #content_box{ width:100%;}
        #member_box{ width:100%;}
        #menu_box{ display: none;}
        #member_box_coupon{ display: none;}
    }

</style>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/api/swiper.css">
    <link rel="stylesheet" href="/api/swiper.min.css">
    <script src="/api/swiper.js"></script>
    <script src="/api/swiper.min.js"></script>
    <title>FITME</title>
</head>


<body>

<div id="header"></div>



<div id="center_box">
    <div id="mypage_box">


        <div id="menu_box">

            <ul style="margin-top: 50px;">
                <li><a href="http://49.247.136.36/main/mypage/order.php">주문조회</a></li>
                <li><a href="#news">장바구니</a></li>
                <li><a href="http://49.247.136.36/main/mypage/order_cancel.php">취소/교환/반품</a></li>
                <li><a class="active" href="http://49.247.136.36/main/mypage/coupon.php">쿠폰</a></li>
                <li><a href="http://49.247.136.36/main/mypage/qna.php">1대1 문의</a></li>
                <li><a href="#contact">정보 수정</a></li>
                <li><a href="http://49.247.136.36/main/mypage/withdraw.php">회원탈퇴</a></li>
            </ul>

        </div>

        <div id="content_box">

            <div id="member_box">

                <div id="member_box_full">

                    <div id="member_box_image">

                        <img src="http://49.247.136.36/main/mypage/mypage_profile.png" alt="My Image" style="margin: 10px;" height="100px">

                    </div>

                    <div id="member_box_info">

                        <div id="member_box_name">

                            <div id="member_box_name1">

                                <h3 style="margin-top: 35px; font-weight: bold; margin-left: 20px;">zzxcho11@naver.com 님 </h3>

                            </div>

                            <div id="member_box_name2" style="text-align: left">

                                <h5 style="font-size: 14px; font-weight: lighter; margin-left: 20px; color: grey "> 누적 구매금액 : 0원 </h5>


                            </div>


                        </div>


                    </div>


                    <div id="member_box_coupon">

                        <div id="member_box_coupon1" style="text-align: center;">

                            <p style="font-weight: lighter; font-size: 15px;"> 쿠폰 </p>

                        </div>

                        <div id="member_box_coupon2" style="text-align: center">

                            <p style="font-size: 20px; font-weight: bold"> 0 </p>

                        </div>

                    </div>


                </div>



            </div>

            <div id="category_content_box" style="text-align: center;" >



                <h5 style="color:grey; font-weight: lighter">사용가능한 쿠폰이 없습니다</h5>





            </div>

            <div id="category_footer_box" style="text-align: center">


            </div>


        </div>
    </div

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
