<!--카테고리 페이지 ( FitMe 메인페이지에서 카테고리 클릭시 이동되는 페이지-->
<?php
session_start();


//DB에 저장된 카테고리를 먼저 불러온다.
$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe');
mysqli_set_charset($connect, 'utf8');
$qry = mysqli_query($connect, "select * from category");
$category1 = array();
$category2 = array();
while ($row = mysqli_fetch_array($qry)) {
    array_push($category1, $row['name']);
    array_push($category2, $row['detail_category']);
}


$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/cart/main.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}


//쇼핑몰 입점 신청 대기 관련 쿼리
//입점 신청 대기는 오래된 순으로 정렬 (빠른 처리를 위해)
$query_cart = "SELECT * FROM mycart ORDER BY id";
$result_cart = mysqli_query($connect, $query_cart);
$total_cart = mysqli_num_rows($result_cart);

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jua&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="http://49.247.136.36/api/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="http://49.247.136.36/main/category.css">
    <link rel="stylesheet" type="text/css" href="http://49.247.136.36/main/head_foot.css">
    <link rel="stylesheet" type="text/css" href="http://49.247.136.36/main/head_foot.css">
    <link rel="stylesheet" href="http://49.247.136.36/api/css-loader.css">
    <title>FITME</title>
</head>
<style>
    #customers {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td, #customers th {
        border-: 1px solid #ddd;
        text-align: center;
        padding: 5px;
    }

    #customers tr:nth-child(even) {
        background-color: #ffffff;
    }


    #customers th {
        padding-top: 5px;
        padding-bottom: 5px;
        background-color: white;
        color: #000000;
    }
    .button {
        background-color: #000000;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 12px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 10px;
    }
</style>
<!-- 숫자를 증가시키는 자바스크립트-->
<script language='javascript'>
    function product_count(num)
    {
        var form  = document.form;


        // count는 상품 수량을 뜻한다
        var count = Number(form.count.value) + num;
        if(count < 1) count = 1;
        form.count.value = count;


        // price는 단일 상품 가격을 뜻한다
        var price_hidden = form.price_hidden.value;


        // sum_number_without_comma는 상품 합계액을 뜻한다  (상품 수량 X 상품 금액)
        // 아직 콤미(,) 적용 전단계
        var sum_number_without_comma = Number(form.count.value) * Number(price_hidden);

        function addComma(num) {
            var regexp = /\B(?=(\d{3})+(?!\d))/g;
            return num.toString().replace(regexp, ',');
        }

        form.sum.value = addComma(sum_number_without_comma);


    }

    function plus(num)
    {

        var count = document.getElementById('price_'+num);


    }


</script>



<body>
<!-- Loader -->
<div class="loader loader-default"></div>
<!-- Loader active -->
<div class="loader loader-default is-active" data-text="잠시 기다려주세요" data-blink></div>
</div>
<div id="fitme_button">
    <div id="fitme_button_text">FitMe</div>
    <div id="fitme_button_icon"></div>
</div>
<div id="header"></div>
<script>
    $('#header').load("http://49.247.136.36/main/head.php");
