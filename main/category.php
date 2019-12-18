<!--카테고리 페이지 ( FitMe 메인페이지에서 카테고리 클릭시 이동되는 페이지-->
<?php
session_start();
//카테고리 2개를 GET 방식으로 받고 사용한다.
$category_1 = $_GET['category1'];
$category_2 = $_GET['category2'];
$page = $_GET['page'];
$option = $_GET['option'];
$myfit = $_GET['myfit'];
if(!$page)
{
    $page=1;
}
if(!$option)
{
    $option='new';
}
if(!$myfit)
{
    $myfit='false';
}

//DB에 저장된 카테고리를 먼저 불러온다.
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

//신상품, 가격순, 인기순 등 ( 넘겨받은 옵션이 없을 경우에는 신상품으로 -- 추후에 수정 - 아직은 고려하지 않음
if($category_1)
{
    if($category_2)
    {
        $qry = mysqli_query($connect,"select product_key, email, name, ex, price, main_image from product where category1='$category_1' and category2='$category_2'");
    }else
    {
        $qry = mysqli_query($connect,"select product_key, email, name, ex, price, main_image from product where category1='$category_1'");
    }
}else
{
    $qry = mysqli_query($connect,"select product_key, email, name, ex, price, main_image from product");
}

//추후에 이 이메일을 기준으로 쇼핑몰 이름을 찾아야 한다.
//페이징 처리
$product_key_array = array();
$shop_name = array();
$name = array();
$ex = array();
$price = array();
$main_image = array();
$page_data=$page-1;
$start_count=$page_data*20;
$finish_count=$start_count+20;
$count=0;
$all_count = mysqli_num_rows($qry);
$all_page = (int)($all_count/20);
$result_page = $all_count%20;
if($result_page>0)
{
    $all_page+=1;
}
while($row = mysqli_fetch_array($qry))
{
    if($count<$start_count)
    {
        $count++;
    }
    else
    {
        if($start_count<$finish_count)
        {
            array_push($product_key_array,$row['product_key']);
            array_push($shop_name,$row['email']);
            array_push($name,$row['name']);
            array_push($ex,$row['ex']);
            array_push($price,number_format($row['price']).'원');
            array_push($main_image,$row['main_image']);
            $start_count++;
            $count++;
        }
        else{
            break;
        }
    }
}
$_SESSION['URL'] = 'http://49.247.136.36/main/category.php?category1='.$category_1.'&category2='.$category_2;

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
    <link rel="stylesheet" type="text/css" href="./category.css">
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
    <div id="category_line"></div>
    <div id="category_left_box">
        <div class="categories_title">CATEGORIES</div>
        <div class="categories_contents">
            <div class="categories_contents_text"><a href="./category.php">전체</a></div>
        </div>
        <?php
        for($i=0;$i<count($category1);$i++)
        {?>
            <div class="categories_contents">
                <div class="categories_contents_text"><?php echo $category1[$i]?></div>
                <div class="categories_more"></div>
            </div>
            <div class="categories_contents_detail">
                <div class="add_category"><a href="./category.php?category1=<?php echo $category1[$i]?>">ALL</a></div>
                <?php
                for($count_d=0;$count_d<count(json_decode($category2[$i]));$count_d++)
                { ?>
                    <div class="add_category"><a href="./category.php?category1=<?php echo $category1[$i]?>&category2=<?php echo json_decode($category2[$i])[$count_d]?>"><?php echo json_decode($category2[$i])[$count_d]?></a></div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <div id="category_right_box">
        <div class="category_right_title">카테고리 -
            <?php if($category_1){
                echo $category_1;
                if($category_2){
                    echo ' - '.$category_2;
                }else{
                    echo ' - ALL';
                }
            }else {
                echo '전체';
            } ?></div>
        <div class="category_right_option_box">
            <div id="checkbox_box">
                <input type="checkbox" id="checkbox_myfit">
                <label for="checkbox_myfit">내 사이즈만 보기</label>
            </div>
            <select class="right_box_option_select">
                <option selected>최신순</option>
                <option>판매량순</option>
                <option>리뷰많은순</option>
                <option>낮은가격순</option>
            </select>
        </div>
        <div class="product_list">
            <?php
            if(count($name)<1)
            {?>
                <div class="nope_product">옷이 없습니다.</div>
            <?php }else
            {
            for($category_c=0;$category_c<count($name);$category_c++)
            {?>
                <ul class="category_product_detail_box">
                    <li class="category_thumbnail_box"><a href="./product.php?product=<?php echo $product_key_array[$category_c]?>"><img class="category_thumbnail_picture" src="<?php echo $main_image[$category_c];?>"></a></li>
                    <li class="category_shop_name"><?php echo $shop_name[$category_c]?></li>
                    <li class="category_product_name"><a href="./product.php?product=<?php echo $product_key_array[$category_c]?>"><?php echo $name[$category_c]?></a></li>
                    <li class="category_product_price"><?php echo $price[$category_c]?></li>
                </ul>
            <?php }
            }
            if($page<=$all_page&&$page>-1)
            {?>
                <div class="category_pagination">
                    <ul class="pagination justify-content-center">
                        <?php
                        if($page>1)
                        {?>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo ($page-1)?>"><</a></li>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo ($page-1)?>"><?php echo ($page-1)?></a></li>
                        <?php }
                        else{?>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo $page?>"><</a></li>
                        <?php }
                        ?>
                        <li class="page-item"><a class="page-link" style="cursor:pointer; background-color:black; color:white;"><?php echo $page;?></a></li>
                        <?php
                        if($all_page>$page)
                        {?>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo $page+1?>"><?php echo $page+1?></a></li>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo $page+1?>">></a></li>
                        <?php }else
                        {?>
                            <li class="page-item"><a class="page-link" href="./category.php?category1=<?php echo $category_1?>&category2=<?php echo $category_2?>&page=<?php echo $page?>">></a></li>
                        <?php }
                        ?>
                    </ul>
                </div>
            <?php }
            ?>
        </div>
    </div>
    <div class="category_center_footer"></div>
    <div id="footer"></div>
    <script>
        $('#footer').load("./foot.php");
    </script>
</body>
<script>
    //이전페이지에서 GET 방식으로 넘어온 카테고리를 확인한 뒤 페이지 좌측의 선택 카테고리 리스트에서 겹치는것을 확인한다.
    //만일 카테고리 리스트에서 GET 방식으로 넘어온 카테고리가 겹칠 경우 해당하는 카테고리의 상세 카테고리 목록을 펼쳐준다.
    //펼친 카테고리 목록중에서 GET 방식으로 넘어온 상세 카테고리와의 겹침을 추가로 확인한 뒤
    //상세 카테고리도 겹칠 경우에는 해당하는 텍스트의 굵기를 굵게 표기해준다.
    //만일 상세 카테고리 겹치지 않을 경우에는 ALL(전부 보기) 을 선택한다.
    for(var i=0;i<$('.categories_contents_text').length;i++){
        if($('.categories_contents_text').eq(i).text()=="<?php echo $category_1?>")
        {
            $('.categories_more').eq(i-1).css("background-image","url('../web/icon/collapse.png')");
            $('.categories_contents_detail').eq(i-1).css("display","block");
            var category2_true=0;
            for(var detail_c=0;detail_c<$('.categories_contents_detail').eq(i-1).children().length;detail_c++)
            {
                if("<?php echo $category_2?>"==$('.categories_contents_detail').eq(i-1).children().eq(detail_c).text())
                {
                    $('.categories_contents_detail').eq(i-1).children().eq(detail_c).css("font-weight","bold");
                    category2_true=1;
                }
                if((detail_c+1==$('.categories_contents_detail').eq(i-1).children().length)&&(category2_true==0))
                {
                    console.log(i);
                    $('.categories_contents_detail').eq(i-1).children().eq(0).css("font-weight","bold");
                }
            }
            break;
        }
    }

    //페이지 좌측의 카테고리 리스트중 한가지를 클릭했을 떄의 이벤트
    //이전에 펼쳐진 카테고리는 접어주고 클릭한 카테고리의 상세카테고리 목록을 펼쳐준다.
    $('.categories_contents').click(function(){
        $('.categories_contents_detail').css("display","none");
        var bool = false;
        if("url(\"http://49.247.136.36/web/icon/collapse.png\")"==$(this).children().eq(1).css("background-image"))
        {
            bool = false;
        }
        else
        {
            bool = true;
        }
        $('.categories_more').css("background-image","url('../web/icon/expand.png')");
        if(bool)
        {
            $(this).children().eq(1).css("background-image","url('../web/icon/collapse.png')");
        }
        var my_category = $(this).children().eq(0).text();
        for(var i=0;i<$('.categories_contents_text').length;i++)
        {
            if($('.categories_contents_text').eq(i).text()==my_category)
            {
                if("url(\"http://49.247.136.36/web/icon/expand.png\")"!=$(this).children().eq(1).css("background-image"))
                {
                    $('.categories_contents_detail').eq(i-1).css("display","block");
                }
            }
        }
    });
</script>
</html>
