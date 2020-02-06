<?php

// url 흐름 - seller/inquire.php -> seller/request_first.php -> seller/request_second.php

// 로그인 필수
// 입점 신청 1단계 페이지로 약관 및 정책 동의가 이루어지는 화면이다
// 동의하지 않을 시 입점 신청 2단계로 이동불가


session_start();
//임시리스트
$pic_array = array("1.jpg", "2.jpg", "3.jpg", "4.jpg", "5.jpg", "6.jpg", "7.jpg", "8.jpg", "9.jpg", "10.jpg");
$shop_array = array("모디파이드", "에이본", "구카", "퍼스트플로어", "퍼스트플로어", "퍼스트플로어", "에이본", "스튜디오 톰보이", "인사일러스", "낫앤낫", "오버더원");
$name_array = array("(XXL 추가) M1412 슬림핏 미니멀 블랙 블레이져", "3110 wool over jacket charcoal", "모던 투피스", "빌보 자켓", "12/17 배송 EASYGOING CROP", "149 cashmere double over long coat black",
    "[MEN] 차이나카라 싱글 롱코트 1909211822135", "IN SILENCE X BUND 익스플로러 더블 코트 BLACK", "[겨울원단 추가]NOT 세미 오버 블레이져 - 블랙", "오버더원 204블레이져 블랙");
$price_array = array("89,000", "66,000", "254,000", "144,000", "57,400", "119,000", "499,000", "289,000", "79,200", "128,000");
$fit_array = array("10.jpg", "11.jpg", "12.jpg", "13.jpg", "14.jpg", "15.jpg");


$email = $_SESSION['email'];

if (!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/main/seller/request_first.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.
}

$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe') or die ("connect fail");
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');


?>

<html>

<style type="text/css">
    /*
     * Specific styles of signin component
     */
    /*
     * General styles
     */

    body, html {
        height: 70%;
        background-repeat: no-repeat;

    }

    .card-container.card {
        max-width: 800px;
        padding: 40px 40px;
        margin-top: 100px;
        margin-bottom: 100px;
    }

    .btn {
        font-weight: 700;
        height: 36px;
        -moz-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        cursor: default;
    }

    /*
     * Card component
     */
    .card {
        background-color: #FFFFFF;
        /* just in case there no content*/
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;

    }

    .button {
        background-color: #000000;
        border: none;
        color: white;
        padding: 10px 25px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
    }


</style>

<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<!--약관 동의를 하지 않을 시 alert를 띄워주는 javascript-->
<script type="text/javascript">

    $(document).ready(function () {

        $("#nextBtn").click(function () {
            if ($("#check_1").is(":checked") == false) {
                alert("모든 약관에 동의 하셔야 다음 단계로 진행 가능합니다.");
                return;
            } else if ($("#check_2").is(":checked") == false) {
                alert("모든 약관에 동의 하셔야 다음 단계로 진행 가능합니다.");
                return;
            } else {
                $("#terms_form").submit();
            }
        });
    });
</script>


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <script src="http://49.247.136.36/api/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="http://49.247.136.36/api/swiper.css">
    <link rel="stylesheet" href="http://49.247.136.36/api/swiper.min.css">
    <script src="http://49.247.136.36/api/swiper.js"></script>
    <script src="http://49.247.136.36/api/swiper.min.js"></script>


    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../head_foot.css">
    <title>FITME</title>
</head>
<body>
<div id="fitme_button">
    <div id="fitme_button_icon"></div>
</div>
<div id="header"></div>


<div id="center_box">
    <div class="product_new_box">

        <div id="page-wrapper">

            <br><br><br>

            <div id="main" class="wrapper style1">


                <div class="card card-container" style="border:4px solid black;">

                    <h1>입점 신청 1단계</h1>
                    <br><br>

                    <form id="terms_form" method="get" action="request_second.php" name="termsForm">

                        <section id="fregister_term">
                            <h4>1. FitME 판매자 이용약관</h4>
                            <textarea readonly style="width:700px; height:140px; text-align:left;">판매자이용약관

제1장 총칙
제 1 조 목적
이 약관은 (주)FitMe(이하 "회사"라 함)가 운영하는 오픈마켓 판매자 페이지 (admin.fitme.co.kr, 이하 "브랜디셀러관리자")에 판매회원으로 가입하여 사이버 몰(www.fitme.com, 이하 "몰"이라 함)과 스마트폰 등 이동통신기기를 통해 제공 되는 모바일 애플리케이션 (이하 "FitMe 앱"이라고 합니다)


제 2 조 (약관의 명시, 효력과 개정)
1. 회사는 이 약관의 내용을 회사의 상호, 영업소 소재지, 대표자의 성명, 사업자 등록번호, 연락처(전화, 팩스, 전자우편주소 등) 등과 함께 회원이 확인할 수 있도록 “몰” 초기 화면 또는 연결화면에 게시합니다.

2. 회사는 약관의규제에관한법률, 전자거래기본법, 전자서명법, 정보통신망이용촉진 및 정보보호 등에 관한 법률, 전자상거래 등에서의 소비자보호에 관한 법률, 전자금융거래법 등 관련 법률을 위배하지 않는 범위에서 본 약관을 개정할 수 있습니다.

3. 회사가 약관을 개정할 경우에는 적용일자 및 개정사유를 명시하여 “브랜디셀러관리자” 공지사항 카테고리에 등록하거나, 회원이 제공한 e-mail주소로 전달합니다. 이중 먼저 이루어진 시점에 개정 사항이 통지된 것으로 보며 그 적용일자 7일(다만, 판매회원에게 불리한 내용으로 변경하는 경우에는 30일) 이전부터 적용일자 전일까지 공지합니다. 변경된 약관은 그 적용일자 이전으로 소급하여 적용되지 아니합니다.



제 2 조의 1 (회사의 일반적 준수사항)


1. 회사는 수수료(제14조의 서비스 이용료)의 결정과 관련하여 다른 오픈마켓 사업자와 담합 등 불공정행위를 하지 않습니다.

2. 회사는 판매회원에게 기획전 및 기타 브랜디 이벤트 참여 등을 부당하게 강요하지 않습니다.

3. 회사는 판매회원 간 수수료를 다르게 정하지 않습니다. 다만, 회사는 합리적인 사유가 있는 경우에는 이를 다르게 정할 수 있습니다.

4. 회사는 판매회원이 다른 오픈마켓사업자와 거래하지 못하게 하거나 다른 오픈마켓사업자와 거래한다는 이유로 판매회원에게 불이익을 제공하지 아니합니다.



제 3 조 (용어의 정의)


1. 이 약관에서 사용하는 용어의 정의는 다음과 같습니다.

① 오픈마켓 : 누구나 판매자나 구매자가 되어 온라인상에서 상품을 팔고 살 수 있는 가상의 장터를 말합니다.

② 오픈마켓사업자 : 오픈마켓과 오픈마켓에서의 부가서비스(광고서비스 등)를 제공하고, 이에 대한 대가를 받는 사업자를 말합니다.

③ 할인쿠폰 : 회사의 서비스를 통하여 물품을 구매할 때 표시된 금액 또는 비율만큼 물품대금에서 할인 받을 수 있는 회사 전용의 사이버 또는 오프라인 쿠폰을 말합니다.

④ 아이템할인 : 판매회원이 회사의 서비스를 통하여 물품을 판매할 때 특정물품의 판매가격을 할인하는 것을 말합니다. 회사는 아이템할인으로 인한 특정물품 판매가격 할인액을 해당 서비스 화면에 게재 하여야 합니다.

⑤ 브랜디셀러관리자 : 회사가 제공하는 “몰” 및 “브랜디 앱”에서 판매 관련 서비스(상품등록, 상품매핑, 배송관리, 정산관리 등)이용할 수 있는 판매자 전용 페이지를 말합니다.

⑥ 셀러명 : 회사가 제공하는 “몰” 및 “브랜디 앱”에서 제공하는 서비스를 이용하기위해 사용하는 판매자 개별의 공식 스토어 명칭입니다.

⑦ 판매수수료 : 회사가 판매회원에게 상품 판매를 위한 서비스를 제공하여 판매회원이 회사에 지급하는 서비스 이용금액을 말합니다. 이는 판매회원의 상품판매금액에 회사가 고지한 일정 비율로 산정합니다.

⑧ 서버이용료 : 회사의 서비스를 이용하기 위한 서버이용 목적의 이용료를 말하며, 이용료의 부과 방식은 회사가 별도로 고지한 방법으로 산정합니다.

⑨  부가서비스이용료 : 판매회원의 상품 판매를 촉진하기 위해 이용하는 서비스의 이용 대금을 말합니다.

⑩ 포인트 : 회사에서 정한 마케팅 활동의 보상으로 지급하는 현금성 자산으로 회사가 제공하는 웹 또는 앱에서 사용가능한 가상 현금을 말합니다.

⑪  회원 : 회사의 서비스를 이용하고자 판매서비스 가입을 완료한 판매회원을 말합니다.



2. 이 약관에서 사용되는 용어의 정의는 이 약관에서 별도로 규정하는 경우를 제외하고 브랜디 서비스 이용약관(이하 "구매약관"이라 함) 제3조의 규정을 따릅니다.



제 4 조 (서비스의 종류)


1. 회사가 제공하는 서비스는 다음과 같습니다.

① E-Commerce Platform 개발 및 운영서비스

가) 판매관련 업무지원서비스

나) 구매관련 지원서비스

