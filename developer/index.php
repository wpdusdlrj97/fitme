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
		<title>FitMe Developers</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<style>


	</style>

	<body class="left-sidebar is-preload">
		<div id="page-wrapper">

			<!-- Header -->
        <section id="header" class="wrapper">


      <!-- Logo -->
        <div id="logo">
          <h1><a href="http://49.247.136.36/developer/index.php">FitMe Developers</a></h1>
					<br>

					<?php
					if(!isset($_SESSION['email']))
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
                        $_SESSION['state'] = $state;

                        $login_url = 'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state='.$state;

					    ?>

						<button class="button style3" type="button"
                                onclick="location.href='<?php echo $login_url;?>'">로그인</button>
					<?php
						  $_SESSION['URL'] = 'http://49.247.136.36/developer/index.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.
				}else{
					?>
						<p><h1 style="color:#FFFFFF;  font-size: 1em; text-align:center;"><?php echo $email; ?>님</h1></p>
						<button class="button style3" type="button"
							onclick="javascript: window.location.href='http://49.247.136.36/fitme_logout.php'">로그아웃</button>
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
					<div class="title">Home</div>
					<div class="container">


						<!-- Features -->
							<section id="features">
								<header class="style1">
									<h2>Dolor consequat feugiat amet veroeros</h2>
									<p>Feugiat dolor nullam orci pretium phasellus justo</p>
								</header>
								<div class="feature-list">
									<div class="row">
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon fa-comment">Mattis velit diam vulputate</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon solid fa-sync">Lorem ipsum dolor sit veroeros</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon fa-image">Pretium phasellus justo lorem</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon solid fa-cog">Tempus sed pretium orci</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon solid fa-wrench">Aliquam consequat et feugiat</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
										<div class="col-6 col-12-medium">
											<section>
												<h3 class="icon solid fa-check">Dolore laoreet aliquam mattis</h3>
												<p>Eget mattis at, laoreet vel et velit aliquam diam ante, aliquet sit amet vulputate et magna feugiat laoreet vel velit lorem.</p>
											</section>
										</div>
									</div>
								</div>
								<ul class="actions special">
									<li><a href="#" class="button style1 large">Get Started</a></li>
									<li><a href="#" class="button style2 large">More Info</a></li>
								</ul>
							</section>

					</div>
				</section>

			<!-- Highlights -->
				<section id="highlights" class="wrapper style3">
					<div class="title">The Endorsements</div>
					<div class="container">
						<div class="row aln-center">
							<div class="col-4 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/pic02.jpg" alt="" /></a>
									<h3><a href="#">Aliquam diam consequat</a></h3>
									<p>Eget mattis at, laoreet vel amet sed velit aliquam diam ante, dolor aliquet sit amet vulputate mattis amet laoreet lorem.</p>
									<ul class="actions">
										<li><a href="#" class="button style1">Learn More</a></li>
									</ul>
								</section>
							</div>
							<div class="col-4 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/pic03.jpg" alt="" /></a>
									<h3><a href="#">Nisl adipiscing sed lorem</a></h3>
									<p>Eget mattis at, laoreet vel amet sed velit aliquam diam ante, dolor aliquet sit amet vulputate mattis amet laoreet lorem.</p>
									<ul class="actions">
										<li><a href="#" class="button style1">Learn More</a></li>
									</ul>
								</section>
							</div>
							<div class="col-4 col-12-medium">
								<section class="highlight">
									<a href="#" class="image featured"><img src="images/pic04.jpg" alt="" /></a>
									<h3><a href="#">Mattis tempus lorem</a></h3>
									<p>Eget mattis at, laoreet vel amet sed velit aliquam diam ante, dolor aliquet sit amet vulputate mattis amet laoreet lorem.</p>
									<ul class="actions">
										<li><a href="#" class="button style1">Learn More</a></li>
									</ul>
								</section>
							</div>
						</div>
					</div>
				</section>

			<!-- Footer -->
				<section id="footer" class="wrapper">
					<div class="title">The Rest Of It</div>
					<div class="container">
						<header class="style1">
							<h2>Ipsum sapien elementum portitor?</h2>
							<p>
								Sed turpis tortor, tincidunt sed ornare in metus porttitor mollis nunc in aliquet.<br />
								Nam pharetra laoreet imperdiet volutpat etiam feugiat.
							</p>
						</header>
						<div class="row">
							<div class="col-6 col-12-medium">

								<!-- Contact Form -->
									<section>
										<form method="post" action="#">
											<div class="row gtr-50">
												<div class="col-6 col-12-small">
													<input type="text" name="name" id="contact-name" placeholder="Name" />
												</div>
												<div class="col-6 col-12-small">
													<input type="text" name="email" id="contact-email" placeholder="Email" />
												</div>
												<div class="col-12">
													<textarea name="message" id="contact-message" placeholder="Message" rows="4"></textarea>
												</div>
												<div class="col-12">
													<ul class="actions">
														<li><input type="submit" class="style1" value="Send" /></li>
														<li><input type="reset" class="style2" value="Reset" /></li>
													</ul>
												</div>
											</div>
										</form>
									</section>

							</div>
							<div class="col-6 col-12-medium">

								<!-- Contact -->
									<section class="feature-list small">
										<div class="row">
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon solid fa-home">Mailing Address</h3>
													<p>
														Untitled Corp<br />
														1234 Somewhere Rd<br />
														Nashville, TN 00000
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon solid fa-comment">Social</h3>
													<p>
														<a href="#">@untitled-corp</a><br />
														<a href="#">linkedin.com/untitled</a><br />
														<a href="#">facebook.com/untitled</a>
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon solid fa-envelope">Email</h3>
													<p>
														<a href="#">info@untitled.tld</a>
													</p>
												</section>
											</div>
											<div class="col-6 col-12-small">
												<section>
													<h3 class="icon solid fa-phone">Phone</h3>
													<p>
														(000) 555-0000
													</p>
												</section>
											</div>
										</div>
									</section>

							</div>
						</div>
						<div id="copyright">
							<ul>
								<li>&copy; Untitled.</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
							</ul>
						</div>
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
