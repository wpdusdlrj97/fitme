<?php
session_start();
$email = $_SESSION['email'];
if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/mypage/purchase_list.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}
$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');

//임시로 제품 목록 전부를 가져옴(이름만)
$qry = mysqli_query($connect,"select product_key, name, main_image from product");
$product_name=array();
$product_image = array();
$product_key = array();
while($row=mysqli_fetch_array($qry))
{
    array_push($product_key,$row['product_key']);
    array_push($product_name,$row['name']);
    array_push($product_image,$row['main_image']);
}
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
    <script src="/api/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="/api/css-loader.css">
    <title>FITME</title>
    <style>
        #purchase_line{
            float:left;
            width:100%;
            height:70px;
            margin-top:70px;
        }
        #purchase_left_box{
            width:17%;
            margin-left:10%;
            border:1px lightgrey solid;
            float:left;
            font-family: 'Noto Sans KR', sans-serif;
        }
        #purchase_right_box{
            width:58%;
            float:left;
            margin-left:5%;
            font-family: 'Noto Sans KR', sans-serif;
        }
        .purchase_footer_line{
            width:100%;
            float:left;
            height:100px;
        }
        .purchase_title{
            width:70%;
            font-size:1.3vw;
            text-align: left;
            margin-top:1.1vw;
            float:left;
            margin-left:20%;
        }
        .purchase_contents{
            width:100%;
            text-align:center;
            float:left;
        }
        .purchase_contents_left{
            float:left; width:30%; height:40px;
            margin-top:30px;
        }
        .purchase_contents_right{
            float:left; width:70%; height:40px; line-height:30px;
            text-align: left;
            padding-left:15px;
            margin-top:30px;
        }
        .purchase_contents_right a{
            color:black;
            text-decoration: none;
            font-size:0.9vw;
        }
        .purchase_contents_right a:hover{
            text-decoration: none;
            color:hotpink;
        }
        .purchase_contents_left a img{
            width:30%; background-color:#FAFAFA; float:right;
        }
        .purchase_contents_bottom_line{
            width:100%; margin:20px 0 0 0; float:left; height:1px; border-top:1px lightgrey solid;
        }
        .purchase_right_title{
            text-align: left; font-weight:bold; font-size:1.5vw; margin-top:10px;
            float:left;
            width:100%;
        }
        .purchase_right_contents{
            margin-top:30px;
            width:100%;
            float:left;
        }
        .purchase_right_contents ul{
            width:100%; list-style-type:none; height:60px; font-size:0.8vw;
            margin:0;
            padding:0;
            border-bottom:1px lightgrey solid;
        }
        .purchase_right_contents ul li{
            text-align: center;
            float:left;
            line-height:60px;
        }
        .purchase_table_content1{
            width:15%;
        }
        .purchase_table_content2{
            width:15%;
        }
        .purchase_table_content3{
            width:45%;
        }
        .purchase_table_content4{
            width:13%;
        }
        .purchase_table_content5{
            width:12%;
        }
        .purchase_table{
            background-color:black;
            color:white;
        }
        .purchase_right_title_date{
            float:left;
            font-size:1vw;
            line-height:50px;
            margin-left:10px;
            color:#585858;
        }
        .purchase_right_title_text{
            float:left;
        }
        .purchase_table_child:hover{
            background-color:#E6E6E6;
            cursor:pointer;
        }
        .starR1{
            background: url('http://miuu227.godohosting.com/images/icon/ico_review.png') no-repeat -52px 0;
            background-size: auto 100%;
            width: 15px;
            height: 30px;
            float:left;
            text-indent: -9999px;
            cursor: pointer;
        }
        .starR2{
            background: url('http://miuu227.godohosting.com/images/icon/ico_review.png') no-repeat right 0;
            background-size: auto 100%;
            width: 15px;
            height: 30px;
            float:left;
            text-indent: -9999px;
            cursor: pointer;
        }
        .starR1.on{background-position:0 0;}
        .starR2.on{background-position:-15px 0;}
        .modal_body_box{
            width:100%; float:left;
        }
        .modal_img_product_name{
            width:100%; text-align:center; margin:10px 0 10px 0; font-size:1.2vw; font-weight:bold;
        }
        .modal_img_box{
            width:100%; float:left; margin:10px 0 20px 0;
        }
        .modal_img{
            float:left; width:60%; margin-left:20%;
        }
        .modal_body_left{
            float:left; height:40px; width:45%;
        }
        #myModal{
            font-family: 'Noto Sans KR', sans-serif;
        }
        .modal_now_date{
            float:right; line-height:40px; font-size:1vw;
        }
        .modal_body_right{
            float:right; height:40px; margin-left:5%; width:50%;
        }
        .modal_success_button{
            cursor:pointer; float:left; padding:0 20px 0 20px; line-height:40px; font-size:1vw; background-color:#F8E0F1;; color:black; border-radius:5px;
        }
        .modal_success_button:hover{
            background-color:#F5A9E1;
        }
        .modal_body_box2{
            width:100%; float:left; display:none;
        }
        .review_start_text{
            float:left; font-size:1.1vw; width:100%; margin-left:3%; margin-top:20px;
        }
        .review_start{
            float:left; margin-top:10px; margin-left:3%;
        }
        .review_file_upload label {
            border:1px #585858 solid;
            cursor:pointer;
            width:130px;
            height:40px;
            float:left;
            margin-left:10%;
            margin-top:10px;
            text-align: center;
            line-height:40px;
            border-radius:10px;
            color:white;
            background-color:#6E6E6E;
        }
        .review_file_upload label:hover {
            background-color:#585858;
        }
        .review_file_upload label:active {
            background-color: #BDBDBD;
        }
        .review_file_upload input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
        .review_submit_button:hover{
            background-color:#F5A9E1;
        }
        .review_submit_button{
            cursor:pointer; width:30%; height:40px; float:left; margin-left:35%; background-color:#F8E0F1; color:black; line-height:40px; border-radius:5px; text-align: center; font-size:1.1vw;
        }
        .review_start_number{
            margin-left:10px; font-size:0.9vw; float:left; line-height:60px;
        }
        .review_text_title{
            float:left; font-size:1.1vw; width:100%; margin-left:3%; margin-top:20px;
        }
        .review_text{
            width:76%; margin-left:3%; border-radius:5px; height:100px; margin-top:5px; float:left;
        }
        .review_text_byte{
            margin-left:1%; float:left; margin-top:80px;
        }
        .review_text_title{
            float:left; font-size:1.1vw; width:100%; margin-left:3%; margin-top:20px;
        }
        .review_file_upload{
            float:left;
        }
        .review_file_name{
            float:left; margin-top:30px; margin-left:30px;
        }
        .review_submit_button_box{
            float:left; width:100%; height:60px; margin-top:40px;
        }
    </style>
