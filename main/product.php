<!--제품 상세 페이지-->
<?php
session_start();
$top_image=array("./product_temp_image/1.jpg","./product_temp_image/2.jpg","./product_temp_image/3.jpg");   //DB에서 값을 불러와야함 ( 지금은 임시로 하드코딩 )
$product=$_GET['product']; //제품의 식별을 위해 이전 페이지에서 GET방식으로 제품 식별을 위한 값을 넘겨 받는다.
if(!$_SESSION['URL'])
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/product.php?product='.$product;//세션에 현재 페이지를 저장한다. ( 만일 로그인 시도가 일어날 경우에 되돌아 오기 위해 )
}
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from product where product_key='$product'");
$row = mysqli_fetch_array($qry);
//추후에 이메일을 상호명으로 바꿔야함
$shop_name = $row['email'];
$name = $row['name'];
$ex = $row['ex'];
$price = number_format($row['price']).' 원';
$size = json_decode($row['size'],true);
$size_key = array_keys($size);
$content = $row['content'];
$detail_image = json_decode($row['detail_image'],true);
$fitme_image = $row['fitme_image'];
$line_position = $row['line_position'];
$stock = $row['stock'];
$date = $row['date'];
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <script src="https://unpkg.com/swiper/js/swiper.js"></script>
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./product.css">
    <link rel="stylesheet" type="text/css" href="./head_foot.css">
    <title>FITME</title>
</head>
<body>
    <div id="fitme_button">
        <div id="fitme_button_text">FitMe</div>
        <div id="fitme_button_icon"></div>
    </div>
<div id="header"></div>
<script>
    $('#header').load("./head.php");
</script>
<div class="product_line"></div>
<div class="product_line"></div>
<div id="product_top_box">
    <div id="product_top_left">
        <?php if(count($detail_image)>1){
            for($image_count=0;$image_count<count($detail_image);$image_count++)
            {?>
                <div class="top_image" style="background-image:url('<?php echo $detail_image[$image_count];?>'); background-size:100% 100%;"></div>
                <div class="top_image_back" onclick="change_image(-1)">&#60;</div>
                <div class="top_image_next" onclick="change_image(1)">&#62;</div>
            <?php }
        }else{
            ?>
            <div class="top_image" style="background-image:url('<?php echo $detail_image[0];?>'); background-size:100% 100%;"></div>
            <div class="top_image_back" onclick="change_image(-1)" style='display:none'>&#60;</div>
            <div class="top_image_next" onclick="change_image(1)" style='display:none'>&#62;</div>
        <?php }?>
    </div>
    <div id="product_top_right">
        <div class="product_top_shop_name"><?php echo $shop_name?></div>
        <div class="product_top_name"><?php echo $ex?></div>
        <div class="product_top_price"><?php echo $price?></div>
        <div class="product_top_line"></div>
        <select class="product_top_color_select">
            <option selected>색상을 선택하세요</option>
            <option>BLACK</option>
            <option>NAVY</option>
            <option>CHECK</option>
        </select>
        <select class="product_top_size_select">
            <option selected>사이즈을 선택하세요</option>
            <?php
            for($i=0;$i<count($size["SIZE"]);$i++)
            {?>
                <option><?php echo $size["SIZE"][$i]?></option>
            <?php }
            ?>
        </select>
        <div class="product_top_select_box">

        </div>
        <div class="product_top_select_price">
            <h4 class="won">&nbsp;원</h4>
            <h4 class="price_number">&nbsp;0</h4>
            <h4>총 금액&nbsp;</h4>
        </div>
        <div class="product_top_buttons">
            <div class="product_fitme_button">입어보기</div>
            <div class="product_cart_button">장바구니</div>
            <div class="product_buy_button">바로구매</div>
            <div class="product_like_button">
                <div class="product_like_image"></div>
            </div>
        </div>
    </div>
</div>
<div id="product_center_category_box">
    <div class="product_center_category">상품정보</div>
    <div class="product_center_category">입어보기</div>
    <div class="product_center_category">리뷰</div>
    <div class="product_center_category">Q&A</div>
