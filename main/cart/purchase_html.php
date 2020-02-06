<?php
session_start();
$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe');
mysqli_set_charset($connect, 'utf8');

$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/cart/purchase_html.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}


//시간 순으로 정렬하기
$query = "SELECT * FROM order_form where user_id='$email' ";

$result = mysqli_query($connect, $query);

$total = mysqli_num_rows($result);


?>
<html>

<style>
    html {scroll-behavior: smooth;}
    body {padding: 0; margin: 0; font-family: 'Noto Sans KR', sans-serif; -ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none;}


    .form-style-2 {max-width: 1500px; font: 13px Arial, Helvetica, sans-serif;}
    .form-style-2-heading {font-weight: bold;border-bottom: 1px solid #ddd;font-size: 13px;padding-bottom: 3px;}

    .form-style-2 label {display: block;font-size: 12px;margin-left: 10px;border-bottom: 1px solid #ddd;padding: 15px;}
    .form-style-2 label > span {width: 100px;float: left;padding-top: 3px;padding-right: 5px;}

    .form-style-2 span.required {color: red;}

    .form-style-2 .tel-number-field {width: 60px;text-align: center;}

    .form-style-2 input.input-field, .form-style-2 .select-field {width: 20%;}

    .form-style-2 input.input-field,
    .form-style-2 .tel-number-field,
    .form-style-2 .textarea-field,
    .form-style-2 .select-field {box-sizing: border-box;-webkit-box-sizing: border-box;-moz-box-sizing: border-box;border: 1px solid #C2C2C2;box-shadow: 1px 1px 4px #EBEBEB;-moz-box-shadow: 1px 1px 4px #EBEBEB;-webkit-box-shadow: 1px 1px 4px #EBEBEB;-webkit-border-radius: 3px;-moz-border-radius: 3px;padding: 7px;outline: none;}
    .form-style-2 .input-field:focus,
    .form-style-2 .tel-number-field:focus,
    .form-style-2 .textarea-field:focus,
    .form-style-2 .select-field:focus {border: 1px solid #0C0;}

    .form-style-2 .textarea-field {height: 100px;width: 65%;}

    .form-style-2 input[type=submit],
    .form-style-2 input[type=button] {border: none;padding: 8px 15px 8px 15px;background: #FF8500;color: #fff;box-shadow: 1px 1px 4px #DADADA;-moz-box-shadow: 1px 1px 4px #DADADA;-webkit-box-shadow: 1px 1px 4px #DADADA;border-radius: 3px;-webkit-border-radius: 3px;-moz-border-radius: 3px;}

    .form-style-2 input[type=submit]:hover,
    .form-style-2 input[type=button]:hover {background: #EA7B00;color: #fff;}

    #customers {font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;border-collapse: collapse;width: 100%;}


    .button {background-color: #000000;border: none;color: white;padding: 10px 25px;text-align: center;text-decoration: none;display:
             inline-block;font-size: 12px;margin: 4px 2px;cursor: pointer;border-radius: 10px;}





    #center_box {margin: 0 auto;width: 100%;float: left;background-color: white}

    #orderpage_box {margin: 0 auto;width: 1320px;float: inside;background-color: white}

    #margin_box {margin: 0 auto;width: 1320px;height: 50px;float: left;background-color: white}

    #title_box {margin: 0 auto;width: 1320px;height: 50px;float: left;background-color: white}

    #table_box {margin: 0 auto;width: 1320px;float: left;background-color: white}

    #table_box1 {margin: 0 auto;width: 1320px; float: left; background-color: white}
    #table_box2 {margin: 0 auto;width: 1320px; float: left; background-color: white}
    #table_box3 {margin: 0 auto;width: 1320px; float: left; background-color: white}
    #table_box3_delete_button {background-color: dimgray; border: none;color: white;text-align: center;text-decoration: none;display:
        inline-block;font-size: 12px;  cursor: pointer;}




    #table_box4 {margin: 0 auto;width: 1320px; float: left;  border-bottom: 1px solid #ddd;background-color: #F5F6F7;}
    #table_box5 {margin: 0 auto;width: 1320px; text-align: end;  float: left;background-color: white}

    #table_box5_button {background-color: dimgray; border: none;color: white; padding: 5px 10px;text-align: center;text-decoration: none;display:
        inline-block;font-size: 12px; margin-top:7px; cursor: pointer;}











    #info_box {margin: 0 auto;width: 1320px;float: left;background-color: white}


    #purchase_box {margin: 0 auto;width: 1320px;float: left;background-color: white}

    #purchase_box1 {margin: 0 auto;width: 1320px; float: left;background-color: white}

    #purchase_box2 {margin: 0 auto;width: 1320px; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; float: left;background-color: #F5F6F7;}

    #purchase_box2_1 {margin: 0 auto; width: 33.3%; height: 80px; float: left;background-color: #F5F6F7; text-align: center;}
    #purchase_box2_2 {margin: 0 auto; width: 33.3%; height: 80px; float: left;background-color: #F5F6F7; text-align: center;}
    #purchase_box2_3 {margin: 0 auto; width: 33.3%; height: 80px; float: left;background-color: #F5F6F7; text-align: center;}



    #purchase_box3 {margin: 0 auto;width: 1320px; border-bottom: 1px solid #ddd; float: left;background-color: white;}

    #purchase_box3_1 {margin: 0 auto; width: 33%; height: 100px; border-right: 1px solid #ddd; float: left;background-color: white; text-align: center;}
    #purchase_box3_2 {margin: 0 auto; width: 33%; height: 100px; border-right: 1px solid #ddd; float: left;background-color: white; text-align: center;}
    #purchase_box3_3 {margin: 0 auto; width: 33%; height: 100px; float: left; background-color: white; text-align: center;}

    #purchase_box4 {margin: 0 auto;width: 1320px; border-bottom: 1px solid #ddd; float: left;background-color: white;}

    #purchase_box4_1 {margin: 0 auto; width: 17%; height: 50px; float: left;background-color: white; text-align: center;}
    #purchase_box4_2 {margin: 0 auto; width: 83%; height: 50px; float: left;background-color: #F5F6F7; }

    #purchase_box5 {margin: 0 auto;width: 1320px; border-bottom: 1px solid #ddd; float: left;background-color: white;}

    #purchase_box5_1 {margin: 0 auto; width: 17%; height: 50px; float: left;background-color: white; text-align: center;}
    #purchase_box5_2 {margin: 0 auto; width: 83%; height: 50px; float: left;background-color: #F5F6F7; }

    #purchase_box6 {margin: 0 auto;width: 1320px; border-bottom: 1px solid #ddd; float: left;background-color: white;}

    #purchase_box6_1 {margin: 0 auto; width: 17%; height: 50px; float: left;background-color: white; text-align: center;}
    #purchase_box6_2 {margin: 0 auto; width: 83%; height: 50px; float: left;background-color: #F5F6F7; }
    #purchase_box6_button {background-color: dimgray;border: none;color: white; padding: 10px 25px;text-align: center;text-decoration: none;display:
                            inline-block;font-size: 12px; margin-top:7px; cursor: pointer;}


    #purchase_box7 {margin: 0 auto;width: 1320px; border-bottom: 1px solid#ddd; float: left;background-color: white;}

    #purchase_box7_1 {margin: 0 auto; width: 17%; height: 50px; float: left;background-color: white; text-align: center;}
    #purchase_box7_2 {margin: 0 auto; width: 83%;  float: left;background-color: #F5F6F7; }
    #purchase_box7_2_1 {margin: 0 auto; width: 100%; height: 40px; float: left;background-color:#F5F6F7; }
    #purchase_box7_2_1_1 {margin: 0 auto; width: 130px; height: 40px; float: left;background-color:#F5F6F7; }
    #purchase_box7_2_1_2 {margin: 0 auto; width: 200px; height: 40px; float: left;background-color: #F5F6F7; }


    #purchase_box7_2_2 {margin: 0 auto; width: 100%;  float: left;background-color: #F5F6F7; }
    #purchase_box7_2_2_1 {margin: 0 auto; width: 280px;  float: left;background-color: #F5F6F7; }


    #method_box {margin: 0 auto;width: 1320px; float: left;background-color: white}

    #method_box0 {margin: 0 auto;width: 1320px; height:40px; float: left;background-color: white}

    #method_box1 {margin: 0 auto;width: 80%; float: left; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: white}

    #method_box1_1 {margin: 0 auto;width: 100%; float: left;background-color: white}

    #method_box1_2{margin: 0 auto;width: 100%; height:250px; float: left; border-top: 1px solid #ddd; background-color: white}


    #method_box2 {margin: 0 auto;width: 20%; height: 300px; float: left;background-color: #F5F6F7;}
    #method_box2_button {background-color: dimgray;border: none;color: white; padding: 10px 25px;text-align: center;text-decoration: none;display:
        inline-block;font-size: 12px; margin-top:7px; cursor: pointer;}

    #method_box3 {margin: 0 auto; width: 100%;  margin-top: 30px; float: left; background-color: white; display: none;}

    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }






    @media (max-width: 1320px) {
        #orderpage_box {width: 100%;}
        #registerpage_box_inside {width: 100%;}
        #margin_box {width: 100%;}
        #title_box {width: 100%;}
        #table_box {width: 100%;}
        #table_box1 {width: 100%;}
        #table_box2 {width: 100%;}
        #table_box3 {width: 100%;}
        #table_box4 {width: 100%;}
        #table_box5 {width: 100%;}



        #info_box {width: 100%;}
        #purchase_box {width: 100%;}

        #purchase_box1 {width: 100%;}
        #purchase_box2 {width: 100%;}
        #purchase_box3 {width: 100%;}

        #purchase_box4 {width: 100%;}
        #purchase_box5 {width: 100%;}
        #purchase_box6 {width: 100%;}
        #purchase_box7 {width: 100%;}

        #method_box {width: 100%;}
        #method_box0 {width: 100%;}





    }


    @media (max-width: 990px) {

        #method_box1 {width: 100%; }
        #method_box2 {display: none;}
        #method_box3 {display: block;}
        #method_box1_2{height:150px; }


    }

    @media (max-width: 750px) {

        #th_delete {display: none;}
        #td_delete {display: none;}


    }


    @media (max-width: 600px) {

        #purchase_box4_1 {margin: 0 auto; width: 25%;}
        #purchase_box4_2 {margin: 0 auto; width: 75%;}
        #purchase_box5_1 {margin: 0 auto; width: 25%;}
        #purchase_box5_2 {margin: 0 auto; width: 75%;}
        #purchase_box6_1 {margin: 0 auto; width: 25%;}
        #purchase_box6_2 {margin: 0 auto; width: 75%;}
        #purchase_box7_1 {margin: 0 auto; width: 25%;}
        #purchase_box7_2 {margin: 0 auto; width: 75%;}
        #purchase_box7_2_1 {margin: 0 auto; width: 75%;}
        #purchase_box7_2_2 {margin: 0 auto; width: 75%;}



    }




</style>

<!-- 주소 검색 -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="https://ssl.daumcdn.net/dmaps/map_js_init/postcode.v2.js"></script>


<script type="text/javascript">
    $(document).ready(function () {
        // DOM 생성 완료 시 화면 숨김 (파라미터로 전달되는 id는 제외)
        hideExclude("change_card");
        hideExclude_button("change_card_button");
        hideExclude_button2("change_card_button2");

        // radio change 이벤트
        $("input[name=radioName]").change(function () {
            var radioValue = $(this).val();
            if (radioValue == "card") {
                hideExclude("change_card");
                hideExclude_button("change_card_button");
                hideExclude_button2("change_card_button2");

            } else if (radioValue == "trans") {
                hideExclude("change_trans");
                hideExclude_button("change_trans_button");
                hideExclude_button2("change_trans_button2");

            } else if (radioValue == "phone") {
                hideExclude("change_phone");
                hideExclude_button("change_phone_button");
                hideExclude_button2("change_phone_button2");

            } else if (radioValue == "none_bank") {
                hideExclude("change_none_bank");
                hideExclude_button("change_none_bank_button");
                hideExclude_button2("change_none_bank_button2");

            } else if (radioValue == "vbank") {
                hideExclude("change_vbank");
                hideExclude_button("change_vbank_button");
                hideExclude_button2("change_vbank_button2");

            }
        });
        // 체크 되어 있는지 확인
        var checkCnt = $("input[name=radioName]:checked").size();
        if (checkCnt == 0) {
            // default radio 체크 (첫 번째)
            $("input[name=radioName]").eq(0).attr("checked", true);
        }
    });

    // text area 숨김
    function hideExclude(excludeId) {
        $("#changeTextArea").children().each(function () {
            $(this).hide();
        });
        // 파라미터로 넘겨 받은 id 요소는 show
        $("#" + excludeId).show();
    }

    // text area 숨김
    function hideExclude_button(excludeId) {
        $("#changeTextArea_button").children().each(function () {
            $(this).hide();
        });
        // 파라미터로 넘겨 받은 id 요소는 show
        $("#" + excludeId).show();
    }

    // text area 숨김
    function hideExclude_button2(excludeId) {
        $("#changeTextArea_button2").children().each(function () {
            $(this).hide();
        });
        // 파라미터로 넘겨 받은 id 요소는 show
        $("#" + excludeId).show();
    }

</script>

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



<script type="text/javascript">

    //상품 삭제 시 사용되는 함수
    function delete_product(order_key) {
        var order_key_delete = order_key;
        var quest = confirm('해당 상품을 삭제하시겠습니까?');
        if (quest) // 예를 선택하실 경우;;

        {
            location.href = " http://49.247.136.36/main/cart/order_delete_product.php?order_key=" + order_key_delete;
        }
    }

</script>





<!-- 적립금을 입력할 시-->
<script type="text/javascript">

    function comma(num){
        var len, point, str;
        num = num + "";
        point = num.length % 3 ;
        len = num.length;
        str = num.substring(0, point);
        while (point < len) {
            if (str != "") str += ",";
            str += num.substring(point, point + 3);
            point += 3;
        }
        return str;
    }


    $(document).ready(function(){

        // 입력란에 입력을 하면 입력내용에 내용이 출력

        // 1. #data 공간에서 keyup이라는 이벤트가 발생했을 때

        $("#use_save").keyup(function(){


            // 2. #out 공간에 #data의 내용이 출력된다.


            if(Number($("#use_save").val())>$("#user_save_amount_hidden").text()){
                alert("적립금 이상으로 사용하실 수 없습니다");
                $("#use_save").val(0);
                $("#order_save").text(comma($("#use_save").val()));

                $("#box3_discount_amount").text(comma(Number($("#order_coupon_hidden").text())+Number($("#use_save").val())));
                $("#box3_discount_amount_hidden").text(Number($("#order_coupon_hidden").text())+Number($("#use_save").val()));

                $("#box3_purchase_amount").text(comma(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text())));
                $("#box3_purchase_amount_hidden").text(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text()));

                $("#final_amount_card").text($("#box3_purchase_amount").text());
                $("#final_amount_card_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_trans").text($("#box3_purchase_amount").text());
                $("#final_amount_trans_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_none").text($("#box3_purchase_amount").text());
                $("#final_amount_none_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_phone").text($("#box3_purchase_amount").text());
                $("#final_amount_phone_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_vbank").text($("#box3_purchase_amount").text());
                $("#final_amount_vbank_hidden").text($("#box3_purchase_amount_hidden").text());

                exit;
            }
            if($("#use_save").val()=="")
            {
                $("#use_save").val(0);
                $("#order_save").text(comma(Number($("#use_save").val())));

                $("#box3_discount_amount").text(comma(Number($("#order_coupon_hidden").text())+Number($("#use_save").val())));
                $("#box3_discount_amount_hidden").text(Number($("#order_coupon_hidden").text())+Number($("#use_save").val()));

                $("#box3_purchase_amount").text(comma(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text())));
                $("#box3_purchase_amount_hidden").text(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text()));

                $("#final_amount_card").text($("#box3_purchase_amount").text());
                $("#final_amount_card_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_trans").text($("#box3_purchase_amount").text());
                $("#final_amount_trans_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_none").text($("#box3_purchase_amount").text());
                $("#final_amount_none_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_phone").text($("#box3_purchase_amount").text());
                $("#final_amount_phone_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_vbank").text($("#box3_purchase_amount").text());
                $("#final_amount_vbank_hidden").text($("#box3_purchase_amount_hidden").text());

                exit;
            }

                $("#order_save").text(comma(Number($("#use_save").val())));

                $("#box3_discount_amount").text(comma(Number($("#order_coupon_hidden").text())+Number($("#use_save").val())));
                $("#box3_discount_amount_hidden").text(Number($("#order_coupon_hidden").text())+Number($("#use_save").val()));

                $("#box3_purchase_amount").text(comma(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text())));
                $("#box3_purchase_amount_hidden").text(Number($("#box3_order_amount_hidden").text())-Number($("#box3_discount_amount_hidden").text()));

                $("#final_amount_card").text($("#box3_purchase_amount").text());
                $("#final_amount_card_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_trans").text($("#box3_purchase_amount").text());
                $("#final_amount_trans_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_none").text($("#box3_purchase_amount").text());
                $("#final_amount_none_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_phone").text($("#box3_purchase_amount").text());
                $("#final_amount_phone_hidden").text($("#box3_purchase_amount_hidden").text());

                $("#final_amount_vbank").text($("#box3_purchase_amount").text());
                $("#final_amount_vbank_hidden").text($("#box3_purchase_amount_hidden").text());






            // #out의 위치에 text로 데이터를 받는다.(setter)

            // 들어가는 데이터는 #data의 값(.val())이다. (getter)

            // 메서드 괄호 안에 아무것도 없으면 getter, 파라미터가 있으면 setter이다.

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

    <!--우클릭 방지 -->
    <script type="text/javascript">
        // F12 버튼 방지
        $(document).ready(function(){
            $(document).bind('keydown',function(e){
                if ( e.keyCode == 123 /* F12 */) {
                    e.preventDefault();
                    e.returnValue = false;
                }
            });
        });

        // 우측 클릭 방지
        document.onmousedown=disableclick;

        function disableclick(event){
            if (event.button==2) {
                return false;
            }
        }
    </script>


    <title>FITME</title>