</head>
<body>

<div id="header"></div>
<script>
    $('#header').load("/main/head.php");
</script>
<div id="purchase_line"></div>
<!-- 좌측 목록 -->
<div id="purchase_left_box">
    <div class="purchase_contents">

        <div class="purchase_title">내 쇼핑정보</div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/cart.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">찜한 상품/장바구니</a>
        </div>

        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/truck.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">주문/배송 조회</a>
        </div>
        <div class="purchase_contents_bottom_line"></div>

        <div class="purchase_title">내 혜택정보</div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/cash.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">적립금</a>
        </div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/coupon.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">쿠폰</a>
        </div>
        <div class="purchase_contents_bottom_line"></div>

        <div class="purchase_title">리뷰/Q&A</div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/review.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">작성한 리뷰</a>
        </div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/qna.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">작성한 Q&A</a>
        </div>
        <div class="purchase_contents_bottom_line"></div>

        <div class="purchase_title">고객센터</div>
        <div class="purchase_contents_left">
            <a href="#"><img src="/web/icon/helpdesk.png"></a>
        </div>
        <div class="purchase_contents_right">
            <a href="#">1:1 문의</a>
        </div>
        <div class="purchase_contents_bottom_line"></div>
    </div>
</div>
<div id="purchase_right_box">
    <div class="purchase_right_title">
        <div class="purchase_right_title_text">최근 구매내역 </div>
        <div class="purchase_right_title_date">(<?php $timestamp = strtotime("-1 months");
            echo date("Y-m-d", $timestamp);?>~<?php $timestamp = strtotime("+0 months");
            echo date("Y-m-d", $timestamp);?>)</div>
    </div>
    <div class="purchase_right_contents">
        <ul class="purchase_table">
            <li class="purchase_table_content1">주문번호</li>
            <li class="purchase_table_content2">주문일자</li>
            <li class="purchase_table_content3">상품이름</li>
            <li class="purchase_table_content4">상품수령일자</li>
            <li class="purchase_table_content5">상품수령확인</li>
        </ul>
        <?php
        for($product_count=0;$product_count<count($product_name);$product_count++)
        {?>
            <ul class="purchase_table_child">
                <li class="purchase_table_content1">AAF<?php echo mt_rand(100000, 999999)?>QX<?php echo mt_rand(100, 999)?></li>
                <li class="purchase_table_content2">2019.12.23</li>
                <li class="purchase_table_content3"><?php echo $product_name[$product_count]?></li>
                <li class="purchase_table_content4"></li>
                <li class="purchase_table_content5">
                    <img style="width:30%;">
                </li>
            </ul>
        <?php }
        ?>
    </div>
