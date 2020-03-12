<?php
session_start();

/*
 *  페이지 이름 - 비밀번호 찾기 페이지
 *
 *  페이지 흐름 - fitme_session_login.php -> find_pw.php -> find_pw_okay.php
 *
 *
 *  페이지 설명 - 아이디(중복X),이름,이메일(중복X)을 입력하면 DB 검출을 통해 이메일로 임시비밀번호를 발급한다
 *
 *
 */


?>


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
        padding: 3px;
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

    #member_box_content_title{ margin: 0px; font-size: 24px;}

    #member_box_content_info_box{ margin-top: 50px; width:100%;  float: left; background-color: white}

    #member_box_content_info{ margin: 0px; font-size: 15px; font-weight: lighter; padding_bottom:10px;}






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


        #member_box_image{ margin-left: 15px; width:120px; float: left; height:120px;}
        #image_success{ margin: 15px; height:90px}

        #member_box_content_title_box{ margin-top: 15px; width:100%; float: left; }
        #member_box_content_title{ margin: 0px; font-size: 18px;}

        #member_box_content_info{ margin: 0px; font-size: 13px;}

        #member_box_content_info_box{ margin-top: 10px;}

        .form-style-2 label > span {
            width: 60px;
            float: left;
            margin-left: 70px;
            padding-top: 3px;
            padding-right: 5px;
        }



        #margin_box{ width:100%;}
        #title_box{ width:100%;}


        #check_box{ width:100%;}

        .button {
            width: 100px;
            height: 40px;
        }

    }

    @media (max-width:670px)
    {

        #member_box_image{ margin-left: 15px; width:100px; float: left; height:120px;}
        #image_success{ margin: 25px; height:70px}

        .form-style-2 label > span {
            width: 60px;
            float: left;
            margin-left: 10px;
            padding-top: 3px;
            padding-right: 5px;
        }

        .form-style-2 input.input-field, .form-style-2 .select-field {
            width: 150px;
            height: 30px;
        }

        #member_box_image{ margin-left: 0px; }

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


<!--비밀번호 찾기 버튼을 눌렀을 때-->
<script type="text/javascript">
    $(document).ready(function () {

        $("#find_pw_button").click(function () {


            var input_ID=$("#input_ID").val();
            var input_name=$("#input_name").val();
            var input_email=$("#input_email").val();
            var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

            if(input_ID==""){
                alert("아이디를 입력해주세요");
                return;
            }else if(input_name==""){
                alert("이름를 입력해주세요");
                return;
            }else if(input_email==""){
                alert("이메일을 입력해주세요");
                return;
            }else if(!reg_email.test(input_email)){
                alert("올바른 이메일 형식으로 입력해주세요");
                return;
            }else{
                $("#find_pw_form").submit();
            }

        });

    });
</script>


<body>

<div id="header"></div>



<div id="center_box" >

    <div id="registerpage_box">

        <div id="registerpage_box_inside">

            <form id="find_pw_form" method="post" action="find_pw_okay.php" name="find_pw_form">

            <div id="margin_box">

            </div>

            <div id="title_box" style="text-align: center;">

                <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">FIND PASSWORD #1 </p>

            </div>

            <div id="margin_box">

            </div>


            <div id="content_box" >

                <div id="member_box_image" >

                    <img id='image_success' src="http://49.247.136.36/main/member/pw.png" alt="My Image">


                </div>

                <div id="member_box_content">



                    <div id="member_box_content_info_box">

                        <div class="form-style-2">

                            <label for="field1"><span>아이디 </span>
                                <input type="text" id="input_ID" name="input_ID" class="input-field"/></label>


                            <label for="field1"><span>이름 </span>
                                <input type="text" id="input_name" name="input_name" class="input-field"/></label>


                            <label for="field1"><span>이메일 </span>
                                <input type="text" id="input_email" name="input_email" class="input-field"/></label>



                        </div>


                    </div>



                </div>

            </div>


            <div id="margin_box">

            </div>


            <div id="check_box_finish">


                <button class="button" type="button" id="find_pw_button">비밀번호 찾기</h1></button>


            </div>

            </form><!-- /form -->


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
