<?php
session_start();
//임시리스트
{
    $pic_array = array("1.jpg","2.jpg","3.jpg","4.jpg","5.jpg","6.jpg","7.jpg","8.jpg","9.jpg","10.jpg");
    $shop_array = array("모디파이드","에이본","구카","퍼스트플로어","퍼스트플로어","퍼스트플로어","에이본","스튜디오 톰보이","인사일러스","낫앤낫","오버더원");
    $name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져","3110 wool over jacket charcoal","모던 투피스","빌보 자켓","12/17 배송 EASYGOING CROP","149 cashmere double over long coat black",
        "[MEN] 차이나카라 싱글 롱코트 1909211822135","IN SILENCE X BUND 익스플로러 더블 코트 BLACK","[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙","오버더원 204블레이져 블랙");
    $price_array = array("89,000","66,000","254,000","144,000","57,400","119,000","499,000","289,000","79,200","128,000");
    $fit_array = array("10.jpg","11.jpg","12.jpg","13.jpg","14.jpg","15.jpg");
?>
    <!DOCTYPE html>
    <html lang="ko">
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
        <style>
            html{ scroll-behavior: smooth; }
            body{ padding:0; margin:0; }
            /*.no-js { display:none; }*/
            #banner{ margin:0 auto; width:100%; float:left; height:750px; }
            .swiper-container { width: 100%; z-index: 1; height:100%; }
            .swiper-slide { z-index: 1; text-align: center; font-size: 18px; background: #fff; display: -webkit-box; display: -ms-flexbox; display: -webkit-flex; display: flex;
                -webkit-box-pack: center; -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; }
            #main_contents{ width:1300px; margin:0 auto; }
            .main_contents_new_product{ float:left; width:100%; margin-top:50px; }
            .main_contents_product_text{ float:left; font-size:23px; padding-left:15px; margin-top:10px; font-family: 'Noto Sans KR', sans-serif; color:#424242; cursor:pointer; }
            .main_contents_product_more { float:right; font-size:14px; padding-right:27px; margin-top:30px; cursor:pointer; color:#848484; font-family: 'Noto Sans KR', sans-serif; }
            .main_contents_product_more:hover, .main_contents_product_text:hover { transition:all 200ms linear; color:#626262; }
            .main_contents_product_line{ width:1255px; margin:0 0 0 15px; border:2px lightgrey solid; float:left; }
            .main_contents_product_box{ width:1270px; padding:0 0 0 15px; float:left; margin-top:30px; }
            .main_contents_product{ padding:10px; float:left; width:240px; margin-bottom:30px; font-family: 'Noto Sans KR', sans-serif; }
            .shop_and_color{ width:100%; float:left; margin-top:2px; margin-bottom:2px; }
            .shop_name{ font-size:12px; float:left; width:100%; margin-bottom:2px; cursor:pointer; font-weight:lighter; color:#424242; }
            .color_box{ float:left; height:12px; margin-bottom:3px; }
            .color_contents{ float:left; width:12px; height:12px; margin-right:0.4vw; }
            .product_image{ max-width:100%; height:300px; cursor:pointer; }
            .product_name{ float:left; font-size:12px; text-align:left; margin-top:3px; overflow:hidden; height:32px; width:100%; margin-bottom:3px; cursor:pointer; font-weight:lighter; color:#424242; }
            .product_price{ float:left; font-size:12px; font-weight:lighter; color:#424242; }
            .shop_name:hover, .product_name:hover{ transition:all 200ms linear; color:#A4A4A4; }
            .product_image:hover{ transition:all 200ms linear; opacity:0.5; }
            @media (max-width:1320px)
            {
                #main_contents{ width:100%;}
                .shop_name{ font-size:0.9vw; }
                .product_name{ font-size:0.9vw; }
                .color_box{ height:0.9vw; }
                .color_contents{ width:0.9vw; height:0.9vw; }
            }
            @media (max-width:1020px)
            {
                #banner{ height:600px; }
            }
            @media (max-width:990px)
            {
                #banner{ height:350px; }
                .main_contents_product_text{ float:left; font-size:20px; }
                .main_contents_new_product{ margin-top:0; }
                .main_contents_product_more { margin-top:20px; }
                .shop_name{ font-size:1.2vw; }
                .product_name{ font-size:1.2vw; }
                .color_box{ height:1.2vw; }
                .color_contents{ width:1.2vw; height:1.2vw; }
            }
            @media (max-width:520px)
            {
                .shop_name{ font-size:1.8vw; }
                .product_name{ font-size:1.8vw; }
                .color_box{ height:1.8vw; }
                .color_contents{ width:1.8vw; height:1.8vw; }
            }
        </style>
    </head>

    <body class="no-js">
    <!--페이지 상단-->
    <div id="header"></div>

    <!--광고 이미지 슬라이드-->
    <div id="banner">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <div class="swiper-slide" style="overflow:hidden;"><img style="height:100%" src="https://cdn.imweb.me/thumbnail/20200107/be1cda56376ad.png"/></div>
                <div class="swiper-slide" style="overflow:hidden;"><img style="height:100%" src="https://cdn.imweb.me/thumbnail/20200107/d88f994e1c23b.png"/></div>
                <div class="swiper-slide" style="overflow:hidden;"><img style="height:100%" src="https://cdn.imweb.me/thumbnail/20200107/20fdb9dcf5c52.png"/></div>
                <div class="swiper-slide" style="overflow:hidden;"><img style="height:100%" src="https://cdn.imweb.me/thumbnail/20200107/aa4a5385ae3ee.png"/></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div id="main_contents">
        <div class="main_contents_new_product">
            <div class="main_contents_product_text" onclick="wrapWindowByMask();">NEW</div>
            <div class="main_contents_product_more">더보기</div>
            <div class="main_contents_product_line"></div>
            <div class="main_contents_product_box">
                <?php
                for($new_pic_count=0;$new_pic_count<count($pic_array);$new_pic_count++){?>
                    <div class="main_contents_product">
                        <img class="product_image" src="./prototype_temp_image/<?php echo $pic_array[$new_pic_count];?>">
                        <div class="shop_and_color">
                            <div class="color_box">
                                <div class="color_contents" style="background:black;"></div>
                                <div class="color_contents" style="background:grey;"></div>
                                <div class="color_contents" style="background:darkblue;"></div>
                            </div>
                        </div>
                        <div class="shop_name"><?php echo $shop_array[$new_pic_count];?></div>
                        <div class="product_name"><?php echo $name_array[$new_pic_count];?></div>
                        <div class="product_price"><?php echo $price_array[$new_pic_count];?> Won</div>
                    </div>
                <?php }?>
            </div>
        </div>
        <div class="main_contents_new_product">
            <div class="main_contents_product_text">BEST</div>
            <div class="main_contents_product_more">더보기</div>
            <div class="main_contents_product_line"></div>
            <div class="main_contents_product_box">
                <?php
                for($new_pic_count=0;$new_pic_count<count($pic_array);$new_pic_count++){?>
                    <div class="main_contents_product">
                        <img class="product_image" src="./prototype_temp_image/<?php echo $pic_array[$new_pic_count];?>">
                        <div class="shop_and_color">
                            <div class="color_box">
                                <div class="color_contents" style="background:black;"></div>
                                <div class="color_contents" style="background:grey;"></div>
                                <div class="color_contents" style="background:darkblue;"></div>
                            </div>
                        </div>
                        <div class="shop_name"><?php echo $shop_array[$new_pic_count];?></div>
                        <div class="product_name"><?php echo $name_array[$new_pic_count];?></div>
                        <div class="product_price"><?php echo $price_array[$new_pic_count];?> Won</div>
                    </div>
                <?php }?>
            </div>
        </div>
    </div>
    <!--페이지 하단-->
    <div id="footer"></div>
    </body>

    <script>

        // window.onload = function(){
        //     //화면의 높이와 너비를 구한다.
        //     setTimeout(function() {
        //         $('body').removeClass('no-js');
        //     }, 100);
        // };

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


        //최초 페이지 접근시
        if($(window).width()<1280)
        {
            $('.main_contents_product_box').css("width",($(window).width()-17));
            $('.main_contents_product_line').css("width",($(window).width()-32));
            if($(window).width()<=973)
            {
                if($(window).width()<=503)
                {
                    $('.main_contents_product').css("width",($('.main_contents_product_box').width()/2-25));
                }
                else
                {
                    $('.main_contents_product').css("width",($('.main_contents_product_box').width()/3-25));
                }
            }
            else
            {
                $('.main_contents_product').css("width",($('.main_contents_product_box').width()/5-25));
            }
            $('.product_image').css("height",($('.main_contents_product').width()/4*5));
        }
        else if($(window).width()>=1280)
        {
            $('.main_contents_product_box').css("width","1270px");
            $('.main_contents_product_line').css("width","1255px");
            $('.main_contents_product').css("width",($('.main_contents_product_box').width()/5-25));
            $('.product_image').css("height",($('.main_contents_product').width()/4*5));
        }

        //옷 목록을 반응형으로 제작
        $(window).resize(function(){
            if($(window).width()<1280)
            {
                $('.main_contents_product_box').css("width",($(window).width()-17));
                $('.main_contents_product_line').css("width",($(window).width()-32));
                if($(window).width()<=973)
                {
                    if($(window).width()<=503)
                    {
                        $('.main_contents_product').css("width",($('.main_contents_product_box').width()/2-25));
                    }
                    else
                    {
                        $('.main_contents_product').css("width",($('.main_contents_product_box').width()/3-25));
                    }
                }
                else
                {
                    $('.main_contents_product').css("width",($('.main_contents_product_box').width()/5-25));
                }
                $('.product_image').css("height",($('.main_contents_product').width()/4*5));
            }
            else if($(window).width()>=1280)
            {
                $('.main_contents_product_box').css("width","1270px");
                $('.main_contents_product_line').css("width","1255px");
                $('.main_contents_product').css("width",($('.main_contents_product_box').width()/5-25));
                $('.product_image').css("height",($('.main_contents_product').width()/4*5));
            }
        });
    </script>
    </html>
<?php } ?>