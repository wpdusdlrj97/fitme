<?php
$conn = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($conn, 'utf8');

/*
 *  페이지 이름 - 아이디 찾기 완료 페이지
 *
 *  페이지 흐름 - find_id.php -> find_id_okay.php 
 *
 *
 *  페이지 설명 - 이름과 이메일에 일치하는 행의 아이디를 조회하기
 *
 *
 */


// 사용자 이름, 이메일
$input_name = $_POST['input_name'];
$input_email = $_POST['input_email'];



//이름과 이메일에 일치하는 행의 아이디를 조회하기
$query_id="select * from user_information where name='$input_name ' and email='$input_email'";
$result_id=mysqli_query($conn,$query_id);
$row_id = mysqli_fetch_assoc($result_id);
$total_rows_id = mysqli_num_rows($result_id);

if($total_rows_id == 0){ // 아이디 조회했을 때 해당 이름과 이메일로 가입된 계정이 없을 경우
    echo "<script> alert('해당 이름과 이메일로 가입된 계정이 존재하지 않습니다'); history.back();</script>";
}else{ ?>




    <html>

    <style>
        html{ scroll-behavior: smooth; }
        body{ padding:0; margin:0; font-family: 'Noto Sans KR', sans-serif; }

        .form-style-2 {
            max-width: 1500px;
            font: 13px Arial, Helvetica, sans-serif;
        }

        .form-style-2-heading {
            font-weight: bold;
            border-bottom: 1px solid #ddd;
            font-size: 17px;
            margin-top: 10px;
            margin-left: 10px;
            padding-bottom: 3px;
        }

        .form-style-2 label {
            display: block;
            margin-left: 10px;
            border-bottom: 1px solid #ddd;
            padding: 15px;
        }

        .form-style-2 label > span {
            width: 150px;
            float: left;
            padding-top: 3px;
            padding-right: 5px;
        }

        .form-style-2 span.required {
            color: red;
        }

        .form-style-2 .tel-number-field {
            width: 60px;
            text-align: center;
        }

        .form-style-2 input.input-field, .form-style-2 .select-field {
            width: 200px;
            height: 30px;
        }

        .form-style-2 input.input-field,
        .form-style-2 .tel-number-field,
        .form-style-2 .textarea-field,
        .form-style-2 .select-field {
            box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            border: 1px solid #C2C2C2;
            box-shadow: 1px 1px 4px #EBEBEB;
            -moz-box-shadow: 1px 1px 4px #EBEBEB;
            -webkit-box-shadow: 1px 1px 4px #EBEBEB;
            border-radius: 3px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
            padding: 7px;
            outline: none;
        }

        .form-style-2 .input-field:focus,
        .form-style-2 .tel-number-field:focus,
        .form-style-2 .textarea-field:focus,
        .form-style-2 .select-field:focus {
            border: 1px solid #0C0;
        }

        .form-style-2 .textarea-field {
            height: 100px;
            width: 55%;
        }

        .form-style-2 input[type=submit],
        .form-style-2 input[type=button] {
            border: none;
            padding: 8px 15px 8px 15px;
            background: #FF8500;
            color: #fff;
            box-shadow: 1px 1px 4px #DADADA;
            -moz-box-shadow: 1px 1px 4px #DADADA;
            -webkit-box-shadow: 1px 1px 4px #DADADA;
            border-radius: 3px;
            -webkit-border-radius: 3px;
            -moz-border-radius: 3px;
        }

        .form-style-2 input[type=submit]:hover,
        .form-style-2 input[type=button]:hover {
            background: #EA7B00;
            color: #fff;
        }

        .button {
            background-color: #000000;
            border: none;
            margin-left: 20px;
            color: white;
            width: 150px;
            height: 50px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            text-align: center;
            cursor: pointer;

        }





        #center_box{ margin:0 auto; width:100%; float:left; background-color: white }

        #registerpage_box{ margin:0 auto; width:1320px; height:600px;  float: inside; background-color: white }

        #registerpage_box_inside{ margin:0 auto; width:990px; height:600px;  float: inside; background-color: white}

        #margin_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }


        #content_box{ margin:0 auto; width:100%; float: left; background-color: white; border: 1px solid #ddd;}

        #member_box_image{ margin-left: 50px; width:200px; float: left; height:200px; background-color: white}

        #image_success{ margin: 50px; height:100px}

        #member_box_content{ width:70%; float: left; background-color: white}

        #member_box_content_title_box{ margin-top: 60px; width:100%; float: left; background-color: white}

        #member_box_content_title{ margin: 0px; font-size: 24px;}

        #member_box_content_info_box{ margin-top: 20px; width:100%; float: left; background-color: white}

        #member_box_content_info{ margin-top: 5px; font-size: 15px; font-weight: lighter; padding_bottom:10px;}






        #title_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }

        #check_box{ margin:0 auto; padding: 10px; width:988px; height:750px;  float: left; background-color: #F5F6F7 }



        #check_box_finish{ margin:0 auto; width:100%; height:100px;  float: left;  background-color: white; text-align: end; }








        @media (max-width:1320px)
        {
            #registerpage_box{ width:100%;}





        }




        @media (max-width:990px)
        {

            #registerpage_box{ height: 500px;}

            #registerpage_box_inside{ width:90%;}


            #member_box_image{ margin-left: 5%; width:100px; float: left; height:100px;}
            #image_success{ margin: 15px; height:70px}


            #member_box_content{ margin-left: 5%;}

            #member_box_content_title_box{ margin-top: 15px; width:100%; float: left; }
            #member_box_content_title{ margin: 0px; font-size: 18px;}



            #member_box_content_info{ margin: 0px; font-size: 13px;}


            #member_box_content_info_box{ margin-top: 5px; width:100%; float: left; background-color: white}

            #margin_box{ width:100%;}
            #title_box{ width:100%;}


            #check_box{ width:100%;}


            .button {
                width: 100px;
                height: 40px;

            }


        }


        @media (max-width:600px)
        {

            #registerpage_box{ height:400px; }
            #registerpage_box_inside{ height:400px; }

            #member_box_image{ margin-left: 10px; margin-bottom: 10px; width:70px; float: left; height:70px;}
            #image_success{ margin: 15px; height:50px}


            #member_box_content_title_box{ margin-top: 15px; width:100%; float: left; }
            #member_box_content_title{ margin: 0px; font-size: 16px;}

            #member_box_content_info{ margin: 0px; font-size: 11px;}
            #member_box_content_info_box{ margin-top: 7px; width:100%; float: left; background-color: white}



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

        <div id="registerpage_box">

            <div id="registerpage_box_inside">

                <div id="margin_box">

                </div>

                <div id="title_box" style="text-align: center;">

                    <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">FIND ID</p>

                </div>

                <div id="margin_box">

                </div>


                <div id="content_box" >

                    <div id="member_box_image" >

                        <img id='image_success' src="http://49.247.136.36/main/member/join_success.png" alt="My Image">


                    </div>

                    <div id="member_box_content">


                        <div id="member_box_content_title_box">

                            <h1 id="member_box_content_title">아이디 찾기가 완료되었습니다</h1>


                        </div>


                        <div id="member_box_content_info_box">


                            <h1 id="member_box_content_info">
                                아이디 : <span style="font-weight: bold"> <?php echo $row_id['id'];?> </span> (개인회원)
                            </h1>
                            <h1 id="member_box_content_info">고객님 즐거운 쇼핑 하세요!</h1>



                        </div>



                    </div>

                </div>


                <div id="margin_box">

                </div>


                <div id="check_box_finish">


                    <?php

                    // 상태 토큰으로 사용할 랜덤 문자열을 생성
                    $state = 'xyz';
                    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
                    $_SESSION['state'] = 'xyz';

                    ?>

                    <button class="button" type="button" onclick="location.href='http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz'">로그인하기</button>


                    <button class="button" type="button" onclick="location.href='http://49.247.136.36/main/member/find_password_1_html.php'">비밀번호 찾기</h1></button>



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


    <?php
}
?>


