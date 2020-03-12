<?php
//초기에 제공하는 카테고리 목록을 가져온다.
session_start();
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from category");
$category1 = array();
$category2 = array();
while($row = mysqli_fetch_array($qry))
{
    array_push($category1,$row['name']);
    array_push($category2,$row['detail_category']);
}
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <title>FitMe</title>
    <style>
        html.open { overflow: hidden; }
        #head_body_for_drag{ padding:0; font-family: 'Noto Sans KR', sans-serif; -ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none; }
        #head_logo_place{ margin:0 auto; font-family: 'Lato', sans-serif; width:1300px; -ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none; }
        .head_logo_left, .head_logo_right{ float:left; width:35%; height:107px; margin:0; padding:0; }
        .head_logo_center{ float:left; width:30%; height:107px; margin:0; padding:0; }
        .head_logo_center a{ font-family: 'Oswald', sans-serif; text-decoration:none; width:100%; cursor:pointer; font-weight:600; font-size:36px; text-align:center; float:left; line-height:107px; letter-spacing: 1.15px; color:black; }
        .head_logo_center a:hover{ text-decoration:none; color:black; }
        .head_contents{ float:left; width:100%; height:50px; margin-top:28.5px; }
        .head_contact, .head_login, .head_logout, .head_mypage, .head_android, .head_ios{ float:right; font-size:13px; line-height:50px; font-weight:500; letter-spacing: 0.8px; }
        .head_contact{ margin-right:10px; }
        .head_ios{ width:30px; height:30px; margin-top:8px; background-image:url("/web/icon/ios.png"); background-size:100% 100%; }
        .head_android{ width:30px; height:30px; margin-top:8px; background-image:url("/web/icon/android.png"); background-size:100% 100%; }
        .head_slash{ float:right; font-size:11px; color:lightgrey; margin:0 10px 0 10px; line-height:50px; }
        .head_contact a, .head_login a, .head_logout a, .head_mypage a{ text-decoration:none; color:black; cursor:pointer; }
        .head_contact a:hover, .head_login a:hover, .head_logout a:hover, .head_mypage a:hover{ color:#585858; text-decoration:none; }
        #head_category_place{ width:100%; float:left; box-shadow:0 0px 2px 1px #E6E6E6; height:56px; position:fixed; top:107px; background:#FFFFFF; z-index:100; }
        .head_category{ width:1300px; margin:0 auto; }
        .head_category_left, .head_category_right{ float:left; width:15%; height:56px; margin:0; padding:0; }
        .head_category_center{ float:left; width:70%; height:56px; margin:0; padding:0; }
        .head_categories{ width:calc(100% / 5); font-weight:600; height:56px; font-size:14px; text-align:center; float:left; line-height:55px; color:black; }
        .head_categories:hover{ transition:all 150ms linear; color:#9370db; cursor:pointer; font-weight:bold; }
        .search_box{ float:right; width:180px; border:1px lightgrey solid; height:32px; margin-top:12px; border-radius: 5px; background:white; }
        .search_box img{ width:20px; height:20px; margin-top:6px; margin-right:8px; float:right; cursor:pointer; opacity:0.8 }
        .search_box img:hover{ transition:all 10ms linear; opacity: 0.6; }
        .search_box input{ width:130px; float:left; margin-left:10px; border:none; height:22px; margin-top:5px; }
        .search_box input:focus{ outline:none; }
        .head_logo_hidden_990 { width:100%; float:left; height:54px; display:none; }
        .head_hidden_990_center td a{ text-decoration: none; color:black; font-size:13px; font-family: 'Lato', sans-serif; cursor:pointer; }
        .head_hidden_990_center td a:hover{ color:#585858; text-decoration:none; }
        .head_hidden_990_android{ margin:0 auto; width:30px; height:30px; background-image:url("/web/icon/android.png"); background-size:100% 100%; }
        .head_hidden_990_ios{ margin:0 auto; width:30px; height:30px; background-image:url("/web/icon/ios.png"); background-size:100% 100%; }
        .head_hidden_990_left, .head_hidden_990_right{ float:left; width:14%; height:54px; }
        .head_hidden_990_menu{ width:30px; height:30px; margin-top:12px; margin-left:7px; background-image:url("/web/icon/head_menu.png"); background-size:100% 100%; opacity:0.7; cursor:pointer; }
        .head_hidden_990_menu:hover{ opacity:0.5; transition:all 200ms linear; }
        .head_hidden_990_center{ float:left; width:60%; margin-left:6%; height:54px; text-align: center; }
        .head_hidden_990_center td { height:100%; }
        #head_hidden_990{ display:none; height:54px; background:#F2F6F6; width:100%; position:fixed; z-index:100; }
        .head_menu_close { opacity:0.6; width: 50px; height: 50px; position: absolute; right: 0; top: 0; background-image: url("/web/icon/menu_close.png"); background-size: 50%; background-repeat: no-repeat; background-position: center; cursor: pointer; }
        .head_menu_close:hover { opacity:0.4; transition:all 200ms linear; }
        #head_menu { width:calc(60% - 60px); font-family: 'Oswald', sans-serif; box-shadow:0 5px 5px 3px #424242; height: calc(100% - 60px); padding:30px; position: fixed; top: 0; left: -65%; z-index: 200; background:white; transition: All 0.4s ease; -webkit-transition: All 0.4s ease; -moz-transition: All 0.4s ease; -o-transition: All 0.4s ease; }
        #head_menu.open { left: 0px; }
        .head_page_cover.open { display: block; }
        .head_page_cover { width: 100%; height: 100%; float:left; position: fixed; top: 0px; left: 0px; background-color: rgba(0, 0, 0, 0.5); z-index: 195; display: none; }
        .head_category_990_hidden_tr{ display:none; clear:left; font-size:13px; color:#848484; margin:0; width:100%; padding:0; list-style-type:none; border-bottom:1px #E6E6E6 solid; float:left; text-align:center; }
        .head_category_hidden_td1{ float:left; height:35px; line-height:38px; width:33%; border-right:1px #E6E6E6 solid; cursor:pointer; }
        .head_category_hidden_td2{ float:left; height:35px; line-height:38px; width:33%; cursor:pointer; }
        .head_category_hidden_td1:hover, .head_category_hidden_td2:hover{ transition:all 200ms linear; color:#9370db; font-weight:bold; }
        .head_fixed_margin{ float:left; width:100%; margin-bottom:56px;}
        .go_predressing{ transition:all 200ms linear; position:fixed; right:30px; bottom:30px; width:70px; height:70px; padding:10px; z-index:100; cursor:pointer; border-radius:100%; background-origin:content-box; background-repeat:no-repeat; background-image:url("/web/icon/go_predressing2.png"); background-size:100% 100%; }
        .go_predressing:hover{ transition:all 200ms linear; background-image:url("/web/icon/go_predressing1.png"); opacity:0.7;  }
        .head_category_menu{ float:left; width:25px; height:16px; padding:20px; cursor:pointer; opacity:0.7; }
        .head_category_menu:hover{ opacity:1; }
        .head_open_menu_box{ float:left; box-shadow:1px 1px 3px 1px #E6E6E6; font-family: 'Noto Sans KR', sans-serif; font-size:13px; position:relative; width:calc( 100% - 20px ); padding:10px; margin-top:1px; background-color:rgba(255,255,255,0.95); text-align:center; display:none; opacity:0; }
        .head_open_menu_inbox1{ float:left; width:calc(15% - 20px); margin:10px 0 0 5%; }
        .head_open_menu_p_text{ float:left; text-align:left; width:100%; font-size:16px; cursor:pointer; }
        .head_open_menu_p_text:hover{ color:#9370db; }
        .head_open_menu_inbox2{ float:left; width:calc(55% - 20px); margin:10px; }
        .head_open_menu_item_text_line{ float:left; width:100%; height:20px; }
        .head_open_menu_item_box{ float:left; text-align:center; width:24%; margin-left:1%; }
        .head_open_menu_item_text_b_line{ float:left; transition:all 200ms linear; font-size:13px; text-align:left; width:100%; margin-bottom:10px; text-decoration: underline; cursor:pointer; }
        .head_open_menu_item_text_box{ float:left; text-align:left; width:97%; margin-left:3%; padding:2px 0 2px 0; margin-bottom:5px; }
        .head_open_menu_item_text{ transition:all 200ms linear; float:left; font-size:11px; height:20px; cursor:pointer; }
        .head_open_menu_item_text:hover{ transition:all 200ms linear; font-size:13px; }
        .head_open_menu_inbox3, .head_open_menu_inbox4{ float:left; width:calc(12.5% - 20px); text-align:left; font-size:12px; margin:55px 10px 10px 10px; color:#848484 }
        .head_open_menu_contents_text{ float:left; width:100%; margin-bottom:10px; height:20px; cursor:pointer; }
        .head_open_menu_contents_text:hover{ color:black; }
        .last_hidden_tr{ border-bottom:none; }
        @media (max-width:1320px){
            #head_logo_place{ width:100%; }
            .head_category{ width:100%; }
            .head_logo_hidden_990{ display:none; }
            .head_contents{ display:block; }
            .go_predressing{ display:none; }
        }
        @media (max-width:990px)
        {
            #head_hidden_990{ display:block; }
            .head_category{ display:none; }
            .head_logo_hidden_990{ display:block; }
            .head_contents{ display:none; }
            .head_category_990_hidden_tr { display:block; }
            #head_category_place{ top:161px; height:auto; }
            .head_fixed_margin{ margin-bottom:74px; }
        }
        @media (max-width:500px)
        {
            .head_table4{display:none;}
            .head_table5{display:none;}
        }
    </style>
</head>
<body id="head_body_for_drag">
    <div class="go_predressing"></div>
    <div onclick="history.back();" class="head_page_cover"></div>
    <div id="head_menu">
        <div onclick="history.back();" class="head_menu_close"></div>
        <?php if($_SESSION['id']){?>
            <div class="head_menu_login_text" style="font-size:13px; width:100%; float:left; text-align:center; margin-bottom:20px;"><?php echo $_SESSION['id']?> 님 즐쇼하쇼</div>
            <div class="head_menu_logout_box" style="float:left; width:100%; height:40px; margin-bottom:30px; text-align:center;">
                <div class="head_menu_logout_button" style="width:30%; height:30px; border-radius:3px; border:1px black solid; line-height:30px; font-size:12px; margin-right:20px; cursor:pointer; display:inline-block; vertical-align:middle; ">MYPAGE</div>
                <div class="head_menu_logout_button" style="width:30%; height:30px; border-radius:3px; border:1px black solid; line-height:30px; font-size:12px; cursor:pointer; display:inline-block; vertical-align:middle; ">LOGOUT</div>
            </div>
        <?php }?>
        <div class="head_menu_main_category" style="float:left; width:100%; font-size:18px; text-align:left; margin-bottom:15px; ">⦁ HOME</div>
        <div class="head_menu_main_category" style="float:left; width:100%; font-size:18px; text-align:left; margin-bottom:15px; ">⦁ NEW</div>
        <div class="head_menu_main_category" style="float:left; width:100%; font-size:18px; text-align:left; margin-bottom:15px; ">⦁ BEST</div>
        <div class="head_menu_main_category" style="float:left; width:100%; font-size:18px; text-align:left; margin-bottom:15px; ">⦁ ITEM</div>
        <?php for($category_count=0;$category_count<count($category1);$category_count++){
            if($category_count%2==0&&$category_count!=0){?>
                <div class="head_open_menu_item_text_line"></div>
            <?php }
            ?>
            <div class="head_menu_main_category_item_box" style="float:left; width:44%; margin-left:6%;">
                <div class="head_menu_main_category_item_category" style="float:left; font-size:15px; text-decoration: underline; margin-bottom:8px;" onclick="location.href='http://49.247.136.36/main/category.php?category1=<?php echo $category1[$category_count]?>'"><?php echo $category1[$category_count]?></div>
                <?php for($category2_count=0;$category2_count<count(json_decode($category2[$category_count],true));$category2_count++){?>
                    <div class="head_menu_main_category_item_detail_box" style="float:left; width:94%; margin-left:6%; margin-bottom:8px;">
                        <div class="head_menu_main_category_item_detail" style="float:left; font-size:13px;" onclick="location.href='http://49.247.136.36/main/category.php?category1=<?php echo $category1[$category_count]?>&category2=<?php echo json_decode($category2[$category_count],true)[$category2_count]?>'"><?php echo json_decode($category2[$category_count],true)[$category2_count]?></div>
                    </div>
                <?php }?>
            </div>
        <?php }?>
        <div class="head_menu_main_category" style="float:left; width:100%; font-size:18px; text-align:left; margin-bottom:15px; margin-top:5px; ">⦁ STORE</div>
        <div class=""sfdddddddddddddddddddddddddddddddddddddddd
    </div>
    <div id="head_hidden_990">
        <div class="head_hidden_990_left">
            <div class="head_hidden_990_menu"></div>
        </div>
        <table class="head_hidden_990_center">
            <td class="head_table1"><a href="http://49.247.136.36/main/seller/inquire.php">입점문의</a></td>
            <?php if($_SESSION['id']){ ?>
                <td class="head_table2"><a href="http://49.247.136.36/fitme_logout.php">Logout</a></td>
                <td class="head_table3"><a href="http://49.247.136.36/main/mypage/main_html.php">Mypage</a></td>
            <?php }else{
                //로그인 state 값 설정
                $state = 'xyz';
                // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
                $_SESSION['state'] = $state;
            ?>
                <td class="head_table2"><a href="http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz">Login</a></td>
            <?php }?>
            <td class="head_table4"><div class="head_hidden_990_android"></div></td>
            <td class="head_table5"><div class="head_hidden_990_ios"></div></td>
        </table>
        <div class="head_hidden_990_right"></div>
    </div>
    <div id="head_logo_place">
        <div class="head_logo_hidden_990"></div>
        <div class="head_logo_left"></div>
        <div class="head_logo_center"><a onclick="page_move('http://49.247.136.36/main/main.php')">FitMe</a></div>
        <div class="head_logo_right">
            <div class="head_contents">
                <div class="head_contact"><a href="http://49.247.136.36/main/seller/inquire.php">입점문의</a></div>
                <div class="head_slash">/</div>
                <?php if($_SESSION['email']){ ?>
                    <div class="head_logout"><a href="http://49.247.136.36/fitme_logout.php">Logout</a></div>
                    <div class="head_slash">/</div>
                    <div class="head_mypage"><a href="http://49.247.136.36/main/mypage/main_html.php">Mypage</a></div>
                    <div class="head_slash">/</div>
                <?php }else{ ?>
                    <div class="head_login"><a href="http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz">Login</a></div>
                    <div class="head_slash">/</div>
                <?php }?>
                <div class="head_android"></div>
                <div class="head_slash">/</div>
                <div class="head_ios"></div>
            </div>
        </div>
    </div>
    <div id="head_category_place">
        <div class="head_category">
            <div class="head_category_left">
                <img class="head_category_menu" src="/web/icon/black_menu.png">
            </div>
            <div class="head_category_center">
                <div class="head_categories" onclick="location.href='http://49.247.136.36/main/category.php?category1=NEW'">NEW</div>
                <div class="head_categories" onclick="location.href='http://49.247.136.36/main/category.php?category1=BEST'">BEST</div>
                <div class="head_categories" onclick="location.href='http://49.247.136.36/main/category.php?category1=ITEM'">ITEM</div>
                <div class="head_categories" onclick="location.href='http://49.247.136.36/main/store_main.php'">STORE</div>
                <div class="head_categories" onclick="location.href='http://49.247.136.36/main/predressing.php'">FITME</div>
            </div>
            <div class="head_category_right">
                <div class="search_box">
                    <img class="search_enter" src="http://49.247.136.36/web/icon/search.png">
                    <input class="search_text" type="text" placeholder="Search">
                </div>
            </div>
            <div class="head_open_menu_box">
                <div class="head_open_menu_inbox1">
                    <div class="head_open_menu_p_text" style="margin-bottom:40px;" onclick="location.href='http://49.247.136.36/main/category.php?category1=NEW'">⦁ NEW</div>
                    <div class="head_open_menu_p_text" style="margin-bottom:40px;" onclick="location.href='http://49.247.136.36/main/category.php?category1=BEST'">⦁ BEST</div>
                    <div class="head_open_menu_p_text" style="margin-bottom:40px;" onclick="location.href='http://49.247.136.36/main/store_main.php'">⦁ STORE</div>
                    <div class="head_open_menu_p_text" style="margin-bottom:40px;" onclick="location.href='http://49.247.136.36/main/predressing.php'">⦁ FITME</div>
                </div>
                <div class="head_open_menu_inbox2">
                    <div class="head_open_menu_p_text" style="margin-bottom:20px;" onclick="location.href='http://49.247.136.36/main/category.php?category1=ITEM'">⦁ ITEM</div>
                    <?php for($category_count=0;$category_count<count($category1);$category_count++){
                        if($category_count%4==0&&$category_count!=0){?>
                            <div class="head_open_menu_item_text_line"></div>
                        <?php }
                        ?>
                        <div class="head_open_menu_item_box">
                            <div class="head_open_menu_item_text_b_line" onclick="location.href='http://49.247.136.36/main/category.php?category1=<?php echo $category1[$category_count]?>'"><?php echo $category1[$category_count]?></div>
                            <?php for($category2_count=0;$category2_count<count(json_decode($category2[$category_count],true));$category2_count++){?>
                                <div class="head_open_menu_item_text_box">
                                    <div class="head_open_menu_item_text" onclick="location.href='http://49.247.136.36/main/category.php?category1=<?php echo $category1[$category_count]?>&category2=<?php echo json_decode($category2[$category_count],true)[$category2_count]?>'"><?php echo json_decode($category2[$category_count],true)[$category2_count]?></div>
                                </div>
                            <?php }?>
                        </div>
                    <?php }?>
                </div>
                <div class="head_open_menu_inbox3">
                    <div class="head_open_menu_contents_text" onclick="location.href='http://49.247.136.36/main/mypage/main_html.php'">마이페이지</div>
                    <div class="head_open_menu_contents_text">공지사항</div>
                    <div class="head_open_menu_contents_text">고객센터</div>
                    <div class="head_open_menu_contents_text">이벤트</div>
                    <div class="head_open_menu_contents_text">즐겨찾기</div>
                    <div class="head_open_menu_contents_text">찜한상품</div>
                    <div class="head_open_menu_contents_text">모바일</div>
                </div>
                <div class="head_open_menu_inbox4">
                    <div class="head_open_menu_contents_text">회사소개</div>
                    <div class="head_open_menu_contents_text">입점문의</div>
                    <div class="head_open_menu_contents_text">쇼핑몰신고</div>
                    <div class="head_open_menu_contents_text">입점안하면크롤링</div>
                </div>
            </div>
        </div>
        <ul class="head_category_990_hidden_tr">
            <li class="head_category_hidden_td1" onclick="page_move('http://49.247.136.36/main/main.php')">홈</li>
            <li class="head_category_hidden_td1" onclick="page_move('http://49.247.136.36/main/category.php?category1=NEW')">신상품</li>
            <li class="head_category_hidden_td2" onclick="page_move('http://49.247.136.36/main/category.php?category1=BEST')">인기상품</li>
        </ul>
        <ul class="head_category_990_hidden_tr last_hidden_tr">
            <li class="head_category_hidden_td1" onclick="page_move('http://49.247.136.36/main/category.php?category1=ITEM')">아이템</li>
            <li class="head_category_hidden_td1" onclick="page_move('http://49.247.136.36/main/store_main.php')">쇼핑몰</li>
            <li class="head_category_hidden_td2" onclick="page_move('http://49.247.136.36/main/search.php?search=검색')">검색</li>
        </ul>
    </div>
    <div class="head_fixed_margin"></div>
</body>
<script>
    var open_menu_running=false;

    $('.head_category_menu').click(function(){
        if(!open_menu_running){
            open_menu_running=true;
            if($('.head_open_menu_box').css("display")=='block'){
                $('.head_open_menu_box').fadeOut(200);
                $('.head_open_menu_box').fadeTo("fast",0);
                setTimeout(function() {
                    $('.head_open_menu_box').css("display","none");
                    open_menu_running = false;
                }, 300);
            }else{
                $('.head_open_menu_box').css("display","block");
                $('.head_open_menu_box').fadeIn(100);
                $('.head_open_menu_box').fadeTo("fast",1);
                setTimeout(function() {
                    open_menu_running = false;
                }, 200);

            }
        }
    });

    $('.go_predressing').click(function(){
        location.href="http://49.247.136.36/main/predressing.php";
    });
    // window.onload = function(){
    //     //화면의 높이와 너비를 구한다.
    //     setTimeout(function() {
    //         $('body').removeClass('no-js');
    //         $('body').fadeIn(500);
    //         $('body').fadeTo("slow",1);
    //     }, 100);
    // };
    function page_move(string)
    {
        // $('body').fadeOut(500);
        // $('body').fadeTo("slow",0);
        // setTimeout(function() {
        //     location.href=string;
        // }, 1200);
        location.href=string;
    }



    var scrollValue = -1; // 스크롤이 일어났는지 확인하기 위한 변수
    //FitMe버튼 클릭시 옷입히기 페이지를 새탭으로 생성
    $('#fitme_button').click(function(){
        window.open('/web/mainpage.php','FITME');
    });
    var rankfocus=false;    //실시간 순위부분이 활성화 되어있는지 확인 할 변수
    var width = screen.width-18;    //모니터 너비를 저장한 변수

    //검색 이미지 클릭시
    $('.search_enter').click(function(){
        location.href="http://49.247.136.36/main/search.php?search="+$('.search_text').val();
    });

    //검색input 엔터
    $('.search_text').keydown(function(key){
        if(key.keyCode==13)
        {
            location.href="http://49.247.136.36/main/search.php?search="+$('.search_text').val();
        }
    });

    //인터넷 창의 너비에 따라서 동작하는 조건 ( 크기가 작아지면 객체들이 겹치거나 보기좋지 않아서 몇가지 객체들을 숨겨줌 - 반대라면 보여줌 )
    $(window).resize(function(){
        //해쉬값에 open이 들어있으면 페이지 뒤로가기 기능 -> 실제로 뒤로가는것이 아닌 menu 의 open클래스가 삭제되면서 메뉴가 닫힘
        if (location.hash == "#open") {
            history.back();
        }
        if($(window).width()<974)
        {
            if(scrollValue!=-1)
            {
                //이미 스크롤 이벤트가 일어난 경우에는 media 쿼리로 카테고리 위치를 조절불가
                if(scrollValue>107)
                {
                    $('#head_category_place').css("top",$('#head_hidden_990').height()+"px");
                }
                else
                {
                    $('#head_category_place').css("top",(107+$('#head_hidden_990').height())-scrollValue+"px");
                }
            }
        }
        else  //화면 최대크기일 경우
        {
            if(scrollValue!=-1)
            {
                if(scrollValue>107)
                {
                    $('#head_category_place').css("top","0px");
                }
                else
                {
                    $('#head_category_place').css("top",107-scrollValue+"px");
                }
            }
        }
    });

    //상단 카테고리에 마우스를 올려두엇을 때의 이벤트 ( 모든 카테고리들을 보여주거나 숨김 )
    $('.navi').hover(function(){
        $('.category').css("display","block");
    },function(){
        $('.category').css("display","none");
    });

    //모든 카테고리가 보여질 경우 마우스를 올려두었을 때의 이벤트
    $('.category').hover(function(){
        $('.category').css("display","block");
    },function(){
        $('.category').css("display","none");
    });

    //화면 스크롤시 이벤트 ( 상단 카테고리가 화면 상단에 고정되도록 설정 )
    $(window).scroll(function () {
        scrollValue = $(document).scrollTop();
        if(scrollValue>107)
        {
            if($('#head_hidden_990').css("display")=="block")
            {
                $('#head_category_place').css("top",$('#head_hidden_990').height());
            }
            else
            {
                $('#head_category_place').css("top","0px");
            }
        }
        else
        {
            if($('#head_hidden_990').css("display")=="block")
            {
                $('#head_category_place').css("top",(107+$('#head_hidden_990').height())-scrollValue+"px");
            }
            else
            {
                $('#head_category_place').css("top",(107)-scrollValue+"px");
            }
        }
    });

    //슬라이드 메뉴 꺼내기
    //해쉬값에 open을 넣는다.
    $('.head_hidden_990_menu').click(function(){
        $("#head_menu,.head_page_cover,html").addClass("open");
        window.location.hash = "#open";
    });

    //해쉬값에 변경이 있을때(뒤로가기 버튼 등 ) -> 슬라이드 메뉴가 닫힘
    window.onhashchange = function () {
        if (location.hash != "#open") {
            $("#head_menu,.head_page_cover,html").removeClass("open");
        }
    };
</script>
</html>
