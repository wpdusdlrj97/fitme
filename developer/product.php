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
                $_SESSION['URL'] = 'http://49.247.136.36/developer/product.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.
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
        <div class="title">Product</div>
        <div class="container">
            <div class="row gtr-150">
                <div class="col-4 col-12-medium">

                    <!-- Sidebar -->
                    <div id="sidebar">
                        <section class="box">
                            <br><br> <br><br>
                            <header>
                                <h2>FitMe Open API</h2>
                            </header>
                            <ul class="style2">
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/product.php" class="image left"><img
                                                    src="images/pic08.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/product.php">FitMe API 소개</a></h3>
                                        <p> 네이버에서 제공하는 다양한 서비스와 컨텐츠를 소개합니다. </p>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/product_fitme.php"
                                           class="image left"><img src="images/pic10.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/product_fitme.php">FitMe 아이디로
                                                로그인</a></h3>
                                        <p>별도의 아이디, 비밀번호없이 FitMe 아이디로 간편하게 외부 서비스에 로그인 할 수 있도록 하는 서비스입니다.</p>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/product_faq.php" class="image left"><img
                                                    src="images/pic10.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/product_faq.php">FAQ</a></h3>
                                        <p>FitMe API 관련 일반적/개발적인 질문들에 대한 답변입니다.</p>
                                    </article>
                                </li>
                                <li>
                                    <article class="box post-excerpt">
                                        <a href="http://49.247.136.36/developer/product_useinfo.php" class="image left"><img
                                                    src="images/pic09.jpg" alt=""/></a>
                                        <h3><a href="http://49.247.136.36/developer/product_useinfo.php">이용약관</a></h3>
                                        <p>FitMe API 서비스 이용약관이 상세히 나와있습니다 .</p>
                                    </article>
                                </li>
                            </ul>

                        </section>

                    </div>

                </div>
                <div class="col-8 col-12-medium imp-medium">

                    <!-- Content -->
                    <div id="content">
                        <article class="box post">
                            <br><br>
                            <header class="style1">
                                <h2>FitMe API 소개</h2>
                            </header>

                            <header class="style2">
                                <h2>1. FitMe 오픈API 서비스</h2>
                            </header>
                            <p>FitMe 오픈API는 24시간 365일 무중단으로 운영되고 있습니다.
                                오픈API 오류에 신속하게 대응하기 위해 매 10분 단위로 자동으로 모니터링하고 있습니다.
                                API가 정상 작동 여부는 아래에서 확인가능합니다.

                                * API 헬스체크: https://developers.fitme.com/notice/apistatus</p>
                            <header class="style2">
                                <h2>2. FitMe 오픈API 공지 및 FAQ</h2>
                            </header>

                            <p>개발자센터를 통해 제공되는 오픈API 관련 변경사항은 아래 공지사항에서 확인하실 수 있습니다.
                                * 공지사항 게시판: https://developers.fitme.com/notice

                                FitMe 오픈API 이용관련 FAQ를 보시면 자주 묻는 질문들에 대한 답변을 파악하실 수 있습니다
                                * FAQ 게시판: https://developers.fitme.com/products/intro/faq/</p>
                            <header class="style2">
                                <h2>3. 기술 문의</h2>
                            </header>
                            <p>
                                API 이용 관련 기술, 정책 문의는 개발자 포럼을 통해 올려주시면 됩니다.
                                * 개발자 포럼: https://developers.fitme.com/notice/forum

                                개발자 포럼에 올라 오는 글은 API 오류 및 이슈에 신속히 대응하기 위해 자동 모니터링하고 있습니다.
                                * 다만 아래에 해당하는 내용은 공식 대응에서 제외됩니다.
                                - 개발자센터에서 제공하는 API나 서비스와 무관한 질문
                                - 일반적인 응용애플리케이션 구현 방법에 대한 질문</p>
                            <header class="style2">
                                <h2>4. 커뮤니케이션 채널</h2>
                            </header>
                            <p>- API 및 개발가이드 오류 및 개선 문의: https://developers.fitme.com/forum/list
                                - API 제휴 문의: https://developers.fitme.com/forum/create 또는 dl_FitMe_openapi @
                                navercorp.com
                                - 사업 제휴 제안: https://www.fitmecorp.com/ko/company/proposalGuide.nhn
                                - 네이버 고객센터: https://help.fitme.com</p>
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
    console.log($('#content').children().children("p").css("color", "black"));
    //$('#content') = > id로찾기
    //$('.content') = > 클래스로찾기
</script>
</html>
