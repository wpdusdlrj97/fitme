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
    $_SESSION['URL'] = 'http://49.247.136.36/main/mypage/withdraw.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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

    .button {
        background-color: #000000;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 13px;
        margin: 4px 2px;
        cursor: pointer;
    }




    #center_box{ margin:0 auto; width:100%; float:left; background-color: #F5F6F7}
    #before_footer{ margin:0 auto; width:100%; float:inside; height: 100px; background-color: #F5F6F7}
    #mypage_box{ margin:0 auto; width:1320px; float: inside;  background-color: #F5F6F7}
    #menu_box{ margin:0 auto; width:250px; float: left;  background-color:  #F5F6F7}

    #content_box{ margin:0 auto; width:75.5%; float: left; background-color: #F5F6F7}


    #member_box{ margin:50px auto; width:90%; float: inside; height:650px; background-color: white}

    #member_box_title{ margin:0 auto; width:95%; float: inside; height:100px; background-color: white}
    #member_box_title1{ margin:0 auto; width:95%; float: inside; height:40px; background-color: white}
    #member_box_title2{ margin:0 auto; width:95%; float: inside; height:30px; background-color: white}

    #member_box_content{ margin:0 auto; width:95%; float: inside; height:300px; background-color: white}

    #member_box_content1{ margin:0 auto; width:95%; float: left; height:40px; background-color: white}
    #member_box_content1_warning{ margin:0 auto; width:40px; float: left; height:40px; background-color: white}
    #member_box_content1_text{ margin:0 auto; width:350px; float: left; height:40px; background-color: white}


    #h6_title{ font-weight: bold; font-size: 16px; margin: 0; padding: 7px;}
    #h6_content{ font-weight: normal; font-size: 13px; margin: 0; padding: 7px;}



    #member_box_content2{ margin-bottom: 30px; width:90%; float: left; height:80px; background-color: white}

    #member_box_content3{ margin-bottom: 30px; width:90%; float: left; height:80px; background-color: white}






    #category_footer_box{ margin:0 auto; width:90%; float: inside;  height: 150px; background-color: #F5F6F7}





    @media (max-width:1320px)
    {
        #center_box{ }
        #mypage_box{ width:100%; }
        #menu_box{ width:20%;}
        #content_box{ width:75%;}


    }
    @media (max-width:990px)
    {
        #mypage_box{ width:100%; }
        #content_box{ width:100%;}
        #member_box{ width:100%;}
        #menu_box{ display: none;}
        #h6_title{ font-weight: bold; font-size: 17px; margin: 0; padding: 5px;}
        #h6_content{ font-weight: normal; font-size: 14px; margin: 0; padding: 5px;}

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



<div id="header"></div>



<body>
<div id="center_box">
    <div id="mypage_box">


        <div id="menu_box">

            <ul style="margin-top: 50px;">
                <li><a href="http://49.247.136.36/main/mypage/order.php">주문조회</a></li>
                <li><a href="#news">장바구니</a></li>
                <li><a href="http://49.247.136.36/main/mypage/order_cancel.php">취소/교환/반품</a></li>
                <li><a href="http://49.247.136.36/main/mypage/coupon.php">쿠폰</a></li>
                <li><a href="http://49.247.136.36/main/mypage/qna.php">1대1 문의</a></li>
                <li><a href="#contact">정보 수정</a></li>
                <li><a class="active" href="http://49.247.136.36/main/mypage/withdraw.php">회원탈퇴</a></li>
            </ul>

        </div>

        <div id="content_box">

            <div id="member_box">


                <div id="member_box_title">

                    <div id="member_box_title2">

                    </div>

                    <div id="member_box_title1" style="text-align: left">

                        <h1 style="font-weight: normal; font-size: 25px; margin: 0;" >회원 탈퇴 안내</h1>


                    </div>

                    <hr style="border:solid 0.5px lightgrey;">



                </div>



                <div id="member_box_content">

                    <div id="member_box_content1">

                        <div id="member_box_content1_warning">

                            <img src="http://49.247.136.36/main/mypage/mypage_warning.png" alt="My Image"  height="30px" style="padding: 5px">

                        </div>

                        <div id="member_box_content1_text">


                            <h6 id="h6_title" >FitMe 아이디는 재사용 및 복구 불가 안내</h6>


                        </div>


                    </div>

                    <div id="member_box_content2">

                        <h6 id="h6_content" style="margin-left: 40px;">
                            회원탈퇴 진행 시 본인을 포함한 타인 모두 아이디 재사용이나 복구가 불가능합니다.
                            <br>
                            신중히 선택하신 후 결정해주세요.
                        </h6>


                    </div>


                    <div id="member_box_content1">

                        <div id="member_box_content1_warning">

                            <img src="http://49.247.136.36/main/mypage/mypage_warning.png" alt="My Image"  height="30px" style="padding: 5px">

                        </div>

                        <div id="member_box_content1_text">


                            <h6 id="h6_title" >내정보 및 개인형 서비스 이용 기록 삭제 안내</h6>


                        </div>


                    </div>

                    <div id="member_box_content2">

                        <h6 id="h6_content" style="margin-left: 40px;">
                            내정보 및 개인형 서비스 이용기록이 모두 삭제되며,삭제된 데이터는 복구되지 않습니다.
                            <br>삭제되는 서비스를 확인하시고, 필요한 데이터는 미리 백업을 해주세요.

                        </h6>


                    </div>


                    <div id="member_box_content1">

                        <div id="member_box_content1_warning">

                            <img src="http://49.247.136.36/main/mypage/mypage_warning.png" alt="My Image"  height="30px" style="padding: 5px">

                        </div>

                        <div id="member_box_content1_text">


                            <h6 id="h6_title" >타 쇼핑몰에 등록한 게시글 삭제 불가 안내</h6>


                        </div>


                    </div>

                    <div id="member_box_content2">

                        <h6 id="h6_content" style="margin-left: 40px;">
                            삭제를 원하는 게시글이 있다면 반드시 회원탈퇴 전 비공개 처리하거나 삭제하시기 바랍니다.
                            <br>
                            탈퇴 후에는 회원정보가 삭제되어 본인 여부를 확인할 수 있는 방법이 없어, 게시글을 임의로 삭제해드릴 수 없습니다.
                        </h6>


                    </div>

                    <div id="member_box_content3" style="text-align:end;">

                        <button class="button" type="button">탈퇴하기</button>

                    </div>




                </div>





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