다) 매매계약체결관련 서비스

라) 상품 정보검색 서비스

마) 기타 전자상거래 관련 서비스

② 광고 집행 및 프로모션 서비스

2. 회사가 제공하는 전항의 서비스는 회원이 재화 등을 거래할 수 있도록 사이버몰의 이용을 허락하거나, 통신판매를 알선하는 것을 목적으로 하며, 개별 판매회원이 “브랜디셀러관리자”에 등록한 상품과 관련해서는 일체의 책임을 지지 않습니다.



제 5 조 (대리행위의 부인)


회사는 통신판매중개자로서 효율적인 서비스를 위한 시스템 운영 및 관리 책임만을 부담하며, 재화 또는 용역의 거래와 관련하여 구매자 또는 판매회원을 대리하지 아니하고, 회원 사이에 성립된 거래 및 회원이 제공하고 등록한 정보에 대해서는 해당 회원이 그에 대한 직접적인 책임을 부담하여야 합니다.



제 6 조 (보증의 부인)


회사는 회사가 제공하는 시스템을 통하여 이루어지는 구매자와 판매회원 간의 거래와 관련하여 판매의사 또는 구매의사의 존부 및 진정성, 등록물품의 품질, 완전성, 안정성, 적법성 및 타인의 권리에 대한 비침해성, 구매자 또는 판매회원이 입력하는 정보 및 그 정보를 통하여 링크된 URL에 게재된 자료의 진실성 또는 적법성 등 일체에 대하여 보증하지 아니하며, 이와 관련한 일체의 위험과 책임은 판매회원이 전적으로 부담합니다.



제2장 이용계약 및 정보보호


제 7 조 (판매 서비스 이용계약의 성립)


1. 판매 서비스 이용계약(이하 "이용계약"이라고 합니다)은 회사가 제공하는 판매 서비스를 이용하고자 하는 자의 이용신청에 대하여 회사가 가입승인을 하는 동시에 이를 승낙한 것으로 간주하여 계약이 성립합니다. 회사는 이용 승낙의 사실을 E-mail, SMS 또는 기타 방법으로 10일 이내 개별적으로 통지합니다.

2. 판매 서비스를 이용하고자 하는 자는 본 약관에 동의하고, 회사가 정하는 판매회원 가입 신청 양식에 따라 필요한 사항을 기입합니다.

3. 판매회원 가입은 만 19세 이상의 개인 또는 사업자(개인사업자 및 법인사업자)가 할 수 있으며, 이용신청자는 실명으로 가입신청을 해야 하며, 실명이 아니거나 타인의 정보를 도용하는 경우 서비스이용이 제한될 수 있습니다.

4. 이용신청의 처리는 신청순서에 의하며, 회원가입의 성립시기는 회사의 승낙이 된 시점입니다. 회원이 악의적 목적을 위해 허위계정 생성 및 이용 중 적발 시 회사는 피해사항에 따라 민형사상에 소송을 제기할 수 있습니다.

5. 회사는 다음과 같은 사유가 발생한 경우 이용신청에 대한 승낙을 거부하거나 유보할 수 있습니다.

①  회사에 의하여 이용계약 해지 및 정지 된 후 재이용신청을 하는 경우

②  회사로부터 회원자격 정지 조치 등을 받은 회원이 그 조치기간 중에 이용계약을 임의 해지하고 재이용신청을 하는 경우

③  설비에 여유가 없거나 기술상 지장이 있는 경우

④  기타 이 약관에 위배되거나 위법 또는 부당한 이용신청임이 확인된 경우 및 회사가 합리적인 판단에 의하여 필요하다고 인정하는 경우



제 8 조 (증빙서류)


회사는 판매회원이 이 약관 제7조 제2항에 따라 제공한 정보의 정확성을 확인하기 위하여 관련법령이 허용하는 범위 내에서 증빙자료의 제공을 요청할 수 있습니다. 판매회원이 부당하게 증빙자료를 제공하지 않는 경우 회사는 이용계약의 해지, 판매활동의 제한 또는 정산금의 지급 보류 등 조치를 취할 수 있으며, 판매회원은 이로 인하여 발생하는 손해에 대해 회사에게 어떠한 책임도 물을 수 없습니다.



제 9 조 (개인정보의 변경, 보호)


1.  회원은 이용신청 시 허위의 정보를 제공하여서는 아니 되며, 기재한 사항이 변경되었을 경우에는 즉시 변경사항을 최신의 정보로 수정하여야 합니다. 단, 법령에 의한 변경 이외의 회원ID는 수정할 수 없습니다. 회원은 변경사항과 관련하여 회사가 요청하는 경우 즉시 변경사항에 관한 증빙자료를 제공하여야 합니다. 회원 정보 수정에 대한 권한은 아래와 같습니다.

항목

수정가능유무

수정방법

회원ID

수정불가

-

셀러명, 사업자등록정보

운영자 승인시 수정가능

운영자에 증빙자료 제출

기타 정보(주소/연락처 등)

판매회원 자체 수정가능

“브랜디셀러관리자”에서 수정



2. 회사의 회원에 대한 통지는 회원이 제공한 주소 또는 e-mail주소에 도달함으로써 또는 회원이 제공한 휴대폰 연락처에 SMS형태로 정상 수신이 되었을 때, 통지된 것으로 보며, 수정하지 않은 정보로 인하여 발생하는 회원의 손해 또는 타인의 손해는 당해 회원이 전적으로 부담하며, 회사는 이에 대하여 아무런 책임을 지지 않습니다. 또한, 회원이 변경된 정보를 수정하지 않거나 또는 허위 내용으로 수정하여 회사에게 손해를 입힌 경우에는 이에 대한 손해배상 책임을 부담합니다.

3. 회사는 이용계약을 위하여 회원이 제공한 정보를 회원이 동의한 회사 서비스 운영을 위한 목적 이외의 용도로 사용할 수 없으며, 새로운 이용목적이 발생한 경우 또는 제3자에게 제공하는 경우에는 이용·제공단계에서 당해 회원에게 그 목적을 고지하고 동의를 받습니다. 다만, 관련 법령에 달리 정함이 있는 경우에는 예외로 합니다.

4. 회사는 개인정보의 수집·이용·제공에 관한 동의란을 미리 선택한 것으로 설정해두지 않습니다. 또한 개인정보의 수집·이용·제공에 관한 이용자의 동의거절시 제한되는 서비스를 구체적으로 명시하고, 필수수집항목이 아닌 개인정보의 수집·이용·제공에 관한 구매서비스를 이용하고자 하는 자의 동의 거절을 이유로 회원가입 등 서비스 제공을 제한하거나 거절하지 않습니다.

5. 회사는 회원의 개인정보를 보호하기 위해 제3자에게 판매회원의 개인정보를 제공할 필요가 있는 경우에는 실제 물품등록시에 제공되는 개인정보 항목, 제공받는 자, 제공받는 자의 개인정보 이용목적 및 보유·이용기간 등을 명시하여 판매회원의 동의를 받고, 개인정보를 위탁하는 경우에는 관련 법령이 정하는 바에 따라 "개인정보취급방침"을 수립하고 개인정보 보호 책임자를 지정하여 이를 게시하고 운영합니다.



제 10 조 (아이디 및 비밀번호의 관리)


1. 아이디(ID) 및 비밀번호에 대한 관리책임은 회원에게 있으며, 회원은 어떠한 경우에도 본인의 아이디(ID) 또는 비밀번호를 타인에게 양도하거나 대여할 수 없습니다.

2. 회사의 귀책사유 없이 아이디(ID) 또는 비밀번호의 유출, 양도, 대여로 인하여 발생하는 손실이나 손해에 대하여는 회원 및 이용자 본인이 그에 대한 책임을 부담합니다.

3. 회원은 아이디(ID) 또는 비밀번호를 도난 당하거나 제3자가 무단으로 이를 사용하고 있음을 인지한 경우, 이를 즉시 회사에 통보하여야 하고 회사는 이에 대한 신속한 처리를 위하여 최선의 노력을 다합니다.



제 11 조(계약기간 및 이용계약의 종료)


1. 이용계약의 기간은 판매회원이 약관에 대해 동의한 날로부터 만 1년이 도래하는 시점까지로 하고, 기간 만료 1개월 전까지 서면에 의한 반대의 의사표시가 없는 한 계약기간은 동일한 조건으로 1년간 자동 갱신됩니다.

2. 회사의 해지

① 회사는 다음과 같은 사유가 발생하거나 확인된 경우 이용계약을 해지할 수 있습니다

가) 다른 회원 또는 타인의 권리나 명예, 신용 기타 정당한 이익을 침해하거나 대한민국 법령 또는 공서양속에 위배되는 행위를 한 경우

나) 회사가 제공하는 서비스의 원활한 진행을 방해하는 행위를 하거나 시도한 경우

다) 제7조 제5항의 승낙거부사유가 있음이 확인된 경우

라) 판매회원이 제공한 정보 또는 그에 관한 증빙자료가 허위이거나 회사가 요청하는 증빙자료를 제공하지 않는 경우

마) 판매회원의 요청에 의해 서비스 이용을 일시적으로 중단한 후, 해당 기간이 6개월 이상 지속되는 경우

바) 회사에서 운영하는 정책 위반에 따른 페널티가 2회 이상 부여된 경우

사)   기타 회사가 합리적인 판단에 기하여 서비스의 제공을 거부할 필요가 있다고 인정할 경우

