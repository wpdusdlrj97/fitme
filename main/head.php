<!--FitMe 홈페이지 상단 카테고리 부분-->
<?php
//초기에 제공하는 카테고리 목록을 가져온다.
session_start();
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

?>
<html>
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
    <link rel="stylesheet" type="text/css" href="./main.css">
</head>
<body id="head_body">
    <div id="login_area">
        <div class="logo"><a href="http://49.247.136.36/main/main.php">F I T M E</a></div>
        <div class="search">
            <div class="search_box">
                <img src="http://49.247.136.36/web/icon/search.png">
                <input type="text" placeholder="옷을 검색하세요">
                <div class="rank">
<!--                    실시간 순위를 나타냄, 현재는 하드코딩 되어있는 부분 -> 추후에 DB에 연동시켜 순위를 나타내게 할 것 -->
                    <h4>실시간 순위</h4>
                    <ul>
                        <li><a>1. 아우터</a></li>
                        <li><a>2. 집업</a></li>
                        <li><a>3. 오버핏</a></li>
                        <li><a>4. 슬림핏</a></li>
                        <li><a>5. 코트</a></li>
                        <li><a>6. 슬랙스</a></li>
                        <li><a>7. 스윔</a></li>
                        <li><a>8. 맨투맨</a></li>
                        <li><a>9. 패딩</a></li>
                        <li><a>10. 롱패딩</a></li>
                    </ul>

                </div>
            </div>
        </div>
        <div class="top_box">
            <?php
            if($_SESSION['email'])
            { ?>

                <div class="logout"><a href="http://49.247.136.36/fitme_logout.php">LOGOUT</a></div>
                <div class="mypage"><a href="http://49.247.136.36/main/mypage/mypage.php">MYPAGE</a></div>
                <div class="mine"><a href="#">찜목록</a></div>
                <?php
            }
            else
            {
                //csrf 공격에 대응하기 위한 state 값 설정
                function generate_state() {
                    $mt = microtime();
                    $rand = mt_rand();
                    return md5($mt . $rand);
                }

                // 상태 토큰으로 사용할 랜덤 문자열을 생성
                $state = 'xyz';
                // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
                $_SESSION['state'] = 'xyz';

                $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=".$state;
                ?>
                <div class="login"><a href=<?php echo $login_url?>>LOGIN</a></div>
                <?php
            }
            ?>
            <div class="shop"><a href="http://49.247.136.36/main/seller/inquire.php">입점문의</a></div>
            <div class="android"></div>
            <div class="ios"></div>
        </div>
    </div>
    <div id="menu">
        <div class="navi">
            <ul>
                <li class="new"><a href="./category.php?category1=NEW">NEW</a></li>
<!--                카테고리 추가하는 부분-->
                <?php
                for($i=0;$i<count($category1);$i++)
                {?>
                    <li><a href="./category.php?category1=<?php echo $category1[$i]?>"><?php echo $category1[$i]?></a></li>
                <?php }
                ?>
                <li class="community"><a>COMMUNITY</a></li>
            </ul>
        </div>
        <div class="category">
            <ul class="category_first">
                <li class="category_value"><a>NEW</a></li>
                <li class="category_value"><a>COMMUNITY</a></li>
                <li class="category_value"><a>SEARCH</a></li>
                <li class="category_value"><a>MYPAGE</a></li>
            </ul>
            <div class="category_second_box">
                    <?php
                    for($i=0;$i<count($category1);$i++)
                    {
                        ?>
                        <ul class="category_second">
                        <li class="category_name"><a href="./category.php?category1=<?php echo $category1[$i]?>"><?php echo $category1[$i]?></a></li>
                    <?php
                        for($ii=0;$ii<count(json_decode($category2[$i]));$ii++)
                        {
                            if($ii==0)
                            {?>
                                <li class="category_value"><a href="./category.php?category1=<?php echo $category1[$i]?>">ALL</a></li>
                                <li class="category_value"><a href="./category.php?category1=<?php echo $category1[$i]?>&category2=<?php echo json_decode($category2[$i])[$ii]?>"><?php echo json_decode($category2[$i])[$ii]?></a></li>
                            <?php }
                            else
                            {?>
                                <li class="category_value"><a href="./category.php?category1=<?php echo $category1[$i]?>&category2=<?php echo json_decode($category2[$i])[$ii]?>"><?php echo json_decode($category2[$i])[$ii]?></a></li>
                            <?php }
                        }?>
                        </ul>
                        <?php
                    }?>
            </div>
        </div>
    </div>
</body>
<script>
    //FitMe버튼 클릭시 옷입히기 페이지를 새탭으로 생성
    $('#fitme_button').click(function(){
        window.open('/web/mainpage.php','FITME');
    });
    var rankfocus=false;    //실시간 순위부분이 활성화 되어있는지 확인 할 변수
    var width = screen.width-18;    //모니터 너비를 저장한 변수

    //인터넷 창의 너비에 따라서 동작하는 조건 ( 크기가 작아지면 객체들이 겹치거나 보기좋지 않아서 몇가지 객체들을 숨겨줌 - 반대라면 보여줌 )
    if($(window).width()>=769)
    {
        $('.community').css("display","block");
        $('.search').css("display","block");
        $('.android').css("display","block");
        $('.ios').css("display","block");
    }
    else
    {
        $('.community').css("display","none");
        $('.search').css("display","none");
        $('.android').css("display","none");
        $('.ios').css("display","none");
    }

    //인터넷 창의 크기가 변할 때마다 동작 - 객체를 숨기거나 보여줌
    $(window).resize(function(){
        if($(window).width()>=769)
        {
            $('.community').css("display","block");
            $('.search').css("display","block");
            $('.android').css("display","block");
            $('.ios').css("display","block");
        }
        else
        {
            $('.community').css("display","none");
            $('.search').css("display","none");
            $('.android').css("display","none");
            $('.ios').css("display","none");
        }
    });

    //상단 카테고리에 마우스를 올려두엇을 때의 이벤트 ( 모든 카테고리들을 보여주거나 숨김 )
    $('.navi').hover(function(){
        $('.category').css("display","block");
    },function(){
        $('.category').css("display","none");
    });

    //모든 카테고리가 보여질 경우 마우스를 올려두었을 때의 이벤트
    $('.category').hover(function(){
        $('.category').css("display","block");
    },function(){
        $('.category').css("display","none");
    });

    //화면 스크롤시 이벤트 ( 상단 카테고리가 화면 상단에 고정되도록 설정 )
    $(window).scroll(function () {
        var scrollValue = $(document).scrollTop();
        if(scrollValue>60)
        {
            $('#menu').css("top","0px");
        }
        else
        {
            $('#menu').css("top",60-scrollValue+"px");
        }
    });

    //검색창에 마우스를 올려두었을 때의 이벤트
    $('.search').hover(function(){
        rankfocus=true;
    }, function(){
        rankfocus=false;
    });

    //검색창에 마우스를 올려두었을 때의 이벤트
    $('.search_box input').focus(function(){
        $('.search').css("border","2px #96A5FF solid");
        $('.rank').css("display","block");
    });

    //화면을 클릭시 이벤트 ( 검색창이 활성화 되어있는 것을 활성화 취소시키기 위함 )
    $('body').click(function(){
        if(!rankfocus)
        {
            $('.search').css("border","1px grey solid");
            $('.rank').css("display","none");
        }
    });
</script>
</html>
