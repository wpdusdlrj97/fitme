<?php
session_start();


/*
 *  페이지 이름 - 회원가입 2단계 페이지
 *
 *  페이지 흐름 - join_first.php -> join_second.php -> join_okay.php
 *
 *
 *  페이지 설명 - 약관동의 후 회원정보를 입력하는 페이지
 *              입력 필수사항 - 아이디, 비밀번호, 비밀번호 입력, 이름, 이메일
 *              입력 선택사항 - 주소, 일반전화, 휴대전화
 */

/*
 *  예외 처리 - 아이디 중복 확인, 비밀번호 일치 확인, 이메일 중복확인
 */


//광고성 홍보 수신 동의 -> 할경우 1, 체크 안할 경우 0
$agree3=($_GET['agree3'])?$_GET['agree3']:0;

?>

<html>



<style>
    html{ scroll-behavior: smooth; }
    body{ padding:0; margin:0; font-family: 'Noto Sans KR', sans-serif; }

    .form-style-2 {max-width: 1500px;font: 13px Arial, Helvetica, sans-serif;}
    .form-style-2-heading {font-weight: bold;border-bottom: 1px solid #d4d4d4;font-size: 17px;margin-top: 10px;margin-left: 10px;padding-bottom: 3px;}
    .form-style-2 label {display: block;margin-left: 10px;border-bottom: 1px solid #ddd;padding: 15px;}
    .form-style-2 label > span {width: 150px;float: left;padding-top: 3px;padding-right: 5px;}
    .form-style-2 span.required {color: red;font-size: 15px;}
    .form-style-2 .tel-number-field {width: 60px;text-align: center;}
    .form-style-2 input.input-field, .form-style-2 .select-field {width: 190px;height: 30px;}

    .form-style-2 input.input-field,
    .form-style-2 .tel-number-field,
    .form-style-2 .textarea-field,
    .form-style-2 .select-field {box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;border: 1px solid #C2C2C2;box-shadow: 1px 1px 4px #EBEBEB;-moz-box-shadow: 1px 1px 4px #EBEBEB;-webkit-box-shadow: 1px 1px 4px #EBEBEB;padding: 6px;outline: none;}

    .form-style-2 .input-field:focus,
    .form-style-2 .tel-number-field:focus,
    .form-style-2 .textarea-field:focus,
    .form-style-2 .select-field:focus {border: 1px solid #0C0;}

    .form-style-2 .textarea-field {height: 100px;width: 55%;}

    .form-style-2 input[type=submit],
    .form-style-2 input[type=button] {border: none;padding: 8px 15px 8px 15px;background: #FF8500;color: #fff;box-shadow: 1px 1px 4px #DADADA;-moz-box-shadow: 1px 1px 4px #DADADA;-webkit-box-shadow: 1px 1px 4px #DADADA;border-radius: 3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;}
    .form-style-2 input[type=submit]:hover,
    .form-style-2 input[type=button]:hover {background: #EA7B00;color: #fff;}

    .button {background-color: #000000;border: none;color: white;width: 150px;height: 50px;text-align: center;text-decoration: none;display: inline-block;font-size: 14px;text-align: center;cursor: pointer;}





    #center_box{ margin:0 auto; width:100%; float:left; background-color: white }

    #registerpage_box{ margin:0 auto; width:1320px; height:1000px;  float: inside; background-color: white }

    #registerpage_box_inside{ margin:0 auto; width:990px; height:1000px;  float: inside; background-color: white }

    #margin_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }

    #title_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }

    #check_box{ margin:0 auto; padding: 10px; width:988px; height:650px;  float: left; background-color:  white }
    #check_box_title{ margin:0 auto; width:988px; height:50px;  float: left;  background-color:  white }
    #check_box_content{ margin:0 auto; width:988px; height:150px;  float: left; text-align: center; background-color: white}


    #check_box_finish{ margin:0 auto; width:988px; height:50px;  float: left;  background-color: white }

    #button_check_id { background-color: white;border: 1px solid black ; color: black;width: 60px;height: 30px;  text-align: center;text-decoration: none;display: inline-block;font-size: 11px;text-align: center;cursor: pointer;}
    #button_post_number{ background-color:white;border: 1px solid black ; color: black;width: 60px;height: 30px; text-align: center;text-decoration: none;display: inline-block;font-size: 11px;text-align: center;cursor: pointer;}
    #button_check_email { background-color: white;border: 1px solid black ; color: black;width: 40px;height: 30px;  text-align: center;text-decoration: none;display: inline-block;font-size: 11px;text-align: center;cursor: pointer;}







    @media (max-width:1320px)
    {
        #registerpage_box{ width:100%;}

        #check_all_box_2_hidden{ display: none;}
        #check_box_content_hidden{ display: none;}
        #check_box_content_hidden{ display: none;}


    }




    @media (max-width:990px)
    {

        #registerpage_box{height:900px;}
        #registerpage_box_inside{ width:90%;}

        #margin_box{ width:100%;}
        #title_box{ width:100%;}
        #check_all_box{ width:100%;}


        #check_box{ width:100%;}
        #check_box_title{ width:100%;}
        #check_box_content{ width:100%;}

        #check_box_finish{ width:100%;}

        .button {
            width: 100px;
            height: 40px;

        }


    }

    @media (max-width:600px)
    {

        .form-style-2 label > span {
            width: 100px;
            float: left;
            padding-top: 3px;
            padding-right: 5px;
        }


    }



</style>


<!-- 아이디 중복 확인 시작-->
<!-- 빈칸이 아니며 아이디 형식에 맞는 아이디를 입력할 시 중복검사 페이지로 넘어가 중복 체크를 한다 (join_id_chk-->
<script>
    function check_id(){

        document.getElementById("chk_id2").value=0;
        var id=document.getElementById("input_ID").value;

        if(id==""){
            alert("빈칸을 채워주세요");
            exit;
        }

        if(id.length<4){
            alert("영문/숫자 4~16자 이내로 입력해주세요");
            exit;
        }

        if(id.length>16){
            alert("영문/숫자 4~16자 이내로 입력해주세요");
            exit;
        }

        ifrm1.location.href="join_id_chk.php?userid="+id;
    }
</script>

<!-- 이메일 중복 확인 시작-->
<!-- 빈칸이 아니며 이메일 형식에 맞는 이메일를 입력할 시 중복검사 페이지로 넘어가 중복 체크를 한다 (join_email_chk-->
<script>
    function check_email(){

        document.getElementById("chk_email2").value=0;
        var email=document.getElementById("input_email").value;
        var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

        if(email==""){
            alert("빈칸을 채워주세요");
            exit;
        }

        if(!reg_email.test(email)){
            alert("올바른 이메일 형식으로 입력해주세요");
            return;
        }

        ifrm1.location.href="join_email_chk.php?useremail="+email;
    }
</script>



<!-- 비밀번호 정규식 검사 및 일치여부 판단한 후 join_okay.php로 넘어간다 -->
<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {

        $("#join_button").click(function () {


            var id=$("#input_ID").val();
            var chk_id2=$("#chk_id2").val();

            var pwd1=$("#input_PW1").val();
            var pwd2=$("#input_PW2").val();
            var name=$("#input_name").val();

            var email=$("#input_email").val();
            var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;
            var chk_email2=$("#chk_email2").val();

            if(id==""){
                alert("아이디를 입력해주세요");
                return;
            }else if(chk_id2 != "1"){
                alert("아이디 중복검사를 해주세요");
                return;
            }else if(pwd1 == ""){
                alert("비밀번호를 입력해주세요");
                return;
            }else if(pwd2 == ""){
                alert("비밀번호 확인을 입력해주세요");
                return;
            }else if(pwd1.length<8 || pwd1.length>16){
                alert("영문/숫자 8~16자 이내로 입력해주세요1");
                return;
            }else if(pwd2.length<8 || pwd2.length>16){
                alert("영문/숫자 8~16자 이내로 입력해주세요2");
                return;
            }else if(pwd1 != pwd2){
                alert("비밀번호가 일치하지 않습니다");
                return;
            }else if(name == ""){
                alert("이름을 입력해주세요");
                return;
            }else if(email == ""){
                alert("이메일을 입력해주세요");
                return;
            }else if(!reg_email.test(email)){
                alert("올바른 이메일 형식으로 입력해주세요");
                return;
            }else if(chk_email2 != "1"){
                alert("이메일 중복검사를 해주세요");
                return;
            }else{
                $("#join_form").submit();
            }


        });




    });
</script>


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





<!-- 주소 검색 기능 시작-->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>
<script>

    function openZipSearch() {
        new daum.Postcode({
            oncomplete: function (data) {
                $('[name=buyer_postcode]').val(data.zonecode); // 우편번호 (5자리)
                $('[name=buyer_addr1]').val(data.address);
                $('[name=buyer_addr2]').val(data.buildingName);
            }
        }).open();
    }

</script>
<!-- 주소 검색 기능 끝-->





<body>

<div id="header"></div>



<div id="center_box" >

    <div id="registerpage_box">

        <div id="registerpage_box_inside">


            <form id="join_form" method="post" action="join_okay.php" name="join_form">

            <div id="margin_box">


            </div>

            <div id="title_box" style="text-align: center; margin-bottom: 20px;">

                <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">Membership #2</p>

            </div>

            <div id="check_box">

                <div class="form-style-2">
                    <div class="form-style-2-heading">기본정보  <span style="font-size: 11px;">( <span class="required">*</span> 필수 입력사항 )</span></div>



                    <label for="field1">
                        <span>아이디 <span class="required">*</span></span>
                        <input type="text" id="input_ID" name="input_ID" class="input-field"  placeholder="영문/숫자, 4~16자"  maxlength="16" minlength="4" style="width:125px; height:30px;" required autofocus/>
                        <button type="button" id="button_check_id" onclick="check_id();" >중복확인</button>
                        <input type=hidden id="chk_id2" name="chk_id2" value="0">
                    </label>


                    <label for="field1">
                        <span>비밀번호 <span class="required">*</span></span>
                        <input type="password" id="input_PW1" name="input_PW1" class="input-field" placeholder="영문/숫자, 8~16자" maxlength="16" minlength="8" required/>
                    </label>

                    <label for="field1">
                        <span>비밀번호 확인 <span class="required">*</span></span>
                        <input type="password" id="input_PW2" name="input_PW2" class="input-field" placeholder="비밀번호 재입력" maxlength="16" minlength="8" required/>
                    </label>

                    <label for="field1">
                        <span>이름 <span class="required">*</span></span>
                        <input type="text" id="input_name" name="input_name" class="input-field" placeholder="본명 입력" maxlength="16" required/>
                    </label>

                    <label style="border-bottom: 1px solid white; padding-bottom: 0px;">
                        <span>주소 </span>
                        <input type="text" id="buyer_postcode" name="buyer_postcode"  class="input-field" style="width:112px; height:30px;" readonly/>
                        <button id="button_post_number" type="button" onclick="openZipSearch()" style="margin-left: 10px;">우편번호</button>
                    </label>

                    <label style="border-bottom: 1px solid white; padding-bottom: 0px; margin-top: 0px;">
                        <span></span>
                        <input type="text" id="buyer_addr1" name="buyer_addr1" class="input-field" style="width:190px; height:30px; font-size: 11px;" readonly/>
                    </label>

                    <label style="margin-top: 0px;">
                        <span></span>
                        <input type="text" id="buyer_addr2" name="buyer_addr2" class="input-field" style="width:190px; height:30px; font-size: 11px;"/>
                    </label>


                    <label>
                        <span>일반전화</span>
                        <input type="text" id="tel_no_1" name="tel_no_1" class="tel-number-field"  maxlength="4" style="width:55px; height:30px;"/>
                        -
                        <input type="text" id="tel_no_2" name="tel_no_2"class="tel-number-field"  maxlength="4" style="width:55px; height:30px;" />
                        -
                        <input type="text" id="tel_no_3" name="tel_no_3" class="tel-number-field" maxlength="4" style="width:55px; height:30px;"/>
                    </label>

                    <label>
                        <span>휴대전화</span>
                        <input type="text" id="phone_no_1" name="phone_no_1" class="tel-number-field" maxlength="4" style="width:55px; height:30px;"/>
                        -
                        <input type="text" id="phone_no_2" name="phone_no_2" class="tel-number-field" maxlength="4" style="width:55px; height:30px;"/>
                        -
                        <input type="text" id="phone_no_3"  name="phone_no_3" class="tel-number-field" maxlength="4" style="width:55px; height:30px;"/>
                    </label>

                    <label for="field1">
                        <span>이메일 <span class="required">*</span></span>
                        <input type="email" id="input_email" name="input_email" class="input-field" name="input_email" placeholder=" '@' 포함 필수" maxlength="255"  style="width:145px; height:30px; font-size: 10.7px;" required/>
                        <button type="button" id="button_check_email" onclick="check_email();" >중복</button>
                        <input type=hidden id="chk_email2" name=chk_email2 value="0">
                    </label>

                    <?php if($agree3==1){?>
                        <input type=hidden id="chk_agree" name="chk_agree" value="1">
                    <?php }else{?>
                        <input type=hidden id="chk_agree" name="chk_agree" value="0">
                    <?php }?>



                </div>


            </div>

            <div id="check_box_finish" style="text-align: end; margin-top: 20px;" >


                <button type="button" class="button" id="join_button">회원가입</button>

            </div>

            <div id="margin_box">


            </div>

            </form><!-- /form -->


        </div>


    </div>

</div>





<div id="footer"></div>
</body>
<iframe src="" id="ifrm1" scrolling=no frameborder=no width=0 height=0 name="ifrm1"></iframe>

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