②  회사가 해지를 하는 경우 회사는 회원에게 유선 또는 이메일, 기타의 방법을 통하여 해지사유를 밝혀 해지의사를 통보합니다. 이 경우 회사는 해당 회원에게 사전에 해지사유에 대한 의견진술의 기회를 부여할 수 있습니다.

③  이용계약은 회사의 해지의사를 회원에게 통지한 시점에 종료됩니다.

④  본 항에서 정한 바에 따라 이용계약이 종료될 시에는 회사는 회원에게 부가적으로 제공한 각종 혜택을 회수할 수 있습니다.

⑤  본 항에서 정한 바에 따라 이용계약이 종료된 경우에는, 회원의 재이용신청에 대하여 회사는 이에 대한 승낙을 거절할 수 있습니다.

⑥   회사가 이용계약을 해지하는 경우, 판매회원은 구매회원의 보호를 위하여 해지 시까지 완결되지 아니한 주문건의 배송, 교환, 환불, 하자보수 등 필요한 조치를 취하여야 합니다.

⑦   회사는 판매회원의 이용계약 해지 요청 시 조회되는 주문건 중, 주문발생일 기준으로 15일 이내 정당한 사유없이 필요한 조치가 취해지지 않은 주문건에 대해서는 직권 취소를 진행할 수 있습니다.

⑧   회사는 판매회원이 이용계약 해지를 요청한 이후 30일간 완결되지 아니한 주문건에 대해서는 처리불가 상태로 간주, 구매회원의 권익보호를 위해 직권처리를 진행할 수 있습니다. 이로 인해 발생하는 피해에 대해서는 별도로 보상하지 않습니다.

3.  당사자 일방에게 다음 각 호의 사유가 발생한 경우, 그 상대방은 별도의 최고 없이 해지의 통지를 함으로써 이용계약을 해지할 수 있습니다.

①   이용계약의 의무를 위반하여 상대방으로부터 그 시정을 요구 받은 후 7일 이내에 이를 시정하지 아니한 경우

②   부도 등 금융기관의 거래정지, 회생 및 파산절차의 개시, 영업정지 및 취소 등의 행정처분, 주요 자산에 대한 보전처분, 영업양도 및 합병 등으로 이용계약의 이행이 불가능한 경우

③   판매회원의 책임 있는 사유로 2개월간의 거래건 중 30% 이상의 거래 건에서 구매자로부터의 클레임이 제기되었을 경우

④   관련 법령 위반 등 판매회원의 책임 있는 사유로 인하여 회사가 명예 실추 등 유무형적 손해를 입은 경우

⑤   판매회원의 해지

4. 제3항에도 불구하고, 판매회원은 언제든지 회사에게 해지의사를 통지함으로써 이용계약을 해지할 수 있습니다. 다만, 판매회원은 해지의사를 통지하기 전에 진행중인 모든 매매절차를 종료하고 회사에 대한 채무를 정산하여야 합니다.

5. 회사는 컴퓨터 등 정보통신설비의 보수, 점검, 교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 서비스의 제공을 일시적으로 중단할 수 있습니다. 이 경우 서비스 일시 중단 사실과 그 사유를 “브랜디셀러관리자” 의 공지사항 카테고리에 게시하거나 회원이 제공한 전자우편으로 또는 회원이 제공한 휴대폰 연락처에 SMS 형태로 통지합니다.

6. 회사는 천재지변 또는 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스의 제공을 제한하거나 일시 중단할 수 있습니다.

7. 이용계약의 해지에도 불구하고 판매회원은 해지 시까지 완결되지 않은 주문건의 배송, 교환, 환불에 필요한 조치를 취하여야 하며, 해지 이전에 이미 판매한 상품과 관련하여 발생한 판매회원의 책임과 관련된 조항은 그 효력을 유지합니다.



제3장 브랜디 판매서비스의 이용


제1절 통칙가격
제 12 조 (전자상거래 플랫폼 제공 서비스)


1. 회사는 전자상거래 플랫폼 제공을 통해 “몰”과 “브랜디 앱”에서 판매회원이 다양한 형태로 상품을 판매할 수 있도록 지원합니다.

2. 회사는 판매회원이 등록한 상품을 판매촉진을 위해 국내외 포털, 가격비교 사이트, 회사의 계열사 또는 제휴사가 운영하는 사이트 및 제휴사와 제휴하는 국내외 사이트 중 회사가 동의한 사이트 등에 노출할 수 있으며, 할인행사 등을 실시할 경우에 등록된 상품을 할인된 가격으로 노출할 수 있습니다.

3. 회사는 판매회원이 등록한 물품등록정보를 회사가 서비스 제공을 위하여 정한 기준과 방법에 따라 “브랜디 웹”,  “브랜디 앱”, "브랜디가 계약한 외부판매 및 홍보 사이트" 에 게재합니다. 회사는 게재하는 물품등록정보의 위치, 크기, 배열 등을 결정하고 조정할 수 있습니다. 또한 이벤트 광고 등 회사의 서비스를 위하여 이미지 등 물품등록정보를 사용할 수 있으며, 해당 서비스화면을 구성, 편집하거나 물품등록정보 외의 사항을 게재할 수 있습니다.

4. 회사는 가격비교 방식으로 서비스를 제공할 수 있으며, 판매회원이 등록한 물품등록정보는 가격비교 방식의 서비스 및 회사가 운영하는 모든 사이트에 사용될 수 있습니다. 구체적인 사용방식은 회사가 정한 기준과 방법에 의합니다.

5. 회사가 제공하는 서비스에서 보여지는 ‘주문상태’의 상태값과 설명은 다음과 같습니다.

1) 상품준비 : 고객이 판매회원의 상품을 주문한 상태

2) 배송준비 : 상품이 입고가 되어 배송을 준비하는 상태

3) 배송중 : 출고지시 상태에서 판매회원이 상품발송 후 송장번호를 입력한 상태

4) 배송완료 : 고객에게 상품이 도달한 것을 확인하여 판매회원이 수동으로 상태를 입력하거나, 배송중으로 상태값 변경 후 7일이 경과하면 자동적으로 ‘배송완료’로 변경

5) 구매확정 : 고객의 반품이나 환불의사가 없음을 확인하여 판매회원이 수동으로 상태를 입력하거나, ‘배송완료’상태에서 관련 법규상 환불이 보장되는 7일이 경과하면 자동적으로 ‘구매확정’으로 변경

6) 주문취소중 : 고객에게 상품을 발송하기 전, 거래를 취소하고 최종 취소 대기상태

7) 환불승인중 : 고객에게 상품을 발송한 후, 거래를 취소하고 최종 환불 대기상태

8) 주문취소완료 : 고객에게 상품을 발송하기 전, 취소가 완료된 상태

9) 환불완료 : 고객에게 상품을 발송한 후, 환불이 완료된 상태



제 13 조 (판매회원의 판매활동)


 “몰”과 “브랜디 앱”에서의 상품 및 용역의 판매는 판매회원 등록이 완료됨과 동시에 가능하며, 이를 위해서 판매회원은 상품 및 용역에 관한 정보와 거래조건에 관한 내용을 전자상거래등에서의소비자보호에관한법률 등 관련 법령 및 이 약관에서 정한 방법으로 판매회원거래관리시스템(회사가 판매회원에 대한 정보제공 등을 목적으로 마련한 온라인상의 판매회원 전용화면을 말하며, 이하 “브랜디셀러관리자”라 함)을 통하여 직접 등록, 관리하여야 합니다. 이때 판매하는 상품의 가격은 판매회원의 모든 자사몰 및 매장을 포함한 거래처 대비 경쟁력 있는 가격수준을 유지해야 하며, 이에 대해서 회사가 정한 가격정책에 따라, 상품 노출의 차등 및 제한을 둘 수 있습니다.
판매회원은 등록 상품에 특별한 거래조건이 있거나 추가되는 비용이 있는 경우 구매자가 이를 알 수 있도록 명확하게 기재하여야 합니다.
 판매회원은 상품 등록 시 ① 품목별 재화 등에 관한 정보, ② 거래조건에 관한 정보 등 ‘전자상거래 등에서의 상품 등의 정보제공에 관한 고시’(공정거래위원회 고시 제2015-17호, 이하 ‘상품정보제공고시’)에서 정한 정보를 입력하여야 하고, 상품 등록 후 상품정보제공고시가 변경되는 경우 그에 맞추어 관련 정보를 수정, 보완하여야 합니다. 판매회원이 상품정보제공고시에 따른 정보를 입력하지 않거나, 상품 등록 후 변경된 상품정보제공고시에 따라 정보를 수정, 보완하지 않는 경우 회사는 서비스 제한, 페널티 부여, 이용 중지 등 필요한 조치를 취할 수 있습니다.
