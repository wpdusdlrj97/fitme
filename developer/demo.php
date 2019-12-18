<!DOCTYPE HTML>
<?php
session_start();

$email = $_SESSION['email'];

if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/developer/demo.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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

    $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=" . $state;
    echo "<meta http-equiv='refresh' content='0; url=$login_url'>";

    //echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read\'</script>'; //로그인 페이지로 이동한다.
} else {

$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect,'utf8');





?>
<!--
	Escape Velocity by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>FitMe Developers-Application</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />




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

#customers tr:nth-child(even){background-color: #ffffff;}

#customers tr:hover {background-color: #ddd;}

#customers th {
	padding-top: 12px;
	padding-bottom: 12px;
	background-color: #ff6f61;
	color: white;
}

a { text-decoration:none }

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
            <p><h1 style="color:#FFFFFF;  font-size: 1em; text-align:center;"><?php echo $email; ?>님</h1></p>
            <button class="button style3" type="button"
							onclick="javascript: window.location.href='http://49.247.136.36/fitme_logout.php'">로그아웃</button>

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
					<div class="title">Application</div>
					<div class="container">
						<div class="row gtr-150">
							<div class="col-4 col-12-medium">

								<!-- Sidebar -->
									<div id="sidebar">
										<section class="box">
											<br><br>
											<header>
												<h2>Application for using API</h2>
											</header>
											<ul class="style2">
												<li>
													<article class="box post-excerpt">
														<a href="http://49.247.136.36/developer/myapplication.php" class="image left"><img src="images/pic08.jpg" alt="" /></a>
														<h3><a href="http://49.247.136.36/developer/myapplication.php">나의 어플리케이션</a></h3>
														<p> FitMe API를 이용하기 위해 자신이 등록한 어플의 상세정보를 조회할 수 있습니다</p>
													</article>
												</li>
												<li>
													<article class="box post-excerpt">
														<a href="http://49.247.136.36/developer/register.php" class="image left"><img src="images/pic09.jpg" alt="" /></a>
														<h3><a href="http://49.247.136.36/developer/register.php">어플리케이션 등록</a></h3>
														<p>API 이용을 위해 애플리케이션을 등록하는 곳입니다</p>
													</article>
												</li>
												<li>
													<article class="box post-excerpt">
														<a href="http://49.247.136.36/developer/demo.php" class="image left"><img src="images/pic10.jpg" alt="" /></a>
														<h3><a href="http://49.247.136.36/developer/demo.php">Demo</a></h3>
														<p>FitMe API 이용 Demo 페이지</p>
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
											<header class="style2">
												<h2>FitMe API 이용 Demo 페이지</h2>

                        <button class="btn btn-lg btn-primary btn-block btn-signin"
                         onclick="window.open('http://13.209.40.189/demo_fitme_login.php','fullscreen=yes');">
                         <h1 style="color:#FFFFFF; font-weight: bold; font-size: 1.5em; text-align:center;">->샘플페이지로 이동</h1></button>

											</header>

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
								Sed turpis tortor, tincidunt sed ornare in metus porttitor mollis nunc in aliquet.<br />
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
</html>
<?php } ?>