</head>


<body oncontextmenu='return false' onselectstart='return false' ondragstart='return false'>

<div id="header"></div>


<div id="center_box">

    <div id="orderpage_box">

        <div id="registerpage_box_inside">

            <div id="margin_box">

            </div>

            <div id="title_box" style="text-align: center;">

                <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">ORDER FORM</p>

            </div>

            <div id="margin_box">

            </div>


            <div id="table_box">

                <div id="table_box1">
                    <img src="message.png" alt="My Image" width="12" height="12" style="margin-left: 10px; ">
                    <span style="font-size: 11px; color: red; padding:5px; display:inline-block;">상품의 옵션 및 수량 변경은 상품상세 또는 장바구니에서 가능합니다.</span>
                </div>

                <div id="table_box2">

                    <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-left: 10px;">국내배송상품 주문내역</span>


                </div>

                <div id="table_box3">


                        <table id="customers"">
                            <tr style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
                                <th> <span style="font-size: 12px; color: black; padding:1px; margin-top: 10px; margin-bottom: 10px; display:inline-block;">이미지</span></th>
                                <th><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">상품명/옵션</span></th>
                                <th><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">판매가</span></th>
                                <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">수량</span></th>
                                <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">적립금</span></th>
                                <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송구분</span></th>
                                <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송비</span></th>
                                <th id="th_delete"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">합계</span></th>
                                <th><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">선택</span></th>


                            </tr>


                            <tbody style="border-bottom: 1px solid #ddd;">
                            <?php

                            //총 주문 금액
                            $order_amount=0;

                            //배송비
                            $order_delivery=2500;

                            //사용자의 적립금
                            $user_save_amount=4000;
                            //적립금 할인 금액
                            $order_save=0;
                            //쿠폰 할인 금액
                            $order_coupon=0;

                            //총 할인 금액
                            $order_discount=$order_save+ $order_coupon;

                            //상품명
                            $buy_product_array = array();


                           while ($rows = mysqli_fetch_assoc($result)) { //DB에 저장된 데이터 수 (열 기준)

                                $order_key = $rows['order_key'];
                                $product_image = $rows['product_image'];
                                $product_name = $rows['product_name'];
                                $product_size = $rows['product_size'];
                                $product_color = $rows['product_color'];
                                $product_amount = $rows['product_amount'];
                                $product_count = $rows['product_count'];



                                //상품 적립금
                                $ten_percent=100;
                                $product_save=$product_amount*$product_count/$ten_percent;
                                //상품 합계
                                $product_amount_all=$product_amount*$product_count;

                                $order_amount=$order_amount+$product_amount_all;

                                //상품명 배열
                                array_push($buy_product_array,$product_name);

                                ?>

                            <!-- 상품 이미지 -->
                            <td width="10%" align="center"><img src="<?php echo $product_image; ?>" alt="My Image" width="90" height="90" style="margin-top:15px; margin-bottom: 15px;"></td>
                            <!-- 상품명/옵션 -->
                            <td width="30%" align="center">
                                <div name='buy_product_name' id='buy_product_name' style="font-size: 12px; color: black; padding:1px; display:inline-block;">
                                    <?php echo $product_name; ?></div><br>
                                <div style="font-size: 12px; color: black; padding:1px; display:inline-block;">
                                    <?php echo '[옵션 - '.$product_color.', '. $product_size.']'; ?>
                                </div>
                            </td>
                            <!-- 상품 판매가 -->
                            <td width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($product_amount); ?></span></td>
                            <!-- 상품 수량 -->
                            <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo $product_count; ?></span></td>
                            <!-- 상품 적립금 -->
                            <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"> <?php echo number_format($product_save); ?> </span></td>
                            <!-- 배송구분 -->
                            <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '기본배송'; ?></span></td>
                            <!-- 배송비 -->
                            <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '무료'; ?></span></td>
                            <!-- 합계 -->
                            <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($product_amount_all);?> </span></td>
                            <!-- 선택/삭제-->
                            <td width="5%" align="center" > <button id="table_box3_delete_button" type="button" class="btnDel" onclick="delete_product('<?php echo $order_key; ?>')"> X </button></td>

                            </tbody>

                            <?php
                            }
                            ?>


                        </table>



                </div>

                <div id="table_box4" style="text-align: end">


                    <span style="font-size: 12px; color: black; padding:1px; margin-top: 10px; margin-bottom: 10px; display:inline-block;">상품구매금액</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($order_amount); ?></span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;">+ 배송비</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($order_delivery); ?></span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"> = 합계 : </span>

                    <span style="font-size: 14px; font-weight: bold; color: black; padding:1px; display:inline-block;"><?php echo number_format($order_amount+$order_delivery); ?></span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"> 원</span>

                    <div id="buy_product_count" name="buy_product_count" style="font-size: 12px; color: black; padding:1px; display:none;"> <?php echo count($buy_product_array); ?> </div>

                    <div id="buy_product_first" name="buy_product_first" style="font-size: 12px; color: black; padding:1px; display:none;"> <?php echo $buy_product_array[0]; ?> </div>

                </div>

                <div id="table_box5">

                    <button id="table_box5_button" type="button" style="margin-right: 5px;"> 이전페이지 </button>

                </div>


            </div>

            <div id="margin_box">

            </div>

            <div id="info_box">

                <div class="form-style-2" style="padding: 10px;">
                    <div class="form-style-2-heading">주문 정보</div>

                    <label for="field2"><span>배송지 선택<span class="required">*</span> </span>
                        <input type='radio' name='address_choice' value='new' checked/>신규배송지
                        &nbsp;&nbsp;&nbsp;<input type='radio' name='address_choice' value='basic'/>기본배송지</label>


                    <label for="field1"><span>주문하시는 분 <span class="required">*</span></span>
                        <input type="text" class="input-field" name="buyer_name" id="buyer_name" value="조제연"
                               style="width:120px; height:26px;"/></label>

                    <label style="border-bottom: 1px solid white; padding-bottom: 0px;"><span>주소<span
                                    class="required">*</span> </span><input type="text" class="input-field"
                                                                            name="buyer_postcode" id="buyer_postcode"
                                                                            style="width:80px; height:26px;"
                                                                            readonly/>
                        <button type="button" onclick="openZipSearch()" style="margin-left: 10px;">우편번호</button>
                    </label>
                    <label style="border-bottom: 1px solid white; padding-bottom: 0px;"><span></span>
                        <input type="text"class="input-field"name="buyer_addr1" id="buyer_addr1" style="width:200px; height:30px;"readonly/>
                    </label>
                    <label><span></span>
                        <input type="text" class="input-field" name="buyer_addr2" id="buyer_addr2"style="width:200px; height:30px;"/>
                    </label>


                    <label><span>일반전화</span><input type="text" class="tel-number-field"
                                                   name="tel_no_1" value="" maxlength="4"/> -
                        <input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"/> - <input
                                type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"/></label>
                    <label><span>휴대전화<span class="required">*</span></span><input type="text" class="tel-number-field"
                                                                                  name="phone_no_1" id="phone_no_1"
                                                                                  value="010"
                                                                                  maxlength="4"/> -
                        <input type="text" class="tel-number-field" name="phone_no_2" id="phone_no_2" value="9488"
                               maxlength="4"/> -
                        <input
                                type="text" class="tel-number-field" name="phone_no_3" id="phone_no_3" value="3402"
                                maxlength="10"/></label>

                    <label for="field2"><span>Email <span class="required">*</span></span><input type="text"
                                                                                                 class="input-field"
                                                                                                 name="buyer_email"
                                                                                                 id="buyer_email"
                                                                                                 value="wpdusdlrj97@gmail.com"
                                                                                                 style="width:200px; height:26px;"/></label>

                    <label for="field5"><span>배송메시지 </span><textarea name="buyer_message" id="buyer_message" class="textarea-field" ></textarea></label>


                </div>

            </div>

            <div id="margin_box">

            </div>


            <div id="purchase_box">

                <div id="purchase_box1">
                    <div class="form-style-2" style="padding: 10px;">
                        <div class="form-style-2-heading" style="border-bottom: 1px solid white;">결제 예정 금액</div>
                    </div>

                </div>

                <div id="purchase_box2">

                    <div id="purchase_box2_1">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 30px;"> 총 주문 금액 </p>
                    </div>
                    <div id="purchase_box2_2">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 30px;"> 총 할인 금액 </p>
                    </div>
                    <div id="purchase_box2_3">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 30px;"> 총 결제예정 금액 </p>
                    </div>



                </div>

                <div id="purchase_box3" >


                    <div id="purchase_box3_1">
                        <div id='box3_order_amount' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block"> <?php echo number_format($order_amount+$order_delivery); ?></div>
                        <div id='box3_order_amount_hidden' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: none"> <?php echo $order_amount+$order_delivery; ?></div>
                        <div style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block">원 </div>
                    </div>
                    <div id="purchase_box3_2">
                        <div style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block"> - </div>
                        <div id='box3_discount_amount' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block"><?php echo number_format($order_discount); ?></div>
                        <div id='box3_discount_amount_hidden' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: none"><?php echo $order_discount; ?></div>
                        <div style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block">원 </div>
                    </div>
                    <div id="purchase_box3_3">
                        <div style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block"> = </div>
                        <div id='box3_purchase_amount' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block">
                            <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                        <div id='box3_purchase_amount_hidden' style="font-weight: bold; font-size: 17px; margin-top: 40px; display: none">
                            <?php
                            echo $order_amount+$order_delivery-$order_discount; ?></div>
                        <div style="font-weight: bold; font-size: 17px; margin-top: 40px; display: inline-block">원 </div>
                    </div>


                </div>



                <div id="purchase_box5">

                    <div id="purchase_box5_1">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 15px;"> 쿠폰 할인 금액 </p>
                    </div>
                    <div id="purchase_box5_2">
                        <div id="order_coupon" style="font-weight: bold; font-size: 12px; margin-top: 15px; margin-left: 20px; display: inline-block">  <?php echo number_format($order_coupon); ?></div>
                        <div id="order_coupon_hidden" style="font-weight: bold; font-size: 12px; margin-top: 15px; margin-left: 20px; display: none">  <?php echo $order_coupon; ?></div>
                        <div id="order_coupon_won" style="font-weight: bold; font-size: 12px; margin-top: 15px;display: inline-block">원 </div>
                    </div>

                </div>

                <div id="purchase_box6">

                    <div id="purchase_box6_1">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 15px;"> 쿠폰 </p>
                    </div>
                    <div id="purchase_box6_2">
                        <button id="purchase_box6_button" style="margin-left: 10px;"> 쿠폰적용 </button>
                    </div>

                </div>


                <div id="purchase_box4">

                    <div id="purchase_box4_1">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 15px;"> 적립금 할인 금액 </p>
                    </div>
                    <div id="purchase_box4_2">
                        <div id="order_save" style="font-weight: bold; font-size: 12px; margin-top: 15px; margin-left: 20px; display: inline-block;"><?php echo number_format($order_save); ?></div>
                        <div id="order_save_hidden" style="font-weight: bold; font-size: 12px; margin-top: 15px; margin-left: 20px; display: none;"><?php echo $order_save; ?></div>
                        <div id="order_save_won" style="font-weight: bold; font-size: 12px; margin-top: 15px; display: inline-block;">원 </div>
                    </div>



                </div>

                <div id="purchase_box7">

                    <div id="purchase_box7_1">
                        <p style="font-weight: bold; font-size: 12px; margin-top: 15px;"> 적립금 </p>
                    </div>
                    <div id="purchase_box7_2">

                        <div id="purchase_box7_2_1">

                            <div id="purchase_box7_2_1_1" style="margin-left: 4px;">
                                <input type="number" name="use_save" id="use_save" value="0" style="width:120px; height:26px; margin: 7px; padding:3px; border: 1px solid black; text-align: end;"/>
                            </div>

                            <div id="purchase_box7_2_1_2">

                                <span style="font-weight: lighter; font-size: 12px; padding-top: 10px; display: inline-block"> 원 ( 총 사용가능 적립금 :
                                    <div id='user_save_amount' style="font-weight: bold; color: #F76560;display:none "><?php echo number_format($user_save_amount);?></div>
                                    <div id='user_save_amount_hidden' style="font-weight: bold; color: #F76560;display: inline-block "><?php echo $user_save_amount;?></div>
                                    <div style="font-weight: bold; color: #F76560;display: inline-block ">원</div>
                                    <div style="display: inline-block ">)</div>



                            </div>

                        </div>

                        <div id="purchase_box7_2_2">

                            <div id="purchase_box7_2_2_1" style="margin-left: 10px;">
                                <span style="font-weight: lighter; font-size: 12px; padding: 5px; display: inline-block"> - 적립금은 최소 1,500 이상일 때 결제가 가능합니다. </span>
                                <br>
                                <span style="font-weight: lighter; font-size: 12px; padding: 5px; display: inline-block"> - 최대 사용금액은 제한이 없습니다.</span>
                                <br>
                                <span style="font-weight: lighter; font-size: 12px; padding: 5px; display: inline-block"> - 구매시 적립금 최대 사용금액은 <span style="color: #F76560 "><?php echo number_format($user_save_amount);?>원</span>입니다.</span>
                                <br>
                                <br>

                            </div>



                        </div>

                    </div>

                </div>


            </div>


            <div id="margin_box">

            </div>
            <div id="margin_box">

            </div>

            <div id="method_box">

                <div id="method_box0">
                    <div class="form-style-2" style="padding: 10px;">
                        <div class="form-style-2-heading" style="border-bottom: 1px solid white;">결제 수단</div>
                    </div>
                </div>


                <div id="method_box1">

                    <div id="method_box1_1">

                            <div id="radioArea" style="padding: 10px;">
                                <input type="radio" style="width:12px;height:12px; margin-bottom: 10px;"  name="radioName" value="card"/> <span style="font-size: 12px; margin-right: 5px;">카드결제</span>
                                &nbsp;&nbsp;&nbsp;<input type="radio" style="width:12px;height:12px; margin-bottom: 10px;" name="radioName" value="trans"/><span style="font-size: 12px; margin-right: 5px;">실시간 계좌이체</span>
                                &nbsp;&nbsp;&nbsp;<input type="radio" style="width:12px;height:12px; margin-bottom: 10px;" name="radioName" value="phone"/><span style="font-size: 12px; margin-right: 5px;">휴대폰 결제</span>
                                &nbsp;&nbsp;&nbsp;<input type="radio" style="width:12px;height:12px; margin-bottom: 10px;" name="radioName" value="none_bank"/><span style="font-size: 12px; margin-right: 5px;">무통장입금</span>
                                &nbsp;&nbsp;&nbsp;<input type="radio" style="width:12px;height:12px; margin-bottom: 10px;" name="radioName" value="vbank"/><span style="font-size: 12px; margin-right: 5px;">가상계좌</span>
                            </div>


                    </div>

                    <div id="method_box1_2">
                        <div id="changeTextArea">
                            <div id="change_card" style="margin-top: 20px; margin-left: 20px;">
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                &nbsp;&nbsp;<span style="font-size: 11px;">최소 결제 가능 금액은 결제금액에서 배송비를 제외한 금액입니다.</span>
                                <br><br>
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                <span style="font-size: 11px;">&nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.</span>
                                &nbsp;
                            </div>

                            <div id="change_trans" style="margin-top: 20px; margin-left: 20px;">
                                <span style="font-size: 12px;">예금주명</span>
                                <input type="text" class="input-field" style="margin-left: 10px; border: 1px solid #ddd;" name="trans_buyer_name" id="trans_buyer_name" />
                                <br><br>
                                <input type="checkbox" style="margin: 0px;" id="checkbox_trans" name="checkbox_trans" value="">
                                <span style="font-size: 11px;">&nbsp;&nbsp;에스크로 (구매안전) 서비스를 적용합니다.</span>
                                <br><br>
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                <span style="font-size: 11px;">&nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.</span>
                            </div>
                            <div id="change_phone" style="margin-top: 20px; margin-left: 20px;">
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                <span style="font-size: 11px;">&nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.</span>
                            </div>
                            <div id="change_none_bank" style="margin-top: 20px; margin-left: 20px;">
                                <span style="font-size: 12px;">입금자명</span>
                                <input type="text" class="input-field" style="margin-left: 10px; border: 1px solid #ddd; " name="none_bank_buyer_name" id="none_bank_buyer_name" />
                                <br><br>

                                <span style="font-size: 12px; margin-right: 10px;">입금은행</span>
                                <select name="none_bank_account" style="font-size: 12px; height: 22px;">
                                    <option value="none"> --- 선택해주세요 --- </option>
                                    <option value="fitme_bank">우리은행:1002893121128 주식회사 FitMe </option>
                                </select>


                                <br><br>
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                <span style="font-size: 11px;">&nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.</span>
                            </div>
                            <div id="change_vbank" style="margin-top: 20px; margin-left: 20px;">
                                <input type="checkbox" style="margin: 0px; font-size: 11px;" id="checkbox_vbank" name="checkbox_vbank" value="">
                                <span style="font-size: 11px;">&nbsp;&nbsp;에스크로 (구매안전) 서비스를 적용합니다.</span>
                                <br><br>
                                <img src="message.png" alt="My Image" width="12" height="12" >
                                <span style="font-size: 11px;">&nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.</span>
                            </div>
                        </div>

                    </div>

                </div>

                <div id="method_box2">

                    <div id="changeTextArea_button">
                        <div id="change_card_button" style="text-align: end;">
                            <br>
                            <span style="font-size: 12px; font-weight: bold;">카드 결제</span> &nbsp; <span style="font-size: 12px; margin-right: 10px;"> 최종 결제 금액</span>

                            <br><br>

                            <div id='final_amount_card' style="font-size: 25px; font-weight: bold; color: #F76560; display: inline-block;"> <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                            <div id='final_amount_card_hidden' style="font-size: 25px; font-weight: bold; color: #F76560; display: none;"> <?php echo $order_amount+$order_delivery-$order_discount; ?></div>
                            <div style="font-size: 12px; margin-right: 10px; display: inline-block;">원</div>

                            <br><br>
                            <button id="method_box2_button" type="button" style="width:90%; height: 50px; margin-right: 5%; margin-left: 5%; "
                                    onclick="requestPay_card()">결제하기
                            </button>
                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 12px; font-weight: bold; ">총 적립예정 금액</span>
                            <span style="font-size: 12px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block; color: #F76560;"> 680원</span>

                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 11px; ">상품별 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 680원</span>

                            <br>

                            <span style="font-size: 11px; ">회원 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>

                            <span style="font-size: 11px; ">쿠폰 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>


                        </div>


                        <div id="change_trans_button" style="text-align: end;">
                            <br>
                            <span style="font-size: 12px; font-weight: bold;">실시간 계좌이체</span> &nbsp; <span style="font-size: 12px; margin-right: 10px;"> 최종 결제 금액</span>

                            <br><br>
                            <div id='final_amount_trans' style="font-size: 25px; font-weight: bold; color: #F76560; display: inline-block;"> <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                            <div id='final_amount_trans_hidden' style="font-size: 25px; font-weight: bold; color: #F76560; display: none;"> <?php echo $order_amount+$order_delivery-$order_discount; ?></div>
                            <div style="font-size: 12px; margin-right: 10px; display: inline-block;">원</div>

                            <br><br>
                            <button id="method_box2_button" type="button" style="width:90%; height: 50px; margin-right: 5%; margin-left: 5%; "
                                    onclick="requestPay_trans()">결제하기
                            </button>
                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 12px; font-weight: bold; ">총 적립예정 금액</span>
                            <span style="font-size: 12px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block; color: #F76560;"> 680원</span>

                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 11px; ">상품별 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 680원</span>

                            <br>

                            <span style="font-size: 11px; ">회원 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>

                            <span style="font-size: 11px; ">쿠폰 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>
                        </div>



                        <div id="change_phone_button" style="text-align: end;">
                            <br>
                            <span style="font-size: 12px; font-weight: bold;">휴대폰 결제</span> &nbsp; <span style="font-size: 12px; margin-right: 10px;"> 최종 결제 금액</span>

                            <br><br>
                            <div id='final_amount_phone' style="font-size: 25px; font-weight: bold; color: #F76560; display: inline-block;"> <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                            <div id='final_amount_phone_hidden' style="font-size: 25px; font-weight: bold; color: #F76560; display: none;"> <?php echo $order_amount+$order_delivery-$order_discount; ?></div>
                            <div style="font-size: 12px; margin-right: 10px; display: inline-block;">원</div>

                            <br><br>
                            <button id="method_box2_button" type="button" style="width:90%; height: 50px; margin-right: 5%; margin-left: 5%; "
                                    onclick="requestPay_phone()">결제하기
                            </button>
                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 12px; font-weight: bold; ">총 적립예정 금액</span>
                            <span style="font-size: 12px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block; color: #F76560;"> 680원</span>

                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 11px; ">상품별 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 680원</span>

                            <br>

                            <span style="font-size: 11px; ">회원 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>

                            <span style="font-size: 11px; ">쿠폰 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>
                        </div>
                        <div id="change_none_bank_button" style="text-align: end;">
                            <br>
                            <span style="font-size: 12px; font-weight: bold;">무통장 입금</span> &nbsp; <span style="font-size: 12px; margin-right: 10px;"> 최종 결제 금액</span>

                            <br><br>
                            <div id='final_amount_none' style="font-size: 25px; font-weight: bold; color: #F76560; display: inline-block;"> <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                            <div id='final_amount_none_hidden' style="font-size: 25px; font-weight: bold; color: #F76560; display: none;"> <?php echo $order_amount+$order_delivery-$order_discount; ?></div>
                            <div style="font-size: 12px; margin-right: 10px; display: inline-block;">원</div>

                            <br><br>
                            <button id="method_box2_button" type="button" style="width:90%; height: 50px; margin-right: 5%; margin-left: 5%;">결제하기
                            </button>
                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 12px; font-weight: bold; ">총 적립예정 금액</span>
                            <span style="font-size: 12px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block; color: #F76560;"> 680원</span>

                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 11px; ">상품별 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 680원</span>

                            <br>

                            <span style="font-size: 11px; ">회원 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>

                            <span style="font-size: 11px; ">쿠폰 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>
                        </div>
                        <div id="change_vbank_button" style="text-align: end;">
                            <br>
                            <span style="font-size: 12px; font-weight: bold;">가상계좌</span> &nbsp; <span style="font-size: 12px; margin-right: 10px;"> 최종 결제 금액</span>

                            <br><br>
                            <div id='final_amount_vbank' style="font-size: 25px; font-weight: bold; color: #F76560; display: inline-block;"> <?php echo number_format($order_amount+$order_delivery-$order_discount); ?></div>
                            <div id='final_amount_vbank_hidden' style="font-size: 25px; font-weight: bold; color: #F76560; display: none;"> <?php echo $order_amount+$order_delivery-$order_discount; ?></div>
                            <div style="font-size: 12px; margin-right: 10px; display: inline-block;">원</div>

                            <br><br>
                            <button id="method_box2_button" type="button" style="width:90%; height: 50px; margin-right: 5%; margin-left: 5%; "
                                    onclick="requestPay_vbank()">결제하기
                            </button>
                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 12px; font-weight: bold; ">총 적립예정 금액</span>
                            <span style="font-size: 12px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block; color: #F76560;"> 680원</span>

                            <br>

                            <hr color="#ddd" size="1px">
                            <span style="font-size: 11px; ">상품별 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 680원</span>

                            <br>

                            <span style="font-size: 11px; ">회원 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>

                            <span style="font-size: 11px; ">쿠폰 적립금</span>
                            <span style="font-size: 11px; margin-left:50px; margin-right: 10px; width: 20%; display: inline-block"> 0원</span>

                            <br>
                        </div>
                    </div>

                </div>

            </div>

            <div id="method_box3">

                <div id="changeTextArea_button2">

                    <div id="change_card_button2" style="text-align: end;">
                        <button id="method_box2_button" type="button" onclick="requestPay_card()" style="width:30%; height: 50px; margin-right: 35%; margin-left: 35%;"> 카드 결제</button>
                    </div>


                    <div id="change_trans_button2" style="text-align: end;">
                        <button id="method_box2_button" type="button" onclick="requestPay_trans()" style="width:30%; height: 50px; margin-right: 35%; margin-left: 35%;"> 실시간계좌 결제</button>
                    </div>

                    <div id="change_phone_button2" style="text-align: end;">
                        <button id="method_box2_button" type="button" onclick="requestPay_phone()" style="width:30%; height: 50px; margin-right: 35%; margin-left: 35%;"> 휴대폰 결제</button>
                    </div>

                    <div id="change_none_bank_button2" style="text-align: end;">
                        <button id="method_box2_button" type="button" style="width:30%; height: 50px; margin-right: 35%; margin-left: 35%;"> 무통장 입금</button>
                    </div>

                    <div id="change_vbank_button2" style="text-align: end;">
                        <button id="method_box2_button" type="button" onclick="requestPay_vbank()" style="width:30%; height: 50px; margin-right: 35%; margin-left: 35%;"> 가상계좌 결제</button>
                    </div>






                </div>


            </div>





            <div id="margin_box">

            </div>
            <div id="margin_box">

            </div>



        </div>


    </div>