회사는 상품검색의 효율성, 판매회원관리시스템의 정상적인 운영을 위하여, 판매회원에 대한 사전통지로써 판매자 1인당 물품 등록 건수를 제한할 수 있습니다. 구체적인 제한시기, 내용, 방법 등은 판매회원이 알 수 있도록 “브랜디셀러관리자” 공지사항 카테고리에 등록하거나, 사전에 회원이 제공한 e-mail주소 또는 휴대폰 연락처에 SMS형태로 공지합니다. 판매회원이 회사의 물품등록건수 제한 조치를 위반한 경우 회사는 상품 등록을 삭제하거나 취소할 수 있고, 등급점수 차감, 이용중지 등 필요한 조치를 취할 수 있습니다.
판매회원은 상품등록 후 1년간 구매이력이 없는 상품(이하 “휴면리스팅”)을 유지할 수 없고, 회사는 이러한 휴면리스팅에 대해서는 품절 처리, 상품 미진열, 미판매 등 적절한 조치를 취할 수 있습니다.
판매회원은 재고 수량 등 수시로 변동되는 사항에 대한 데이터를 적절히 관리하여야 하며, “브랜디셀러관리자”에 데이터를 허위로 기재할 수 없습니다.
판매회원이 “브랜디셀러관리자”를 통하지 않고 제3의 외부업체의 프로그램을 이용하여 상품을 등록하는 경우 그 과정에서 유발되는 각종 기술적, 법적 문제에 대해 회사는 아무런 책임을 지지 아니하며 이로 인해 발생되는 모든 손해에 대해 판매회원이 전적으로 부담합니다.
판매회원은 전자상거래등에서의 소비자보호에 관한 법률(이하 "전소법"이라 함) 등 “몰”과 “브랜디 앱”에서의 상품 및 용역의 판매와 관련하여 법령이 요구하는 사항을 준수하여야 합니다.
판매회원은 회사의 서면에 의한 사전 승인 없이 “회사”의 상호나 로고 등을 사용할 수 없습니다.
판매회원은 본 약관 제27조(금지행위)를 준수해야 하며, 이를 위반한 경우 회원자격이 정지될 수 있습니다.
판매회원은 판매된 상품 및 용역에 대한 보증 서비스를 자신의 책임과 비용으로 실시하여야 합니다.
판매회원은 자신의 판매회원 정보란에 회사가 정하는 절차에 따라 인증받은 유선전화 또는 휴대폰 번호를 대표번호로서 설정하고 항상 최신 정보로서 유지하여야 합니다. 판매회원이 본항의 의무를 이행하지 않을 경우 회사는 이행 완료시까지 해당 판매회원이 이용가능한 서비스를 제한할 수 있습니다.
추가 아이디는 한 판매회원이 다수 분야의 상품을 취급할 경우 각각의 분야에 일관성 있고 전문성 있게 상품이 노출될 수 있도록 한 판매회원에게 다수의 아이디를 발급해주는 제도입니다. 추가 아이디를 사용하여 최초 가입 아이디와 동일한 대분류 카테고리 내에 상품등록을 하는 경우, 회사는 판매회원에게 판매회원 아이디 중지, 상품판매 제한, 상품 또는/및 옵션등록 가능개수 제한 등의 페널티를 부과할 수 있습니다. 추가 아이디 사용 중 최초가입 아이디가 각종 제재를 받는 경우 추가 아이디에 동일한 제재조치가 가해질 수 있으며, 추가 아이디에 각종 제재가 가해지면 최초가입 아이디에도 동일한 제재조치가 가해질 수 있습니다.
판매회원은 회사에서 자유롭게 정하는 내부의 기준에 따라, 그에 반하는 리뷰에 대하여 삭제요청을 할 수 있으며, 회사는 정당한 요구에 대해 응할 의무를 가집니다.


제 14 조 (서비스이용료)


1. 서비스이용료는 회원이 “몰”과 “브랜디 앱” 전자상거래 플랫폼 제공 서비스 및 각종 부가서비스를 이용함에 따른 대가로 판매회원이 회사에 지불하여야 하는 금액을 의미하며, 회사는 서비스제공 비용, 시장상황, 판매의 거래업종, 취급품목, 거래방식 등을 고려하여 판매 회원에게 제공하는 서비스에 대한 이용료를 정합니다. 서비스 이용료는 판매수수료와 서버이용료 및 부가서비스이용료를 각각 산정하여 합산합니다.

2. 판매수수료는 결제금액 및 부가지원 금액의 합계에서 회사가 정하는 일정한 비율의 금액으로 책정되며, 회사의 정책에 따라 일시적으로 수수료율이 낮아질 수 있습니다.

3. 판매수수료 및 서버이용료 부과시 이에 따른 부가가치세액은 별도로 부과됩니다.

4. 다만, 판매자의 요구에 의해, 할인쿠폰을 발행한 경우에는, 상품판매가액에서 할인쿠폰 적용액을 제외한 금액을 기준으로 판매수수료를 산정합니다.

5. 회사는 서비스 이용자에게 서버이용료를 부과하며. 서버이용료는 회사가 책정한 방법에 의해 월 2회 부과됩니다. 다만 회사의 정책에 따라 일시적으로 부과하지 않거나 금액을 하향 조정할 수 있습니다

6. 부가서비스이용료는 판매회원이 자신의 상품 노출을 용이하게 할 수 있는 다양한 판매촉진서비스를 말하며, 서비스의 방식은 회사의 방침에 따라 변경될 수 있습니다. 회사는 부가서비스의 내용, 이용방법 및 이용요금, 실시기간 등을 “브랜디셀러관리자” 의 공지사항 카테고리에 게시하거나 판매회원에게 개별적으로 고지하여, 판매회원의 해당 서비스 이용에 조력합니다

7. 회사는 서비스 이용료를 “브랜디셀러관리자” 의 공지사항 카테고리에 게시하거나 회원이 기재한 E-mail 주소 또는 주소, 휴대폰번호를 통해 판매회원에게 고지합니다. 회사는 필요한 경우 서비스이용료를 신설, 변경할 수 있습니다. 신설 또는 변경사항은 “브랜디셀러관리자”에 공지합니다.

8. 서비스이용료는 판매대금에서의 공제하는 방식으로 결제할 수 있으며, 회사와 판매회원간의 협의 또는 회사의 내부 사정에 따라 요율, 결제방법 등이 변경될 수 있습니다.

9. 회사는 거래가 종료된 날짜를 기준으로 공개된 기준에 따라 1항의 서비스 이용료에 대한 정산 및 세금계산서를 발행 합니다. 다만, 회사의 정책 및 결제수단에 따라 정산시기가 변경될 수 있습니다.



제2절 배송
제 15 조 (상품의 배송)


1. 구매자의 주문에 따른 결제가 완료되면, 회사는 판매회원이 주문 정보를 확인할 수 있도록 조치를 취하고, 판매회원은 당해 주문 정보에 따라 배송을 하여야 합니다.

2. 판매회원은 주문내역을 확인하고 배송 중 상품이 파손되지 않도록 적절한 포장을 한 후 배송의 증명 또는 추적이 가능한 물류대행(택배)업체에 배송을 위탁하여야 합니다.

3. 전자상거래등에서의 소비자보호에 관한 법률 제15조 1항에 의거하여 판매회원은 구매자의 결제일로부터 3 영업일 이내에 상품의 발송을 완료하여야 하고, “브랜디셀러관리자”에 송장번호 등의 발송 관련 데이터를 입력하여 발송이 완료되었음을 증명하여야 합니다.

4. 판매회원이 전항의 기한 내에 발송하지 않은 경우 상품 판매 제한 또는 옵션 판매 제한, 물품 및 옵션 등록 가능개수 제한 등의 페널티를 받을 수 있습니다. 또한, 구매자의 귀책사유로 인하지 않은 배송지 오류 등으로 인하여 구매자가 상품을 정상적으로 수령하지 못한 경우 판매회원은 그에 관한 모든 책임을 부담하여야 합니다. 단, 상품의 판매시점에서 소비자가 3 영업일 이내에 상품을 발송할 수 없다는 내용을 인지할 수 있도록 상품설명에 고지하고, 구매일로부터 3 영업일이 초과하였을 때, 개별 소비자에게 SNS 형태로 배송과정에 대한 안내를 공지한 경우에 한하여, 판매자에게 페널티를 부과하지 않습니다.

5. 판매회원은 발송 후 3일 이내에 구매자가 주문한 상품을 수령할 수 있도록 조치해야 합니다.

6. 회사는 제3자와 업무제휴를 통해 통합택배, 해외배송 서비스 등을 실시할 수 있습니다.



제 16 조 (판매회원의 배송 의무)


1. 주문을 확인한 판매회원은 “브랜디셀러관리자”를 통하여 발송과 관련된 데이터를 입력하여야 합니다.

2. 판매회원은 상품을 발송하기 전에 주문확인을 통하여 반드시 주문이 취소되었는지 최종 확인하여야 하며 상품발송 후 주문확인 미입력 건에 대해서 구매자가 “회사”로 취소요청을 하는 경우 판매회원에게 통보 없이 주문이 취소되어 구매자에게 환불될 수 있으며 상품회수에 소요되는 비용은 판매회원의 부담이 됩니다.

3. 상품을 발송하지 않아 거래가 취소되는 경우 회사는 판매회원에게 판매거부로 인한 불이익을 줄 수 있습니다.



제 17 조 (판매회원의 배송정보 입력 의무 및 분쟁 처리 의무)


1. 판매회원은 상품을 물류대행업체에 배송 위탁한 후, 즉시 “브랜디셀러관리자”에 상품 발송과 관 데련된이터를 입력하여 발송이 완료되었음을 증명하여야 합니다. 판매회원은 실제 배송대행업체에 배송 위탁한 상품에 한해 “브랜디셀러관리자”에 발송과 관련된 데이터를 입력하여야 하며, 실제 배송위탁이 이루어지지 않은 상품의 배송정보를 입력한 경우 회사는 허위배송정보를 입력한 것으로 간주합니다.