</div>
<div class="purchase_footer_line"></div>
<div id="footer"></div>
<script>
    $('#footer').load("/main/foot.php");
</script>
<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog" style="opacity: 1;">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">수령확인</h4>
            </div>
            <div class="modal-body">
                <div class="modal_body_box">
                    <div class="modal_img_product_name"></div>
                    <div class="modal_img_box">
                        <img class="modal_img">
                    </div>
                    <div class="modal_body_left">
                        <div class="modal_now_date"><?php $timestamp = strtotime("+0 months"); echo date("Y-m-d", $timestamp);?></div>
                    </div>
                    <div class="modal_body_right">
                        <div class="modal_success_button">수령확인</div>
                    </div>
                </div>
                <div class="modal_body_box2">
                    <div class="review_start_text">상품 평점</div>
                    <div class="review_start">
                        <div class="starRev">
                            <span class="starR1" value="0.5"></span>
                            <span class="starR2" value="1.0"></span>
                            <span class="starR1" value="1.5"></span>
                            <span class="starR2" value="2.0"></span>
                            <span class="starR1" value="2.5"></span>
                            <span class="starR2" value="3.0"></span>
                            <span class="starR1" value="3.5"></span>
                            <span class="starR2" value="4.0"></span>
                            <span class="starR1" value="4.5"></span>
                            <span class="starR2" value="5.0"></span>
                        </div>
                    </div>
                    <div class="review_start_number">(0.0)</div>
                    <div class="review_text_title">상품 리뷰</div>
                    <form id="review_upload" action="/main/mypage/review_register.php" method="post"  enctype="multipart/form-data">
                        <textarea class="review_text" placeholder='상품 리뷰를 30자 이상 500자 이내로 작성해주세요' maxlength="500" onKeyup="textByte(this);"></textarea>
                        <div class="review_text_byte">0/500</div>
                        <div class="review_text_title">착용사진 첨부</div>
                        <div class="review_file_upload">
                            <label for="review_file">첨부</label>
                            <input type="file" id="review_file" name="review_file">
                        </div>
                        <div class="review_file_name"></div>
                        <input class="review_txt" type="text" name="review_text" style="display:none;">
                        <input class="review_star" type="text" name="review_star" style="display:none;">
                        <input class="review_key" type="text" name="product_key" style="display:none;">
                    </form>
                    <div class="review_submit_button_box">
                        <div class="review_submit_button">리뷰등록</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script>
    var img_array = <?php echo json_encode($product_image)?>;
    var name_array = <?php echo json_encode($product_name)?>;
    var key_array = <?php echo json_encode($product_key)?>;
    var now_node;
    var now_index;

    //리뷰등록 버튼 클릭시 이벤트
    //검증을 거치고 난 후 서버로 전송한다.
    $('.review_submit_button').click(function(){
        var review_star = $('.review_start_number').text().replace("(","").replace(")","");
        if($('.review_text').val().length<30||$('.review_text').val().length>500)
        {
            swal({
                title: "Failed",
                text: "리뷰글을 30자 이상 500자 이하로 작성해주세요",
                icon: "warning",
                buttons: "false",
                dangerMode: true
            });
        }
        else if(review_star=='0.0')
        {
            swal({
                title: "Failed",
                text: "평점을 선택해주세요",
                icon: "warning",
                buttons: "false",
                dangerMode: true
            });
        }
        else
        {
            $('.review_key').val(key_array[now_index]);
            $('.review_star').val(review_star);
            var review_text = $('.review_text').val();
            $('.review_txt').val(review_text.replace(/ /gi,'&nbsp').replace(/\n/gi,'<br>').replace(/\"/gi,'&quot'));
            $('#review_upload').submit();
        }
    });

    //사진이 첨부됬을 때의 이벤트
    $('#review_file').change(function(){
        var files = this.files;
        var file_array = Array.prototype.slice.call(files);
        file_array.forEach(function(f){
            if(!f.type.match("image.*")){
                swal({
                    title: "Failed",
                    text: "이미지가 아닙니다.",
                    icon: "warning",
                    buttons: "false",
                    dangerMode: true
                });
                $('#review_file').val("");
                $('.review_file_name').text("");
            }else
            {
                $('.review_file_name').text(f.name);
            }
        });
    });

    //리뷰작성글의 글자수를 체크해서 표기해주는 함수
    function textByte(object)
    {
        $('.review_text_byte').text($(object).val().length+'/500');
    }

    //배송완료된 제품목록중 한개를 클릭했을 때의 이벤트, 이벤트는 배송완료확인이 되지않은 제품 대상으로만 발생
    $('.purchase_table_child').click(function(){
        if($($(this).children('.purchase_table_content5').children('img')).attr("src")!="/web/icon/check_mark.png")
        {
            now_node = this;
            now_index = $(this).index()-1;
            $('.modal_body_box2').css("display","none");
            $('.modal_body_box').css("display","block");
            $('.modal_img_product_name').text(name_array[now_index]);
            $(".modal_img").attr("src",img_array[now_index]);
            $('.starRev').empty();
            $('.starRev').append("<span class=\"starR1\" value=\"0.5\"></span><span class=\"starR2\" value=\"1.0\"></span><span class=\"starR1\" value=\"1.5\"></span>" +
                "<span class=\"starR2\" value=\"2.0\"></span><span class=\"starR1\" value=\"2.5\"></span><span class=\"starR2\" value=\"3.0\"></span><span class=\"starR1\" value=\"3.5\"></span>" +
                "<span class=\"starR2\" value=\"4.0\"></span><span class=\"starR1\" value=\"4.5\"></span><span class=\"starR2\" value=\"5.0\"></span>");
            //별점 표기에 관한 이벤트 함수
            $('.starRev span').click(function(){
                $(this).parent().children('span').removeClass('on');
                $(this).addClass('on').prevAll('span').addClass('on');
                $('.review_start_number').text('('+$(this).attr("value")+')');
                return false;
            });
            $('.review_start_number').text('(0.0)');
            $('.review_text').val("");
            $('.review_key').val("");
            $('.review_file_name').text("");
            $('.review_txt').val("");
            $('#review_file').val("");
            $("#myModal").show();
        }
    });

    //배송완료 확인 버튼 클릭시 이벤트 ( 추후 서버와 연동 ) - 아직 배송처리에 관한 부분이 개발이 안되서 하드코딩으로 현재 페이지에서만 동작
    $('.modal_success_button').click(function(){
        $(now_node).children('.purchase_table_content4').text("<?php $timestamp = strtotime("+0 months"); echo date("Y-m-d", $timestamp);?>");
        $($(now_node).children('.purchase_table_content5').children('img')).attr("src","/web/icon/check_mark.png");
        $('.modal_body_box').css("display","none");
        $('.modal_body_box2').css("display","block");
    });
    window.onload = function(){
        $('.loader-default').remove();
    }
</script>
</html>
