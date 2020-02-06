<?php
session_start(); //세션을 유지한다.
/*
이 페이지에서 가장 먼저 해야할것은 접속한 사용자가 일반사용자인지 관리자, 즉 쇼핑몰 인지를 확인 하여야한다.
DB에서 user_information테이블에서 level이 사용자 권한을 나타낸다.
level이 0이라면 일반사용자이며 1 이상이라면 이 페이지를 이용할 권한을 가지고 있는것이다.
 */
$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/admin/product_approval.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    //csrf 공격에 대응하기 위한 state 값 설정
    function generate_state() {
        $mt = microtime();
        $rand = mt_rand();
        return md5($mt . $rand);
    }

    // 상태 토큰으로 사용할 랜덤 문자열을 생성
    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=".$state;
    echo "<meta http-equiv='refresh' content='0; url=$login_url'>";
    //echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read\'</script>'; //로그인 페이지로 이동한다.
}
else
{
    //로그인이 되어있는 상태
    //접근권한을 DB에서 조회해야 한다.
    $qry = mysqli_query($con,"select * from user_information where email='$email'");
    $row_level = mysqli_fetch_array($qry);
    if($row_level['level']<'1') //접근권한이 일반 사용자인 경우에는 에러페이지로 넘긴다.
    {
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }
}

