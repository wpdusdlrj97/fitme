<?php
session_start();
//임시리스트
$pic_array = array("1.jpg","2.jpg","3.jpg","4.jpg","5.jpg","6.jpg","7.jpg","8.jpg","9.jpg","10.jpg");
$shop_array = array("모디파이드","에이본","구카","퍼스트플로어","퍼스트플로어","퍼스트플로어","에이본","스튜디오 톰보이","인사일러스","낫앤낫","오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져","3110 wool over jacket charcoal","모던 투피스","빌보 자켓","12/17 배송 EASYGOING CROP","149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135","IN SILENCE X BUND 익스플로러 더블 코트 BLACK","[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙","오버더원 204블레이져 블랙");
$price_array = array("89,000","66,000","254,000","144,000","57,400","119,000","499,000","289,000","79,200","128,000");
$fit_array = array("10.jpg","11.jpg","12.jpg","13.jpg","14.jpg","15.jpg");


$find_pw_id = $_POST['joinid'];

$find_pw_number = $_POST['joinnumber'];

$find_pw_chkphone = $_POST['chk_phone'];


//임시 비밀번호 생성
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if($find_pw_chkphone==0){
    echo"<script>alert('문자인증을 해주세요.');history.back();</script>";
}else {
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');

    $query ="SELECT * FROM user_information where phone = '$find_pw_number'";

    $result = mysqli_query($connect, $query);

    $row = mysqli_fetch_assoc($result);

    $total = mysqli_num_rows($result);


    //조건 -> 회원가입된 계정이어야 한다  total이 0일시 회원가입
    //     -> 번호로 조회해서 DB에 기입된 이메일과 입력한 이메일이 같아야한다

    if($total==0){
      echo"<script>alert('해당 이메일과 번호로 가입된 계정이 없습니다');history.back();</script>";
    }elseif($find_pw_id!==$row['email']){
      echo"<script>alert('해당 이메일로 가입된 계정이 없습니다');history.back();</script>";
    }else{ // 비밀번호 새로 발급해주고 DB 저장

      //임시 비밀번호
      $temporary_pw = generateRandomString();


      //임시 비밀번호 암호화
      $hash_temporary_pw = hash("sha256", $temporary_pw);

      //임시 비밀번호 DB에 넣기
      $query_pw ="UPDATE resource_owner set password='$hash_temporary_pw' where username = '$find_pw_id'";

      //쿼리 실행
      mysqli_query($connect, $query_pw);
    }

}

?>

<html>
<style type="text/css">
    /*
     * Specific styles of signin component
     */
    /*
     * General styles
     */

    body, html {
        height: 70%;
        background-repeat: no-repeat;

    }

    .card-container.card {
        max-width: 500px;
        padding: 40px 40px;
        margin-top: 100px;
        margin-bottom: 100px;
    }

    .btn {
        font-weight: 700;
        height: 36px;
        -moz-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        cursor: default;
    }

    /*
     * Card component
     */
    .card {
        background-color: #FFFFFF;
        /* just in case there no content*/
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;

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


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/css/swiper.min.css">
    <script src="https://unpkg.com/swiper/js/swiper.js"></script>
    <script src="https://unpkg.com/swiper/js/swiper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../head_foot.css">
    <title>FITME</title>
</head>
<body>
<div id="fitme_button">
    <div id="fitme_button_icon"></div>
</div>
<div id="header"></div>


<div id="center_box">
  <div id="page-wrapper">

      <div id="main" class="wrapper style1">

          <div class="card card-container" style="border:4px solid black;">

              <!-- 가입된 계정이 있으면 이메일을 띄워주고 없으면 가입된 계정이 없다고 한다 -->

             <?php echo $temporary_pw;?>


              <button type="button" class="button" onclick="location.href='http://49.247.136.36/main/fitme_session_login.php'">로그인하러 가기</button>

          </div><!-- /card-container -->


      </div>


  </div>
</div>

<br><br><br>


<div id="footer"></div>
</body>

<script>
    $('#header').load("../head.php");
    $('#footer').load("../foot.php");
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        centeredSlides: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        }
    });
    $(window).scroll(function () {
        var scrollValue = $(document).scrollTop();
        var Height = screen.height;
        console.log("페이지높이:"+$( window ).height());
        console.log("현재스크롤:"+scrollValue);
        console.log("화면높이:"+Height);
        console.log("이벤트div"+$("#foot").prop('scrollHeight'));
    });
</script>
</html>
