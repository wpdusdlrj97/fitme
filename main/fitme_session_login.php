<html>

<style>
    html{ scroll-behavior: smooth; }
    body{ padding:0; margin:0; font-family: 'Noto Sans KR', sans-serif; }



    #center_box{ margin:0 auto; width:100%; float:left; background-color: white }

    #loginpage_box{ margin:0 auto; width:1320px; height:700px;  float: inside; background-color: white }

    #login_box{ margin:0 auto; width:620px; height:500px;  float: inside; background-color: white}

    #login_box_margin{margin:0 auto; width:620px; height:140px; float: inside; background-color: white;}

    #login_box_title{margin:0 auto; width:620px; height:70px; float: inside; background-color: white; text-align: center}

    #login_box_idpw{ margin:0 auto; width:620px;  float: inside;  background-color: white; }

    #login_box_idpw_inside{ margin:0 auto; width:500px; height:110px;  float: inside; background-color: white; text-align: center}

    #login_box_idpw_inside_id{ margin:0 auto; width:500px; height:50px;  float: inside; background-color: white;}

    #login_box_idpw_inside_pw{margin:0 auto; width:500px; height:50px;  float: inside; background-color: white;}


    #login_box_login_button{ margin:0 auto; width:500px; height:60px;  float: inside;  background-color: white; text-align: center }
    #login_box_join_button{ margin:0 auto; width:500px; height:50px;  float: inside;  background-color: white; text-align: center }

    #login_box_more{ margin:0 auto; width:500px; height:30px;  float: inside;  background-color: white;}


    #login_box_more2{ margin:0 auto; width:175px; height:30px;  float: right;  background-color: white;}






    input {
        width:500px;
        height:40px;
        padding: 5px;
        font-size:15px;
        border: 2px solid #ddd;
    }

    .button {
        background-color: #000000;
        border: none;
        color: white;
        width: 500px;
        height: 50px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        text-align: center;
        cursor: pointer;
    }

    a{
        text-decoration: none;
        color: black;
    }




    @media (max-width:1320px)
    {
        #loginpage_box{ width:100%;}


    }
    @media (max-width:990px)
    {

        #loginpage_box{height:500px;}

        #login_box{ width:100%;}
        #login_box_margin{width:90%;}

        #login_box_title{width:90%;}
        #login_box_idpw{width:90%;}
        #login_box_idpw_inside{width:380px;}

        #login_box_idpw_inside_id{width:380px;}

        #login_box_idpw_inside_pw{width:380px;}

        #login_box_login_button{width:380px;}
        #login_box_join_button{width:380px;}

        #login_box_more{width:380px;}


        #login_box_margin{height:70px;}

        input {
            width:380px;
            height:40px;
        }

        .button {
            width: 380px;height: 40px;
        }


        #login_box_login_button{height:50px; }

        #login_box_more2{ margin:0 auto; width:380px; height:30px;  background-color: white;}


    }


    @media (max-width:600px)

    {
        input {
            width:300px;
            height:40px;
        }

        .button {
            width: 300px;height: 40px;
        }

        #login_box_idpw_inside{width:300px;}

        #login_box_idpw_inside_id{width:300px;}

        #login_box_idpw_inside_pw{width:300px;}

        #login_box_login_button{width:300px;}
        #login_box_join_button{width:300px;}
        #login_box_more{width:300px;}

        #login_box_more2{ margin:0 auto; width:300px; height:30px;  background-color: white;}




    }

</style>


<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/api/swiper.css">
    <link rel="stylesheet" href="/api/swiper.min.css">
    <script src="/api/swiper.js"></script>
    <script src="/api/swiper.min.js"></script>


    <title>FITME</title>
</head>


<body>

<div id="header"></div>



<div id="center_box" >

    <div id="loginpage_box">

        <div id="login_box">

            <div id="login_box_margin" >


            </div>


            <div id="login_box_title" >

                <p style="font-size:20px;">LOGIN</p>

            </div>

            <div id="login_box_idpw">

                <div id="login_box_idpw_inside">

                    <form method="post" action="http://49.247.136.36/main/fitme_session_login_ok.php" class="form-signin"
                          name="loginForm">
                        <span id="reauth-email" class="reauth-email"></span>
                        <input type="text" id="inputEmail" class="form-control" placeholder="ID" name="username"
                               required autofocus>

                        <br>

                        <input type="password" id="inputPassword" class="form-control" placeholder="PASSWORD" style="margin-top: 10px;"
                               name="password" required>





                </div>

                <div id="login_box_login_button">

                    <button class="button" type="submit">로그인</h1></button>

                </div>


                <div id="login_box_join_button">

                    <button class="button" onclick="location.href='http://49.247.136.36/main/member/join_first.php'">회원가입</button>

                </div>

                <div id="login_box_more" style="margin-top: 10px;">




                    <div id="login_box_more2" style="text-align: end;">


                        <a style="font-size: 14px;" href="http://49.247.136.36/main/member/find_id.php"> 아이디 찾기</a> | <a style="font-size: 14px;" href="http://49.247.136.36/main/member/find_pw.php"> 비밀번호 찾기 </a>


                    </div>





                </div>

                </form><!-- /form -->



            </div>

        </div>

    </div>

</div>





<div id="footer"></div>
</body>

<script>
    $('#header').load("http://49.247.136.36/main/head.php");
    $('#footer').load("http://49.247.136.36/main/foot.php");
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
        console.log("페이지높이:" + $(window).height());
        console.log("현재스크롤:" + scrollValue);
        console.log("화면높이:" + Height);
        console.log("이벤트div" + $("#foot").prop('scrollHeight'));
    });
</script>
</html>
