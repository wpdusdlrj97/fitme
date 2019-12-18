<?php
session_start();
$none_data = $_GET['none_data'];
if(!$none_data){
    Header("Location:/main/main.php");
}
$email = $_SESSION['email'];
//DB에 연결하는 코드이다.
$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($con,'utf8');

//DB에서 사용자 데이터 가져오기 ( email로 사용자를 조회한다 )
//가져온 데이터에는 사용자의 신체정보가 들어있다.
$qry = mysqli_query($con,"select * from user_information where email='$email'");
$row = mysqli_fetch_array($qry);
$my_tall = $row['height_length'];
$photo = $row['photos'];
if($none_data=='photo'){
    if($photo){
        Header("Location:/main/main.php");
    }
}else if($none_data=='tall'){
    if($my_tall){
        Header("Location:/main/main.php");
    }
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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <script src="https://unpkg.com/swiper/js/swiper.js"></script>
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./fitme_none_data.css">
    <link rel="stylesheet" type="text/css" href="./head_foot.css">
</head>
<body id="body">
<?php if($none_data=='photo'){ ?>
    <div class="fitme_guide">FitMe Guide(회원 사진)</div>
    <div class="top_box_none_data_">
        <div class="top_box_text">1. 사진 등록
            <div class="top_box_button" number="0"></div>
        </div>
        <div class="top_box_link">
            <div class="top_image">
                <img class="android_ios_image" src="/web/icon/android_ios.png">
            </div>
            <div class="top_text">
                <div class="button_android">Android - Google PlayStore</div>
            </div>
            <div class="top_text">
                <div class="button_ios">Apple - App Store</div>
            </div>
        </div>
        <div class="top_box_text">2. 앱 실행 및 FitMe기능 실행
            <div class="top_box_button" number="1"></div>
        </div>
        <div class="top_box_link">

        </div>
        <div class="top_box_text">3. 사진 촬영
            <div class="top_box_button" number="2"></div>
        </div>
        <div class="top_box_link">
            <div class="step_box">
                <div class="step_title">
                    <div class="step_title_1">STEP1</div>
                    <div class="step_title_2">STEP2</div>
                    <div class="step_title_3">STEP3</div>
                </div>
                <div class="step_img_box">
                    <img class="step_img_1" src="../web/icon/step1.png">
                    <img class="step_img_2" src="../web/icon/step2.png">
                    <img class="step_img_3" src="../web/icon/step3.png">
                </div>
                <div class="step_text_box">각 STEP에 맞게 팔과 다리를 벌려가며 총 3장의 사진을 찍습니다.</div>
            </div>
        </div>
        <div class="top_box_text">4. 사진 전송
            <div class="top_box_button" number="3">
            </div>
        </div>
        <div class="top_box_link">
            <div class="send_photo_box">
                <img class="send_photo_box_image" src="../web/icon/send_photo.png">
            </div>
            <div class="send_photo_box_text">촬영한 사진들을 확인한 뒤 전송합니다.</div>
        </div>
        <div class="top_box_text">5. 신체 정보 등록
            <div class="top_box_button" number="4"></div>
        </div>
        <div class="top_box_link">
            <div class="send_body_size_box">
                <img class="send_body_size_box_image" src="../web/icon/write_body.png">
                <img class="send_body_size_box_image" src="../web/icon/send_body.png">
            </div>
            <div class="send_body_size_box_text">신체정보를 입력한 뒤 전송합니다.<br>키는 FitMe 기능을 이용하는데 있어서 필수 입력사항입니다.</div>
        </div>
    </div>
    <div class="bottom_button_box">
        <div class="go_fitme_button">FitMe</div>
    </div>
<?php }?>
<div id="footer"></div>
<script>
    $('#footer').load("./foot.php");
</script>
</body>
<script>
    $('.top_box_link').eq(0).css("display","block");    //1번가이드만 펼쳐준다.
    $('.top_box_button').eq(0).css("background-image","url('../web/icon/collapse.png')");   //1번가이드 버튼 이미지를 바꿔준다.

    $('.top_box_button').click(function(){  //접기 펼치기 버튼 클릭시 버튼의 이미지를 바꿔주고 내용을 숨기거나 보여준다.
        if($(this).css("background-image")=="url(\"http://49.247.136.36/web/icon/collapse.png\")")
        {
            $(this).css("background-image","url('../web/icon/expand.png')");
            $('.top_box_link').eq($(this).attr("number")).css("display","none");
        }else{
            $(this).css("background-image","url('../web/icon/collapse.png')");
            $('.top_box_link').eq($(this).attr("number")).css("display","block");
        }
    });
    $('.go_fitme_button').click(function(){
        location.href="../web/mainpage.php";
    });
    swal({
        title: "사진이 존재하지 않습니다.",
        text: "가이드를 따라 사진을 등록해주세요",
        icon: "warning",
        button: "확인",
        dangerMode: true
    });
</script>