</script>
<div id="category_line"></div>
<div id="category_left_box">
    <div class="categories_title">CATEGORIES</div>
    <div class="categories_contents">
        <div class="categories_contents_text"><a href="http://49.247.136.36/main/category.php">전체</a></div>
    </div>
    <?php
    for ($i = 0; $i < count($category1); $i++) {
        ?>
        <div class="categories_contents">
            <div class="categories_contents_text"><?php echo $category1[$i] ?></div>
            <div class="categories_more"></div>
        </div>
        <div class="categories_contents_detail">
            <div class="add_category"><a
                        href="http://49.247.136.36/main/category.php?category1=<?php echo $category1[$i] ?>">ALL</a>
            </div>
            <?php
            for ($count_d = 0; $count_d < count(json_decode($category2[$i])); $count_d++) { ?>
                <div class="add_category"><a
                            href="http://49.247.136.36/main/category.php?category1=<?php echo $category1[$i] ?>&category2=<?php echo json_decode($category2[$i])[$count_d] ?>"><?php echo json_decode($category2[$i])[$count_d] ?></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div id="category_right_box">
    <div class="category_right_title"> 장바구니</div>

    <div class="product_list">
        <br><br><br>
        <form name='form'>
        <table id="customers">
            <tr style="border: 1px solid #ddd;">
                <th><input type="checkbox" name="chk_info" value="HTML"></th>
                <th>이미지</th>
                <th>상품명/옵션</th>
                <th>판매가</th>
                <th>수량</th>
                <th>합계</th>
                <th>배송비</th>
                <th>삭제</th>

            </tr>
            <tbody style="border: 1px solid #ddd;">

            <?php
            while ($row_cart = mysqli_fetch_assoc($result_cart)) { //DB에 저장된 데이터 수 (열 기준)
                if ($total_cart % 2 == 0) {
                    ?>                      <tr class="even">
                <?php } else {
                    ?>                      <tr>

                <?php } ?>
                <td width="5%" align="center"><input type="checkbox" name="chk_info" value="HTML"></td>

                <td width="15%" align="center"><img src="<?php echo $row_cart['product_image'];?>" alt="My Image"
                                                    style="width: 48%; height: 15%"></td>
                <td width="25%" align="center">
                    <?php echo $row_cart['product_name']; ?><br>
                    [옵션: <?php echo $row_cart['product_size']; ?>, <?php echo $row_cart['product_color']; ?> ]
                </td>
                <td width="10%" align="center">
                    <input type='text' name='price'  id ='price_<?php echo $row_cart['id'];?>' value='<?php echo $row_cart['product_price'];?>' size='7' style="border:none; text-align: center" readonly>
                    
                </td>
                <td width="10%" align="center">
                    <img src='http://49.247.136.36/main/cart/minus.jpg' onclick='minus(-1);' style="cursor:pointer">
                    &nbsp;<input type='text' name='count' value='1' size='2' style="text-align: center" readonly>
                    <img src='http://49.247.136.36/main/cart/plus.jpg'  onclick='plus(<?php echo $row_cart['id'];?>);' style="cursor:pointer">
                    <!--버튼을 이미지로 바꾸세요 <img src='이미지경로' onclick='javascript_:change(1);'>-->
                </td>
                <td width="10%" align="center"><input type='text' name='sum' id ='sum_<?php echo $row_cart['id'];?>' value='<?php echo $row_cart['product_price'];?>' size='7' style="border:none; text-align: center" readonly></td>
                <td width="10%" align="center">배송비 무료</td>
                <td width="10%" align="center"><button class="button" type="button" onclick="location.href='mycart_delete.php?product=<?php echo '상품이름';?>'">상품삭제</button></td>

                </tr>
                <?php
                $total--;
            }
            ?>



            </tbody>



        </table>
        </form>


        <br><br><br><br><br>

    </div>

</div>
<div class="category_center_footer"></div>
<div id="footer"></div>
<script>
    $('#footer').load("http://49.247.136.36/main/foot.php");
</script>
</body>
<script>
    //이전페이지에서 GET 방식으로 넘어온 카테고리를 확인한 뒤 페이지 좌측의 선택 카테고리 리스트에서 겹치는것을 확인한다.
    //만일 카테고리 리스트에서 GET 방식으로 넘어온 카테고리가 겹칠 경우 해당하는 카테고리의 상세 카테고리 목록을 펼쳐준다.
    //펼친 카테고리 목록중에서 GET 방식으로 넘어온 상세 카테고리와의 겹침을 추가로 확인한 뒤
    //상세 카테고리도 겹칠 경우에는 해당하는 텍스트의 굵기를 굵게 표기해준다.
    //만일 상세 카테고리 겹치지 않을 경우에는 ALL(전부 보기) 을 선택한다.
    for (var i = 0; i < $('.categories_contents_text').length; i++) {
        if ($('.categories_contents_text').eq(i).text() == "<?php echo $category_1?>") {
            $('.categories_more').eq(i - 1).css("background-image", "url('http://49.247.136.36//web/icon/collapse.png')");
            $('.categories_contents_detail').eq(i - 1).css("display", "block");
            var category2_true = 0;
            for (var detail_c = 0; detail_c < $('.categories_contents_detail').eq(i - 1).children().length; detail_c++) {
                if ("<?php echo $category_2?>" == $('.categories_contents_detail').eq(i - 1).children().eq(detail_c).text()) {
                    $('.categories_contents_detail').eq(i - 1).children().eq(detail_c).css("font-weight", "bold");
                    category2_true = 1;
                }
                if ((detail_c + 1 == $('.categories_contents_detail').eq(i - 1).children().length) && (category2_true == 0)) {
                    console.log(i);
                    $('.categories_contents_detail').eq(i - 1).children().eq(0).css("font-weight", "bold");
                }
            }
            break;
        }
    }

    //페이지 좌측의 카테고리 리스트중 한가지를 클릭했을 떄의 이벤트
    //이전에 펼쳐진 카테고리는 접어주고 클릭한 카테고리의 상세카테고리 목록을 펼쳐준다.
    $('.categories_contents').click(function () {
        $('.categories_contents_detail').css("display", "none");
        var bool = false;
        if ("url(\"http://49.247.136.36/web/icon/collapse.png\")" == $(this).children().eq(1).css("background-image")) {
            bool = false;
        } else {
            bool = true;
        }
        $('.categories_more').css("background-image", "url('http://49.247.136.36/web/icon/expand.png')");
        if (bool) {
            $(this).children().eq(1).css("background-image", "url('http://49.247.136.36/web/icon/collapse.png')");
        }
        var my_category = $(this).children().eq(0).text();
        for (var i = 0; i < $('.categories_contents_text').length; i++) {
            if ($('.categories_contents_text').eq(i).text() == my_category) {
                if ("url(\"http://49.247.136.36/web/icon/expand.png\")" != $(this).children().eq(1).css("background-image")) {
                    $('.categories_contents_detail').eq(i - 1).css("display", "block");
                }
            }
        }
    });
    window.onload = function () {
        $('.loader-default').remove();
    }
</script>
</html>