2. 회사는 정산금 지급의 목적 등으로 경우에 따라 판매회원에게 배송완료의 증빙을 요청할 수 있으며, 판매회원은 회사의 요청이 있은 날로부터 7일 이내에 해당 자료를 제출하여야 합니다.

3. 판매회원이 전항의 증빙을 제출하지 않거나, 허위 배송정보를 입력함으로써 발생하는 회사의 손해 및 제반 문제에 대한 일체의 책임은 판매회원에게 있으며, 회사는 판매회원에게 정산대금 지급 보류, 등급점수 차감 등으로 불이익을 줄 수 있습니다.

4. 상품 배송 시 판매회원은 배송 방식을 자체배송으로 선택하여 발송할 수 있으나 배송의 증명 또는 배송의 추적이 되지 않아 클레임이 발생할 경우, 상품배송에 대한 증빙을 제시하여야 합니다.

5. 판매회원은 상품별 배송비 수취 여부를 설정할 수 있으며, 구매자의 결제 방법 선택에 따라 결제 여부를 확인하여 배송절차를 완료할 의무를 부담합니다.

6. 판매회원이 배송정보를 정확하게 입력하였음에도 불구하고 구매자로부터 상품의 배송과정에서 하자가 발생한 것으로 분쟁이 제기되는 경우 판매회원은 자신의 책임 하에 하자발생의 원인을 규명하고 분쟁을 해결하여야 합니다.



제3절 취소 및 반품 등
제 18 조 (취소 및 반품)


1. 판매회원은 구매자가 주문한 상품을 공급하기 곤란하다는 것을 알았을 때, 즉시 “브랜디셀러관리자”에 이를 반영하고 해당 사실을 구매자에게 유선으로 통보한 다음 구매자의 동의를 얻은 후 취소를 하여야 합니다.  회사가 구매자의 상품 대금 결제일로부터 3일 이내에 상품대금 환불 및 환불에 필요한 조치를 취할 수 있도록 하여야 합니다.

2. 주문확인 후의 취소 요청 건에 대하여 다음과 같은 주문취소 및 환불처리 규정을 적용합니다. 단, 배송중인 경우에는 취소가 아닌 반품절차에 의합니다.

① 무통장입금 : 운영자 확인 후 ‘취소접수‘가 완료되며, 개별적으로 환불이 진행됩니다.도서

② 카드취소 : 취소 신청 즉시 자동적으로 취소처리가 됩니다. 하지만, PG사의 정산기준일을 초과하여, 결제 취소가 불가능한 경우는 ‘회사’에 문의하여 취소처리가 가능합니다.

3. 판매회원은 반품상품 수령일로부터 3영업일 이내에 환불 또는 환불에 필요한 조치를 취하여야 합니다.

4. 판매회원이 구매자의 반품을 수령한 날의 익영업일까지 아무런 조치를 취하지 않은 주문 건은 자동 환불될 수 있습니다.

5. 판매회원은 상품하자나 오배송 등을 인정한 상태에서 구매자에게 반품 또는 교환 배송비를 부담시켜서는 안되며 반품 배송비를 선결제한 구매자가 반품상품 발송 시 추가 부담한 착불 배송료는 구매자의 요청에 따라 반환하여야 합니다.

6. 구매자는 판매회원의 상품 발송 시로부터 브랜디셀러관리자 상 배송완료일 후 7일 이내까지 관계법령에 의거하여 반품 또는 교환요청을 할 수 있으며 판매회원은 구매자가 이 기간 내 반품이나 교환을 요청하는 경우 구매자의 요청에 따라 반품 또는 교환을 해 주어야 합니다. 단, 구매자의 귀책사유로 상품이 훼손된 경우, 사용이나 일부 소비로 인해 상품의 가치가 현저히 감소한 경우, 시간의 경과에 의하여 재판매가 곤란할 정도로 상품의 가치가 현저히 감소한 경우, 복제 가능한 상품의 포장을 훼손한 경우(내용확인을 위한 포장훼손은 제외), 주문에 따라 개별적으로 생산되는 물품 등 판매회원에게 회복할 수 없는 중대한 피해가 예상되는 경우로서 사전에 해당 거래에 대하여 별도로 그 사실을 고지하고 구매자의 서면(전자문서를 포함)에 의한 동의를 받은 경우 기타 법령에 의하여 반품이 제한되어 있는 경우는 예외로 합니다. 또한 상품이 표시 또는 광고 내용과 다를 경우에는 상품수령 후 90일 이내 및 그 사실을 알게 된 날 또는 알 수 있었던 날로부터 30일 이내에 구매자가 반품 또는 교환을 요청하는 경우, 판매회원은 반품 또는 교환을 해 주어야 합니다.

7. 판매회원은 게시판이나 “브랜디 앱”, 전화 등을 통한 반품신청을 수시로 확인하여 조치를 취하여야 합니다. 또한, 게시판 또는 “브랜디셀러관리자”를 통한 반품신청을 확인하지 못한 것은 판매회원의 과실로 인정하고 구매자와 사전협의를 하지 않은 것을 사유로 반품을 거부하여서는 아니 됩니다.

8. 판매회원이 구매자의 청약철회를 제한하고자 하는 경우, 상품페이지 등 구매자가 쉽게 알 수 있는 곳에 반품제한 사유를 게재하여야 하나 부당한 근거로 반품을 거부하는 경우에는 전자상거래 등에서의 소비자보호에 관한 법률에 규정된 반품규정이 판매회원이 지정한 반품조건보다 우선합니다.

9. 구매자가 자체 배송한 상품에 대하여 반품을 원할 경우, 판매회원은 구매자에게 반품절차를 정확히 안내한 후 반품을 진행하여야 합니다.

10. 판매회원이 상품의 취소, 반품, 환불과 관련한 이용정책을 위반하거나 이로 인한 클레임이 발생하였을 경우, 회사는 판매회원의 서비스 이용제한, 페널티 부여, 자격 정지 등의 조치를 취할 수 있습니다.

11. 판매회원은 주문 건에 대한 취소 및 반품 처리시 정확한 귀책 사유를 입력하여야 하며, 이와 관련된 클레임 발생 시 판매회원에게 페널티가 부과될 수 있습니다.

12. 판매회원의 귀책사유로 다수의 취소 및 반품이 발생하는 경우 또는 동일 중분류 카테고리 내 타상품보다 취소, 반품비율이 현저히 높은 경우 회사는 판매회원의 물품판매의 제한, 물품 및 옵션 등록 가능개수 제한 등의 페널티를 부과할 수 있습니다.

13. 청약철회를 진행해야 할 주문 건의 상태가 12조 5항의 구매확정 상태인 경우 대금의 환급은 판매회원이 진행합니다.



제 19 조 (교환 및 환불)


1. 구매자가 상품 수령 후 교환이나 환불을 요청하는 경우 판매회원은 전자상거래등에서의 소비자보호에 관한 법률 등 관련 법률에 의거하여 반품을 받은 후 교환이나 환불을 해주어야 하며, 추가로 발생하는 비용은 교환이나 환불의 책임이 있는 측에서 부담합니다.

2. 판매회원은 상품의 하자 또는 사용상의 안전성에 결함이 있는 경우 전량 리콜(수리, 교환, 환불)하여야 하며, 리콜에 따른 모든 비용을 부담하여야 합니다.

3. 판매회원은 청약철회가 불가능한 상품의 경우 해당 내용을 상품 상세페이지에 명시하고, 배송 시에도 포장 또는 기타 소비자가 쉽게 알 수 있는 곳에 명기하여야 합니다.



제4절 정산
제 20 조 (판매대금의 정산과 환불)


1. 판매회원이 “몰”과 “브랜디 앱”을 통하여 판매한 상품 및 용역의 판매대금(이하 "판매대금"이라 함)에 대한 정산은 상품 판매 가격에서 제14조의 서비스이용료와 이에 따른 부가가치세액을 제외한 금액을 기준으로 산정됩니다.

2. 판매대금은 구매확정된 주문건을 대상으로 계약서 또는 운영 정책의 정산 기준에 준하여 지급합니다. 다만, 회사는 정산대금을 지급하기 이전에 구매자가 취소, 반품, 교환 또는 환불의 의사를 표시하거나 이 약관 제21조 및 27조에 판매회원이 해당하는 경우 정산대금의 지급을 보류할 수 있습니다.

3. 회사는 판매대금에서 제14조의 서비스이용료와 상계할 수 있는 채권액을 공제한 나머지 금액을 판매회원에게 송금하며, 상품판매대금, 공제내역, 송금 금액을 “브랜디셀러관리자” 화면을 통하여 통보합니다.

4. 회사는 판매대금의 정산 이후 구매자의 정당한 환불 요청이 있는 경우 판매회원의 미정산대금에서 우선적으로 출금하여 환불하고, 미정산대금이 환불액보다 부족한 경우에는, 환불 요청 시부터 1개월 내에 판매회원에게 지급될 미정산대금에서 차감할 수 있으며, 그 미정산대금으로도 부족한 경우에는 환불하지 않을 수 있습니다.

5. 회사의 판매회원에 대한 정산 일자 등 구매안전서비스(결제대금예치)의 운영, 판매대금 정산방법에 관한 구체적인 내용은 회사가 제공하는 “브랜디셀러관리자”를 통하여 공지합니다.



제 21 조 (정산의 보류)


1. 회사는 판매회원의 귀책사유로 인해 발생한 비용을 판매대금 정산 시 정산금액에서 공제한 후 나머지 금액에 한하여 판매회원에게 지급할 수 있습니다.