//등록 대기중인 옷입히기 이미지들을 가져와야 함
$qry = mysqli_query($con,"select * from product_approval");
$product_key = array();
$shop_name = array();
$product_name = array();
$product_category1=array();
$product_category2=array();
$product_price = array();
$product_stock = array();
$product_image = array();
$product_stock = array();
while($row = mysqli_fetch_array($qry))
{
    $p_key = $row['product_key'];
    $image = $row['fitme_image'];
    $ne_qry = mysqli_query($con,"select product_key,email,name,price,category1,category2,fitme_image,stock from product where product_key = '$p_key'");
    $ne_row = mysqli_fetch_array($ne_qry);
    array_push($product_key,$ne_row['product_key']);
    array_push($shop_name,$ne_row['email']);  //임시로 이메일 저장 - 추후에 쇼핑몰 이름을 저장해야함
    array_push($product_name,$ne_row['name']);
    array_push($product_price,number_format($ne_row['price']).' 원');
    array_push($product_category1,$ne_row['category1']);
    array_push($product_category2,$ne_row['category2']);
    array_push($product_image,$image);
    array_push($product_stock,$ne_row['stock']);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>FitMe Admin</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jua&display=swap" rel="stylesheet">



    <script src="http://49.247.136.36/api/sweetalert/dist/sweetalert.min.js"></script>


    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" type="text/css" href="./product_approval.css">
    <link rel="stylesheet" href="/api/css-loader.css">
</head>
<body>
<!-- Loader -->
<div class="loader loader-default"></div>
<!-- Loader active -->
<div class="loader loader-default is-active"  data-text="잠시 기다려주세요" data-blink ></div>
<div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <a class="navbar-brand" href="shop_main.php">
            <img src="assets/img/admin_logo.png" style="width:30%; height:300%" />
        </a>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <a href="http://49.247.136.36/admin/shop_manage.php"><i class="fa fa-desktop "></i>쇼핑몰 관리</a>
                </li>
                <li>
                    <a href="http://49.247.136.36/admin/seller/shop_request.php"><i class="fa fa fa-flag-o"></i>입점 문의/신청 관리</a>
                </li>
                <li>
                    <a href="http://49.247.136.36/admin/member_manage.php"><i class="fa fa-bar-chart-o"></i>회원 관리</a>
                </li>
                <li>
                    <a href="http://49.247.136.36/admin/order_manage.php"><i class="fa fa-table "></i>주문 관리</a>
                </li>
                <li class="active-link">
                    <a href="http://49.247.136.36/admin/product_approval.php"><i class="fa fa-edit "></i>상품 관리</a>
                </li>
                <li>
                    <a href="http://49.247.136.36/admin/ui.html"><i class="fa fa-bar-chart-o "></i>ui</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper" style="font-family: 'Noto Sans KR', sans-serif;">
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>FitMe 등록 대기제품</h2>
                </div>
                <div class="product_top">
                    <ul class="content_box_table_name">
                        <li class="product_key">제품번호</li>
                        <li class="shop_name">쇼핑몰이름</li>
                        <li class="product_name">제품이름</li>
                        <li class="product_category1">제품카테고리</li>
                        <li class="product_category2">제품세부카테고리</li>
                        <li class="product_price">제품가격</li>
                        <li class="product_stock">제품재고</li>
                    </ul>
<!--                    승인 대기중인 제품 목록을 넣는다. -->
                    <?php
                    for($num=0;$num<count($product_image);$num++)
                    {?>
                        <ul class="approval_product_box">
                            <li class="approval_product_key"><?php echo $product_key[$num]?></li>
                            <li class="approval_shop_name"><?php echo $shop_name[$num]?></li>
                            <li class="approval_product_name"><?php echo $product_name[$num]?></li>
                            <li class="approval_product_category1"><?php echo $product_category1[$num]?></li>
                            <li class="approval_product_category2"><?php echo $product_category2[$num]?></li>
                            <li class="approval_product_price"><?php echo $product_price[$num]?></li>
                            <li class="approval_product_stock"><?php echo $product_stock[$num]?></li>
                            <li class="approval_product_image" style="display:none"><?php echo $product_image[$num]?></li>
                        </ul>
                    <?php }
                    ?>
                </div>
                <div class="product_content_box" style="display:none">
                    <div class="left_box">
                        <div class="product_content_box_shop_name">쇼핑몰 이름</div>
                        <div class="product_content_box_product_name">제품이름</div>
                        <div class="product_content_box_product_key" style="display:none">제품키</div>
                        <div class="product_width_box1">
                            <a class="download_src" download href="nope"><div class="product_content_box_image_download">이미지다운로드</div></a>
                        </div>
                        <div class="product_width_box2">
                            <form method="POST" enctype="multipart/form-data" id="ajaxSendData">
                                <label for="input_image">이미지첨부</label>
                                <input type="file" id="input_image" name="uploaded_file">
                                <input type="text" id="key" name="key" style="display:none">
                                <input type="text" id="line_position" name="line_position" style="display:none">
                            </form>
                        </div>
                        <div class="cont_radio">
                            <ul>
                                <li>
                                    <input type="radio" id="toption" name="top">
                                    <label for="toption">TOP</label>
                                    <div class="check"></div>
                                </li>
                                <li>
                                    <input type="radio" id="loption" name="left">
                                    <label for="loption">LEFT</label>
                                    <div class="check"></div>
                                </li>
                                <li>
                                    <input type="radio" id="roption" name="right">
                                    <label for="roption">RIGHT</label>
                                    <div class="check"></div>
                                </li>
                                <li>
                                    <input type="radio" id="boption" name="bottom">
                                    <label for="boption">BOTTOM</label>
                                    <div class="check"></div>
                                </li>
                            </ul>
                        </div>
                        <div style="width:100%; height:100px; float:left;"></div>
                    </div>
                    <div class="default_image_box">
                        <div class="default_image_object_box">
                            <div class="default_image_text">기존 이미지</div>
                            <div id="default_image_line_box"><img class="default_image" src=""></div>
                        </div>
                        <div class="default_image_object_box2">
                            <div class="default_image_text">변경 이미지</div>
                            <div id="change_image_line_box"><img class="change_image" src=""></div>
                        </div>
                    </div>
                    <div class="bottom_place">
                        <div class="approval_s_button">승인</div>
                        <div class="approval_f_button">승인거부</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="row">
        <div class="col-lg-12" >
            &copy;  2014 yourdomain.com | Design by: <a href="http://binarytheme.com" style="color:#fff;" target="_blank">www.binarytheme.com</a>
        </div>
    </div>
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
</body>
<script>
    //현재 선택된 제품이 있는지 확인할 변수
    var now_approval_product_box = null;
    //변경 이미지;
    var change_image = null;
    //이미지 변경확인 체크 가이드
    var guid=false;

    $('.approval_s_button').click(function(){
        if($('#top').length>0&&$('#bottom').length>0&&$('#left').length>0&&$('#right').length>0)
        {
            swal({
                title: "대기제품 승인",
                text: "해당 제품을 승인 하시겠습니까?",
                icon: "warning",
                buttons: ["아니오","네"],
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    //현재 좌표값들을 전부 가져옴 ( 제품 내부의 길이, 너비값의 좌표), 현재 이미지 너비, 높이, 원본 이미지의 너비, 높이값도 가져옴
                    var x_left=null, x_right=null, y_top=null, y_bottom=null, img_width=null, img_height=null, default_img_width=null, default_img_height=null;
                    if($('.default_image_object_box2').css("display")=="none")
                    {
                        img_width = $('.default_image').width();
                        img_height = $('.default_image').height();
                        default_img_width = $('.default_image')[0].naturalWidth;
                        default_img_height = $('.default_image')[0].naturalHeight;
                    }
                    else
                    {
                        img_width = $('.change_image').width();
                        img_height = $('.change_image').height();
                        default_img_width = $('.change_image')[0].naturalWidth;
                        default_img_height = $('.change_image')[0].naturalHeight;
                    }
                    var parent = $($('#top').parent()).offset().top;
                    y_top = ($('#top').offset().top)-parent;
                    parent = $($('#left').parent()).offset().left;
                    x_left = ($('#left').offset().left)-parent+15;
                    parent = $($('#right').parent()).offset().left;
                    x_right = ($('#right').offset().left)-parent+15;
                    parent = $($('#bottom').parent()).offset().top;
                    y_bottom = ($('#bottom').offset().top)-parent;

                    //위에서 구한 각 좌표값과 이미지 현재 크기를 비교하여
                    //원본 이미지의 크기일 때의 좌표값을 구한다.
                    x_left = x_left*default_img_width/img_width;
                    x_right = x_right*default_img_width/img_width;
                    y_top = y_top*default_img_height/img_height;
                    y_bottom = y_bottom*default_img_height/img_height;

                    //좌표값들은 JSON형태로 전송한다.
                    var sendJson = new Object();
                    sendJson.x_left = x_left;
                    sendJson.x_right = x_right;
                    sendJson.y_top = y_top;
                    sendJson.y_bottom = y_bottom;
                    if(change_image)    //첨부 이미지가 있는 경우에는 폼태그로 전송
                    {
                        $('#key').val($('.product_content_box_product_key').text());
                        $('#line_position').val(JSON.stringify(sendJson));
                        var form = $('#ajaxSendData')[0];
                        // Create an FormData object
                        var data = new FormData(form);
                        $.ajax({
                            type: "POST",
                            enctype: 'multipart/form-data',
                            url: "./product_approval_server.php",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function(string){
                                swal({
                                    title: "대기제품 승인",
                                    text: "해당 제품이 승인이 완료되었습니다.",
                                    icon: "success",
                                    buttons: ["네"],
                                    dangerMode: true
                                }).then((willDelete) => {
                                $('input:radio[name=top]').prop("checked",false);
                                $('input:radio[name=left]').prop("checked",false);
                                $('input:radio[name=right]').prop("checked",false);
                                $('input:radio[name=bottom]').prop("checked",false);
                                $('#top').remove();
                                $('#bottom').remove();
                                $('#left').remove();
                                $('#right').remove();
                                change_image = null;
                                guid=false;
                                $('.product_content_box').css("display","none");
                                $('#input_image').val("");
                                $(now_approval_product_box).remove();
                                now_approval_product_box = null;
                                });
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                        });
                    }
                    else //첨부 이미지가 없는 경우
                    {
                        $.ajax({
                            type:"POST",
                            url:"./product_approval_server.php",
                            data : {key:$('.product_content_box_product_key').text(),line_position:JSON.stringify(sendJson)},
                            dataType : "text",
                            success: function(string){
                                swal({
                                    title: "대기제품 승인",
                                    text: "해당 제품이 승인이 완료되었습니다.",
                                    icon: "success",
                                    buttons: ["네"],
                                    dangerMode: true
                                }).then((willDelete) => {
                                $('input:radio[name=top]').prop("checked",false);
                                $('input:radio[name=left]').prop("checked",false);
                                $('input:radio[name=right]').prop("checked",false);
                                $('input:radio[name=bottom]').prop("checked",false);
                                $('#top').remove();
                                $('#bottom').remove();
                                $('#left').remove();
                                $('#right').remove();
                                change_image = null;
                                guid=false;
                                $('.product_content_box').css("display","none");
                                $('#input_image').val("");
                                $(now_approval_product_box).remove();
                                now_approval_product_box = null;
                                });
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                        });
                    }
                }
            });
        }
        else
        {
            swal({
                title: "대기제품 승인",
                text: "너비, 길이 미체크",
                icon: "warning",
                buttons: "false",
                dangerMode: true
            });
        }

    })

    //첨부한 이미지가 변경될 때 호출되는 함수
    $('#input_image').change(function(){
        $('#top').remove();
        $('#bottom').remove();
        $('#left').remove();
        $('#right').remove();


        $('input:radio[name=top]').prop("checked",false);
        $('input:radio[name=left]').prop("checked",false);
        $('input:radio[name=right]').prop("checked",false);
        $('input:radio[name=bottom]').prop("checked",false);

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
                this.files=null;
                return;
            }
            change_image = f;
            var reader = new FileReader();
            reader.onload = function(e){
                $('.change_image').attr("src",e.target.result);
                $('.default_image_object_box2').css("display","block");
            };
            reader.readAsDataURL(f);
        });
    });

    //좌표를 잡는 라디오버튼을 클릭할 시
    //1. 다른 라디오 버튼들을 체크해제
    //2. 선택한 라디오 버튼에 맞는 오브젝트 생성(좌표를 잡을 오브젝트)
    $('input:radio').click(function(){
        if(this.name=='top')
        {
            $('input:radio[name=left]').prop("checked",false);
            $('input:radio[name=right]').prop("checked",false);
            $('input:radio[name=bottom]').prop("checked",false);
        }
        else if(this.name=='left')
        {
            $('input:radio[name=top]').prop("checked",false);
            $('input:radio[name=right]').prop("checked",false);
            $('input:radio[name=bottom]').prop("checked",false);
        }
        else if(this.name=='right')
        {
            $('input:radio[name=top]').prop("checked",false);
            $('input:radio[name=left]').prop("checked",false);
            $('input:radio[name=bottom]').prop("checked",false);
        }
        else if(this.name=='bottom')
        {
            $('input:radio[name=top]').prop("checked",false);
            $('input:radio[name=left]').prop("checked",false);
            $('input:radio[name=right]').prop("checked",false);
        }
        var none=true; //변경 이미지 존재 여부 확인
        if($('.default_image_object_box2').css("display")=="none")
        {
            if(!guid)
            {
                swal({
                    title: "대기제품 승인",
                    text: "이미지를 변경하지 않으셨습니다. 진행하시겠습니까?",
                    icon: "warning",
                    buttons: ["아니오","네"],
                    dangerMode: true
                }).then((willDelete) => {
                    if (willDelete) {
                        none=true;
                        guid=true;
                        position(none,this.name);
                    }else{
                        $('input:radio[name=top]').prop("checked",false);
                        $('input:radio[name=left]').prop("checked",false);
                        $('input:radio[name=right]').prop("checked",false);
                        $('input:radio[name=bottom]').prop("checked",false);
                    }
                });
            }
            else
            {
                none=true;
                position(none,this.name);
            }
        }else
        {
            none=false;
            position(none,this.name);
        }
    });


