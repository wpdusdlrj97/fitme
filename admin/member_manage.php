<?php
session_start(); //세션을 유지한다.

/*
 이 페이지는 회원 조회 및 관리 페이지이다
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


    if ($_SESSION['query']) { // 세션 쿼리에 저장 값이 있을 시에
        //memeber_manage_search에서 저장한 Session 쿼리를 가져온뒤 NULL 값으로 입력한다
        $query_member = $_SESSION['query'];
        $_SESSION['query'] = null;

        // 회원정보 조회 관련 쿼리
        $result_member = mysqli_query($con, $query_member);
        $total_member = mysqli_num_rows($result_member);
    }else{
        $total_member = 0;
    }


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


            <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
            <script src="http://code.jquery.com/jquery-1.10.2.js"></script>
            <script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
            <script type="text/javascript">
                $(function () {
                    $("#datepicker1, #datepicker2").datepicker({

                        showOn: "both",
                        buttonImage: "http://49.247.136.36/admin/image/calendar.png",
                        buttonImageOnly: true,
                        showButtonPanel: true,
                        closeText: '닫기',

                        dateFormat: 'yy.mm.dd',
                        prevText: '이전 달',
                        nextText: '다음 달',
                        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                        monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                        showMonthAfterYear: true,
                        changeMonth: true,
                        changeYear: true,
                        yearSuffix: '년'
                    });
                });
            </script>
            <script>
                // 회원정보 상세 조회하기
                function member_detail(email) {
                    var member_email = email;

                    //회원 정보 상세 페이지로 이동

                    //location.href = "http://49.247.136.36/admin/member_detail.php?member_email=" + member_email;
                    //하드 코딩
                    location.href = "http://49.247.136.36/admin/member_detail.php";

                }
            </script>


        </head>


        <body>


        <style>
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }

            table.type05 {
                border-collapse: separate;
                border-spacing: 0;
                text-align: left;
                line-height: 1.5;
                border-top: 1px solid #ccc;
                border-left: 1px solid #ccc;
                margin: 20px 10px;
            }

            table.type05 th {

                padding: 5px;
                font-weight: bold;
                vertical-align: top;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
                border-top: 1px solid #fff;
                border-left: 1px solid #fff;
                background: #eee;
            }

            table.type05 td {

                padding: 5px;
                vertical-align: top;
                border-right: 1px solid #ccc;
                border-bottom: 1px solid #ccc;
            }

            #customers {
                font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            #customers td, #customers th {
                border: 1px solid #ddd;
                text-align: center;
                padding: 5px;
            }

            #customers tr:nth-child(even) {
                background-color: #ffffff;
            }

            #customers tr:hover {
                background-color: #ddd;
            }

            #customers th {
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #000000;
                color: white;
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
                            <h2>회원 관리</h2>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>

                    <div style="margin-left: 100px;">

                        <form action="http://49.247.136.36/admin/member_manage_search.php" accept-charset="utf-8"
                              name="member_info" method="post">

                            <table class="type05">
                                <tr>
                                    <th scope="row" style="width: 140px;">아이디</th>
                                    <td style="width: 600px;"><input type="email" id="member_id" maxlength=40
                                                                     style="width:50% ;padding:2px; font-size:9pt;"
                                                                     name="member_id">
                                    </td>

                                    <th scope="row" style="width: 140px;">키</th>
                                    <td style="width: 400px;"><input type="number" id="member_height1" maxlength=3
                                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_height1">
                                        cm ~ <input type="number" id="member_height2" maxlength=3
                                                    style="width:10%;padding:2px; font-size:9pt;" name="member_height2"> cm
                                    </td>



                                </tr>
                                <tr>
                                    <th scope="row">회원등급</th>
                                    <td>
                                        <select name="member_level">
                                            <option value="">전체</option>
                                            <option value="0">일반회원</option>
                                            <option value="1">쇼핑몰 판매자</option>
                                            <option value="2">FitMe 관리자</option>
                                        </select>
                                    </td>
                                    </td>
                                    <th scope="row" style="width: 140px;">몸무게</th>
                                    <td style="width: 400px;"><input type="number" id="member_weight1" maxlength=3
                                                                     style="width: 9%;padding:2px; font-size:9pt;" name="member_weight1">
                                        kg ~ <input type="number" id="member_weight2" maxlength=3
                                                    style="width:9%;padding:2px; font-size:9pt;" name="member_weight2"> kg
                                    </td>


                                </tr>
                                <tr>
                                    <th scope="row">성별</th>
                                    <td>
                                        <select name="member_sex">
                                            <option value="">전체</option>
                                            <option value="man">남자</option>
                                            <option value="woman">여자</option>
                                        </select>
                                    </td>
                                    <th scope="row" style="width: 140px;">허리둘레</th>
                                    <td style="width: 400px;"><input type="number" id="member_waist1" maxlength=3
                                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_waist1">
                                        cm ~  <input type="number" id="member_waist2" maxlength=3
                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_waist2"> cm
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">나이</th>
                                    <td><input type="number" id="member_age1" maxlength=3
                                               style="width:10%;padding:2px; font-size:9pt;" name="member_age1">
                                        세 ~
                                        <input type="number" id="member_age2" maxlength=3
                                               style="width:10%;padding:2px; font-size:9pt;" name="member_age2">세
                                    </td>
                                    <th scope="row" style="width: 140px;">상체 총기장</th>
                                    <td style="width: 400px;"><input type="number" id="member_top1" maxlength=3
                                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_top1">
                                        cm ~  <input type="number" id="member_top2" maxlength=3
                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_top2"> cm
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">전화번호</th>
                                    <td><input type="tel" id="member_phone" maxlength=12
                                               style="width:40%;padding:2px; font-size:9pt;" name="member_phone"
                                               placeholder="'-'없이 ex.01012345678">
                                    </td>
                                    <th scope="row" style="width: 140px;">다리 길이</th>
                                    <td style="width: 400px;"><input type="number" id="member_leg1" maxlength=3
                                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_leg1">
                                        cm ~  <input type="number" id="member_leg2" maxlength=3
                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_leg2"> cm
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">광고수신동의</th>
                                    <td>
                                        <select name="member_advertise">
                                            <option value="">전체</option>
                                            <option value="yes">예</option>
                                            <option value="no">아니요</option>
                                        </select>
                                    </td>
                                    <th scope="row">총 구매금액</th>
                                    <td style="width: 400px;"><input type="number" id="member_buy_sum1" maxlength=3
                                                                     style="width:30%;padding:2px; font-size:9pt;" name="member_buy_sum1">
                                        원 ~  <input type="number" id="member_buy_sum2" maxlength=3
                                                    style="width:30%;padding:2px; font-size:9pt;" name="member_buy_sum2"> 원
                                    </td>
                                </tr>
                                <tr>
                                    <th scope="row">가입날짜</th>
                                    <td><input type="text" id="datepicker1"> ~
                                        <input type="text" id="datepicker2"></td>
                                    <th scope="row">총 구매건수</th>
                                    <td style="width: 400px;"><input type="number" id="member_buy_count1" maxlength=3
                                                                     style="width:10%;padding:2px; font-size:9pt;" name="member_buy_count1">
                                        건 ~  <input type="number" id="member_buy_count2" maxlength=3
                                                    style="width:10%;padding:2px; font-size:9pt;" name="member_buy_count2"> 건
                                    </td>
                                </tr>
                            </table>

                            <br>
                            <button class="btn btn-default" type="submit" style="margin-left: 600px;">조회하기</button>
                        </form>
                        <!-- /. ROW  -->
                    </div>



                    <br><br>


                    <div class="row">
                        <div class="col-md-12">
                            <h3>회원정보 리스트 </h3>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>


                    <table id="customers">
                        <tr>
                            <th>이메일</th>
                            <th>전화번호</th>
                            <th>나이</th>
                            <th>등급</th>
                            <th>성별</th>
                            <th>상세정보</th>
                        </tr>
                        <tbody>
                        <?php
                        while ($row_member = mysqli_fetch_assoc($result_member)) { //DB에 저장된 데이터 수 (열 기준)
                            if ($total_member % 2 == 0) {
                                ?>                      <tr class="even">
                            <?php } else {
                                ?>                      <tr>

                            <?php } ?>
                            <td width="10%" align="center"><?php echo $row_member['email'] ?></td>
                            <td width="25%" align="center"><?php echo $row_member['phone'] ?></td>
                            <td width="15%" align="center"><?php echo $row_member['age'] ?></td>
                            <td width="10%" align="center"><?php echo $row_member['level'] ?></td>
                            <td width="20%" align="center"><?php echo $row_member['sex'] ?></td>
                            <td width="10%" align="center"><a style="color: dodgerblue; cursor:pointer;"
                                                              onclick="member_detail('<?php echo $row_member['email'] ?>')">자세히보기</a>
                            </td>

                            </tr>
                            <?php
                            $total--;
                        }
                        ?>
                        </tbody>

                    </table>
                    <?php
                        if($total_member=="0"){?>
                            <h3 style="text-align: center">검색된 회원 내역이 없습니다.</h3>
                        <?php    }
                    ?>

                    <br><br><br><br><br>


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
