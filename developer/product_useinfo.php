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
            if (!isset($_SESSION['email'])) {
                //csrf 공격에 대응하기 위한 state 값 설정
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
                $_SESSION['URL'] = 'http://49.247.136.36/developer/product_useinfo.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.
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
                            <br><br><br><br>
                            <header>
                                <h2>FitMe 이용약관</h2>
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
                    <header class="style1">
                        <h2>이용약관</h2>
                    </header>

                    <!-- Content -->
                    <div id="content" style="overflow:scroll; width:820px; height:1050px;">
                        <article class="box post">


                            <header class="style2">
                                <h2>1. 목적</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">FitMe API서비스 이용약관(이하 ‘본 약관’이라 합니다)은
                                FitMe주식회사(이하 '회사'라 합니다)와 이용자 간에 회사가 제공하는 API 서비스의 제공 및 이용과 관련한 회사와 이용자의 권리,
                                의무 및 책임에 관한 제반 사항과 기타 필요한 사항을 구체적으로 규정함을 목적으로 합니다.</p>

                            <br>

                            <header class="style2">
                                <h2 style="font-size: 1.5em;">2. 용어의 정의</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">2.1. ‘API’란 Application Programming Interface의
                                약자로서 이용자가 본인의 애플리케이션 등에서 회사가 제공하는 기술을 사용하기 위한 인터페이스를 의미하며,
                                ‘API서비스’란 회사가 그와 같은 API를 이용자에게 제공하는 것을 지칭합니다.</p>

                            <p>2.2. ‘이용자’란 네이버 서비스(http://www.naver.com)의 회원으로서 본 약관에 따라 회사와 이용계약을 체결하고 회사가 제공하는 API서비스를
                                이용하는 자를 말합니다.</p>

                            <p>2.3. ‘애플리케이션 등’이라 함은 이용자가 API서비스를 적용시키고자 하는 이용자의 애플리케이션, 프로그램 또는 웹사이트 등을 의미합니다.</p>

                            <p>2.4. ‘개발자센터’라 함은 회사의 API서비스 제공 웹페이지(https://developers.naver.com)를 말합니다.</p>

                            <p>2.5. ‘클라이언트 아이디’라 함은 API를 사용하고자 하는 어플리케이션 등이 API서비스의 이용 승낙을 받은 이용자의 애플레이케이션 등인 것을 식별할 수
                                있도록 회사가 이용자에게 할당하는 고유한 인증 값을 의미합니다.</p>

                            <br>

                            <header class="style2">
                                <h2 style="font-size: 1.5em;">3. API 이용계약의 체결 및 약관의 개정</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">3.1. 본 약관은 이용자가 API서비스의 이용을 위하여 동의를 하고 회사가
                                이용자에게 클라이언트 아이디를 발급함으로써 효력이 발생하며, 그에 따라 회사와 이용자 사이의 이용계약(이하 ‘API 이용계약’이라 합니다)이
                                체결됩니다.</p>

                            <p>3.2. 회사는 약관규제법 등 관련 법령에 위배되지 않는 범위 안에서 약관을 개정할 수 있으며,
                                약관 개정 시 적용일자로부터 7일 이전부터 약관의 개정내용 및 적용일자를 개발자센터를 통해 공지합니다.
                                다만, 약관이 이용자에게 불리하게 개정되는 경우에는 적용일자로부터 30일 이전부터 공지하고 이용자에게 이메일 등의 수단으로 개별적으로 통지합니다.</p>

                            <br>
                            <header class="style2">
                                <h2 style="font-size: 1.5em;">4. API서비스의 종류 및 내용</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">4.1 API서비스의 종류 및 내용은 개발자센터에서 정한 바에 따릅니다.
                                - https://developers.fitme.com/products/intro/plan</p>


                            <br>
                            <header class="style2">
                                <h2 style="font-size: 1.5em;">5. API 서비스의 제공의 조건</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">5.1. 회사는 API서비스를 제공함에 있어서 API서비스의 범위,
                                이용 가능 시간, 이용 가능 횟수를 지정할 수 있으며, 이와 같은 제공조건은 개발자센터를 통해 공지되며,
                                이용자는 그와 같이 정해진 제공조건에 따라서만 API서비스를 이용할 수 있습니다.</p>

                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">5.2. 회사의 API서비스 제공은 어떠한 경우에도 회사와 이용자의 제휴 관계의
                                성립을 의미하지 않습니다.</p>

                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">회사는 API서비스를 이용해 이용자가 제공받은 API서비스의 출력 결과에 광고를
                                게재할 수 있습니다.
                                다만, 이와 같이 광고를 게재하고자 할 경우에는 광고 적용일 30일 전에 개발자센터를 통해 이를 공지합니다.</p>


                            <br>
                            <header class="style2">
                                <h2 style="font-size: 1.5em;">6. 클라이언트 아이디의 발급</h2>
                            </header>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">6.1. 이용자는 API 서비스를 이용하기 위해서는 개발자센터를 통해 클라이언트
                                아이디를 발급받아야 하며,
                                이용자는 발급 신청 과정에서 입력해야 하는 정보를 거짓 없이 그리고 정확하게 입력하여야 합니다.이용자가 입력한 정보가 정확하지 않거나 불충분한 경우 회사는
                                정보의 수정,
                                추가적인 정보의 제공을 요청하거나 클라이언트 아이디의 발급을 거부하고 API이용계약 체결을 거절할 수 있습니다.</p>
                            <p>
                            <h1 style="color:#000000; font-size: 0.7em;">6.2. 하나의 어플리케이션 등에는 하나의 클라이언트 아이디만이 발급될 수
                                있습니다.</p>


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
