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
                        <span style="font-size: 12px;  color: black; display:inline-block; margin-left: 15px;"> 주문번호 : 20191227-0001358</span>
                        <br>
                        <span style="font-size: 12px;  color: black; display:inline-block; margin-left: 15px;"> 주문일자 : 2019-12-27 21:36:47</span>


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
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">수량</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">적립금</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송구분</span></th>
                        <th id="th_delete"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;">배송비</span></th>
                        <th id="th_delete"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;">합계</span></th>


                    </tr>


                    <tbody style="border-bottom: 1px solid #ddd;">

                    <td width="10%" align="center"><img
                            src="http://49.247.136.36/product_resource/image/main/yohan@gmail.com20191220211834_main.jpg"
                            alt="My Image" width="90" height="90" style="margin-top:15px; margin-bottom: 15px;"></td>
                    <td width="30%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '메모리 MA-1 항공점퍼3colors'; ?><br>
                                <?php echo '[옵션 - Black, L]'; ?></span></td>
                    <td width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '81,000원'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '1'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '810원'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '기본배송'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '무료'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '81,000원'; ?></span></td>

                    </tbody>

                    <tbody style="border-bottom: 1px solid #ddd;">

                    <td width="10%" align="center"><img
                            src="http://49.247.136.36/product_resource/image/main/yohan@gmail.com20191220180341_main.jpg"
                            alt="My Image" width="90" height="90" style="margin-top:15px; margin-bottom: 15px;"></td>
                    <td width="30%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo 'Tydi Crop Jeans'; ?><br>
                                <?php echo '[옵션 - Black, 30]'; ?></span></td>
                    <td width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '96,000원'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '1'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '960원'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '기본배송'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span  style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '무료'; ?></span></td>
                    <td id="td_delete" width="5%" align="center"><span style="font-size: 12px; color: black; padding:1px; display:inline-block;"><?php echo '96,000원'; ?></span></td>

                    </tbody>




                    </table>



                </div>

                <div id="table_box4" style="text-align: end">


                    <span style="font-size: 12px; color: black; padding:1px; margin-top: 10px; margin-bottom: 10px; display:inline-block;">상품구매금액</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;">177,000</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;">+ 배송비</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;">2500</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"> = 합계 :</span>

                    <span style="font-size: 14px; font-weight: bold; color: black; padding:1px; display:inline-block;"> 177,000</span>

                    <span style="font-size: 12px; color: black; padding:1px; display:inline-block;"> 원</span>


                </div>




            </div>

            <div id="margin_box">

            </div>

            <div id="table_box_payment">

                <div id="table_box_payment1">

                    <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-left: 10px;">결제 금액</span>


                </div>
                <div id="table_box_payment2">

                    <div id="table_box_payment2_1">

                        <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 13px; ">총 주문 금액</span>


                    </div>
                    <div id="table_box_payment2_2">

                        <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 13px; ">총 결제 금액</span>


                    </div>

                </div>
                <div id="table_box_payment3">

                    <div id="table_box_payment3_1">

                        <span style="font-size: 21px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 15px; ">177,700원</span>


                    </div>
                    <div id="table_box_payment3_2">

                        <span style="font-size: 21px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 15px;">177,700원</span>


                    </div>


                </div>
                <div id="table_box_payment4">

                    <div id="table_box_payment4_1">

                        <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 7px; ">총 적립 예정 금액</span>


                    </div>
                    <div id="table_box_payment4_2">

                        <span style="font-size: 12px; font-weight: bold; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-left: 10px;">1,7770원</span>


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

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">조제연</span>


                    </div>

                </div>

                <div id="table_box_address3">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 우편번호 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">420730</span>


                    </div>

                </div>

                <div id="table_box_address4">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 주소 </span>


                    </div>
                    <div id="table_box_address_long">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">경기도 부천시 원미구 중4동 은하마을아파트 503동 902호</span>


                    </div>

                </div>

                <div id="table_box_address5">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 일반전화 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 10px;">032-326-2402</span>


                    </div>

                </div>

                <div id="table_box_address6">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 휴대전화 </span>


                    </div>
                    <div id="table_box_address2_2">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px;margin-left: 10px;">010-9488-3402</span>


                    </div>

                </div>

                <div id="table_box_address7">

                    <div id="table_box_address2_1">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px;  margin-bottom: 7px; margin-left: 15px;"> 배송메시지 </span>


                    </div>
                    <div id="table_box_address_long">

                        <span style="font-size: 12px; color: black; padding:5px; display:inline-block; margin-top: 7px; margin-bottom: 7px; margin-left: 10px;">
                            주문시에 작성하시는 배송메시지란은 직접 운송하시는 택배사의 택배기사님께 메시지를 전달하는 부분입니다.</span>
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