2. 판매회원 또는 회사가 서비스 이용 계약을 해지한 경우, 회사는 판매회원의 마지막 3개월 동안 월평균 판매액의 30%에 해당하는 금액을 계약 해지일로부터 3개월 동안 예치하여 구매자로부터의 클레임에 대한 환불, 교환 등 추가비용지급에 사용하고, 이러한 염려가 없어진 후 나머지 금액 전액을 지급 할 수 있습니다.

3. 회사는 장기간 배송지연 건을 배송완료 건으로 간주하여 주문 절차를 종결할 수 있되, 판매대금의 정산은 향후 구매자의 환불 요청에 대비하여 일정기간 유보할 수 있습니다

4. 판매회원의 채권자의 신청에 의한 판매대금의 가압류, 압류 및 추심명령 등 법원의 결정이 있을 경우, 회사는 판매회원과 채권자 간의 합의 또는 채무액의 변제 등으로 동 결정이 해제될 때까지 판매대금의 정산을 중지하거나 제3채무자로서 판매회원의 정당한 채무를 변제할 수 있습니다.

5. 회사는 아래의 사유가 발생하는 경우 상품판매대금의 정산을 유보할 수 있습니다.

①  구매자가 신용카드로 결제한 경우, [여신전문금융업법 시행령 제6조의9 제1항]상의 규정에 따라 회사는 신용카드 부정사용을 통한 허위거래여부를 판단하기 위해 최고 60일까지 판매대금에 대한 송금을 보류할 수 있습니다. 이 경우, 회사는 거래사실 확인을 위한 증빙을 판매회원에 요구할 수 있으며, 회사는 사실 여부 확인 후 상품판매대금을 지급할 수 있습니다.

②  법원 등 제3자가 자격을 갖추어 상품판매대금의 지급보류를 요청한 경우 회사는 보류요청이 해제될 때까지 관련 상품판매대금의 송금을 보류하거나 정당한 채권자에게 지급할 수 있습니다.

③  회사는 판매회원이 매매 부적합 상품의 판매회원으로 적발되거나, 구매자 클레임의 다수 발생으로 인한 환불, 교환 등의 요청이 염려되는 경우 3개월간 정산을 보류할 수 있습니다.

④  판매회원과 구매자 간에 동일한 유형의 클레임이 지속적으로 발생하는 경우, 구매자로부터의 클레임에 대비하여 일정기간 판매대금의 정산을 유보할 수 있습니다.

6. 판매회원은 폐업신고 이후에는 원칙적으로 판매가 금지되며, 회사는 판매회원의 폐업 이후에 판매된 상품의 판매대금에 관해서는 정산을 하지 않는 것을 원칙으로 합니다.

7.  본 조에 정한 외에도 법률의 규정에 의하거나 합리적인 사유가 있는 경우에는 회사는 판매회원에게 통지하고 판매대금의 전부 또는 일부에 대한 정산을 일정 기간 유보할 수 있습니다.



제 22 조 (납세관리에 관한 정책의 수립)


회사는 부가가치세법 제33조 2항의 규정에 근거하여 "납세관리에 관한 정책"을 수립하여 운영할 수 있습니다.





제4장 이용자 관리 및 보호


제 23 조 (회원 관리)


1. 회사는 본 약관의 본지와 관련 법령 및 상거래의 일반원칙을 위반한 회원과 본 약관의 의무사항을 위반한 판매자에 대하여 다음과 같은 조치를 할 수 있습니다.

① 정산일자 변경

② 회사가 부가적으로 제공한 혜택의 일부 또는 전부의 회수

③ 특정서비스 이용제한

④ 이용계약의 해지

⑤ 손해배상의 청구

⑥ 휴점 및 퇴점처리

2. 회사가 전항 각 호에 정한 조치를 할 경우 회사는 사전에 회원에게 유선 또는 이메일, 기타의 방법을 통하여 통보하며, 회원의 연락이 두절되거나 긴급을 요하는 것과 같이 부득이한 경우 선 조치 후 사후 통보할 수 있습니다.

3. 회원은 본조에 의한 회사의 조치에 대하여 항변의 사유가 있는 경우 이에 대하여 항변을 할 수 있습니다.



제 24 조 (등급점수 및 페널티 부여)


1. 회사는 서비스를 통한 거래의 안전성과 신뢰성을 제고하기 위하여 판매회원에 대한 평가를 진행하고 등급점수(상벌점)을 부여하며, 이를 기준으로 판매회원에게 일정한 혜택 또는 제한을 적용할 수 있습니다.

①  회사는 상품이미지, 배송, 반품, 민원 처리 지연 등에 기초하여 판매회원의 거래를 평가하여 등급점수 및 페널티를 부여합니다.

②  판매회원이 신규 회원자격을 얻은 후 운영정책에 따른 페널티 2회 이상 누적 부여받았을 경우, 회사는 판매회원에게 서비스 이용제한, 회원자격 정지 등의 조치를 취할 수 있습니다.

2. 판매회원에 대한 등급점수 및 페널티 부여, 서비스 이용 제한, 회원자격 정지 등의 기준은 운영정책에 따르며, 회사는 판매회원이 운영정책의 내용을 확인할 수 있도록 “브랜디셀러관리자” 공지사항 또는 기타의 방법으로 안내합니다.

3. 회사는 판매회원이 본 약관, 회사의 운영정책 및 관련법령을 위반하거나, 타인의 권리를 침해하는 행위 또는 그러한 위법•부당한 행위가 있는 것으로 의심될 만한 상당한 이유가 있는 경우 판매회원의 회원자격을 정지하거나 서비스의 이용을 제한할 수 있습니다.



제 25 조 (매매부적합상품)


1. 회사는 매매부적합상품은 판매를 금하며, 매매부적합상품을 판매함에 따른 모든 책임은 당해 매매부적합상품을 등록한 판매회원이 부담합니다. 매매부적합상품은 매매불가상품과 매매제한상품으로 구분됩니다.

① 매매불가상품

지적재산권 등 권리침해상품, 미등록 영상매체물 등 관련법령상 판매 또는 유통이 불가한 상품을 말합니다.

② 매매제한상품

상품의 판매방식, 판매장소 또는 판매 대상자 등에 대한 법적 제한이 있는 상품, 소비자에게 피해가 발생할 염려가 있는 상품, 기타 사회통념상 매매에 부적합하거나 회사의 정책에 의하여 매매가 제한되는 상품을 말합니다.

③ 회사는 매매부적합상품에 해당되는 상품의 구체적인 종류와 내용을 임의로 추가, 변경할 수 있습니다.

④ 상품등록 시 사용된 사진이 도매처 및 중국 등 기타 거래처 등에서 제공된 이미지(이하 도매처 이미지)인 경우 도매처 이미지 소유권자의 사용 허가 유무와 상관없이 매매부적합상품으로 간주되어 제재처리가 진행될 수 있습니다. 이때 제재처리는 운영정책에 명시된 기준에 따라 진행됩니다.

2. 회사는 매매부적합상품이 발견된 경우 사전 통보 없이 당해 상품의 광고를 삭제하거나 그 판매를 중지시킬 수 있으며, 당해 상품이 기 판매된 경우 그 거래를 취소할 수 있습니다.

3. 회사는 매매부적합상품을 등록한 판매회원에게 페널티 부여, 서비스 이용제한, 이용정지 등의 조치를 취할 수 있으며, 매매부적합상품으로 인하여 입은 손해를 해당 판매회원에게 청구할 수 있습니다.

4. 회사는 판매회원이 등록된 상품이 구매자 또는 제3자에게 위해 또는 손해를 발생시키거나 발생시킬 우려가 있다고 인정되는 경우, 해당 상품 삭제 또는 중지, 페널티 부여, 서비스 이용제한, 이용 정지 등의 조치를 취할 수 있습니다.



제 26 조 (취득한 구매자 정보의 보호)


1. 판매회원은 판매서비스의 이용에 따라 취득한 구매자 등 타인의 개인정보를 이 약관에서 정한 목적 이외의 용도로 사용할 수 없으며, 이를 위반할 경우 당해 판매회원은 관련 법령에 의한 모든 민ㆍ형사상의 법적 책임을 지고 자신의 노력과 비용으로 회사를 면책시켜야만 하며, 회사는 당해 판매회원을 탈퇴시킬 수 있습니다.

2. 회사는 개인정보 보호를 위하여 배송 등의 목적으로 판매회원에게 공개되어 있는 구매자의 개인정보를 상당 기간이 경과한 후 비공개 조치할 수 있습니다.

3. 회사가 개인정보의 보호를 위하여 상당한 주의를 기울였음에도 불구하고, 특정 판매회원이 제1항을 위반하여 타인의 개인정보를 유출 또는 유용한 경우 회사는 그에 대하여 아무런 책임을 지지 않습니다.

4. 전기통신사업법 등 관련 법령이 규정하는 적법한 절차에 따라 수사관서 등이 회사에 판매회원에 관한 정보의 제공을 요청한 경우, 회사는 그에 관한 자료를 제출할 수 있습니다.

5. 판매회원이 구매회원의 개인정보를 취급할 때에는 개인정보의 분실·도난·누출·변조 또는 훼손을 방지하기 위하여 관련법령에서 정한 기술적·관리적 조치를 다하여야 합니다. 회원은 이용자의 개인정보를 취급하는 자를 최소한으로 제한하여야 합니다. 회원은 목적을 다한 개인정보에 대하여 지체 없이 해당 개인정보를 복구·재생할 수 없도록 파기하여야 합니다.