</div>
<div id="product_center_contents_box">
    <div class="product_center_contents">
        <div class="product_contents_table_box" style="width:100%; float:left; margin-bottom:60px;">
            <div class="product_size_table_text">제품 사이즈</div>
            <table class="contents_size_table">
                <thead>
                <?php
                for($i=0;$i<count($size_key);$i++)
                {?>
                    <td><?php echo $size_key[$i]?></td>
                <?php }
                ?>
                </thead>
                <tbody>
                <?php
                for($i=0;$i<count($size[$size_key[0]]);$i++)
                {?>
                    <tr>
                        <td class="table_size"><?php echo $size[$size_key[0]][$i]?></td>
                        <?php
                        for($ii=1;$ii<count($size_key);$ii++)
                        {?>
                            <td><?php echo $size[$size_key[$ii]][$i]?></td>
                        <?php }
                        ?>
                    </tr>
                <?php }
                ?>
                </tbody>
            </table>
        </div>
        <?php
        echo $content;
        ?>
    </div>
    <div class="product_center_contents">
        <div class="product_center_contents_select">
            입어보기 들어갈 공간
        </div>
    </div>
    <div class="product_center_contents">
        <div class="product_center_contents_select">
            <div class="product_contents_select_text">리뷰 0</div>
            <select class="product_contents_select_box">
                <option selected>전체</option>
                <option>포토리뷰</option>
                <option>텍스트리뷰</option>
            </select>
        </div>
        <div class="product_photo_review">
            <div class="product_photo_review_text">포토리뷰 0</div>
            <div class="product_photo_reviews">등록된 포토리뷰가 없습니다.</div>
        </div>
        <div class="product_text_review">
            <div class="product_text_review_text">텍스트리뷰 0</div>
            <div class="product_text_reviews">등록된 텍스트리뷰가 없습니다.</div>
        </div>
    </div>
    <div class="product_center_contents">
        <div class="product_contents_top_box">
            <div class="product_contents_top_text">Q&A 0</div>
            <div class="product_contents_top_button">문의 작성</div>
        </div>
        <table class="product_contents_qna_table">
            <thead>
                <td style="width:10%">답변상태</td>
                <td style="width:60%">내용</td>
                <td style="width:15%">작성자</td>
                <td style="width:15%">작성일</td>
            </thead>
        </table>
        <div class="none_qna">등록된 Q&A가 없습니다.</div>
    </div>
</div>
<!--<div id="product_center_box">sdf</div>-->
<div class="product_line"></div>
<div id="footer"></div>
<script>
    $('#footer').load("./foot.php");
