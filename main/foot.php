<!--FitMe 홈페이지 하단 부분-->
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald&display=swap" rel="stylesheet">
    <title>FitMe</title>
    <style>
        body{ margin:0; padding:0; font-family: 'Lato', sans-serif; }
        #foot_box{ width:100%; float:left; background-color:#383838; padding:30px 0 30px 0; }
        .foot_section{ width:1300px; background:red; margin:0 auto; }
        .foot_section1{ width:60%; float:left; }
        .foot_section2{ width:40%; float:left; color:white; }
        .foot_section1_enter{ width:100%; float:left; }
        .foot_section1_content{ float:left; font-size:13px; cursor:pointer; margin:10px; color:white; }
        .foot_section1_content:hover{ transition:all 100ms linear; color:#848484; }
        .foot_logo{ font-size:30px; font-family: 'Oswald', sans-serif; }
        .foot_call{ margin-top:5px; font-size:20px; }
        .foot_section3{ width:100%; float:left; margin-top:15px; }
        .foot_section3_content{ color:white; font-size:12px; letter-spacing: 1.15px; margin:10px; line-height:150%; }
        @media (max-width:1320px){
            .foot_section{ width:100%; }
        }
        @media (max-width:990px)
        {
            .foot_section1_content{ font-size:12px; }
            .foot_logo{ font-size:25px;}
            .foot_call{ margin-top:5px; font-size:17px; }
            .foot_section3_content{ font-size:11px; }
        }
        @media (max-width:500px)
        {
            .foot_section1_content{ font-size:11px; }
            .foot_logo{ font-size:23px;}
            .foot_call{ margin-top:5px; font-size:15px; }
            .foot_section3_content{ font-size:10px; }
        }
    </style>
</head>
<body>
    <div id="foot_box">
        <div class="foot_section">
            <div class="foot_section1">
                <div class="foot_section1_enter">
                    <div class="foot_section1_content" onclick="foot_click(1)">개발자페이지</div>
                    <div class="foot_section1_content" onclick="foot_click(2)">관리자페이지</div>
                    <div class="foot_section1_content" onclick="foot_click(3)">고객센터</div>
                    <div class="foot_section1_content" onclick="foot_click(4)">FITME소개</div>
                </div>
                <div class="foot_section1_enter">
                    <div class="foot_section1_content" onclick="foot_click(5)">입점/제휴문의</div>
                    <div class="foot_section1_content" onclick="foot_click(6)">이용약관</div>
                    <div class="foot_section1_content" onclick="foot_click(7)">개인정보 취급방침</div>
                </div>
            </div>
            <div class="foot_section2">
                <div class="foot_logo">F i t M E</div>
                <div class="foot_call">고객센터&nbsp;&nbsp;&nbsp;010-8832-4280</div>
            </div>
            <div class="foot_section3">
                <div class="foot_section3_content">
                    회사명 : ㈜Funidea | 대표이사 : 송익주 | 사업자등록번호 : 999-99-99999 | 통신판매업신고 : 2019-서울-99999 | 호스팅사업자 : (주)Funidea<br>
                    주소 : 서울특별시 동작구 사당4동 318-12<br>
                    개인정보관리책임자 : 우요한(wyh4280@gmail.com)<br>
                    FitMe는 통신판매중개자로서 통신판매 당사자가 아니며, 판매자가 등록한 상품정보 및 거래에 FitMe는 책임을 지지 않습니다.
                </div>
            </div>
    </div>
</body>
<script>
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