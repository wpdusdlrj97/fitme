<?php
session_start();
//임시리스트
$pic_array = array("1.jpg","2.jpg","3.jpg","4.jpg","5.jpg","6.jpg","7.jpg","8.jpg","9.jpg","10.jpg");
$shop_array = array("모디파이드","에이본","구카","퍼스트플로어","퍼스트플로어","퍼스트플로어","에이본","스튜디오 톰보이","인사일러스","낫앤낫","오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져","3110 wool over jacket charcoal","모던 투피스","빌보 자켓","12/17 배송 EASYGOING CROP","149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135","IN SILENCE X BUND 익스플로러 더블 코트 BLACK","[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙","오버더원 204블레이져 블랙");
$price_array = array("89,000","66,000","254,000","144,000","57,400","119,000","499,000","289,000","79,200","128,000");
$fit_array = array("10.jpg","11.jpg","12.jpg","13.jpg","14.jpg","15.jpg");
?>

<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jua&display=swap" rel="stylesheet">
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
<!--페이지 좌측 하단의 옷입어보기 버튼-->
<div id="fitme_button">
    <div id="fitme_button_text">FitMe</div>
    <div id="fitme_button_icon"></div>
</div>
<!--페이지 상단-->
<div id="header"></div>

<!--광고 이미지 슬라이드-->
<div id="banner">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide" style="overflow:hidden;"><img style="width:100%" src="https://image.brandi.me/home/banner/bannerImage_100840_1575252057.jpg"/></div>
            <div class="swiper-slide" style="overflow:hidden;"><img style="width:100%" src="https://i0.codibook.net/files/1977050411742/f2e31c0eb9a9bb/198778612.jpg"/></div>
            <div class="swiper-slide" style="overflow:hidden;"><img style="width:100%" src="https://image.brandi.me/home/banner/bannerImage_100526_1575039672.jpg"/></div>
            <div class="swiper-slide" style="overflow:hidden;"><img style="width:100%" src="http://cdn2-aka.makeshop.co.kr/shopimages/girlsje/main_rolling1_105.jpg?1574142216"/></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</div>
<!--페이지의 컨텐츠 ( 인기상품, 신상품 등 )-->
<div id="center_box">
    <div class="product_new_box">
        <div class="product_new_box_text">
            <div class="product_new_box_text_title">FitMe Community</div>
            <div class="product_new_box_text_contents">Best Codi</div>
            <div class="product_new_box_text_more">더보기 ></div>
        </div>
        <div class="product_new_box_detail">
            <?php
            for($numf=0;$numf<5;$numf++)
            { ?>
                <ul class="product_detail">
                    <li class="thumbnail_box"><div class="thumbnail_picture" style="background-image:url('./prototype_temp_image/<?php echo $fit_array[$numf];?>'); background-size:100% 100%;"></div></li>
                </ul>
            <?php }
            ?>
        </div>
    </div>
    <div class="center_line"></div>
    <div class="product_new_box">
        <div class="product_new_box_text">
            <div class="product_new_box_text_title">인기신상</div>
            <div class="product_new_box_text_contents">쇼핑몰/마켓 예쁜 신상 가득</div>
            <div class="product_new_box_text_more">더보기 ></div>

        </div>
        <div class="product_new_box_detail">
            <?php
            for($num=0;$num<10;$num++)
            { ?>
                <ul class="product_detail">
                    <li class="thumbnail_box"><div class="thumbnail_picture" style="background-image:url('./prototype_temp_image/<?php echo $pic_array[$num];?>'); background-size:100% 100%;"></div></li>
                    <li class="shop_name"><?php echo $shop_array[$num]?></li>
                    <li class="product_name"><?php echo $name_array[$num]?></li>
                    <li class="product_price"><?php echo $price_array[$num]?></li>
                    <li class="product_like"></li>
                </ul>
            <?php }
            ?>
        </div>
    </div>
    <div class="center_line"></div>
</div>
<!--페이지 하단-->
<div id="footer"></div>
</body>

<script>
//    페이지 상단, 하단의 div 에 미리 만들어둔 php 파일을 불러온다.
    $('#header').load("./head.php");
    $('#footer').load("./foot.php");

    //이미지 슬라이드 관련
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

    //페이지에서 스크롤이 일어날 경우에 상단의 카테고리 목록이 따라다니도록 구현
    $(window).scroll(function () {
        var scrollValue = $(document).scrollTop();
        var Height = screen.height;
    });
</script>


</html>