</script>
</body>
<script>

    //최초에 선택된 카테고리이다. ( 상품정보 )  --> default 카테고리
    $('.product_center_category').eq(0).css({"border-bottom":"3px hotpink solid", "color":"hotpink", "font-size":"1.2vw"});
    //최초 선택된 카테고리에 맞게 내용을 보여준다 ( 상품정보 )
    $('.product_center_contents').eq(0).css("display","block");

    //각 카테고리를 클릭했을 때의 이벤트이다.
    $('.product_center_category').click(function(){
        $('.product_center_category').css({"border-bottom":"1px lightgrey solid", "color":"black", "font-size":"1vw"});    //카테고리들을 전부 초기화 시킨다. ( 밑줄&색상&크기 )
        $(this).css({"border-bottom":"3px hotpink solid", "color":"hotpink", "font-size":"1.2vw"}); //클릭한 카테고리의 디자인을 변경시킨다.
        $('.product_center_contents').css("display","none");    //카테고리 내용들을 전부 숨긴다.
        $('.product_center_contents').eq($(this).index()).css("display","block");   //클릭한 카테고리 인덱스 번호를 활용하여 카테고리에 맞는 내용을 보여준다.
    });

    //리뷰카테고리에서 select박스를 바꿨을 때 동작하는 함수이다. ( 전체를 클릭하면 포토리뷰, 텍스트리뷰가 전부 보인다. )
    $(".product_contents_select_box").change(function(){
        var option = $(".product_contents_select_box option:selected").text();
        $('.product_photo_review').css("display","block");
        $('.product_text_review').css("display","block");
        if("포토리뷰"==option)
        {
            $('.product_text_review').css("display","none");
        }
        else if("텍스트리뷰"==option)
        {
            $('.product_photo_review').css("display","none");
        }
    });


    //입어보기 버튼을 클릭시 입어보기 페이지가 생성
    $('.product_fitme_button').click(function(){
        window.open('/web/mainpage.php?product=<?php echo $product;?>');
    });
    var now_image=0; //현재 이미지 인덱스번호
    //페이지 최초 접근시 사진 바꾸는 버튼위치 선정
    var target = $('.top_image');//이미지슬라이드
    var size=null;//옵션1
    var color=null;//옵션2

    //이미지 슬라이드 내부에 이미지 변경 버튼의 위치를 설정 (최초 페이지 접근)
    var y = target.outerHeight(true)/2+(target.position().top+60)-($('.top_image_back').height()/2);
    $('.top_image_back').css({"top":y+"px", "left":(target.position().left)+"px"});
    var x = target.outerWidth()+(target.position().left)-($('.top_image_back').width());
    $('.top_image_next').css({"top":y+"px", "left":x+"px"});

    //이미지 슬라이드 내부에 이미지 변경 버튼의 위치를 설정 (인터넷창의 크기가 변할 경우)
    $(window).resize(function(){
        var target = $('.top_image');
        var y = target.outerHeight(true)/2+(target.position().top)-($('.top_image_back').height()/2);
        $('.top_image_back').css({"top":y+"px", "left":(target.position().left)+"px"});
        var x = target.outerWidth()+(target.position().left)-($('.top_image_back').width());
        $('.top_image_next').css({"top":y+"px", "left":x+"px"});
    });

    //이미지를 임시로 저장
    var my_image_array = new Array;
    my_image_array[0] = "<?php echo $top_image[0] ?>";
    my_image_array[1] = "<?php echo $top_image[1] ?>";
    my_image_array[2] = "<?php echo $top_image[2] ?>";

    //이미지 변경 버튼을 클릭한 경우
    function change_image(num)
    {
        now_image+=num;
        if(now_image<0)
        {
            now_image=2;
        }
        else if(now_image>2)
        {
            now_image=0;
        }
        $('.top_image').css("background-image","url('"+my_image_array[now_image]+"')");
    }
    //색상 드롭다운 선택이벤트
    $(".product_top_color_select").change(function(){
        color = $(".product_top_color_select option:selected").text();
        if(size){
            add_product(color,size);
            color=null;
            size=null;
            $(".product_top_color_select option:eq(0)").prop("selected",true);
            $(".product_top_size_select option:eq(0)").prop("selected",true);
        }
    });
    //사이즈 드롭다운 선택이벤트
    $(".product_top_size_select").change(function(){
        size = $(".product_top_size_select option:selected").text();
        if(color){
            add_product(color,size);
            color=null;
            size=null;
            $(".product_top_color_select option:eq(0)").prop("selected",true);
            $(".product_top_size_select option:eq(0)").prop("selected",true);
        }
    });
    //좋아요버튼 클릭이벤트
    $('.product_like_image').click(function(){
        console.log($('.product_like_image').css("background-image"));
        if($('.product_like_image').css("background-image")=="url(\"http://49.247.136.36/web/icon/heart_white.png\")"){
            $('.product_like_image').css("background-image","url('../web/icon/heart_red.png')");
        }else{
            $('.product_like_image').css("background-image","url('../web/icon/heart_white.png')");
        }
    });

    //아래는 옵션을 전부 선택했을 때 동적으로 선택 제품을 추가하는 함수
    function add_product(color, size)
    {
        var product_option = color+" / "+size;
        for(var item_count=0;item_count<$(".product_top_select_item").length;item_count++)
        {
            if(product_option==$(".product_select_item_option").eq(item_count).text()){ return; }
        }
        $(".product_top_select_box").append("<div class='product_top_select_item'><div class='product_select_item_option'>"+product_option+"</div><div class='product_select_item_drop' onclick='drop(this)'>X</div>" +
            "<div class='product_select_item_price'>171,000원</div><div class='product_select_item_button_box'><div class='product_decrease' onclick='decrease(this)'>-</div>" +
            "<div class='product_num'>1</div><div class='product_increase' onclick='increase(this)'>+</div></div></div>");
        total_price();
    }
    function drop(object)
    {
        var parents = $(object).parents(".product_top_select_item");
        parents.remove();
        total_price();
    }

    //아래는 선택한 제품의 수량을 증가시키는 함수 또는 감소시키는 함수
    var run_func=false;
    function decrease(object){
        if(!run_func)
        {
            run_func = true;
            var num = $($(object).parents(".product_select_item_button_box")).children(".product_num").text();
            if(num!=1)
            {
                num--;
                $($(object).parents(".product_select_item_button_box")).children(".product_num").text(num);
                var price = 171000*num;
                $($(object).parents(".product_select_item_button_box")).parents(".product_top_select_item").children(".product_select_item_price").text(comma(price)+"원");
                total_price();
            }
            run_func=false;
        }
    }
    function increase(object){
        if(!run_func)
        {
            run_func = true;
            var num = $($(object).parents(".product_select_item_button_box")).children(".product_num").text();
            num++;
            $($(object).parents(".product_select_item_button_box")).children(".product_num").text(num);
            var price = 171000*num;
            $($(object).parents(".product_select_item_button_box")).parents(".product_top_select_item").children(".product_select_item_price").text(comma(price)+"원");
            run_func=false;
            total_price();
        }
    }

    //선택한 제품의 전체 금액을 구하는 함수이다.
    function total_price()
    {
        var total_num=0;
        for(var i=0;i<$('.product_num').length;i++)
        {
            total_num+=parseInt($('.product_num').eq(i).text());
        }
        $('.price_number').text(comma(total_num*171000));
    }

    //세자리 단위마다 콤마를 찍는 함수
    function comma(num){
        var len, point, str;
        num = num + "";
        point = num.length % 3 ;
        len = num.length;
        str = num.substring(0, point);
        while (point < len) {
            if (str != "") str += ",";
            str += num.substring(point, point + 3);
            point += 3;
        }
        return str;
    }


</script>
</html>
