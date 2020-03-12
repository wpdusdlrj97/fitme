<!--카테고리 페이지 ( FitMe 메인페이지에서 카테고리 클릭시 이동되는 페이지-->
<?php
session_start();
//사용자의 검색어를 GET 방식으로 받고 사용한다.
$email=null;
$search=$_GET['search'];
if(!$search)
{
    Header("Location:/main/main.php");
}
else
{
    if($_SESSION['email'])
    {
        $email = $_SESSION['email'];
    }
    //DB에 저장된 카테고리를 먼저 불러온다.
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    $_SESSION['URL'] = 'http://49.247.136.36/main/search.php?search=';

    //사용자의 검색어로 DB를 조회한다.
    $qry = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%') order by date desc");
    $search_product_key = array();
    $search_product_shop = array();
    $search_product_name = array();
    $search_product_price = array();
    $search_product_image = array();
    $search_product_color = array();
    while($row = mysqli_fetch_array($qry))
    {
        $shop_email = $row['email'];
        $qry2 = mysqli_query($connect,"select name from shop_name where email='$shop_email'");
        $result = mysqli_fetch_array($qry2);
        array_push($search_product_key,$row['product_key']);
        array_push($search_product_shop,$result['name']);
        array_push($search_product_name,$row['name']);
        array_push($search_product_price,number_format($row['price']));
        array_push($search_product_image,$row['main_image']);
        array_push($search_product_color,json_decode($row['color'],true)['rgb']);
    }
    $qry = mysqli_query($connect,"select * from shop_name where name like '%$search%'");
    $shop_name_array = array();
    $shop_email_array = array();
    while($row = mysqli_fetch_array($qry))
    {
        array_push($shop_name_array,$row['name']);
        array_push($shop_email_array,$row['email']);
    }
    mysqli_close($connect);
}
?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <title>FITME</title>
    <style>
        body{ padding:0; margin:0; }
        #search_contents_box{ width:1300px; margin:0 auto; }
        .search_contents{ width:380px; margin:0 auto; padding:10px; }
        .search_contents_search_box{ width:100%; border:1px #BDBDBD solid; float:left; margin-top:80px; border-radius:3px; margin-bottom:80px; }
        .search_contents_search_img{ height:28px; width:30px; opacity:0.6; padding:10px 10px 10px 15px; cursor:pointer; float:left; }
        .search_contents_search_img:hover{ opacity:0.7; }
        .search_contents_search_input{ width:280px; height:45px; margin-top:2px; float:left;  font-size:17px; border:none; font-family: 'Noto Sans KR', sans-serif; }
        .search_contents_search_input:focus { outline: none; }
        .search_contents_search_click{ height:28px; width:30px; padding:10px 15px 10px 0; float:left; cursor:pointer; }
        .search_contents_category{ width:100%; height:39px; border-bottom:2px #D8D8D8 solid; float:left; margin-bottom:30px; margin-left:15px; font-family: 'Noto Sans KR', sans-serif; }
        .search_contents_category_product, .search_contents_category_shop{ color:#848484; height:39px; padding:0 15px 0 15px; margin-right:30px; float:left; line-height:45px; cursor:pointer; }
        .search_contents_category_product{ color:#2E2E2E; border-bottom:2px #2E2E2E solid; }
        .search_contents_category_text{ font-size:13px; font-family: 'Oswald', sans-serif; float:left; width:90%; margin-bottom:30px; margin-left:15px; color:#6E6E6E; }
        .search_contents_none_search{ float:left; width:100%; line-height:100px; text-align:center; font-family: 'Noto Sans KR', sans-serif; }
        .search_contents_product_box{ width:1270px; padding-left:15px; float:left; margin-top:30px; }
        .search_contents_product{ padding:10px; float:left; width:240px; margin-bottom:30px; font-family: 'Noto Sans KR', sans-serif; }
        .search_shop_and_color{ width:100%; float:left; margin-top:2px; margin-bottom:2px; margin-left:5px; }
        .search_shop_name{ font-size:12px; float:left; width:100%; margin-bottom:2px; cursor:pointer; font-weight:lighter; color:#424242; margin-left:5px; }
        .search_color_box{ float:left; height:12px; margin-bottom:3px; }
        .search_color_contents{ float:left; width:12px; height:12px; margin-right:0.4vw; }
        .search_product_image_box{ width:100%; height:300px; cursor:pointer; background-color:#F2F2F2; text-align:center; }
        .search_product_image{ max-width:100%; height:100%; }
        .search_product_name{ float:left; font-size:12px; text-align:left; margin-top:3px; margin-left:5px; overflow:hidden; height:32px; width:100%; margin-bottom:3px; cursor:pointer; font-weight:lighter; color:#424242; }
        .search_product_price{ float:left; font-size:12px; font-weight:lighter; margin-left:5px; color:#424242; }
        .search_shop_name:hover, .search_product_name:hover{ transition:all 200ms linear; color:#A4A4A4; }
        .search_product_image_box:hover{ transition:all 200ms linear; opacity:0.5; }
        .search_product_contents_box, .search_shop_contents_box{ width:100%; min-height:114px; float:left; margin-bottom:100px; }
        .search_hidden_shop_contents_box, .search_hidden_product_contents_box{ width:100%; min-height:114px; float:left; }
        .search_category_shop_box{ float:left; width:1270px; height:180px; margin-left:15px; margin-bottom:40px; cursor:pointer; }
        .search_category_shop_box:hover{ opacity: 0.7; transition:all 200ms linear; }
        .search_category_shop_profile_image{ float:left; width:160px; margin-top:10px; height:160px; overflow:hidden; background-image:url('https://image.brandi.me/seller/lookast_profile_1572921630.jpg'); background-size:100% 100%; }
        .search_category_shop_text{ float:left; margin-left:20px; }
        .search_category_shop_name{ font-family: 'Oswald', sans-serif; font-size:22px; }
        .search_category_shop_ex{ font-family: 'Oswald', sans-serif; font-size:13px; }
        .search_category_shop_tag{ color:#BDBDBD; font-size:14px; }
        @media (max-width:1320px)
        {
            #search_contents_box{ width:100%; }
        }
        /*상품 3개씩 보여주기*/
        @media (max-width:990px)
        {
            .search_category_shop_name{margin-top:70px; margin-bottom:30px;}
            .search_category_shop_ex{display:none}
            .search_category_shop_profile_image{border-radius: 100%;}
        }
        /*상품 2개씩 보여주기*/
        @media (max-width:520px)
        {

        }
    </style>
</head>
<body>
<div id="header"></div>
<script>
    $('#header').load("./head.php");
</script>
<div id="search_contents_box">
    <div class="search_contents">
        <div class="search_contents_search_box">
            <img class="search_contents_search_img" src="/web/icon/search.png">
            <input class="search_contents_search_input" type="text" placeholder="검색">
            <div class="search_contents_search_click"></div>
        </div>
    </div>
    <div class="search_contents_category">
        <div class="search_contents_category_product" onclick="change_shop_product_list(1);">상품</div>
        <div class="search_contents_category_shop" onclick="change_shop_product_list(2);">쇼핑몰</div>
    </div>
    <div class="search_contents_category_text"><?php echo count($search_product_key)?> Search products </div>
    <div class="search_product_contents_box" style="display:block">
        <div class="search_hidden_product_contents_box">
            <?php if(count($search_product_key)<1){ ?>
                <div class="search_contents_none_search">검색된 상품이 없습니다.</div>
            <?php }?>
            <div class="search_contents_product_box">
                <?php for($product_count=0;$product_count<count($search_product_key);$product_count++){?>
                    <div class="search_contents_product">
                        <div class="search_product_image_box">
                            <img class="search_product_image" onclick="location.href='/main/product.php?product=<?php echo $search_product_key[$product_count]?>'" src="<?php echo $search_product_image[$product_count]?>">
                        </div>
                        <div class="search_shop_and_color">
                            <div class="search_color_box">
                                <?php for($color_count=0;$color_count<count($search_product_color[$product_count]);$color_count++){?>
                                    <div class="search_color_contents" style="background:<?php echo $search_product_color[$product_count][$color_count]?>"></div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="search_shop_name"><?php echo $search_product_shop[$product_count]?></div>
                        <div class="search_product_name" onclick="location.href='/main/product.php?product=<?php echo $search_product_key[$product_count]?>'"><?php echo $search_product_name[$product_count]?></div>
                        <div class="search_product_price"><?php echo $search_product_price[$product_count]?> Won</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <div class="search_shop_contents_box" style="display:none;">
        <div class="search_hidden_shop_contents_box">
            <?php if(count($shop_name_array)<1){ ?>
                <div class="search_contents_none_search">검색된 쇼핑몰이 없습니다.</div>
            <?php }else{ for($shop_count=0;$shop_count<count($shop_name_array);$shop_count++){?>
                <div class="search_category_shop_box">
                    <div class="search_category_shop_profile_image"></div>
                    <div class="search_category_shop_text">
                        <p class="search_category_shop_name"><?php echo $shop_name_array[$shop_count]?></p>
                        <p class="search_category_shop_ex">다양한 19 F/W 인기상품을 단독 최대 56% 할인율로 만나보세요!<br>브랜드 연합 시즌오프 기획전입니다.<br>레이쿠,코싸,지미코브리코,이치니,한량,크레이마의 인기 상품을 최대 66% 할인된 가격에 만나보세요. </p>
                        <p class="search_category_shop_tag">#트레이닝&nbsp;&nbsp;#인기&nbsp;&nbsp;#데일리&nbsp;&nbsp;#데이트&nbsp;&nbsp;#겨울</p>
                    </div>
                </div>
            <?php }}?>
        </div>
    </div>
</div>
<div id="footer"></div>
<script>
    $('#footer').load("./foot.php");
</script>
</body>
<script>

    var show_mylist = 1;
    //목록 변경될 때
    function change_shop_product_list(numb)
    {
        if(show_mylist!=numb)
        {
            if(numb==1)
            {
                $('.search_shop_contents_box').css("display","none");
                $('.search_product_contents_box').css("display","block");
                $('.search_contents_category_product').css({
                    "color":"#2E2E2E",
                    "border-bottom":"2px #2E2E2E solid"
                });
                $('.search_contents_category_shop').css({
                    "color":"#848484;",
                    "border-bottom":"none"
                });
                $('.search_contents_category_text').text("<?php echo count($search_product_key)?> Search products");
            }
            else
            {
                $('.search_product_contents_box').css("display","none");
                $('.search_shop_contents_box').css("display","block");
                $('.search_contents_category_shop').css({
                    "color":"#2E2E2E",
                    "border-bottom":"2px #2E2E2E solid"
                });
                $('.search_contents_category_product').css({
                    "color":"#848484;",
                    "border-bottom":"none"
                });
                $('.search_contents_category_text').text("<?php echo count($shop_name_array)?> Search shops");
            }
            show_mylist=numb;
        }
    }

    //검색창이 포커스를 얻을 때
    $('.search_contents_search_input').focus(function(){
        $('.search_contents_search_box').css({"border":"1px #585858 solid","transition":"all 200ms linear"})
    });

    //검색창이 포커스를 벗어날 때
    $('.search_contents_search_input').blur(function(){
        $('.search_contents_search_box').css({"border":"1px #BDBDBD solid","transition":"all 200ms linear"})
    });
    //검색창이 포커스를 얻게 하기
    $('.search_contents_search_click').click(function(){
        $('.search_contents_search_input').focus();
    });

    //검색 이미지 클릭시
    $('.search_contents_search_img').click(function(){
        location.href="http://49.247.136.36/main/search.php?search="+$('.search_contents_search_input').val();
    });

    //검색input 엔터
    $('.search_contents_search_input').keydown(function(key){
        if(key.keyCode==13)
        {
            location.href="http://49.247.136.36/main/search.php?search="+$('.search_contents_search_input').val();
        }
    });

    //최초 페이지 접근시
    if($(window).width()<1280)
    {
        $('.search_category_shop_box').css("width",$(window).width()-30);
        $('.search_contents_category').css("width",$(window).width()-47);
        $('.search_contents_product_box').css("width",($(window).width()-17));
        if($(window).width()<=973)
        {
            if($(window).width()<=503)
            {
                $('.search_contents_product').css("width",($('.search_contents_product_box').width()/2-25));
            }
            else
            {
                $('.search_contents_product').css("width",($('.search_contents_product_box').width()/3-25));
            }
        }
        else
        {
            $('.search_contents_product').css("width",($('.search_contents_product_box').width()/5-25));
        }
        $('.search_product_image_box').css("height",($('.search_contents_product').width()/4*5));
    }
    else if($(window).width()>=1300)
    {
        $('.search_contents_product_box').css("width","1270px");
        $('.search_contents_product').css("width",($('.search_contents_product_box').width()/5-25));
        $('.search_product_image_box').css("height",($('.search_contents_product').width()/4*5));
    }

    //옷 목록을 반응형으로 제작
    $(window).resize(function(){
        if($(window).width()<1280)
        {
            $('.search_category_shop_box').css("width",$(window).width()-30);
            $('.search_contents_category').css("width",$(window).width()-30);
            $('.search_contents_product_box').css("width",($(window).width()-17));
            if($(window).width()<=973)
            {
                if($(window).width()<=503)
                {
                    $('.search_contents_product').css("width",($('.search_contents_product_box').width()/2-25));
                }
                else
                {
                    $('.search_contents_product').css("width",($('.search_contents_product_box').width()/3-25));
                }
            }
            else
            {
                $('.search_contents_product').css("width",($('.search_contents_product_box').width()/5-25));
            }
            $('.search_product_image_box').css("height",($('.search_contents_product').width()/4*5));
        }
        else if($(window).width()>=1280)
        {
            $('.search_contents_product_box').css("width","1270px");
            $('.search_contents_product').css("width",($('.search_contents_product_box').width()/5-25));
            $('.search_product_image_box').css("height",($('.search_contents_product').width()/4*5));
        }
    });










    //정렬 옵션이 바뀌었을 때의 이벤트
    $('.search_product_box_option_select').change(function(){
        $('.search_product_detail_box').remove();
        $('.search_count2').text('0');
        $('.search_contents_box').append("<div class='loader loader-default is-active' data-text='잠시 기다려주세요' data-blink ></div>");
        var option = $('.search_product_box_option_select').val();
        $.ajax({
            type:"GET",
            url:"/for_mobile/product_option.php",
            data : {'search':'<?php echo $search?>','option':option},
            dataType : "text",
            success: function(string){
                //반환된 문자열은 json형태의 데이터가 들어있음 -> 쪼개서 나온 개수만큼 노드 생성
                if(string!='failed')
                {
                    var result_data = JSON.parse(string);
                    for(var result_count=0;result_count<result_data['search_product_key'].length;result_count++)
                    {
                        var append_data = "<ul class='search_product_detail_box'>";
                        append_data+="<li class='search_thumbnail_box'><a href='./product.php?product="+result_data['search_product_key'][result_count]+"'><img class='search_thumbnail_picture' src='"+result_data['search_product_image'][result_count]+"'></a></li>";
                        append_data+="<li class='search_color_box'>";
                        for(var color_count=0;color_count<result_data['search_product_color'][result_count].length;color_count++)
                        {
                            append_data+="<div class='search_color_content' style='background-color:"+result_data['search_product_color'][result_count][color_count]+"'></div>";
                        }
                        append_data+="</li><li class='search_product_shop_name'>"+result_data['search_product_shop'][result_count]+"</li>";
                        append_data+="<li class='search_product_name'><a href='./product.php?product="+result_data['search_product_key'][result_count]+"'>"+result_data['search_product_name'][result_count]+"</a></li>";
                        append_data+="<li class='search_product_price'>"+result_data['search_product_price'][result_count]+"</li></ul>";
                        $('.search_product_list').append(append_data);
                    }
                    $('.loader-default').remove();
                    console.log(result_data);
                }
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    });
</script>
</html>
