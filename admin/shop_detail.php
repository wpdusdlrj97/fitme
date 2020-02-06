<?php
session_start(); //세션을 유지한다.

/*
 이 페이지는 회원 상세정보 페이지이다
 */

/*
이 페이지에서 가장 먼저 해야할것은 접속한 사용자가 일반사용자인지 FitMe 관리자 인지를 확인 하여야한다.
DB에서 user_information테이블에서 level이 사용자 권한을 나타낸다.
level이 0이라면 일반사용자이며 1이라면 일반 쇼핑몰이고 2라면 FitMe 관리자를 뜻한다
 */

$con = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe'); //DB에 연결한다.
mysqli_set_charset($con, 'utf8'); //문자셋을 지정한다.

//현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
$email = $_SESSION['email'];


if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/admin/member_manage.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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



    //로그인이 되어있는 상태
    //접근권한을 DB에서 조회해야 한다.
    $qry = mysqli_query($con, "select * from user_information where email='$email'");
    $row_level = mysqli_fetch_array($qry);
    if ($row_level['level'] >= '1') { ?>

        <!DOCTYPE html>
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            <title>FitMe Admin 페이지</title>
            <!-- BOOTSTRAP STYLES-->
            <link href="assets/css/bootstrap.css" rel="stylesheet"/>
            <!-- FONTAWESOME STYLES-->
            <link href="assets/css/font-awesome.css" rel="stylesheet"/>
            <!-- CUSTOM STYLES-->
            <link href="assets/css/custom.css" rel="stylesheet"/>
            <!-- GOOGLE FONTS-->
            <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
            <link rel="stylesheet" type="text/css" href="./product_approval.css">

            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">




        </head>


        <body>


        <style>
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            table.type03 {
                border-collapse: collapse;
                text-align: left;
                line-height: 1.5;
                border-top: 1px solid #ccc;
                border-left: 3px solid #369;
                margin-bottom: 20px;
            }
            table.type03 th {
                width: 297px;
                padding: 10px;
                font-weight: bold;
                vertical-align: top;
                color: #153d73;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;

            }
            table.type03 td {
                width: 500px;
                padding: 10px;
                vertical-align: top;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
            }

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }


            .info_box {
                float: bottom;
                width: 70%;
                margin-left: 1%;
                margin-right: 1%;
            }

        </style>


        <div id="wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <a class="navbar-brand" href="#">
                    <img src="assets/img/admin_logo.png" style="width:30%; height:300%"/>
                </a>
            </div>

            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">


                        <li>
                            <a href="http://49.247.136.36/admin/shop_manage.php"><i class="fa fa-desktop "></i>쇼핑몰
                                관리</a>
                        </li>

                        <li>
                            <a href="http://49.247.136.36/admin/seller/shop_request.php"><i class="fa fa fa-flag-o"></i>입점
                                문의/신청 관리</a>
                        </li>


                        <li class="active-link">
                            <a href="http://49.247.136.36/admin/member_manage.php"><i class="fa fa-bar-chart-o"></i>회원
                                관리</a>
                        </li>

                        <li>
                            <a href="http://49.247.136.36/admin/order_manage.php"><i class="fa fa-table "></i>주문 관리</a>
                        </li>
                        <li>
                            <a href="http://49.247.136.36/admin/product_approval.php"><i class="fa fa-edit "></i>상품
                                관리</a>
                        </li>
                        <li>
                            <a href="http://49.247.136.36/admin/ui.html"><i class="fa fa-bar-chart-o "></i>ui</a>
                        </li>


                    </ul>
                </div>

            </nav>
            <!-- /. NAV SIDE  -->
            <div id="page-wrapper">
                <div id="page-inner">

                    <div class="row">
                        <div class="col-md-12">
                            <h2>쇼핑몰 상세 페이지 - A쇼핑몰</h2>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>



                    <div class="info_box" >

                        <h3 style="color:#000000;  font-size: 1.5em; ">기본 정보</h3>
                        <br>

                        <table class="type03">
                            <tr>
                                <th scope="row">상호명</th>
                                <td>A쇼핑몰</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰 링크</th>
                                <td>https://wpdusdlrj97.cafe24.com/admin/admin_l.php</td>
                            </tr>
                            <tr>
                                <th scope="row">판매자 이메일</th>
                                <td>zzxcho11@naver.com</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰 전화번호</th>
                                <td>01094883402</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰 카톡ID</th>
                                <td>ask@gmail.com</td>
                            </tr>
                            <tr>
                                <th scope="row">계약날짜</th>
                                <td>2020.11.27</td>
                            </tr>

                        </table>

                    </div>

                    <br><br>

                    <div class="info_box">

                        <h3 style="color:#000000;  font-size: 1.5em; ">사업자 정보</h3>
                        <br>

                        <table class="type03">
                            <tr>
                                <th scope="row">사업자등록번호</th>
                                <td >113-8641728</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰명</th>
                                <td>A쇼핑몰</td>
                            </tr>
                            <tr>
                                <th scope="row">대표자성명</th>
                                <td>조제연</td>
                            </tr>
                            <tr>
                                <th scope="row">사업장주소</th>
                                <td>서울특별시 서초구 방배동 동작대로 112 </td>
                            </tr>
                            <tr>
                                <th scope="row">대표전화 </th>
                                <td>01094883402</td>
                            </tr>
                            <tr>
                                <th scope="row">대표이메일</th>
                                <td>zzxcho11@naver.com</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰 주소</th>
                                <td>서울특별시 서초구 방배동 동작대로 112</td>
                            </tr>
                            <tr>
                                <th scope="row">통신판매업 신고여부</th>
                                <td>예</td>
                            </tr>
                            <tr>
                                <th scope="row">계좌번호</th>
                                <td>우리 1004-893-121129</td>
                            </tr>
                            <tr>
                                <th scope="row">교환/반품 주소</th>
                                <td>서울특별시 서초구 방배동 동작대로 112</td>
                            </tr>
                            <tr>
                                <th scope="row">배송업체 선정</th>
                                <td>대한통운</td>
                            </tr>

                        </table>

                    </div>

                    <br><br>

                    <div class="info_box">

                        <h3 style="color:#000000;  font-size: 1.5em; ">고객센터 정보</h3>
                        <br>

                        <table class="type03">
                            <tr>
                                <th scope="row">상담/주문 전화</th>
                                <td>01094883402</td>
                            </tr>
                            <tr>
                                <th scope="row">상담/주문 이메일</th>
                                <td>ask@gmail.com</td>
                            </tr>
                            <tr>
                                <th scope="row">팩스번호</th>
                                <td>129-4750</td>
                            </tr>
                            <tr>
                                <th scope="row">CS 운영시간</th>
                                <td>09:00 ~ 17:00 (주말 제외)</td>
                            </tr>
                        </table>

                    </div>

                    <br><br>
                    <div class="info_box" >

                        <h3 style="color:#000000;  font-size: 1.5em; ">주문 정보</h3>
                        <br>

                        <table class="type03">
                            <tr>
                                <th scope="row">총 판매건수</th>
                                <td>109건</td>
                            </tr>
                            <tr>
                                <th scope="row">총 판매금액</th>
                                <td>9,000,000원</td>
                            </tr>
                            <tr>
                                <th scope="row">총 주문건수</th>
                                <td>129건</td>
                            </tr>
                            <tr>
                                <th scope="row">총 반품건수</th>
                                <td>10건</td>
                            </tr>
                            <tr>
                                <th scope="row">리뷰 개수</th>
                                <td>109건</td>
                            </tr>
                            <tr>
                                <th scope="row">상품별 하트</th>
                                <td>자세히보기</td>
                            </tr>
                            <tr>
                                <th scope="row">쇼핑몰 하트</th>
                                <td>자세히보기</td>
                            </tr>
                        </table>

                    </div>





                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->

        </div>
        <div class="footer">


            <div class="row">
                <div class="col-lg-12">
                    &copy; 2014 yourdomain.com | Design by: <a href="http://binarytheme.com" style="color:#fff;"
                                                               target="_blank">www.binarytheme.com</a>
                </div>
            </div>
        </div>


        </body>
        </html>
        <?php
    } else { //접근권한이 Fitme 관리자가 아닌 경우에는 wrong_access.php로 넘긴다
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }
}
?>
