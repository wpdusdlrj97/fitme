<!--카테고리 페이지 ( FitMe 메인페이지에서 카테고리 클릭시 이동되는 페이지-->
<?php
session_start();
//카테고리 2개를 GET 방식으로 받고 사용한다.
$email=null;
if($_SESSION['email'])
{
    $email = $_SESSION['email'];
}
$category_1 = $_GET['category1'];
$category_2 = $_GET['category2'];

//DB에 저장된 카테고리를 먼저 불러온다.
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from category where name='$category_1'");
$category2 = array();
$row = mysqli_fetch_array($qry);
$category2 = json_decode($row['detail_category'],true);


//신상품, 가격순, 인기순 등 ( 넘겨받은 옵션이 없을 경우에는 신상품으로 -- 추후에 수정 - 아직은 고려하지 않음
if($category_1)
{
    if($category_2)
    {
        $qry = mysqli_query($connect,"select product_key, email, name, price, main_image, color from product where category1='$category_1' and category2='$category_2' order by date desc");
    }else
    {
        $qry = mysqli_query($connect,"select product_key, email, name, price, main_image, color from product where category1='$category_1' order by date desc");
    }
}else
{
    echo '<script>history.go(-1);</script>';
}

//추후에 이 이메일을 기준으로 쇼핑몰 이름을 찾아야 한다.
//페이징 처리
$product_key_array = array();
$shop_name = array();
$name = array();
$price = array();
$likes = array();
$main_image = array();
$color_rgb = array();
while($row = mysqli_fetch_array($qry))
{
    $key = $row['product_key'];
    array_push($product_key_array,$key);
    $shop_names = $row['email'];
    $get_shop_name = mysqli_query($connect,"select * from shop_name where email='$shop_names'");
    $result_shop_name = mysqli_fetch_array($get_shop_name);
    array_push($shop_name,$result_shop_name['name']);
    array_push($name,$row['name']);
    array_push($price,number_format($row['price']));
    array_push($main_image,$row['main_image']);
    array_push($color_rgb,json_decode($row['color'],true)['rgb']);
    if($email)
    {
        $qry_for_likes = mysqli_query($connect,"select * from likes where product_key = $key and email='$email'");
        $result_for_likes = mysqli_fetch_array($qry_for_likes);
        if($result_for_likes)
        {
            array_push($likes,'1');
        }
        else
        {
            array_push($likes,'0');
        }
    }
    else
    {
        array_push($likes,'0');
    }
}
mysqli_close($connect);
$_SESSION['URL'] = 'http://49.247.136.36/main/category.php?category1='.$category_1.'&category2='.$category_2;
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <script src="/api/swiper.js"></script>
    <script src="/api/swiper.min.js"></script>
    <title>FITME</title>
    <style>
        body{ padding:0; margin:0; -ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none; }
        #contents_box{  margin:0 auto; width:1300px; }
        .center_contents_box{ width:100%; float:left; font-family: 'Oswald', sans-serif; letter-spacing: 1.15px; color:#585858; }
        .category1_name{ margin-top:50px; font-size:22px; text-align:left; float:left; cursor:pointer; padding-left:15px; }
        .category2_box{ float:left; font-size:13px; width:100%; overflow:hidden }
        .category2_name{ float:left; cursor:pointer; padding:15px 30px 15px 15px; background:#F2F2F2; overflow:hidden; }
        .category1_name:hover, .category2_name:hover{ transition:all 200ms linear; font-weight:bold; }
        .category2_990fix_hidden_table{ width:80%; display:none; float:left; margin-left:10%; }
        .category2_990fix_hidden_td{ height:50px; line-height:50px; cursor:pointer; background:#F2F2F2; text-align: center; font-size:14px; overflow:hidden; }
        .category2_990fix_hidden_td:hover{ transition:all 200ms linear; font-weight:bold; }
        .category_none_place{ width:100%; float:left; margin-top:15px; margin-bottom:15px; }
        .category_count_sort_box{ float:left; width:100%; margin-top:30px; margin-bottom:20px; }
        .products_count{ font-size:12px; float:left; padding-left:15px; line-height:20px; }
        .products_sort1{ float:right; font-size:12px; line-height:50px; height:50px; margin-right:30px; margin-top:15px; cursor:pointer; z-index:2; }
        .products_sort2{ float:right; font-size:12px; line-height:50px; height:50px; margin-right:15px; margin-top:15px; cursor:pointer; z-index:2; }
        .products_mysize{ float:right; font-size:12px; line-height:50px; margin-right:2vw; margin-top:15px; cursor:pointer; font-weight:bold; z-index:2; }
        #checkbox_myfit{ float:left; margin-top:16px; width:18px; height:18px; margin-right:5px; }
        .products_sort1:hover, .products_sort2:hover{ transition:all 200ms linear; font-weight:bold; }
        .nope_product{ width:100%; height:100%; line-height:360px; font-size:16px; text-align:center; }
        .category_contents_product_box{ width:1270px; padding-left:15px; float:left; margin-top:30px; }
        .category_contents_product{ padding:10px; float:left; width:240px; margin-bottom:30px; font-family: 'Noto Sans KR', sans-serif; }
        .category_shop_and_color{ width:100%; float:left; margin-top:2px; margin-bottom:2px; margin-left:5px; }
        .category_shop_name{ font-size:12px; float:left; width:100%; margin-bottom:2px; cursor:pointer; font-weight:lighter; color:#424242; margin-left:5px; }
        .category_color_box{ float:left; height:12px; margin-bottom:3px; }
        .category_color_contents{ float:left; width:12px; height:12px; margin-right:0.4vw; }
        .category_product_image_box{ width:100%; height:300px; cursor:pointer; background-color:#F2F2F2; }
        .category_product_image{ max-width:100%; height:100%; margin-left:auto; margin-right:auto; display:block; }
        .category_product_name{ float:left; font-size:12px; text-align:left; margin-top:3px; margin-left:5px; overflow:hidden; height:32px; width:100%; margin-bottom:3px; cursor:pointer; font-weight:lighter; color:#424242; }
        .category_product_price{ float:left; font-size:12px; font-weight:lighter; margin-left:5px; color:#424242; }
        .category_shop_name:hover, .category_product_name:hover{ transition:all 200ms linear; color:#A4A4A4; }
        .category_product_image_box:hover{ transition:all 200ms linear; opacity:0.5; }
        @media (max-width:1320px)
        {
            #contents_box{ width:100%; }
            .category_contents_product_box{ width:100%; }
            .category_shop_name{ font-size:0.9vw; }
            .category_product_name{ font-size:0.9vw; }
            .category_color_box{ height:0.9vw; }
            .category_color_contents{ width:0.9vw; height:0.9vw; }
        }
        /*상품 3개씩 보여주기*/
        @media (max-width:990px)
        {
            .category1_name{ width:100%; margin-top:50px; font-size:25px; text-align:center; padding:0; }
            .category2_990fix_hidden_table{ display:block; }
            .category2_990fix_hidden_td{ font-size:1vw; }
            .category2_box{ display:none; }
            .products_count{ font-size:13px; }
            .products_sort1, .products_sort2{ font-size:14px; }
            .category_shop_name{ font-size:1.2vw; }
            .category_product_name{ font-size:1.2vw; }
            .category_color_box{ height:1.2vw; }
            .category_color_contents{ width:1.2vw; height:1.2vw; }
        }
        /*상품 2개씩 보여주기*/
        @media (max-width:520px)
        {
            .category2_990fix_hidden_table{ width:98%; margin-left:1%; }
            .category2_990fix_hidden_td{ font-size:8px; }
            .category_shop_name{ font-size:1.8vw; }
            .category_product_name{ font-size:1.8vw; }
            .category_color_box{ height:1.8vw; }
            .category_color_contents{ width:1.8vw; height:1.8vw; }
            .products_sort2{ margin-right:7px; }
            .products_sort1, .products_sort2{ font-size:12px; }
            .products_count{ width:90%; text-align:center; }
        }
    </style>
</head>
<body>
<div id="header"></div>
<script>
    $('#header').load("./head.php");
</script>
<div id="contents_box">
    <div class="center_contents_box">
        <div class="category1_name"><?php echo $category_1?> <?php if($category_2){ echo '-'.$category_2; }?></div>
        <div class="category_none_place"></div>
        <div class="category2_990fix_hidden_table">
            <?php for($category_count=0;$category_count<count($category2);$category_count++){ if($category_count==0&&($category_1!='NEW'||$category_1!='BEST')){?>
                <div class="category2_990fix_hidden_td" style="width:<?php echo (100/(count($category2)+1));?>%; float:left; <?php if($category_2){  }else{?> font-weight:bold; <?php }?>" onclick="change_page()">ALL</div>
            <?php }?>
                <div class="category2_990fix_hidden_td" style="width:<?php echo (100/(count($category2)+1));?>%; float:left; <?php if($category_2==$category2[$category_count]){?> font-weight:bold; <?php }?>" onclick="change_page('<?php echo $category2[$category_count]?>')"><?php echo $category2[$category_count]?></div>
            <?php }?>
        </div>
        <div class="category2_box">

            <?php for($category_count=0;$category_count<count($category2);$category_count++){ if($category_count==0&&($category_1!='NEW'||$category_1!='BEST')){?>
                <div class="category2_name" style="<?php if($category_2){  }else{?> font-weight:bold; <?php }?>" onclick="change_page()">ALL</div>
            <?php }?>
                <div class="category2_name" style="<?php if($category_2==$category2[$category_count]){?> font-weight:bold; <?php }?>" onclick="change_page('<?php echo $category2[$category_count]?>')"><?php echo $category2[$category_count]?></div>
            <?php }?>
        </div>
        <div class="category_count_sort_box">
            <div class="products_count"><?php echo count($product_key_array);?> products</div>
            <div class="products_sort1" onclick="change_sort(this)">낮은가격순</div>
            <div class="products_sort2" onclick="change_sort(this)">리뷰많은순</div>
            <div class="products_sort2" onclick="change_sort(this)">인기순</div>
            <div class="products_sort2" onclick="change_sort(this)" style="font-weight:bold;">최신순</div>
            <div class="products_mysize">
                <input type="checkbox" id="checkbox_myfit">
                <label for="checkbox_myfit">Mysize</label>
            </div>
        </div>
        <div class="category_product_contents_box" style="width:100%; min-height:418px; float:left; margin-bottom:100px; ">
            <?php if(count($product_key_array)<1){ ?>
                <div class="nope_product">상품이 없습니다.</div>
            <?php }?>
            <div class="category_contents_product_box">
                <?php for($product_count=0;$product_count<count($product_key_array);$product_count++){?>
                    <div class="category_contents_product">
                        <div class="category_product_image_box">
                            <img class="category_product_image" onclick="location.href='/main/product.php?product=<?php echo $product_key_array[$product_count]?>'" src="<?php echo $main_image[$product_count]?>">
                        </div>
                        <div class="category_shop_and_color">
                            <div class="category_color_box">
                                <?php for($color_count=0;$color_count<count($color_rgb[$product_count]);$color_count++){?>
                                    <div class="category_color_contents" style="background:<?php echo $color_rgb[$product_count][$color_count]?>"></div>
                                <?php }?>
                            </div>
                        </div>
                        <div class="category_shop_name"><?php echo $shop_name[$product_count]?></div>
                        <div class="category_product_name" onclick="location.href='/main/product.php?product=<?php echo $product_key_array[$product_count]?>'"><?php echo $name[$product_count]?></div>
                        <div class="category_product_price"><?php echo $price[$product_count]?> Won</div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div id="footer"></div>
<script>
    $('#footer').load("./foot.php");
</script>
</body>
<script>

    var sort='최신순';//정렬기준 default 값
    var category1='<?php echo $category_1?>';
    var category2='<?php echo $category_2?>';

    function change_page(string)
    {
        if(string)
        {
            location.href="/main/category.php?category1="+category1+"&category2="+string;
        }
        else
        {
            location.href="/main/category.php?category1="+category1;
        }
    }

    //최초 페이지 접근시
    if($(window).width()<1280)
    {
        $('.category_contents_product_box').css("width",($(window).width()-17));
        if($(window).width()<=973)
        {
            if($(window).width()<=503)
            {
                $('.category_contents_product').css("width",($('.category_contents_product_box').width()/2-25));
            }
            else
            {
                $('.category_contents_product').css("width",($('.category_contents_product_box').width()/3-25));
            }
        }
        else
        {
            $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
        }
        $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
    }
    else if($(window).width()>=1280)
    {
        $('.category_contents_product_box').css("width","1270px");
        $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
        $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
    }

    //옷 목록을 반응형으로 제작
    $(window).resize(function(){
        if($(window).width()<1280)
        {
            $('.category_contents_product_box').css("width",($(window).width()-17));
            if($(window).width()<=973)
            {
                if($(window).width()<=503)
                {
                    $('.category_contents_product').css("width",($('.category_contents_product_box').width()/2-25));
                }
                else
                {
                    $('.category_contents_product').css("width",($('.category_contents_product_box').width()/3-25));
                }
            }
            else
            {
                $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
            }
            $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
        }
        else if($(window).width()>=1280)
        {
            $('.category_contents_product_box').css("width","1270px");
            $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
            $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
        }
    });

    //정렬기준 변경시
    function change_sort(object)
    {
        if(sort!=$(object).text())
        {
            // 다른 정렬기준을 클릭했을 때
            $('.products_sort1').css("font-weight","normal");
            $('.products_sort2').css("font-weight","normal");
            $(object).css({"transition":"all 200ms linear","font-weight":"bold"});
            sort = $(object).text();
            $('.category_contents_product_box').fadeOut(300);
            $('.category_contents_product_box').fadeTo("slow",0);
            setTimeout(function() {
                $('.category_contents_product').remove();
                $.ajax({
                    type:"GET",
                    url:"/for_mobile/product_option.php",
                    data : {'option':sort,'category1':category1,'category2':category2},
                    dataType : "text",
                    success: function(string){
                        //반환된 문자열은 json형태의 데이터가 들어있음 -> 쪼개서 나온 개수만큼 노드 생성
                        if(string!='failed')
                        {
                            var result_data = JSON.parse(string);
                            for(var result_count=0;result_count<result_data['product_key'].length;result_count++)
                            {
                                var append_data = "<div class='category_contents_product'>";
                                append_data+="<div class='category_product_image_box'><img class='category_product_image' onclick=\"location.href='/main/product.php?product="+result_data['product_key'][result_count]+"'\" src='"+result_data['product_image'][result_count]+"'></div>";
                                append_data+="<div class='category_shop_and_color'>";
                                append_data+="<div class='category_color_box'>";
                                for(var color_count=0;color_count<result_data['product_color'][result_count].length;color_count++)
                                {
                                    append_data+="<div class='category_color_contents' style='background:"+result_data['product_color'][result_count][color_count]+"'></div>";
                                }
                                append_data+="</div></div><div class='category_shop_name'>"+result_data['product_shop'][result_count]+"</div>";
                                append_data+="<div class='category_product_name' onclick=\"location.href='/main/product.php?product="+result_data['product_key'][result_count]+"'\">"+result_data['product_name'][result_count]+"</div>";
                                append_data+="<div class='category_product_price'>"+result_data['product_price'][result_count]+" Won</div></div>";
                                $('.category_contents_product_box').append(append_data);
                            }
                            if($(window).width()<1280)
                            {
                                $('.category_contents_product_box').css("width",($(window).width()-17));
                                if($(window).width()<=973)
                                {
                                    if($(window).width()<=503)
                                    {
                                        $('.category_contents_product').css("width",($('.category_contents_product_box').width()/2-25));
                                    }
                                    else
                                    {
                                        $('.category_contents_product').css("width",($('.category_contents_product_box').width()/3-25));
                                    }
                                }
                                else
                                {
                                    $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
                                }
                                $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
                            }
                            else if($(window).width()>=1280)
                            {
                                $('.category_contents_product_box').css("width","1270px");
                                $('.category_contents_product').css("width",($('.category_contents_product_box').width()/5-25));
                                $('.category_product_image_box').css("height",($('.category_contents_product').width()/4*5));
                            }
                            setTimeout(function() {
                                $('.category_contents_product_box').fadeIn(400);
                                $('.category_contents_product_box').fadeTo("slow",1);
                            }, 500);
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            }, 400);
        }
    }
</script>
</html>
