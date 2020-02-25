<?php
session_start();
$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe');
mysqli_set_charset($connect, 'utf8');

$id = $_SESSION['id'];
$email = $_SESSION['email'];

$order_number = $_GET['order_number'];

if (!$id) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{


    // 로그인이 안되었을 경우에는 상품페이지로 이동한다
    $_SESSION['URL'] = 'http://49.247.136.36/main/cart/order_finish_html.php';

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.

}



//주문 상품 나열
$query_product = "SELECT * FROM order_success_product where order_number='$order_number'";
$result_product = mysqli_query($connect, $query_product);



//주문관련 정보
$query_information = "SELECT * FROM order_success where order_number='$order_number'";
$result_information = mysqli_query($connect, $query_information);
$row_information = mysqli_fetch_assoc($result_information);

if($id!=$row_information['user_id']){

    echo '<script>alert("접근 불가");</script>';

    echo '<script>location.href=\'http://49.247.136.36/main/main.php\'</script>'; //로그인 페이지로 이동한다.

}


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

    #ok_box {margin: 0 auto;width: 1320px; float: left; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; background-color: white}
    #ok_box_inside {margin: 0 auto; width: 550px; height: 250px; float: inside;background-color: white}

    #ok_box_inside1 {margin: 0 auto;width: 120px; height: 120px; margin-top:60px;  float: left;background-color: white}
    #ok_box_inside2 {margin: 0 auto;width: 430px; height: 120px; margin-top:60px; text-align: left; float: left;background-color: white}
    #image_delete{display: none;}




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



    #table_box_payment {margin: 0 auto;width: 1320px; float: left;background-color: white}

    #table_box_payment1 {margin: 0 auto;width: 1320px; float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_payment2 {margin: 0 auto;width: 1320px;  float: left; background-color: #F5F6F7; border-bottom: 1px solid #ddd;}
    #table_box_payment2_1 {margin: 0 auto;width: 50%; height: 50px; float: left;background-color: #F5F6F7; text-align: center}
    #table_box_payment2_2 {margin: 0 auto;width: 50%; height: 50px; float: left;background-color: #F5F6F7; text-align: center}
    #table_box_payment3 {margin: 0 auto;width: 1320px; height: 80px; float: left;background-color: dimgray; border-bottom: 1px solid #ddd;}
    #table_box_payment3_1 {margin: 0 auto;width: 50%; height: 80px; float: left;background-color: white; text-align: center}
    #table_box_payment3_2 {margin: 0 auto;width: 50%; height: 80px; float: left;background-color: white; text-align: center}

    #table_box_payment4 {margin: 0 auto;width: 1320px; height: 40px; float: left;background-color: #F5F6F7; border-bottom: 1px solid #ddd;}
    #table_box_payment4_1 {margin: 0 auto;width: 150px; height: 40px; float: left;background-color: white; text-align: center}
    #table_box_payment4_2 {margin: 0 auto;width: 150px; height: 40px; float: left;background-color: #F5F6F7; text-align: left}


    #table_box_address {margin: 0 auto;width: 1320px; float: left;background-color: pink}
    #table_box_address1 {margin: 0 auto;width: 1320px; float: left; background-color: white; border-bottom: 1px solid #ddd;}

    #table_box_address2 {margin: 0 auto;width: 1320px; float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_address2_1 {margin: 0 auto;width: 150px;  float: left;background-color: white; text-align: left}
    #table_box_address2_2 {margin: 0 auto;width: 220px;  float: left;background-color: white; text-align: left}

    #table_box_address3 {margin: 0 auto;width: 1320px;  float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_address4{margin: 0 auto;width: 1320px;  float: left; background-color: white; border-bottom: 1px solid #ddd;}

    #table_box_address_long {margin: 0 auto; width: 700px;  float: left;background-color: white; text-align: left}

    #table_box_address5 {margin: 0 auto;width: 1320px;  float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_address6 {margin: 0 auto;width: 1320px;  float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_address7 {margin: 0 auto;width: 1320px;  float: left; background-color: white; border-bottom: 1px solid #ddd;}
    #table_box_address8 {margin: 0 auto;width: 1320px; float: left; background-color: white; text-align: end;}

    #table_box_address8_button {background-color: dimgray;border: none;color: white; padding: 10px 25px;text-align: center;text-decoration: none;display:
        inline-block;font-size: 12px; margin-top:7px; cursor: pointer;}











    @media (max-width: 1320px) {
        #orderpage_box {width: 100%;}
        #registerpage_box_inside {width: 100%;}
        #margin_box {width: 100%;}
        #title_box {width: 100%;}

        #ok_box{width: 100%;}





        #table_box {width: 100%;}
        #table_box1 {width: 100%;}
        #table_box2 {width: 100%;}
        #table_box3 {width: 100%;}
        #table_box4 {width: 100%;}
        #table_box5 {width: 100%;}

        #table_box_payment {width: 100%;}
        #table_box_payment1 {width: 100%;}
        #table_box_payment2 {width: 100%;}
        #table_box_payment3 {width: 100%;}
        #table_box_payment4 {width: 100%;}
        #table_box_payment5 {width: 100%;}

        #table_box_address {width: 100%;}
        #table_box_address1 {width: 100%;}
        #table_box_address2 {width: 100%;}
        #table_box_address3 {width: 100%;}
        #table_box_address4 {width: 100%;}
        #table_box_address5 {width: 100%;}
        #table_box_address6 {width: 100%;}
        #table_box_address7 {width: 100%;}
        #table_box_address8 {width: 100%;}
        #table_box_address9 {width: 100%;}



    }


    @media (max-width: 990px) {


        #table_box_address_long {margin: 0 auto; width: 500px;  float: left;background-color: white; text-align: left}

    }

    @media (max-width: 750px) {

        #th_delete {display: none;}
        #td_delete {display: none;}

        #table_box_address_long {margin: 0 auto; width: 400px;  float: left;background-color: white; text-align: left}


    }


    @media (max-width: 570px) {

        #ok_box_inside{width: 100%;}
        #ok_box_inside1{display: none;}
        #ok_box_inside2{width: 90%; margin-left: 9%; }
        #image_delete{display: block;}

        #table_box_address_long {margin: 0 auto; width: 210px;  float: left;background-color: white; text-align: left}

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


<div id="center_box">

    <div id="orderpage_box">

        <div id="registerpage_box_inside">

            <div id="margin_box">

            </div>

            <div id="title_box" style="text-align: center;">

                <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">ORDER</p>

            </div>

            <div id="ok_box" style="text-align: center;">

                <div id="ok_box_inside" style="text-align: center;">

                    <div id="ok_box_inside1" style="text-align: center;">

                        <img src="order_finish.png" alt="My Image" style="width: 100%; height: 100%;">

                    </div>
                    <div id="ok_box_inside2">


                        <span style="float: left; font-size: 18px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-left: 10px;">고객님의 주문이 완료되었습니다 </span>
                        <img id='image_delete' src="order_finish.png" style="float: left;width: 30px; height: 30px; ">

                        <span style="font-size: 12px;  color: black; display:inline-block; margin-left: 15px;">주문내역 및 배송에 관한 안내는 주문조회를 통해 확인 가능합니다</span>

                        <br><br>
                        <span style="font-size: 12px;  color: black; display:inline-block; margin-left: 15px;"> 주문번호 : <?php echo $order_number;?></span>
                        <br>
                        <span style="font-size: 12px;  color: black; display:inline-block; margin-left: 15px;"> 주문일자 :
                            <?php

                            $order_date = $row_information['order_date'];

                            echo substr($order_date, 0, 4);
                            echo "-";
                            echo substr($order_date, 4, 2);
                            echo "-";
                            echo substr($order_date, 6, 2);
                            echo " ";
                            echo substr($order_date, 8, 2);
                            echo ":";
                            echo substr($order_date, 10, 2);
                            echo ":";
                            echo substr($order_date, 12, 2);

                            ?>

                        </span>


                    </div>


                </div>

            </div>




            <div id="margin_box">

            </div>


            <div id="table_box">



                <div id="table_box2">

                    <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-left: 10px;">주문 상품 정보</span>


                </div>

                <div id="table_box3">


                    <table id="customers"">
                    <tr style="border-top: 1px solid #ddd; border-bottom: 1px solid #ddd;">
                        <th> <span style="font-size: 12px; color: black; padding:1px; margin-top: 10px; margin-bottom: 10px; display:inline-block;">이미지</span></th>
                        <th><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">상품명/옵션</span></th>
                        <th><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">판매가</span></th>
                        <th><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">수량</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">적립금</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송구분</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송비</span></th>
                        <th ><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">합계</span></th>


                    </tr>


                    <tbody style="border-bottom: 1px solid #ddd;">

                    <?php

                    //상품 구매금액
                    $order_finish_amount=0;

                    //배송비
                    $order_finish_delivery=0 ;




                    while ($rows = mysqli_fetch_assoc($result_product)) { //DB에 저장된 데이터 수 (열 기준)


                    //주문상품번호
                    $order_product_number = $rows['order_product_number'];
                    //해당 상품 키
                    $order_product_key = $rows['product_key'];
                    //해당 상품 색상,사이즈,수량
                    $order_product_color = $rows['product_color'];
                    $order_product_size = $rows['product_size'];
                    $order_product_count = $rows['product_count'];

                    //시간 순으로 정렬하기
                    $query_information_key = "SELECT * FROM product where product_key='$order_product_key'";
                    $result_information_key = mysqli_query($connect, $query_information_key);
                    $row_information_key = mysqli_fetch_assoc($result_information_key);


                    //해당상품 이미지
                    $order_product_image = $row_information_key['main_image'];
                    //해당상품 이름
                    $order_product_name = $row_information_key['name'];
                    //해당상품 가격
                    $order_product_amount = $row_information_key['price'];



                    //상품 적립금
                    $one_percent=100;
                    $order_product_save=$order_product_amount*$order_product_count/$one_percent;
                    //상품 합계
                    $order_product_amount_all=$order_product_amount*$order_product_count;

                    $order_finish_amount=$order_finish_amount+$order_product_amount_all;



                    ?>

                    <td width="10%" align="center"><img
                            src="<?php echo $order_product_image; ?>"
                            alt="My Image" width="90" height="90" style="margin-top:15px; margin-bottom: 15px;"></td>
                    <td width="25%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo $order_product_name; ?><br>
                                <?php echo '[옵션 - '.$order_product_color.','.$order_product_size.']'; ?></span></td>
                    <td width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($order_product_amount); ?></span></td>
                    <td width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo $order_product_count; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo $order_product_save; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '기본배송'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '무료'; ?></span></td>
                    <td  width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo number_format($order_product_amount*$order_product_count); ?></span></td>

                    </tbody>

                    <?php

                    }

                    ?>


                    </table>



                </div>




            </div>

            <div id="margin_box">

            </div>
            <div id="margin_box">

            </div>

            <div id="table_box_payment">

                <div id="table_box_payment1">

                    <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-left: 10px;">결제 정보</span>


                </div>

                <div id="table_box_address2">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-bottom: 7px; margin-left: 15px;"> 최종 결제 금액</span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;"><?php echo number_format($row_information['payment_amount']).'원';?></span>


                    </div>

                </div>

                <div id="table_box_address2">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-bottom: 7px; margin-left: 15px;"> 결제 수단</span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;"><?php echo $row_information['payment_method'];?></span>


                    </div>

                </div>



            </div>


            <div id="margin_box">

            </div>


            <div id="table_box_address">

                <div id="table_box_address1">

                    <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-left: 10px;">배송지 정보</span>

                </div>

                <div id="table_box_address2">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-bottom: 7px; margin-left: 15px;"> 받으시는 분</span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;"><?php echo $row_information['recipient_name'];?></span>


                    </div>

                </div>

                <div id="table_box_address3">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 우편번호 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">
                            <?php

                            $recipient_addr_split=$row_information['recipient_addr'];

                            $recipient_addr = explode( '/', $recipient_addr_split);

                            echo $recipient_addr[0];

                            ?>
                        </span>


                    </div>

                </div>

                <div id="table_box_address4">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 주소 </span>


                    </div>
                    <div id="table_box_address_long">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">
                            <?php


                            echo $recipient_addr[1]." ".$recipient_addr[2];

                            ?>
                        </span>


                    </div>

                </div>

                <div id="table_box_address5">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 일반전화 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;"><?php echo $row_information['recipient_tel'];?></span>


                    </div>

                </div>

                <div id="table_box_address6">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 휴대전화 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px;margin-left: 10px;"><?php echo $row_information['recipient_phone'];?></span>


                    </div>

                </div>

                <div id="table_box_address7">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 배송메시지 </span>


                    </div>
                    <div id="table_box_address_long">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-bottom: 7px; margin-left: 10px;">
                            <?php echo $row_information['recipient_message'];?></span>
                    </div>
                </div>

                <div id="table_box_address8">

                    <button id="table_box_address8_button" type="button" style="width:120px; height: 40px; margin-right: 10px; margin-top: 15px; ">
                        주문 확인
                   </button>

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
