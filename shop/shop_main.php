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
    $_SESSION['URL'] = 'http://49.247.136.36/shop/shop_main.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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
    if($row_level['level']!='1') //접근권한이 일반 사용자인 경우에는 에러페이지로 넘긴다.
    {
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>FITME SHOP</title>
    <link rel="stylesheet" type="text/css" href="./product_upload.css">
    <link rel="stylesheet" type="text/css" href="./shop.css">
</head>
<body>

<!--상단부 FitMe Shop 로고와 카테고리들을 정렬 해 둔다-->
<div id="head">
    <div id="title">FitMe Shop</div>
    <button style="float:right; margin-right:100px;" onclick="go_main()">메인페이지로</button>
    <table id="category">
        <tr>
            <th id="category1" onclick="category_change(1,this);" class="category_head">관리자 홈</th>
            <th id="category2" onclick="category_change(2,this);" class="category_head">제품 등록</th>
            <th id="category3" onclick="category_change(3,this);" class="category_head">카테고리3</th>
            <th id="category4" onclick="category_change(4,this);" class="category_head">카테고리4</th>
            <th id="category5" onclick="category_change(5,this);" class="category_head">카테고리5</th>
            <th id="category6" onclick="category_change(6,this);" class="category_head">카테고리6</th>
            <th id="category7" onclick="category_change(7,this);" class="category_head">카테고리7</th>
            <th id="category8" onclick="category_change(8,this);" class="category_head">카테고리8</th>
        </tr>
    </table>
</div>
<!-- 아래 div 내부에 각 카테고리들의 내용들을 import해온다. -->
<div id="contents">
</div>

<!--<form action="user_upload.php" method="post" enctype="multipart/form-data">-->
<!--    <input style="width:100%; height:100px;" name="uploaded_file" type="file">-->
<!--    <input style="width:100%; height:60px;" type="text" name="email" placeholder="이메일">-->
<!--    <input style="width:100%; height:60px;" type="text" name="location_head" placeholder="머리좌표y">-->
<!--    <input style="width:100%; height:60px;" type="text" name="location_waist" placeholder="허리좌표y">-->
<!--    <input style="width:100%; height:60px;" type="text" name="location_foot" placeholder="발좌표y">-->
<!--</form>-->
</body>
<script type="text/javascript">
    function go_main()
    {
        location.href="http://49.247.136.36/main/main.php";
    }
    var now_contents=1; //현재 어떤 카테고리를 선택중인지 저장할것 ( 초기값은 0번째 카테고리 이므로 0 으로 지정 )
    $("#category"+now_contents).css("background-color","#333333");
    function category_change(number,object) //카테고리 클릭시 매개변수로 어떤 카테고리를 클릭했는지 가져온다.
    {
        if(now_contents!=number) //현재 선택중인 카테고리를 다시 선택한것이 아니면 동작시킴
        {
            $("#contents").empty(); //불러올 공간을 비운다.
            $("#category"+now_contents).css("background-color","#555555");
            if(number==1) //관리자 홈
            {

            }
            else if(number==2) //제품 업로드 카테고리
            {
                $("#contents").load("http://49.247.136.36/shop/product_upload.php"); //제품 업로드 페이지를 불러옴
            }
            else if(number==3)
            {

            }
            now_contents=number;//현재 카테고리 번호를 변수에 저장
            $(object).css("background-color","#333333");
        }
    }
</script>
</html>