제 27 조 (금지행위)


1. 판매회원은 다음 각 호에 해당하는 행위를 하여서는 아니되며 이를 위반한 경우 회사는 판매회원에게 페널티 부여, 서비스 이용 제한, 이용계약 해지 등의 조치를 취할 수 있습니다.  이에 대한 기준은 운영정책에서 정합니다.

①  회사는 판매회원의 금지 행위에 대해 부가적인 확인 요청을 요구할 수 있으며, 판매회원은 이에 협조할 의무가 있습니다. 회사는 금지 행위 위반으로 인해 발생하는 모든 피해에 대하여 책임지지 않습니다.

②  다음 각 호에 해당하는 행위 적발 시 24조에 의거, 서비스 이용제한, 이용계약 해지 등의 조치를 취할 수 있습니다.

2. 상품등록 관련 금지행위

①  상품 중복 등록: 판매 회원이 본인의 아이디, 추가 아이디 또는 다른 회원의 아이디를 이용하여 실질적으로 동일한 상품(“이하 동일 상품”)을 중복하여 등록하는 것

②  카테고리 위반 등록: 해당 상품과 관계없는 카테고리에 상품 등록 등 기타 비정상적인 방법으로 상품을 노출하는 행위

③  부정키워드 사용: 상품 등록 시 상품리스트 노출을 목적으로 해당 상품과 무관한 검색 키워드를 기재, 타 판매회원의 셀러명, 유사 셀러명을 기재하는 경우

④  제조사, 브랜드, 원산지 위반 등록: 상품등록 시 제조사, 원산지, 브랜드를 허위로 기재하거나 표시하지 않는 행위

⑤  상표권 침해: 상품 등록 시 상품과 상관없는 상표명을 사용하거나 중복해서 사용하는 행위

⑥  저작권 침해: 허가 없이 타인의 상표나 로고를 사용하는 행위 등 타인의 지적재산권을 침해행위 또는 타인이 촬영한 사진, 타인이 창작한 이미지나 문구 등 인간의 사상 또는 감정을 표현한 모든 창작물을 무단으로 사용하는 행위

⑦  초상권 및 성명권 침해: 연예인 사진 등 타인의 초상권 및 성명권을 침해하는 행위 또는 ‘연예인 이름+스타일’과 같은 문구를 제목, 키워드, 상품상세설명에 무단으로 사용하는 행위

⑧  청소년 유해 매체물 및 성인대상 판매상품 판매 시 카테고리 미준수 행위: 판매상품이 청소년 유해매체물이거나 성인을 대상으로 판매하여야 하는 상품인 경우 성인용품 카테고리에 등록하지 않거나 일반 카테고리에 등록 시 지정된 카테고리에 이용등급을 설정하지 않고 등록하는 행위



3. 판매관련 금지행위

①  허위체결: 판매회원이 상품 노출순위 및 판매회원 신용등급 조작, 상품평 조작 등 매출증대를 위해 본인 또는 타인의 ID를 사용하여 판매회원 본인의 상품을 구매하는 체결 행위

②  특정 서비스 가입조건 판매: 등록상품, 서비스의 판매 및 광고 이외의 목적으로 상품을 등록하여 판매하는 행위 예) 인터넷 서비스 가입을 조건으로 하여 일정 금액을 부담하면 지급되는 사은품을 등록하여 판매하는 행위

③  직거래 및 직거래 유도: 회사의 결제대금 보호 서비스를 통하지 않은 직거래 유도행위 및 구매회원의 직거래 요청을 수락하는 행위

④  무재고 재판매 행위: 스스로 재고를 보유하지 않은 판매회원이 다른 오픈마켓이나 인터넷쇼핑몰 등에 임의로 최저가를 등록하는 등으로 유도한 후 구매자가 해당 쿠폰을 적용한 조건으로 구매를 신청하는 경우 재고를 보유한 다른 판매자에게 재주문하여 구매자의 배송지로 배송하는 행위

⑤  허위 정보 입력: 허위로 발송 사실을 입력하거나 발송하지 않은 상품에 대한 운송장 번호를 미리 입력하는 행위 또는 허위 고객센터를 입력하는 행위

⑥  부당 반품 거부: 18조 7, 8항에 의거, 판매회원이 부당한 근거로 구매회원의 반품을 거부하는 행위

⑦  CS 불만족(분쟁) 미처리: 판매회원이 CS를 해결하기 위한 행동을 취하지 않거나 방치하는 행위

⑧  연락두절: 구매자 및 회사가 판매 회원이 제공한 유선 또는 이메일, 기타의 방법을 통하여 연락을 시도하였음에도 일체의 응대가 진행되지 않는 것

⑨ 판매회원은 휴업, 영업정지, 폐업 등 정상적인 영업활동이 불가한 상태 또는 이와 같은 상태가 예상되는 경우 이를 즉시 회사에 통보하여야 하며 전자상거래 등에서의 소비자보호에 관한 법률 등 관련법에 따른 취소, 반품, 교환 등의 신속한 처리를 위하여 최선의 노력을 다하여야 합니다.

⑩  기타 법령 준수 의무 위반한 상품의 판매 행위:  전기용품, 의료기기, 식품, 화장품 등 개별 법령에 의하여 판매에 일정한 자격이 필요한 경우나 상품 자체에 유통을 위한 검증이 필요한 경우에는 관련 법령이 요구하는 조건을 갖추지 아니한 상품의 판매 또는 관련 법령이 요구하는 조건을 갖추지 아니한 상품의 판매 행위


4. 그외 금지 행위

①  판매회원 광고 등록 부정행위: 회사가 정한 광고 등록기준을 준수하지 않거나 회사가 정하지 않은 부정한 방식의 입찰을 통하여 등록하거나 허위로 입찰하는 행위

②  특정 셀러명 사용: 셀러명 등록시 회사는 “브랜디”와 혼동, 오인의 여지가 있는 모든 명칭 및 문구를 사용하는 경우 예) 브랜디, Brandi, 브랜디몰, brandi-mall, 브랜디샵, brandi shop 등 (영문의 경우에는 대소문자를 포함/ 이 외 브랜디와 혼동, 오인의 여지가 있는 모든 명칭 및 문구)

③  타 쇼핑몰 홍보행위: 판매회원이 독립적으로 운영하는 쇼핑몰 또는 개인의 블로그 마켓의 주소를 소개말에 홍보하는 경우

④  기타 위법 · 부당행위: “브랜디 앱”이나 “몰” 관련 정보나 소프트웨어를 상업화하는 경우



제 28 조 (품질보증 및 애프터서비스)


1. “몰”과 “FitMe 앱”에서 판매된 상품의 품질보증에 따른 사후관리(이하 “A/S”)에 관해서는 관련 법규에 따라 제조자와 판매회원이 연대책임을 집니다.

2. 판매회원이 정한 품질보증기간이 소비자분쟁해결기준보다 짧을 경우, 소비자분쟁해결기준이 우선 적용됩니다.

3. 제조자 측에서 A/S 를 할 수 없는 경우(병행수입품, 제조사가 국내에 있지 않은 경우, 제조사 측에서 A/S처리가 불가능한 경우 등)에는 판매회원의 책임 하에 수리, 교환, 환불 등의 조치가 이루어져야 합니다. 이와 같은 사항에 대한 판매회원의 처리 거부로 구매자가 브랜디에 A/S 를 요구할 경우, “회사”는 판매회원에게 품질보증에 관한 사항의 이행을 강제할 수 있습니다.



제5장 기타


제 29 조 (약관 외 준칙 및 관련 법령과의 관계)


1.  이 약관에 명시되지 않은 사항은 전자상거래등에서의소비자보호에관한법률 등 관련 법령의 규정과 일반 상관례에 의합니다.

2.  회사는 이 약관에서 규정되지 않은 구체적인 내용과 특정서비스에 관한 내용을 별도의 약관(이하 "개별약관"이라 함)에 규정할 수 있으며, 이를 “브랜디셀러관리자”의 “공지사항” 카테고리를 통하여 공지하거나 회원이 제공한 e-mail주소 또는 회원이 제공한 휴대폰 연락처에 SMS형태로 정상 수신이 되었을 때, 공지사항 카테고리에 변경사항에 대한 내용이 등록되었을 때 개정 사항이 통지된 것으로 보며 판매회원이 이에 동의한 경우 개별약관은 이 약관과 더불어 이용계약의 일부를 구성합니다.

3.  회사는 전항의 개별약관에 변경이 있을 경우, 적용일자 및 변경사유를 명시하여 현행 개별약관 등과 함께 그 적용일자 7일(다만, 판매회원에게 불리한 내용으로 변경하는 경우에는 30일) 이전부터 적용일자 전일까지 위 2항과 같은 방법으로 해당 변경사항을 공지합니다. 변경된 개별약관은 그 적용일자 이전으로 소급하여 적용되지 아니 합니다.

4.  회원은 이 약관 및 개별약관(이하 “약관등”)의 내용에 변경이 있는지 여부를 주시하여야 하며, 변경사항의 공지가 있을 시에는 이를 확인하여야 한다.

5.  회사는 특정 판매회원과 개별적으로 약관등에 규정된 내용과 다른 내용의 계약(이하 “개별계약”이라 함)을 체결할 수 있습니다. 이 경우 개별계약이 약관등에 우선하여 적용됩니다. 회사는 개별계약을 체결한 판매회원에게 계약내용을 서면(전자문서 포함)교부하거나 판매회원 화면에서 확인할 수 있도록 하여야 합니다.



