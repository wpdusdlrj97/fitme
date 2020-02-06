<!DOCTYPE HTML>
<?php
session_start();

$email = $_SESSION['email'];


?>
<!--
	Escape Velocity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
<head>
    <title>FitMe Developers-Application</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>


    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #ffffff;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: #ff6f61;
            color: white;
        }


    </style>
</head>
<body class="left-sidebar is-preload">
<div id="page-wrapper">

    <!-- Header -->
    <section id="header" class="wrapper">

        <!-- Logo -->
        <div id="logo">
            <h1><a href="http://49.247.136.36/developer/index.php">FitMe Developers</a></h1>

            <br>

            <?php
            if (!isset($_SESSION['email'])) {                 //csrf 공격에 대응하기 위한 state 값 설정
                function generate_state()
                {
                    $mt = microtime();
                    $rand = mt_rand();
                    return md5($mt . $rand);
                }

                // 상태 토큰으로 사용할 랜덤 문자열을 생성
                $state = 'xyz';
                // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
                $_SESSION['state'] = $state;

                $login_url = 'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=' . $state;

                ?>

                <button class="button style3" type="button"
                        onclick="location.href='<?php echo $login_url; ?>'">로그인
                </button>
                <?php
                $_SESSION['URL'] = 'http://49.247.136.36/developer/document.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.
            } else {
                ?>
                <p><h1 style="color:#FFFFFF;  font-size: 1em; text-align:center;"><?php echo $email; ?>님</h1></p>
                <button class="button style3" type="button"
                        onclick="javascript: window.location.href='http://49.247.136.36/fitme_logout.php'">로그아웃
                </button>
                <?php
            }
            ?>

        </div>


        <!-- Nav -->
        <nav id="nav">
            <ul>
                <li><a href="http://49.247.136.36/developer/index.php">Home</a></li>
                <li class="current"><a href="http://49.247.136.36/developer/product.php">Product</a>
                    <ul>
                        <li><a href="http://49.247.136.36/developer/product.php">FitMe API 소개</a></li>
                        <li><a href="http://49.247.136.36/developer/product_fitme.php">FitMe 아이디로 로그인</a></li>
                        <li><a href="http://49.247.136.36/developer/product_faq.php">FAQ</a></li>
                        <li><a href="http://49.247.136.36/developer/product_useinfo.php">이용약관</a></li>
                    </ul>
                </li>
                <li><a href="http://49.247.136.36/developer/document.php">Documents</a></li>
                <li>
                    <a href="http://49.247.136.36/developer/myapplication.php">Application</a>
                    <ul>
                        <li><a href="http://49.247.136.36/developer/myapplication.php">내 어플리케이션</a></li>
                        <li><a href="http://49.247.136.36/developer/register.php">어플리케이션 등록</a></li>
                        <li><a href="http://49.247.136.36/developer/demo.php">Demo</a></li>
                    </ul>
                </li>
                <li><a href="no-sidebar.html">No Sidebar</a></li>
            </ul>
        </nav>

    </section>

    <!-- Main -->
    <section id="main" class="wrapper style2">
        <div class="title">Document</div>
        <div class="container">
            <div class="row gtr-150">
                <div class="col-4 col-12-medium">

                    <!-- Sidebar -->
                    <div id="sidebar">
                        <section class="box">
                            <br><br><br>
                            <header>
                                <h2>FitMe 로그인 가이드</h2>
                            </header>
                            <ul class="style2">
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/document.php" class="image left"><img
                                                    src="images/pic08.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/document.php">개요</a></h3>
                                        <p> FitMe 로그인 API에 대한 전반적인 개요입니다</p>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/document_guide.php"
                                           class="image left"><img src="images/pic09.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/document_guide.php">개발 가이드</a></h3>
                                        <p>FitMe 로그인 API 개발 가이드 및 튜토리얼이 상세히 나와있습니다</p>
                                    </article>
                                </li>

                            </ul>

                        </section>

                    </div>

                </div>
                <div class="col-8 col-12-medium imp-medium">

                    <header class="style1">
                        <h2 style="font-size: 1.5em;">개요</h2>
                    </header>
                    <!-- Content -->
                    <div id="content" style="overflow:scroll; width:820px; height:700px;">
                        <article class="box post">
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">FitMe 아이디로 로그인은 OAuth 2.0 기반의 사용자 인증 기능을 제공해
                                FitMe가 아닌
                                다른 서비스에서 FitMe의 사용자 인증 기능을 이용할 수 있게 하는 서비스입니다. 별도의 아이디나 비밀번호를 기억할 필요 없이 FitMe 아이디로 간편하고
                                안전하게 서비스에 로그인할 수 있어,
                                가입이 귀찮거나 가입한 계정이 생각나지 않아 서비스를 이탈하는 사용자를 잡고 싶다면 FitMe 아이디로 로그인을 사용해 보세요.</h1></p>
                            <img src="images/product1.png">
                            <h1 style="color:#000000; font-size: 0.7em;">FitMe 아이디로 로그인을 통해 로그인하는 기본 절차는 다음과 같습니다.</h1>
                            <img src="images/product2.png">
                            <h1 style="color:#000000; font-size: 0.7em;">1. 애플리케이션에서 FitMe 아이디로 로그인 버튼을 클릭하면 FitMe 로그인
                                화면으로 이동합니다.
                                모바일 애플리케이션에서는 FitMe 앱의 간편 로그인 기능으로 로그인합니다.</h1>
                            <h1 style="color:#000000; font-size: 0.7em;">2. 사용자가 FitMe 아이디로 로그인하면 사용자 정보 제공에 동의하는 화면으로
                                이동합니다.</h1>
                            <h1 style="color:#000000; font-size: 0.7em;">3. 사용자가 정보 제공에 동의하면 콜백 URL로 애플리케이션에 접근
                                토큰(access token)이 발급됩니다.
                                발급받은 접근 토큰을 이용해 OAuth 2.0을 지원하는 FitMe의 오픈 API를 사용하거나 사용자의 정보를 얻어 올 수 있습니다.</h1>


                        </article>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <section id="footer" class="wrapper">
        <div class="title">FitMe Developers</div>
        <div class="container">
            <header class="style2">
                <h2>Ipsum sapien elementum portitor?</h2>
                <p>
                    Sed turpis tortor, tincidunt sed ornare in metus porttitor mollis nunc in aliquet.<br/>
                    Nam pharetra laoreet imperdiet volutpat etiam feugiat.
                </p>
            </header>
        </div>
    </section>
</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
</body>

<script>
    console.log($('#content').children().children("p"));
    //$('#content') = > id로찾기
    //$('.content') = > 클래스로찾기
</script>
</html>
