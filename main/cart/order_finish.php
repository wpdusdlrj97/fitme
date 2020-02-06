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
    $_SESSION['URL'] = 'http://49.247.136.36/main/cart/order.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}


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

<style type="text/css">
    .info_box {
        float: left;
        width: 50%;
        height: 15%;
        margin-left: 25%;

    }

    .info_box_30 {
        float: left;
        width: 24%;
        height: 100%;
    }
    .info_box_60 {
        float: left;
        width: 60%;
        height: 100%;
    }

    .form-style-2 {
        max-width: 1500px;
        font: 13px Arial, Helvetica, sans-serif;
    }

    .form-style-2-heading {
        font-weight: bold;
        border-bottom: 2px solid #ddd;
        margin-bottom: 20px;
        font-size: 15px;
        padding-bottom: 3px;
    }

    .form-style-2 label {
        display: block;
        margin: 0px 0px 15px 0px;
    }

    .form-style-2 label > span {
        width: 100px;
        font-weight: bold;
        float: left;
        padding-top: 3px;
        padding-right: 5px;
    }

    .form-style-2 span.required {
        color: red;
    }

    .form-style-2 .tel-number-field {
        width: 60px;
        text-align: center;
    }

    .form-style-2 input.input-field, .form-style-2 .select-field {
        width: 20%;
    }

    .form-style-2 input.input-field,
    .form-style-2 .tel-number-field,
    .form-style-2 .textarea-field,
    .form-style-2 .select-field {
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        border: 1px solid #C2C2C2;
        box-shadow: 1px 1px 4px #EBEBEB;
        -moz-box-shadow: 1px 1px 4px #EBEBEB;
        -webkit-box-shadow: 1px 1px 4px #EBEBEB;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        padding: 7px;
        outline: none;
    }

    .form-style-2 .input-field:focus,
    .form-style-2 .tel-number-field:focus,
    .form-style-2 .textarea-field:focus,
    .form-style-2 .select-field:focus {
        border: 1px solid #0C0;
    }

    .form-style-2 .textarea-field {
        height: 100px;
        width: 55%;
    }

    .form-style-2 input[type=submit],
    .form-style-2 input[type=button] {
        border: none;
        padding: 8px 15px 8px 15px;
        background: #FF8500;
        color: #fff;
        box-shadow: 1px 1px 4px #DADADA;
        -moz-box-shadow: 1px 1px 4px #DADADA;
        -webkit-box-shadow: 1px 1px 4px #DADADA;
        border-radius: 3px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
    }

    .form-style-2 input[type=submit]:hover,
    .form-style-2 input[type=button]:hover {
        background: #EA7B00;
        color: #fff;
    }

    .button {
        background-color: #000000;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }

</style>

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

<!-- 주소 검색 -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>



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
    <div class="category_right_title"> Order </div>

    <div class="product_list">
        <br><br><br>

        <div class="form-style-2">
            <div class="form-style-2-heading">주문완료 </div>

            <br><br>

            <div class="info_box" style="text-align: center;">

                <div class="info_box_30">
                    <img src="order_finish.png" alt="My Image" style="width: 100%; height: 100%;">
                </div>
                <div class="info_box_60" style="text-align: left; margin-left: 5%">
                    <h3 style="font-weight: bold;">고객님의 주문이 완료되었습니다</h3>
                    <h5 style="font-size: 12px">주문내역 및 배송에 관한 안내는 주문조회를 통해 확인 가능합니다</h5>

                    <br>
                        주문번호 : 20191227-0001358
                    <br> <br>
                        주문일자 : 2019-12-27 21:36:47


                </div>

            </div>


        </div>


        <br><br><br><br><br><br><br><br><br><br><br>


        <div class="form-style-2">
            <div class="form-style-2-heading">주문상품 정보</div>
            <table id="customers">
                <tr style="border: 1px solid #ddd;">

                    <th>이미지</th>
                    <th>상품명/옵션</th>
                    <th>판매가</th>
                    <th>수량</th>
                    <th>적립금</th>
                    <th>배송비</th>

                </tr>
                <tbody style="border: 1px solid #ddd;">

                <td width="10%" align="center"><img
                        src="http://49.247.136.36/product_resource/image/main/yohan@gmail.com20191220211834_main.jpg"
                        alt="My Image" width="90" height="90" style="margin-bottom: 3px;"></td>
                <td width="20%" align="center"><?php echo '메모리 MA-1 항공점퍼3colors'; ?><br>
                    <?php echo '[옵션 - Black, L]'; ?></td>
                <td width="10%" align="center"><?php echo '2,000원'; ?></td>
                <td width="10%" align="center"><?php echo '1'; ?></td>
                <td width="10%" align="center"><?php echo '20원'; ?></td>
                <td width="10%" align="center"><?php echo '무료'; ?></td>


                </tbody>


            </table>

        </div>

        <br><br><br><br>

        <div class="form-style-2">
            <div class="form-style-2-heading">결제 정보</div>


            <label for="field1"><span>최종 결제 금액 <span class="required">*</span></span>
                <input type="text" class="input-field"  style="width:5%; height:3%; text-align: end; border:none;" value="2000" readonly/>원</label>
            <hr>
            <label for="field1"><span>결제 수단 <span class="required">*</span></span>
                <input type="text" class="input-field"  style="width:7%; height:3%; text-align: end; border:none;" value="카드결제" readonly/></label>
            <hr>

        </div>

        <br><br><br><br>


        <div class="form-style-2">
            <div class="form-style-2-heading">배송지 정보</div>


            <label for="field1"><span>받으시는 분 <span class="required">*</span></span>
                <input type="text" class="input-field"  style=" border:none;" value="조제연" readonly/></label>
            <hr>
            <label for="field1"><span>우편번호 <span class="required">*</span></span>
                <input type="text" class="input-field"  style=" border:none;" value="14538" readonly/></label>
            <hr>
            <label for="field1"><span>주소 <span class="required">*</span></span>
                <input type="text" class="input-field"  style="width:50%; height:3%; border:none;" value="경기 부천시 석천로 216 은하마을 대우,동부아파트 503동 902호" readonly/></label>
            <hr>
            <label for="field1"><span>일반전화 <span class="required">*</span></span>
                <input type="text" class="input-field"  style=" border:none;" value="032-326-2402" readonly/></label>
            <hr>
            <label for="field1"><span>휴대전화 <span class="required">*</span></span>
                <input type="text" class="input-field"  style=" border:none;" value="010-9488-3402" readonly/></label>
            <hr>
            <label for="field1"><span>배송메시지 <span class="required">*</span></span>
                <input type="text" class="input-field"  style="width:50%; height:3%; border:none;" value="경비실에 맡겨주세요" readonly/></label>
            <hr>



        </div>



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
