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
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FitMe Admin</title>
    <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
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
                <?php
                $level=$row_level['level'];
                if($level=='1'){ ?>
                    <li class="active-link">
                        <a href="shop_main.php" ><i class="fa fa-desktop "></i>관리자홈</a>
                    </li>
                    <li>
                        <a href="product_upload.php"><i class="fa fa-table "></i>제품등록</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-qrcode "></i>제품관리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-qrcode "></i>리뷰관리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                    </li>
                <?php
                }else {?>
                    <li class="active-link">
                        <a href="shop_main.php" ><i class="fa fa-desktop "></i>입점 심사</a>
                    </li>
                    <li>
                        <a href="ui.html"><i class="fa fa-table "></i>상품 업로드 검열</a>
                    </li>
                    <li>
                        <a href="blank.html"><i class="fa fa-edit "></i>FitMe 상품 좌표잡기</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-qrcode "></i>쇼핑몰 관리</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-bar-chart-o"></i>일반 회원 관리</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper" >
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if($level=='1')
                    {?>
                        <h2>관리자 홈</h2>
                    <?php }
                    ?>
                </div>
            </div>
            <!-- /. ROW  -->
            <hr />
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="alert alert-info">
                        <strong>Welcome Jhon Doe ! </strong> You Have No pending Task For Today.
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-circle-o-notch fa-5x"></i>
                            <h4>Check Data</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-envelope-o fa-5x"></i>
                            <h4>Mail Box</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-lightbulb-o fa-5x"></i>
                            <h4>New Issues</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-users fa-5x"></i>
                            <h4>See Users</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-key fa-5x"></i>
                            <h4>Admin </h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-comments-o fa-5x"></i>
                            <h4>Support</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-clipboard fa-5x"></i>
                            <h4>All Docs</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-gear fa-5x"></i>
                            <h4>Settings</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-wechat fa-5x"></i>
                            <h4>Live Talk</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-bell-o fa-5x"></i>
                            <h4>Notifications </h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-rocket fa-5x"></i>
                            <h4>Launch</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-user fa-5x"></i>
                            <h4>Register User</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-envelope-o fa-5x"></i>
                            <h4>Mail Box</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-lightbulb-o fa-5x"></i>
                            <h4>New Issues</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-users fa-5x"></i>
                            <h4>See Users</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-key fa-5x"></i>
                            <h4>Admin </h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="#" >
                            <i class="fa fa-comments-o fa-5x"></i>
                            <h4>Support</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-circle-o-notch fa-5x"></i>
                            <h4>Check Data</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-rocket fa-5x"></i>
                            <h4>Launch</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-clipboard fa-5x"></i>
                            <h4>All Docs</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-gear fa-5x"></i>
                            <h4>Settings</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-wechat fa-5x"></i>
                            <h4>Live Talk</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-bell-o fa-5x"></i>
                            <h4>Notifications </h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-user fa-5x"></i>
                            <h4>Register User</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row text-center pad-top">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-lightbulb-o fa-5x"></i>
                            <h4>New Issues</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-users fa-5x"></i>
                            <h4>See Users</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-key fa-5x"></i>
                            <h4>Admin </h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-comments-o fa-5x"></i>
                            <h4>Support</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-circle-o-notch fa-5x"></i>
                            <h4>Check Data</h4>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                    <div class="div-square">
                        <a href="blank.html" >
                            <i class="fa fa-envelope-o fa-5x"></i>
                            <h4>Mail Box</h4>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /. ROW  -->
            <div class="row">
                <div class="col-lg-12 ">
                    <br/>
                    <div class="alert alert-danger">
                        <strong>Want More Icons Free ? </strong> Checkout fontawesome website and use any icon <a target="_blank" href="http://fortawesome.github.io/Font-Awesome/icons/">Click Here</a>.
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
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
</body>
</html>
