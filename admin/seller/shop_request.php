<?php
session_start(); //세션을 유지한다.

/*
 이 페이지는 입점 문의/신청을 관리하는 페이지로
  -계약 진행 중인 쇼핑몰에 대한 계약 성공 여부 파악
  -입점 신청한 쇼핑몰에 대한 허가 or 거부
  -입점 거부된 쇼핑몰에 대한 리스트
 */


/*
이 페이지에서 가장 먼저 해야할것은 접속한 사용자가 일반사용자인지 FitMe 관리자 인지를 확인 하여야한다.
DB에서 user_information테이블에서 level이 사용자 권한을 나타낸다.
level이 0이라면 일반사용자이며 1이라면 일반 쇼핑몰이고 2라면 FitMe 관리자를 뜻한다
 */

$con = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe'); //DB에 연결한다.
mysqli_set_charset($con, 'utf8'); //문자셋을 지정한다.
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/admin/seller/shop_request.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

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


    //쇼핑몰 입점 신청 대기 관련 쿼리
    //입점 신청 대기는 오래된 순으로 정렬 (빠른 처리를 위해)
    $query_shop_wait = "SELECT * FROM shop_request_wait ORDER BY shop_request_date asc";
    $result_shop_wait = mysqli_query($con, $query_shop_wait);
    $total_shop_wait = mysqli_num_rows($result_shop_wait);

    //쇼핑몰 입점 신청 계약 진행중 관련 쿼리
    //쇼핑몰 입점 신청 계약 진행중은 오래된 순으로 정렬 (빠른 처리를 위해)
    $query_shop_contract = "SELECT * FROM shop_request_allow where shop_contract_finish=0 ORDER BY shop_allow_date asc";
    $result_shop_contract = mysqli_query($con, $query_shop_contract);
    $total_shop_contract = mysqli_num_rows($result_shop_contract);


    //쇼핑몰 입점 실패 관련 쿼리
    //쇼핑몰 입점 실패는 최신 순으로 정렬 (빠른 처리를 위해)
    $query_shop_fail = "SELECT * FROM shop_request_fail ORDER BY shop_fail_date desc";
    $result_shop_fail = mysqli_query($con, $query_shop_fail);
    $total_shop_fail = mysqli_num_rows($result_shop_fail);


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
            <link href="../assets/css/bootstrap.css" rel="stylesheet"/>
            <!-- FONTAWESOME STYLES-->
            <link href="../assets/css/font-awesome.css" rel="stylesheet"/>
            <!-- CUSTOM STYLES-->
            <link href="../assets/css/custom.css" rel="stylesheet"/>
            <!-- GOOGLE FONTS-->
            <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'/>
            <link rel="stylesheet" type="text/css" href="../product_approval.css">
        </head>
        <style>
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

        <script>

            //입점 허용 시 이동하는 자바 스크립트 함수
            function request_wait_allow(email) {
                var shop_email = email;
                var quest = confirm('입점 허가를 하시겠습니까?');
                if (quest) // 예를 선택하실 경우;;
                {
                    location.href = "http://49.247.136.36/admin/seller/request_allow.php?shop_email=" + shop_email;
                }
            }

            //입점 거부 시 이동하는 자바 스크립트 함수
            function request_wait_fail(email) {
                var shop_email = email;
                var userInput = prompt("입점 거부 사유를 작성해주세요 :" + "");
                if(userInput!=null){
                    location.href = "http://49.247.136.36/admin/seller/request_fail.php?shop_email=" + shop_email + "&shop_fail_reason=" + userInput;
                }



            }

            //계약 성공 시 이동하는 자바 스크립트 함수
            function contract_success(email) {
                var shop_email = email;
                var quest = confirm('계약이 성사되었습니까?');
                if (quest) // 예를 선택하실 경우;;
                {
                    location.href = "http://49.247.136.36/admin/seller/contract_success.php?shop_email=" + shop_email;
                }
            }

            //입점 거부 시 이동하는 자바 스크립트 함수
            function contract_fail(email) {
                var shop_email = email;
                var userInput = prompt("계약 실패 사유를 작성해주세요 :" + "");
                if(userInput!=null){
                    location.href = "http://49.247.136.36/admin/seller/contract_fail.php?shop_email=" + shop_email + "&shop_fail_reason=" + userInput;
                }
            }





        </script>


        <body>


        <div id="wrapper">
            <div class="navbar navbar-inverse navbar-fixed-top">
                <a class="navbar-brand" href="#">
                    <img src="../assets/img/admin_logo.png" style="width:30%; height:300%"/>
                </a>
            </div>

            <!-- /. NAV TOP  -->
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">


                        <li>
                            <a href="http://49.247.136.36/admin/shop_manage.php"><i class="fa fa-desktop "></i>쇼핑몰 관리</a>
                        </li>

                        <li class="active-link">
                            <a href="http://49.247.136.36/admin/seller/shop_request.php"><i class="fa fa-flag-o"></i>입점 문의/신청 관리</a>
                        </li>

                        <li>
                            <a href="http://49.247.136.36/admin/member_manage.php"><i class="fa fa-bar-chart-o"></i>회원 관리</a>
                        </li>

                        <li>
                            <a href="http://49.247.136.36/admin/order_manage.php"><i class="fa fa-table "></i>주문 관리</a>
                        </li>
                        <li>
                            <a href="http://49.247.136.36/admin/product_approval.php"><i class="fa fa-edit "></i>상품 관리</a>
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

                    <!--

                        계약 진행 중인 쇼핑몰 리스트는 shop_request_allow 테이블의 데이터로 이루어져있다

                        상호명, 쇼핑몰 링크, 판매자 이메일, 쇼핑몰 전화번호, 쇼핑몰 카톡 아이디, 입점 허용 날짜, 입점 허가인, 계약 여부 등이 입력되며

                        계약 성공을 누를 시 -> contract_success.php 파일로 이동해 shop_request_allow의 계약 여부를 0에서 1로 바꾼다

                        계약 실패를 누를 시 -> contract_fail.php 파일로 이동해 해당 데이터를 shop_request_fail 테이블로 옮긴다

                    -->

                    <div class="row">
                        <div class="col-md-12">
                            <h3>계약 진행 중인 쇼핑몰 </h3>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>

                    <table id="customers">
                        <tr>
                            <th style="background-color: royalblue">입점 허가 날짜</th>
                            <th style="background-color: royalblue">입점 허가인</th>
                            <th style="background-color: royalblue">상호명</th>
                            <th style="background-color: royalblue">쇼핑몰 링크</th>
                            <th style="background-color: royalblue">판매자 이메일</th>
                            <th style="background-color: royalblue">쇼핑몰 전화번호</th>
                            <th style="background-color: royalblue">쇼핑몰 Kakao ID</th>

                            <th style="background-color: royalblue">계약 여부</th>
                        </tr>
                        <tbody>
                        <?php
                        while ($row_shop_contract = mysqli_fetch_assoc($result_shop_contract)) { //DB에 저장된 데이터 수 (열 기준)
                            if ($total_shop_contract % 2 == 0) {
                                ?>                      <tr class="even">
                            <?php } else {
                                ?>                      <tr>

                            <?php } ?>
                            <td width="10%" align="center"><?php echo $row_shop_contract['shop_allow_date'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_contract['shop_allow_admin'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_contract['shop_name'] ?></td>
                            <td width="20%" align="center"><?php echo $row_shop_contract['shop_url'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_contract['shop_email'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_contract['shop_phone'] ?></td>
                            <td width="20%" align="center"><?php echo $row_shop_contract['shop_kakao_id'] ?></td>

                            <td width="10%" align="center"><a style="color: dodgerblue; cursor:pointer;"
                                                              onclick="contract_success('<?php echo $row_shop_contract['shop_email'] ?>')">성공</a>
                                / <a style="color: red; cursor:pointer;"
                                     onclick="contract_fail('<?php echo $row_shop_contract['shop_email'] ?>')">실패</a>
                            </td>
                            </tr>
                            <?php
                            $total--;
                        }
                        ?>
                        </tbody>

                    </table>


                    <br><br><br><br><br>


                    <!--

                    쇼핑몰 입점 신청 리스트는 shop_request_wait 테이블의 데이터로 이루어져있다

                    상호명, 쇼핑몰 링크, 판매자 이메일, 쇼핑몰 전화번호, 쇼핑몰 카톡 아이디, 입점 신청 날짜 등이 입력되며

                    허가를 누를 시 -> shop_request_allow 테이블로 해당 쇼핑몰 정보가 이동하며
                                    허가를 한 관리자의 이메일, 전화번호/이메일로 해당 쇼핑몰에 컨택한다

                    거부를 누를 시 -> 거부 사유를 입력하고  shop_request_fail 테이블로
                                    거부를 한 관리자의 이메일,거부 사유,해당 쇼핑몰 정보가 입력된다

                     -->


                    <div class="row">
                        <div class="col-md-12">
                            <h3>쇼핑몰 입점 신청 리스트 </h3>
                        </div>
                    </div>
                    <!-- /. ROW  -->
                    <hr/>


                    <table id="customers">
                        <tr>
                            <th>상호명</th>
                            <th>쇼핑몰 링크</th>
                            <th>판매자 이메일</th>
                            <th>쇼핑몰 전화번호</th>
                            <th>쇼핑몰 Kakao ID</th>
                            <th>입점 신청 날짜</th>
                            <th>허가 여부</th>
                        </tr>
                        <tbody>
                        <?php
                        while ($row_shop_wait = mysqli_fetch_assoc($result_shop_wait)) { //DB에 저장된 데이터 수 (열 기준)
                            if ($total_shop_wait % 2 == 0) {
                                ?>                      <tr class="even">
                            <?php } else {
                                ?>                      <tr>

                            <?php } ?>
                            <td width="10%" align="center"><?php echo $row_shop_wait['shop_name'] ?></td>
                            <td width="25%" align="center"><?php echo $row_shop_wait['shop_url'] ?></td>
                            <td width="15%" align="center"><?php echo $row_shop_wait['shop_email'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_wait['shop_phone'] ?></td>
                            <td width="20%" align="center"><?php echo $row_shop_wait['shop_kakao_id'] ?></td>
                            <td width="10%" align="center"><?php echo $row_shop_wait['shop_request_date'] ?></td>


                            <td width="10%" align="center"><a style="color: dodgerblue; cursor:pointer;"
                                                              onclick="request_wait_allow('<?php echo $row_shop_wait['shop_email'] ?>')">승인</a>
                                / <a style="color: red; cursor:pointer;"
                                     onclick="request_wait_fail('<?php echo $row_shop_wait['shop_email'] ?>')">거부</a>
                            </td>
                            </tr>
                            <?php
                            $total--;
                        }
                        ?>
                        </tbody>

                    </table>
                    <br><br><br><br><br>

                    <!--

                    쇼핑몰 입점 거부 리스트는 shop_request_fail 테이블의 데이터로 이루어져있다

                    상호명, 쇼핑몰 링크, 판매자 이메일, 쇼핑몰 전화번호, 쇼핑몰 카톡 아이디, 입점 거부 날짜, 입점 거부인, 입점 거부 사유등이 입력된다

                    허가를 누를 시 -> shop_request_allow 테이블로 해당 쇼핑몰 정보가 이동하며
                                    허가를 한 관리자의 이메일, 전화번호/이메일로 해당 쇼핑몰에 컨택한다

                    거부를 누를 시 -> 거부 사유를 입력하고  shop_request_fail 테이블로
                                    거부를 한 관리자의 이메일,거부 사유,해당 쇼핑몰 정보가 입력된다

                     -->


                    <div class="row">
                        <div class="col-md-12">
                            <h3>입점 거부된 쇼핑몰 </h3>
                        </div>
                    </div>

                        <!-- /. ROW  -->
                        <hr/>


                        <table id="customers">
                            <tr>
                                <th style="background-color: gray">입점 거부 날짜</th>
                                <th style="background-color: gray">입점 거부인</th>
                                <th style="background-color: gray">상호명</th>
                                <th style="background-color: gray">쇼핑몰 링크</th>
                                <th style="background-color: gray">판매자 이메일</th>
                                <th style="background-color: gray">쇼핑몰 전화번호</th>
                                <th style="background-color: gray">쇼핑몰 Kakao ID</th>
                                <th style="background-color: gray">거부이유</th>
                            </tr>
                            <tbody>
                            <?php
                            while ($row_shop_fail = mysqli_fetch_assoc($result_shop_fail)) { //DB에 저장된 데이터 수 (열 기준)
                                if ($total_shop_fail % 2 == 0) {
                                    ?>                      <tr class="even">
                                <?php } else {
                                    ?>                      <tr>

                                <?php } ?>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_fail_date'] ?></td>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_fail_admin'] ?></td>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_name'] ?></td>
                                <td width="20%" align="center"><?php echo $row_shop_fail['shop_url'] ?></td>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_email'] ?></td>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_phone'] ?></td>
                                <td width="10%" align="center"><?php echo $row_shop_fail['shop_kakao_id'] ?></td>
                                <td width="20%" align="center"><?php echo $row_shop_fail['shop_fail_reason'] ?></td>

                                </tr>
                                <?php
                                $total--;
                            }
                            ?>
                            </tbody>

                        </table>


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


            <!-- /. WRAPPER  -->
            <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
            <!-- JQUERY SCRIPTS -->
            <script src="assets/js/jquery-1.10.2.js"></script>
            <!-- BOOTSTRAP SCRIPTS -->
            <script src="assets/js/bootstrap.min.js"></script>
            <!-- CUSTOM SCRIPTS -->
            <script src="assets/js/custom.js"></script>


        </body>
        </html>
        <?php
    } else { //접근권한이 Fitme 관리자가 아닌 경우에는 wrong_access.php로 넘긴다
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }
}
?>