제 30 조 (손해배상)


1. 당사자 일방 또는 당사자 일방의 피고용인, 대리인, 기타 도급 및 위임 등으로 당사자 일방을 대신하여 이용계약을 이행하는 자의 책임 있는 사유로 이용계약의 이행과 관련하여 상대방에 손해가 발생한 경우, 그 당사자 일방은 상대방에게 발생한 손해를 배상할 책임이 있습니다.

2. 판매회원이 이용계약을 위반함으로써 “회사”의 대외 이미지 실추 등 회사에 유, 무형적 손해가 발생한 경우, 판매회원은 회사의 손해를 배상하여야 합니다.



제 31 조 (비밀유지)


1. 각 당사자는 법령상 요구되는 경우를 제외하고는 상대방으로부터 취득한 구매자명부, 기술정보, 생산 및 판매계획, 노하우 등 비밀로 관리되는 정보를 제3자에게 누설하여서는 안되며, 그 정보를 이용계약의 이행 이외의 목적으로 이용하여서는 아니 됩니다.

2. 전항의 의무는 이용계약의 종료 후에도 3년간 존속합니다.



제 32 조 (회사의 면책)


회사는 통신판매중개자로서 “몰” 및 “브랜디 앱” 기반으로 한 거래시스템만을 제공할 뿐, 판매회원이 등록한 상품 및 용역 등에 관한 정보 또는 구매자와의 거래에 관하여 분쟁이 발생한 경우 회사는 그 분쟁에 개입하지 않으며 그 분쟁의 결과로 인한 모든 책임은 판매회원이 부담합니다. 또한 이와 관련하여 회사가 제3자에게 손해를 배상하거나 기타 비용을 지출한 경우 회사는 판매회원에게 구상권을 행사할 수 있습니다. 단, 회사는 분쟁의 합리적이고 원활한 조정을 위하여 회사가 설치 운영하는 분쟁조정센터(고객센터 포함)를 통하여 예외적으로 당해 분쟁에 개입할 수 있으며, 판매회원은 분쟁조정센터의 결정을 신의칙에 입각하여 최대한 존중해야 합니다.
회사는 적법한 권리자의 요구가 있는 경우에는 당해 상품 및 용역 등에 관한 정보를 삭제하거나 수정할 수 있으며, 판매회원은 이로 인한 손해배상을 회사에 청구할 수 없습니다.
회사는 전소법 제20조 제2항에 의거하여 판매회원의 정보를 열람할 수 있는 방법을 구매자에게 제공할 수 있으며, 판매회원은 당해 정보를 기재하지 아니하거나, 허위로 기재함으로써 발생하는 모든 책임을 부담하여야 합니다. 이와 관련하여 회사가 제3자에게 손해를 배상하거나 기타 비용을 지출한 경우 회사는 판매회원에게 구상권을 행사할 수 있습니다.
회사는 컴퓨터 등 정보통신설비의 보수, 점검, 교체 및 고장, 통신의 두절 등의 사유가 발생한 경우에는 판매서비스의 제공을 일시적으로 중단할 수 있으며, 이와 관련하여 회사는 고의 또는 중대한 과실이 없는 한 책임을 지지 않습니다.
판매회원이 자신의 개인정보를 타인에게 유출 또는 제공함으로써, 발생하는 피해에 대해서 회사는 일절 책임을 지지 않습니다.
기타 관련 법령 및 회사에서 제공한 이용약관 및 개별약관의 변경, 판매회원 공지사항 등의 주의의무를 게을리하여 발생한 판매회원의 피해에 대해서 회사는 일절 책임을 지지 않습니다.
 “브랜디 앱”에서의 거래는 실시간으로 진행되지 않을 수도 있습니다. “브랜디 앱”에서의 거래는 판매회원의 현재 소재지와 판매회원이 이용하는 무선 데이터 서비스 제공자의 네트워크 등의 이유로 제한, 지연될 수 있습니다.
회사는 브랜디셀러관리자의 공지사항을 통해 제공되는 내용에 대해서, 공지사항 내에 명시된 부분을 확인하지 않은 것으로 인해 발생한 피해에 대해서 책임지지 않습니다.
회사는 입점한 판매회원이 사회통념 상 허용이 불가한 문제를 일으킨 경우, 임의로 상품 및 스토어에 대한 적합한 제재행위를 할 수 있으며 이에 대한 책임을 지지 않습니다.
 회사는 정당한 정책절차 하에 진행된 판매회원에 대한 제재 또는 그로 발생한 손해에 대해서 손해를 보상하지 않습니다.
회사의 정책변경과 관련하여 정책 최초 고지 후 15일간 별도의 퇴점 요청 없이 서비스를 계속 이용하는 판매회원에 대해서는 해당 정책에 대한 동의를 한 것으로 간주, 정책과 관련된 책임을 지지 않습니다,


제 33 조 (관할법원)


이 약관과 회사와 회원 간의 이용계약 및 회원 상호간의 분쟁에 대해 회사를 당사자로 하는 소송이 제기될 경우에는 회사의 본사 소재지를 관할하는 법원을 합의관할법원으로 정합니다.





제 34 조 (기타조항)


1. 판매회원은 주소지 또는 대금결제를 위한 통장계좌 등의 변경이 있을 경우 즉시 회사에 이를 통지하여야 하며, 회사는 통지의 지연으로 인하여 발생한 손해에 대하여 책임을 지지 않습니다.

2. 회사는 필요한 경우 특정 서비스(혹은 그 일부)를 회사 홈페이지를 통하여 미리 공지한 후, 일시적 또는 영구적으로 수정하거나 중단할 수 있습니다.

3. 회사와 회원은 상대방의 명백한 동의 없이 본 약관상의 권리와 의무를 제3자에게 양도할 수 없습니다.

4. 이 약관과 관련하여 당사자 간의 합의에 의하여 추가로 작성된 계약서, 협정서, 통보서 등과 회사의 정책변경, 법령의 제정 개정 또는 공공기관의 고시 지침 등에 의하여 회사가 “브랜디셀러관리자”의 “공지사항”카테고리를 통해 게시하거나 회원이 제공한 e-mail주소 또는 휴대폰연락처에 SMS형태로 공지하는 내용도 본 약관의 일부를 구성합니다.



제 35 조 (카카오톡 알림톡 시행에 관한 내용)


1. 회사는 판매회원에게 주문안내, 배송안내, 휴/퇴점 완료 등 비광고성 정보를 카카오톡 알림톡으로 알려드리며, 만약 알림톡 수신이 불가능하거나 수신 차단하신 경우에는 일반 문자메시지로 보내드립니다. 카카오톡 알림톡을 통해 안내되는 정보를 와이파이가 아닌 이동통신망으로 이용할 경우, 알림톡 수신 중 데이터 요금이 발생할 수 있습니다. 카카오톡을 통해 발송되는 알림톡 수신을 원치 않으실 경우 반드시 알림톡을 차단하여 주시기 바랍니다.</textarea>



                            <fieldset class="fregister_agree">
                                <label for="agree11">판매자 이용약관을 동의합니다.</label>
                                <input type="checkbox" name="agree" value="1" id="check_1" required>
                            </fieldset>
                        </section>

                        <br>
                        <section id="fregister_private">
                            <h4>2. FitMe 입점정책</h4>
                            <textarea readonly style="width:700px; height:140px; text-align:left;">
1. 상품이미지 정책국내 도매처 이미지, 해외 도매 거래처 이미지의 사용을 제한하며 입점 취소사유가 될 수 있습니다.

2. 전 상품 이미지 FitMe에서 제공한 규격에 맞게 업로드
FitME는 현재 온라인 의류 가상 피팅과 고객의 신체정보 맞춤 상품 추천 정책을 시행하고 있습니다. FitMe에서의 판매상품은 100% FitMe가 제공한 규격에 맞는 업로드가 시행되어야 합니다 (배송비 업체 부담)

3. 전 상품 가격정찰제
브랜디에서의 판매상품은 자사몰의 최종 판매가와 가격이 동일해야 합니다. 월 1회 이상 판매가 모니터링을 실시하여 가격이 상이할 경우, 브랜디 내 상품 노출이 제한됩니다.

4. 정산 정책
브랜디는 월 2회 정산되며, 판매 수수료와는 별도로 서버 이용료 (45,000원/월 2회 분납, VAT 별도)가 부과됩니다.</textarea>

                            <fieldset class="fregister_agree">
                                <label for="agree21">판매자 본인은 위 내용을 숙지하였고 정책에 동의합니다</label>
                                <input type="checkbox" name="agree2" value="1" id="check_2" required>
                            </fieldset>
                        </section>

                        <br>


                        <br><br><br>
                        <button class="button" type="button"
                                onclick="location.href='http://49.247.136.36/main/seller/inquire.php'">
                            취소
                        </button>

                        <!--약관동의를 모두 누를 시 상단에 있는 javascript ("#nextBtn").click(function () 에 의해 seller_request_second.php로 이동-->
                        <button type="button" class="button" id="nextBtn">계속하기</button>

                    </form><!-- /form -->
                </div><!-- /card-container -->

            </div>

        </div>


    </div>
</div>
<div class="center_line"></div>
</div>

<br><br><br>


<div id="footer"></div>
</body>

<script>
    $('#header').load("../head.php");
    $('#footer').load("../foot.php");
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