//좌표를 설정하는 오브젝트를 생성하는 함수
    function position(isnone, position)
    {

        $('#'+position).remove();

        //좌측 이미지에 오브젝트 생성
        var div = document.createElement('div');

        $(div).draggable({containment:'parent'})
            .css({
                "z-index":"100",
                "cursor":"pointer",
                "position":"absolute"
            });
        if(isnone)
        {
            document.getElementById('default_image_line_box').appendChild(div); // 제품 노드 내부의 자식 노드로 들어가게 된다.
            if(position=='top')
            {
                div.id='top';
                $('#top').css({"width":$($('#top').parent()).width()/10*9+"px","height":"2px","background-color":"blue"});
            }
            else if(position=='bottom')
            {
                div.id='bottom';
                $('#bottom').css({"width":$($('#top').parent()).width()/10*9+"px","height":"2px","background-color":"blue"});
            }
            else if(position=='left')
            {
                div.id='left';
                $('#left').css({"width":"30px","height":"30px","background-color":"red","border-radius":"100%"});
            }
            else if(position=='right')
            {
                div.id='right';
                $('#right').css({"width":"30px","height":"30px","background-color":"red","border-radius":"100%"});
            }
        }
        else    //우측 이미지에 오브젝트 생성
        {
            document.getElementById('change_image_line_box').appendChild(div); // 제품 노드 내부의 자식 노드로 들어가게 된다.
            if(position=='top')
            {
                div.id='top';
                $('#top').css({"width":$($('#top').parent()).width()/10*9+"px","height":"2px","background-color":"blue"});
            }
            else if(position=='bottom')
            {
                div.id='bottom';
                $('#bottom').css({"width":$($('#top').parent()).width()/10*9+"px","height":"2px","background-color":"blue"});
            }
            else if(position=='left')
            {
                div.id='left';
                $('#left').css({"width":"30px","height":"30px","background-color":"red","border-radius":"100%"});
            }
            else if(position=='right')
            {
                div.id='right';
                $('#right').css({"width":"30px","height":"30px","background-color":"red","border-radius":"100%"});
            }
        }
    }

    //제품 클릭시
    $('.approval_product_box').click(function(){
        if(now_approval_product_box==null)
        {
            //만약 기존에 선택된 박스가 없다면 선택된 제품을 보여줄 공간을 보여준다.
            now_approval_product_box = this;
            $('.product_content_box').css("display","block");
            //변경 이미지를 숨긴다.
            change_image=null;
            $('.default_image_object_box2').css("display","none");

            //다운로드의 링크를 바꾼다.
            $('.download_src').attr("href",$(this).children('li').eq(7).text());

            //선택된 제품의 정보를 선택공간 내부의 각 위치 넣는다.
            $('.default_image').attr("src",$(this).children('li').eq(7).text());
            $('.product_content_box_product_key').text($(this).children('li').eq(0).text());
            $('.product_content_box_shop_name').text($(this).children('li').eq(1).text());
            $('.product_content_box_product_name').text($(this).children('li').eq(2).text());
        }else if(now_approval_product_box!=this)
        {
            swal({
                title: "대기제품 승인",
                text: "승인이 완료되지 않았습니다. 다른 제품을 보시겠습니까?",
                icon: "warning",
                buttons: ["아니오","네"],
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    now_approval_product_box = this;
                    //변경 이미지를 숨긴다.
                    change_image=null;
                    $('.default_image_object_box2').css("display","none");

                    //다운로드의 링크를 바꾼다.
                    $('.download_src').attr("href",$(this).children('li').eq(7).text());

                    //선택된 제품의 정보를 선택공간 내부의 각 위치 넣는다.
                    $('.default_image').attr("src",$(this).children('li').eq(7).text());
                    $('.product_content_box_product_key').text($(this).children('li').eq(0).text());
                    $('.product_content_box_shop_name').text($(this).children('li').eq(1).text());
                    $('.product_content_box_product_name').text($(this).children('li').eq(2).text());

                    //좌표를 잡는 라디오버튼을 체크 해제한다.
                    $('input:radio[name=top]').prop("checked",false);
                    $('input:radio[name=left]').prop("checked",false);
                    $('input:radio[name=right]').prop("checked",false);
                    $('input:radio[name=bottom]').prop("checked",false);

                    //좌표를 잡는 객체를 삭제한다.
                    $('#top').remove();
                    $('#bottom').remove();
                    $('#left').remove();
                    $('#right').remove();

                    $('#input_image').val("");

                    guid=false;
                }
            });
        }
    });
    window.onload = function(){
        $('.loader-default').remove();
    }
</script>
</html>