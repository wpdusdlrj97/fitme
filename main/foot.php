<!--FitMe 홈페이지 하단 부분-->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./main.css">
</head>
<body>
    <div id="foot_box">
        <div class="foot_section1">
            <div class="foot_section1_content1" onclick="foot_click(1)">개발자페이지</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(2)">관리자페이지</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(3)">고객센터</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(4)">FITME소개</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(5)">입점/제휴문의</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(6)">이용약관</div>
            <div class="foot_section1_content2">&nbsp;|&nbsp;</div>
            <div class="foot_section1_content1" onclick="foot_click(7)">개인정보 취급방침</div>
        </div>
        <div class="foot_section2">
            <div class="foot_logo">F i t M E</div>
            <div class="foot_call">고객센터 1577-7777</div>
        </div>
        <div class="foot_section3"></div>
        <div class="foot_section4">회사명 : ㈜Funidea | 대표이사 : 송익주 | 사업자등록번호 : 999-99-99999 | 통신판매업신고 : 2019-서울-99999 | 호스팅사업자 : (주)Funidea<br>
            주소 : 서울특별시 동작구 사당4동 318-12<br>
            개인정보관리책임자 : 우요한(bigman@funidea.co.kr)<br>
            FitMe는 통신판매중개자로서 통신판매 당사자가 아니며, 판매자가 등록한 상품정보 및 거래에 FitMe는 책임을 지지 않습니다.</div>
    </div>
</body>
<script>

    //인터넷창 크기가 변할 때마다 동작
    $(window).resize(function(){
        if($(window).width()<768)
        {
            $('#foot_box').css("padding-bottom","100px");
        }else{
            $('#foot_box').css("padding-bottom","0");
        }
    });

    /*
     특정 부분 클릭시 동작하는 함수 ( 특정 페이지를 새탭으로 띄워줌 )
     매개변수에 따라서 페이지가 다르다
     */
    function foot_click(number)
    {
        if(number==1)
        {
            window.open('/developer/index.php');
        }else if(number==2)
        {
            window.open('/shop/shop_main.php');
        }
    }
</script>
</html>