</div>


<div id="footer"></div>


<!-- 입금 방식-->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js" ></script>
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    var IMP = window.IMP; // 생략해도 괜찮습니다.
    IMP.init("imp41398096"); // "imp00000000" 대신 발급받은 "가맹점 식별코드"를 사용합니다.
</script>

<script>

    // 카드결제
    function requestPay_card() {
        // IMP.request_pay(param, callback) 호출


        // 구매 금액
        var buy_amount = Number($('#box3_purchase_amount_hidden').text());

        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();

        // 구매자 일반 전화번호
        var tel_no_1 = $('#tel_no_1').val();
        var tel_no_2 = $('#tel_no_2').val();
        var tel_no_3 = $('#tel_no_3').val();
        var buyer_tel = tel_no_1 + "-" + tel_no_2 +"-"+ tel_no_3;


        // 구매자 핸드폰 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1 + "-" + phone_no_2+"-"+ phone_no_3;

        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1 + " " + buyer_addr2;

        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();
        // 배송메시지
        var  buyer_message = $('#buyer_message').val();

        //구매 첫번째 상품
        var buy_product_first = $('#buy_product_first').text();
        //구매 상품 수
        var buy_product_count = $('#buy_product_count').text();
        //결체창에서의 구매상품명
        var buy_product_name;

        if(buy_product_count==1){ // 구매하는 상품이 하나일 경우

            buy_product_name = buy_product_first;

        }else{ // 구매하는 상품이 2개 이상일 경우 (

            buy_product_name = buy_product_first.concat(" 외", Number(buy_product_count)-1,"건");

        }


        if(buyer_name==""){
            alert("이름을 입력해주세요");
            return;
        }else if(buyer_email == ""){
            alert("이메일을 입력해주세요");
            return;
        }else if(phone_no_1 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_2 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_3 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(buyer_postcode == ""){
            alert("우편번호를 정확히 입력해주세요");
            return;
        }else if(buyer_addr1 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if(buyer_addr2 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else{
            IMP.request_pay({
                pg : 'html5_inicis',
                pay_method : 'card',
                merchant_uid : 'merchant_' + new Date().getTime(),
                name : buy_product_name,
                amount : buy_amount,
                buyer_email: buyer_email,
                buyer_name: buyer_name,
                buyer_tel: buyer_phone,
                buyer_addr: buyer_addr,
                buyer_postcode: buyer_postcode
            }, function (rsp) {
                if (rsp.success) {
                    var msg = '결제가 완료되었습니다.';
                    msg += '고유ID : ' + rsp.imp_uid;
                    msg += '상점 거래ID : ' + rsp.merchant_uid;
                    msg += '결제 금액 : ' + rsp.paid_amount;
                    msg += '카드 승인번호 : ' + rsp.apply_num;

                    post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23','tel':buyer_tel, 'message':buyer_message})


                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;
                }

                /*
                var msg9 = '결제가 완료되었습니다.';
                msg9 += '결제금액 : ' + buy_amount;
                msg9 += '이메일 : ' + buyer_email;
                msg9 += '주문인 : ' + buyer_name;
                msg9 += '전화번호 : ' + buyer_phone;
                msg9 += '주소 : ' + buyer_addr;
                msg9 += '우편번호 : ' + buyer_postcode;
                */

                //alert(msg);

                //post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})
                //alert(msg9);



                // 결제에 성공하면 결제완료 페이지로 이동시킨다
                // POST - 주문번호, 주문일자, 결제 금액, 결제수단,
                //      - 상품이름, 상품컬러, 상품사이즈, 상품 수량, 상품가격
                //      - 이름, 우편번호, 주소, 일반전화, 휴대전화, 배송메시지
                // DB에 저장하고 -> 결제완료 페이지에서 띄워주가


            });
        }





    }

    // 실시간 계좌이체
    function requestPay_trans() {

        // IMP.request_pay(param, callback) 호출

        // 구매 금액
        var buy_amount = Number($('#box3_purchase_amount_hidden').text());

        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();

        // 구매자 일반 전화번호
        var tel_no_1 = $('#tel_no_1').val();
        var tel_no_2 = $('#tel_no_2').val();
        var tel_no_3 = $('#tel_no_3').val();
        var buyer_tel = tel_no_1 + "-" + tel_no_2 +"-"+ tel_no_3;


        // 구매자 핸드폰 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1 + "-" + phone_no_2+"-"+ phone_no_3;

        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1 + " " + buyer_addr2;

        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();
        // 배송메시지
        var  buyer_message = $('#buyer_message').val();


        //구매 첫번째 상품
        var buy_product_first = $('#buy_product_first').text();
        //구매 상품 수
        var buy_product_count = $('#buy_product_count').text();
        //결체창에서의 구매상품명
        var buy_product_name;

        if(buy_product_count==1){ // 구매하는 상품이 하나일 경우

            buy_product_name = buy_product_first;

        }else{ // 구매하는 상품이 2개 이상일 경우 (

            buy_product_name = buy_product_first.concat(" 외", Number(buy_product_count)-1,"건");

        }

        if(buyer_name==""){
            alert("이름을 입력해주세요");
            return;
        }else if(buyer_email == ""){
            alert("이메일을 입력해주세요");
            return;
        }else if(phone_no_1 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_2 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_3 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(buyer_postcode == ""){
            alert("우편번호를 정확히 입력해주세요");
            return;
        }else if(buyer_addr1 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if(buyer_addr2 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if($("#checkbox_trans").is(":checked") == false) {
            alert("에스크로 구매안전 서비스 적용에 체크해주세요");
            return;
        }else{
            IMP.request_pay({
                pg: 'html5_inicis',
                pay_method: 'trans',
                merchant_uid: 'merchant_' + new Date().getTime(),
                name: buy_product_name,
                amount: buy_amount,
                buyer_email: buyer_email,
                buyer_name: buyer_name,
                buyer_tel: buyer_phone,
                buyer_addr: buyer_addr,
                buyer_postcode: buyer_postcode
            }, function (rsp) {
                if (rsp.success) {
                    var msg = '결제가 완료되었습니다.';
                    msg += '고유ID : ' + rsp.imp_uid;
                    msg += '상점 거래ID : ' + rsp.merchant_uid;
                    msg += '결제 금액 : ' + rsp.paid_amount;
                    msg += '카드 승인번호 : ' + rsp.apply_num;

                    post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23','tel':buyer_tel, 'message':buyer_message})

                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;
                }

                /*
                var msg9 = '결제가 완료되었습니다.';
                msg9 += '결제금액 : ' + buy_amount;
                msg9 += '이메일 : ' + buyer_email;
                msg9 += '주문인 : ' + buyer_name;
                msg9 += '전화번호 : ' + buyer_phone;
                msg9 += '주소 : ' + buyer_addr;
                msg9 += '우편번호 : ' + buyer_postcode;
                */
                alert(msg);
                //alert(msg9);

            });
        }


    }


    // 실시간 핸드폰 소액결제
    function requestPay_phone() {
        // IMP.request_pay(param, callback) 호출

        // 구매 금액
        var buy_amount = Number($('#box3_purchase_amount_hidden').text());
        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();

        // 구매자 일반 전화번호
        var tel_no_1 = $('#tel_no_1').val();
        var tel_no_2 = $('#tel_no_2').val();
        var tel_no_3 = $('#tel_no_3').val();
        var buyer_tel = tel_no_1 + "-" + tel_no_2 +"-"+ tel_no_3;


        // 구매자 핸드폰 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1 + "-" + phone_no_2+"-"+ phone_no_3;

        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1 + " " + buyer_addr2;

        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();
        // 배송메시지
        var  buyer_message = $('#buyer_message').val();

        //구매 첫번째 상품
        var buy_product_first = $('#buy_product_first').text();
        //구매 상품 수
        var buy_product_count = $('#buy_product_count').text();
        //결체창에서의 구매상품명
        var buy_product_name;

        if(buy_product_count==1){ // 구매하는 상품이 하나일 경우

            buy_product_name = buy_product_first;

        }else{ // 구매하는 상품이 2개 이상일 경우 (

            buy_product_name = buy_product_first.concat(" 외", Number(buy_product_count)-1,"건");

        }


        if(buyer_name==""){
            alert("이름을 입력해주세요");
            return;
        }else if(buyer_email == ""){
            alert("이메일을 입력해주세요");
            return;
        }else if(phone_no_1 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_2 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_3 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(buyer_postcode == ""){
            alert("우편번호를 정확히 입력해주세요");
            return;
        }else if(buyer_addr1 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if(buyer_addr2 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else{
            IMP.request_pay({
                pg: 'html5_inicis',
                pay_method: 'phone',
                merchant_uid: 'merchant_' + new Date().getTime(),
                name: buy_product_name,
                amount: buy_amount,
                buyer_email: buyer_email,
                buyer_name: buyer_name,
                buyer_tel: buyer_phone,
                buyer_addr: buyer_addr,
                buyer_postcode: buyer_postcode
            }, function (rsp) {
                if (rsp.success) {
                    var msg = '결제가 완료되었습니다.';
                    msg += '고유ID : ' + rsp.imp_uid;
                    msg += '상점 거래ID : ' + rsp.merchant_uid;
                    msg += '결제 금액 : ' + rsp.paid_amount;
                    msg += '카드 승인번호 : ' + rsp.apply_num;

                    post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23','tel':buyer_tel, 'message':buyer_message})

                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;
                }
                /*
                var msg9 = '결제가 완료되었습니다.';
                msg9 += '결제금액 : ' + buy_amount;
                msg9 += '이메일 : ' + buyer_email;
                msg9 += '주문인 : ' + buyer_name;
                msg9 += '전화번호 : ' + buyer_phone;
                msg9 += '주소 : ' + buyer_addr;
                msg9 += '우편번호 : ' + buyer_postcode;
                */

                alert(msg);
                //alert(msg9);
            });
        }


    }

    // 가상계좌
    function requestPay_vbank() {
        // IMP.request_pay(param, callback) 호출

        // 구매 금액
        var buy_amount = Number($('#box3_purchase_amount_hidden').text());
        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();

        // 구매자 일반 전화번호
        var tel_no_1 = $('#tel_no_1').val();
        var tel_no_2 = $('#tel_no_2').val();
        var tel_no_3 = $('#tel_no_3').val();
        var buyer_tel = tel_no_1 + "-" + tel_no_2 +"-"+ tel_no_3;


        // 구매자 핸드폰 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1 + "-" + phone_no_2+"-"+ phone_no_3;

        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1 + " " + buyer_addr2;

        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();
        // 배송메시지
        var  buyer_message = $('#buyer_message').val();

        //구매 첫번째 상품
        var buy_product_first = $('#buy_product_first').text();
        //구매 상품 수
        var buy_product_count = $('#buy_product_count').text();
        //결체창에서의 구매상품명
        var buy_product_name;

        if(buy_product_count==1){ // 구매하는 상품이 하나일 경우

            buy_product_name = buy_product_first;

        }else{ // 구매하는 상품이 2개 이상일 경우 (

            buy_product_name = buy_product_first.concat(" 외", Number(buy_product_count)-1,"건");

        }

        if(buyer_name==""){
            alert("이름을 입력해주세요");
            return;
        }else if(buyer_email == ""){
            alert("이메일을 입력해주세요");
            return;
        }else if(phone_no_1 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_2 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(phone_no_3 == ""){
            alert("핸드폰 번호를 정확히 입력해주세요");
            return;
        }else if(buyer_postcode == ""){
            alert("우편번호를 정확히 입력해주세요");
            return;
        }else if(buyer_addr1 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if(buyer_addr2 == ""){
            alert("주소를 정확히 입력해주세요");
            return;
        }else if($("#checkbox_vbank").is(":checked") == false) {
            alert("에스크로 구매안전 서비스 적용에 체크해주세요");
            return;
        }else{
            IMP.request_pay({
                pg: 'html5_inicis',
                pay_method: 'vbank',
                merchant_uid: 'merchant_' + new Date().getTime(),
                name: buy_product_name,
                amount: buy_amount,
                buyer_email: buyer_email,
                buyer_name: buyer_name,
                buyer_tel: buyer_phone,
                buyer_addr: buyer_addr,
                buyer_postcode: buyer_postcode
            }, function (rsp) {
                if (rsp.success) {
                    var msg = '결제가 완료되었습니다.';
                    msg += '고유ID : ' + rsp.imp_uid;
                    msg += '상점 거래ID : ' + rsp.merchant_uid;
                    msg += '결제 금액 : ' + rsp.paid_amount;
                    msg += '카드 승인번호 : ' + rsp.apply_num;

                    post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23','tel':buyer_tel, 'message':buyer_message})

                } else {
                    var msg = '결제에 실패하였습니다.';
                    msg += '에러내용 : ' + rsp.error_msg;
                }

                /*
                var msg9 = '결제가 완료되었습니다.';
                msg9 += '결제금액 : ' + buy_amount;
                msg9 += '이메일 : ' + buyer_email;
                msg9 += '주문인 : ' + buyer_name;
                msg9 += '전화번호 : ' + buyer_phone;
                msg9 += '주소 : ' + buyer_addr;
                msg9 += '우편번호 : ' + buyer_postcode;

                alert(msg);

                 */
                alert(msg9);
            });
        }



    }

    function post_to_url(path, params, method) {
        method = method || "post"; // Set method to post by default, if not specified.
        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        for (var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    }

</script>


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
