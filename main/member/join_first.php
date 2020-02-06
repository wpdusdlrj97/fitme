<?php
session_start();

/*
 *  페이지 이름 - 회원가입 1단계 페이지
 *
 *  페이지 흐름 - fitme_session_login.php -> join_first.php -> join_second.php
 *
 *
 *  페이지 설명 - 로그인 화면에서 회원가입 버튼을 누를 시 이동하는 페이지
 *              이용약관 동의, 개인정보 수집 동의, 광고성 홍보 수신 동의(선택)에 대한 체크
 *              체크된 사항은 get 방식으로 join_second.php로 보내진다
 */


?>


<html>

<style>
    html{ scroll-behavior: smooth; }
    body{ padding:0; margin:0; font-family: 'Noto Sans KR', sans-serif; }

    .button {
        background-color: #000000;
        border: none;
        color: white;
        width: 150px;
        height: 50px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        text-align: center;
        cursor: pointer;

    }




    #center_box{ margin:0 auto; width:100%; float:left; background-color: white }

    #registerpage_box{ margin:0 auto; width:1320px; height:1100px;  float: inside; background-color: white }

    #registerpage_box_inside{ margin:0 auto; width:990px; height:900px;  float: inside; background-color: white }

    #margin_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }

    #title_box{ margin:0 auto; width:990px; height:50px;  float: left; background-color: white }

    #check_all_box{ margin:0 auto; width:988px; height:50px;  float: left;   border-bottom: 1px solid #ddd; background-color:  white }
    #check_all_box_1{ margin:0 auto; width:50px; height:50px;  float: left;  background-color:  white }
    #check_all_box_2{ margin:0 auto; width:550px; height:50px;  float: left;   background-color:  white }
    #check_all_box_2_hidden{ display: none;}

    #check_box{ margin:0 auto; width:988px; height:250px; margin-top: 20px; float: left; border: 1px solid black; background-color:  white }
    #check_box_title{ margin:0 auto; width:988px; height:50px;  float: left;  background-color:  white }
    #check_box_content{ margin:0 auto; width:988px; height:150px;  float: left; text-align: center; background-color:  white }

    #check_box_button{ margin:0 auto; width:988px; height:50px;  float: left;  background-color:  white }
    #check_box_button_1{ margin:0 auto; width:50px; height:50px;  float: left;  background-color:  white }
    #check_box_button_2{ margin:0 auto; width:220px; height:50px;  float: left;  background-color:  white }

    #check_box_finish{ margin:0 auto; width:988px; height:50px;  float: left;  background-color: white }








    @media (max-width:1320px)
    {
        #registerpage_box{ width:100%;}

        #check_all_box_2_hidden{ display: none;}
        #check_box_content_hidden{ display: none;}
        #check_box_content_hidden{ display: none;}


    }




    @media (max-width:990px)
    {

        #registerpage_box{height:1100px;}
        #registerpage_box_inside{ width:90%;}

        #margin_box{ width:100%;}
        #title_box{ width:100%;}
        #check_all_box{ width:100%;}

        #check_all_box_2{ display: none;}
        #check_all_box_2_hidden{ display: inline;}

        #check_box{ width:100%;}
        #check_box_title{ width:100%;}
        #check_box_content{ width:100%;}

        #check_box_finish{ width:100%;}

        #check_box_button{ width:100%;}

        .button {
            width: 100px;
            height: 40px;
        }
        
    }


</style>


<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

<!-- 약관동의와 관련된 javascript로 1번,2번 체크는 필수이고 3은 체크하지 않을 시 value값 0이 join_second.php로 넘어간다 -->
<script type="text/javascript">
    $(document).ready(function () {

        $("#checkbox_agree").click(function () {
            if ($("#check_1").is(":checked") == false) {
                alert("모든 약관에 동의 하셔야 다음 단계로 진행 가능합니다.");
                return;
            } else if ($("#check_2").is(":checked") == false) {
                alert("모든 약관에 동의 하셔야 다음 단계로 진행 가능합니다.");
                return;
            } else {
                if ($("#check_3").is(":checked") == false) {
                    document.getElementById("check_3").value = 0;
                }
                $("#terms_form").submit();
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


<body>

<div id="header"></div>



<div id="center_box" >

    <div id="registerpage_box">

        <div id="registerpage_box_inside">

            <div id="margin_box">


            </div>

            <div id="title_box" style="text-align: center; margin-bottom: 20px;">

                <p style="font-size: 17px; margin-left: 5px; font-weight: bolder">Membership #1</p>

            </div>


            <form id="terms_form" method="get" action="join_second.php" name="termsForm">


                <div id="check_box">

                    <div id="check_box_title">

                        <p style="font-size: 12px; margin-left: 20px; font-weight: bold">[필수] 이용약관 동의</p>


                    </div>

                    <div id="check_box_content" >

                    <textarea id='check_box_content_text' readonly style="width:95%; height:140px; text-align:left;">제1장 총 칙

제1조(목적)
이 약관은 "쇼핑몰"(이하 "회사"라 한다)가 홈페이지에서 제공하는 모든 서비스(이하 "서비스"라 한다)의 이용조건 및 절차에 관한 사항을 규정함을 목적으로 합니다.

제2조(정의)
이 약관에서 사용하는 용어의 정의는 다음 각 호와 같습니다.
이용자 : 본 약관에 따라 회사가 제공하는 서비스를 받는 자
이용계약 : 서비스 이용과 관련하여 회사와 이용자간에 체결하는 계약
가입 : 회사가 제공하는 신청서 양식에 해당 정보를 기입하고, 본 약관에 동의하여 서비스 이용계약을 완료시키는 행위
회원 : 당 사이트에 회원가입에 필요한 개인정보를 제공하여 회원 등록을 한 자
이용자번호(ID) : 회원 식별과 회원의 서비스 이용을 위하여 이용자가 선정하고 회사가 승인하는 영문자와 숫자의 조합
패스워드(PASSWORD) : 회원의 정보 보호를 위해 이용자 자신이 설정한 영문자와 숫자, 특수문자의 조합
이용해지 : 회사 또는 회원이 서비스 이용이후 그 이용계약을 종료시키는 의사표시

제3조(약관의 효력과 변경)
회원은 변경된 약관에 동의하지 않을 경우 회원 탈퇴(해지)를 요청할 수 있으며, 변경된 약관의 효력 발생일로부터 7일 이후에도 거부의사를 표시하지 아니하고 서비스를 계속 사용할 경우 약관의 변경 사항에 동의한 것으로 간주됩니다.
이 약관의 서비스 화면에 게시하거나 공지사항 게시판 또는 기타의 방법으로 공지함으로써 효력이 발생됩니다.
회사는 필요하다고 인정되는 경우 이 약관의 내용을 변경할 수 있으며, 변경된 약관은 서비스 화면에 공지하며, 공지후 7일 이후에도 거부의사를 표시하지 아니하고 서비스를 계속 사용할 경우 약관의 변경 사항에 동의한 것으로 간주됩니다.
이용자가 변경된 약관에 동의하지 않는 경우 서비스 이용을 중단하고 본인의 회원등록을 취소할 수 있으며, 계속 사용하시는 경우에는 약관 변경에 동의한 것으로 간주되며 변경된 약관은 전항과 같은 방법으로 효력이 발생합니다.

제4조(준용규정)
이 약관에 명시되지 않은 사항은 전기통신기본법, 전기통신사업법 및 기타 관련법령의 규정에 따릅니다.



제2장 서비스 이용계약

제5조(이용계약의 성립)
이용계약은 이용자의 이용신청에 대한 회사의 승낙과 이용자의 약관 내용에 대한 동의로 성립됩니다.

제6조(이용신청)
이용신청은 서비스의 회원정보 화면에서 이용자가 회사에서 요구하는 가입신청서 양식에 개인의 신상정보를 기록하여 신청할 수 있습니다.

제7조(이용신청의 승낙)
회원이 신청서의 모든 사항을 정확히 기재하여 이용신청을 하였을 경우에 특별한 사정이 없는 한 서비스 이용신청을 승낙합니다.
다음 각 호에 해당하는 경우에는 이용 승낙을 하지 않을 수 있습니다.
본인의 실명으로 신청하지 않았을 때
타인의 명의를 사용하여 신청하였을 때
이용신청의 내용을 허위로 기재한 경우
사회의 안녕 질서 또는 미풍양속을 저해할 목적으로 신청하였을 때
기타 회사가 정한 이용신청 요건에 미비 되었을 때

제8조(계약사항의 변경)
회원은 이용신청시 기재한 사항이 변경되었을 경우에는 수정하여야 하며, 수정하지 아니하여 발생하는 문제의 책임은 회원에게 있습니다.



제3장 계약당사자의 의무

제9조(회사의 의무)
회사는 서비스 제공과 관련해서 알고 있는 회원의 신상 정보를 본인의 승낙 없이 제3자에게 누설하거나 배포하지 않습니다. 단, 전기통신기본법 등 법률의 규정에 의해 국가기관의 요구가 있는 경우, 범죄에 대한 수사상의 목적이 있거나 또는 기타 관계법령에서 정한 절차에 의한 요청이 있을 경우에는 그러하지 아니합니다.

제10조(회원의 의무)
회원은 서비스를 이용할 때 다음 각 호의 행위를 하지 않아야 합니다.
다른 회원의 ID를 부정하게 사용하는 행위
서비스에서 얻은 정보를 복제, 출판 또는 제3자에게 제공하는 행위
회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 행위
공공질서 및 미풍양속에 위반되는 내용을 유포하는 행위
범죄와 결부된다고 객관적으로 판단되는 행위
기타 관계법령에 위반되는 행위
회원은 서비스를 이용하여 영업활동을 할 수 없으며, 영업활동에 이용하여 발생한 결과에 대하여 회사는 책임을 지지 않습니다.
회원은 서비스의 이용권한, 기타 이용계약상 지위를 타인에게 양도하거나 증여할 수 없으며, 이를 담보로도 제공할 수 없습니다.



제4장 서비스 이용

제11조(회원의 의무)
회원은 필요에 따라 자신의 메일, 게시판, 등록자료 등 유지보수에 대한 관리책임을 갖습니다.
회원은 회사에서 제공하는 자료를 임의로 삭제, 변경할 수 없습니다.
회원은 회사의 홈페이지에 공공질서 및 미풍양속에 위반되는 내용물이나 제3자의 저작권 등 기타권리를 침해하는 내용물을 등록하는 행위를 하지 않아야 합니다. 만약 이와 같은 내용물을 게재하였을 때 발생하는 결과에 대한 모든 책임은 회원에게 있습니다.

제12조(게시물 관리 및 삭제)
효율적인 서비스 운영을 위하여 회원의 메모리 공간, 메시지크기, 보관일수 등을 제한할 수 있으며 등록하는 내용이 다음 각 호에 해당하는 경우에는 사전 통지없이 삭제할 수 있습니다.
다른 회원 또는 제3자를 비방하거나 중상모략으로 명예를 손상시키는 내용인 경우
공공질서 및 미풍양속에 위반되는 내용인 경우
범죄적 행위에 결부된다고 인정되는 내용인 경우
회사의 저작권, 제3자의 저작권 등 기타 권리를 침해하는 내용인 경우
회원이 회사의 홈페이지와 게시판에 음란물을 게재하거나 음란 사이트를 링크하는 경우
기타 관계법령에 위반된다고 판단되는 경우

제13조(게시물의 저작권)
게시물의 저작권은 게시자 본인에게 있으며 회원은 서비스를 이용하여 얻은 정보를 가공, 판매하는 행위 등 서비스에 게재된 자료를 상업적으로 사용할 수 없습니다.

제14조(서비스 이용시간)
서비스의 이용은 업무상 또는 기술상 특별한 지장이 없는 한 연중무휴 1일 24시간을 원칙으로 합니다. 다만 정기 점검 등의 사유 발생시는 그러하지 않습니다.

제15조(서비스 이용 책임)
서비스를 이용하여 해킹, 음란사이트 링크, 상용S/W 불법배포 등의 행위를 하여서는 아니되며, 이를 위반으로 인해 발생한 영업활동의 결과 및 손실, 관계기관에 의한 법적 조치 등에 관하여는 회사는 책임을 지지 않습니다.

제16조(서비스 제공의 중지)
다음 각 호에 해당하는 경우에는 서비스 제공을 중지할 수 있습니다.
서비스용 설비의 보수 등 공사로 인한 부득이한 경우
전기통신사업법에 규정된 기간통신사업자가 전기통신 서비스를 중지했을 경우
시스템 점검이 필요한 경우 기타 불가항력적 사유가 있는 경우



제5장 계약해지 및 이용제한

제17조(계약해지 및 이용제한)
회원이 이용계약을 해지하고자 하는 때에는 회원 본인이 인터넷을 통하여 해지신청을 하여야 하며, 회사에서는 본인 여부를 확인 후 조치합니다.
회사는 회원이 다음 각 호에 해당하는 행위를 하였을 경우 해지조치 30일전까지 그 뜻을 이용고객에게 통지하여 의견진술할 기회를 주어야 합니다.
타인의 이용자ID 및 패스워드를 도용한 경우
서비스 운영을 고의로 방해한 경우
허위로 가입 신청을 한 경우
같은 사용자가 다른 ID로 이중 등록을 한 경우
공공질서 및 미풍양속에 저해되는 내용을 유포시킨 경우
타인의 명예를 손상시키거나 불이익을 주는 행위를 한 경우
서비스의 안정적 운영을 방해할 목적으로 다량의 정보를 전송하거나 광고성 정보를 전송하는 경우
정보통신설비의 오작동이나 정보 등의 파괴를 유발시키는 컴퓨터바이러스 프로그램 등을 유포하는 경우
회사 또는 다른 회원이나 제3자의 지적재산권을 침해하는 경우
타인의 개인정보, 이용자ID 및 패스워드를 부정하게 사용하는 경우
회원이 자신의 홈페이지나 게시판 등에 음란물을 게재하거나 음란 사이트를 링크하는 경우
기타 관련법령에 위반된다고 판단되는 경우



제6장 기 타

제18조(양도금지)
회원은 서비스의 이용권한, 기타 이용계약상의 지위를 타인에게 양도, 증여할 수 없으며, 이를 담보로 제공할 수 없습니다.

제19조(손해배상)
회사는 무료로 제공되는 서비스와 관련하여 회원에게 어떠한 손해가 발생하더라도 동 손해가 회사의 고의 또는 중대한 과실로 인한 손해를 제외하고 이에 대하여 책임을 부담하지 아니합니다.

제20조(면책 조항)
회사는 천재지변, 전쟁 또는 기타 이에 준하는 불가항력으로 인하여 서비스를 제공할 수 없는 경우에는 서비스 제공에 관한 책임이 면제됩니다.
회사는 서비스용 설비의 보수, 교체, 정기점검, 공사 등 부득이한 사유로 발생한 손해에 대한 책임이 면제됩니다.
회사는 회원의 귀책사유로 인한 서비스이용의 장애에 대하여 책임을 지지 않습니다.
회사는 회원이 서비스를 이용하여 기대하는 이익이나 서비스를 통하여 얻는 자료로 인한 손해에 관하여 책임을 지지 않습니다.
회사는 회원이 서비스에 게재한 정보, 자료, 사실의 신뢰도, 정확성 등의 내용에 관하여는 책임을 지지 않습니다.

제21조(관할법원)
서비스 이용으로 발생한 분쟁에 대해 소송이 제기 될 경우 회사의 소재지를 관할하는 법원을 전속 관할법원으로 합니다.


부 칙

(시행일) 이 약관은 2014년 2월 28일부터 시행합니다.</textarea>

                    </div>


                    <div id="check_box_button">


                        <div id="check_box_button_2">

                            <p style="font-size: 12px; margin-left: 20px; display: inline-block">회원가입약관의 내용에 동의합니다</p>

                        </div>

                        <div id="check_box_button_1">

                            <input type="checkbox" name="agree" value="1" id="check_1" style="margin-top: 12px;" required>

                        </div>



                    </div>


                </div>

                <div id="check_box">

                    <div id="check_box_title">

                        <p style="font-size: 12px; margin-left: 20px; font-weight: bold">[필수] 개인정보 수집 및 이용 동의</p>


                    </div>

                    <div id="check_box_content" >

                    <textarea id='check_box_content_text' readonly style="width:95%; height:140px; text-align:left;">개요 및 목록

&#039;쇼핑몰&#039;는 (이하 &#039;회사&#039;는) 이용자님의 개인정보를 중요시하며,
"정보통신망 이용촉진 및 정보보호"에 관한 법률을 준수하고 있습니다.

회사는 개인정보취급방침을 통하여 이용자님께서 제공하시는 개인정보가 어떠한 용도와 방식으로 이용되고 있으며,
개인정보보호를 위해 어떠한 조치가 취해지고 있는지 알려드립니다.


수집하는 개인정보 항목
회사는 회원가입, 상담, 서비스 신청 등을 위해 아래와 같은 개인정보를 수집하고 있습니다.
개인정보 수집방법 : 홈페이지(회원가입, 게시판, 신청서)
로그인ID, 패스워드, 별명, 이메일, 서비스 이용기록, 접속 로그, 쿠키, 접속 IP 정보, 결제기록

개인정보의 수집 및 이용목적
회사는 수집한 개인정보를 다음의 목적을 위해 활용합니다.
1. 서비스 제공에 관한 계약 이행 및 서비스 제공에 따른 요금정산
컨텐츠 제공, 물품배송 또는 청구서 등 발송, 본인인증, 구매 및 요금 결제, 요금추심
2. 회원 관리
회원제 서비스 이용에 따른 본인확인 , 개인 식별 , 불량회원의 부정 이용 방지와 비인가 사용 방지 , 가입 의사 확인
3. 마케팅 및 광고에 활용
접속 빈도 파악 또는 회원의 서비스 이용에 대한 통계


개인정보의 보유 및 이용기간
원칙적으로, 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체 없이 파기합니다.
단, 관계법령의 규정에 의하여 보존할 필요가 있는 경우 회사는 아래와 같이 관계법령에서 정한 일정한 기간 동안 회원정보를 보관합니다.
보존 항목 : 로그인ID , 결제기록
보존 근거 : 신용정보의 이용 및 보호에 관한 법률
보존 기간 : 3년
표시/광고에 관한 기록 : 6개월 (전자상거래등에서의 소비자보호에 관한 법률)
계약 또는 청약철회 등에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)
대금결제 및 재화 등의 공급에 관한 기록 : 5년 (전자상거래등에서의 소비자보호에 관한 법률)
소비자의 불만 또는 분쟁처리에 관한 기록 : 3년 (전자상거래등에서의 소비자보호에 관한 법률)
신용정보의 수집/처리 및 이용 등에 관한 기록 : 3년 (신용정보의 이용 및 보호에 관한 법률)

개인정보의 파기절차 및 방법
회사는 원칙적으로 개인정보 수집 및 이용목적이 달성된 후에는 해당 정보를 지체없이 파기합니다. 파기절차 및 방법은 다음과 같습니다.
1. 파기절차
회원님이 회원가입 등을 위해 입력하신 정보는 목적이 달성된 후 별도의 DB로 옮겨져(종이의 경우 별도의 서류함) 내부 방침 및 기타 관련 법령에 의한 정보보호 사유에 따라(보유 및 이용기간 참조) 일정 기간 저장된 후 파기되어집니다.
별도 DB로 옮겨진 개인정보는 법률에 의한 경우가 아니고서는 보유되어지는 이외의 다른 목적으로 이용되지 않습니다.
2. 파기방법
전자적 파일형태로 저장된 개인정보는 기록을 재생할 수 없는 기술적 방법을 사용하여 삭제합니다.

개인정보 제공
회사는 이용자님의 개인정보를 원칙적으로 외부에 제공하지 않습니다. 다만, 아래의 경우에는 예외로 합니다.
이용자님이 사전에 동의한 경우
법령의 규정에 의거하거나, 수사 목적으로 법령에 정해진 절차와 방법에 따라 수사기관의 요구가 있는 경우


수집한 개인정보의 위탁
회사는 이용자님의 동의없이 이용자님의 정보를 외부 업체에 위탁하지 않습니다. 향후 그러한 필요가 생길 경우, 위탁 대상자와 위탁 업무 내용에 대해 이용자님께 통지하고 필요한 경우 사전 동의를 받도록 하겠습니다.

이용자 및 법정대리인의 권리와 그 행사방법
이용자는 언제든지 등록되어 있는 자신의 개인정보를 조회하거나 수정할 수 있으며 가입해지를 요청할 수도 있습니다.
이용자들의 개인정보 조회,수정을 위해서는 ‘개인정보변경’(또는 ‘회원정보수정’ 등)을 가입해지(동의철회)를 위해서는 “회원탈퇴”를 클릭하여 본인 확인 절차를 거치신 후 직접 열람, 정정 또는 탈퇴가 가능합니다.
혹은 개인정보관리책임자에게 서면 또는 이메일로 연락하시면 지체없이 조치하겠습니다.
귀하가 개인정보의 오류에 대한 정정을 요청하신 경우에는 정정을 완료하기 전까지 당해 개인정보를 이용 또는 제공하지 않습니다. 또한 잘못된 개인정보를 제3자에게 이미 제공한 경우에는 정정 처리결과를 제3자에게 지체없이 통지하여 정정이 이루어지도록 하겠습니다.
회사는 이용자의 요청에 의해 해지 또는 삭제된 개인정보는 “회사가 수집하는 개인정보의 보유 및 이용기간”에 명시된 바에 따라 처리하고 그 외의 용도로 열람 또는 이용할 수 없도록 처리하고 있습니다.

개인정보 자동수집 장치의 설치, 운영 및 그 거부에 관한 사항
회사는 귀하의 정보를 수시로 저장하고 찾아내는 ‘쿠키(cookie)’ 등을 운용합니다. 쿠키란 회사의 홈페이지를 운영하는데 이용되는 서버가 귀하의 브라우저에 보내는 아주 작은 텍스트 파일로서 귀하의 컴퓨터 하드디스크에 저장됩니다. 회사는 다음과 같은 목적을 위해 쿠키를 사용합니다.
1. 쿠키 등 사용 목적
회원과 비회원의 접속 빈도나 방문 시간 등을 분석, 이용자의 취향과 관심분야를 파악 및 자취 추적, 각종 이벤트 참여 정도 및 방문 회수 파악 등을 통한 타겟 마케팅 및 개인 맞춤 서비스 제공
이용자는 쿠키 설치에 대한 선택권을 가지고 있습니다. 따라서, 이용자께서는 웹브라우저에서 옵션을 설정함으로써 모든 쿠키를 허용하거나, 쿠키가 저장될 때마다 확인을 거치거나, 아니면 모든 쿠키의 저장을 거부할 수도 있습니다.
2. 쿠키 설정 거부 방법
예: 쿠키 설정을 거부하는 방법으로는 이용자님이 사용하시는 웹 브라우저의 옵션을 선택함으로써 모든 쿠키를 허용하거나 쿠키를 저장할 때마다 확인을 거치거나, 모든 쿠키의 저장을 거부할 수 있습니다.
설정방법 예(인터넷 익스플로어의 경우) : 웹 브라우저 상단의 도구 &gt; 인터넷 옵션 &gt; 개인정보
단, 귀하께서 쿠키 설치를 거부하였을 경우 서비스 제공에 어려움이 있을 수 있습니다.


개인정보에 관한 민원서비스
회사는 이용자님의 개인정보를 보호하고 개인정보와 관련한 불만을 처리하기 위하여 아래와 같이 개인정보관리책임자를 지정하고 있습니다.

개인정보관리책임자 : 송익주
연락처 : 010-9024-1511

귀하께서는 회사의 서비스를 이용하시며 발생하는 모든 개인정보보호 관련 민원을 개인정보관리책임자에게 신고하실 수 있습니다. 회사는 이용자들의 신고사항에 대해 신속하게 충분한 답변을 드릴 것입니다.
기타 개인정보침해에 대한 신고나 상담이 필요하신 경우에는 아래 기관에 문의하시기 바랍니다.
1.개인정보보호 침해센터 (privacy.kisa.or.kr / 02-405-5118)
2.정보보호마크인증위원회 (www.eprivacy.or.kr / 02-580-9531~2)
3.대검찰청 사이버범죄신고 (spo.go.kr / 02-3480-2000)
4.경찰청 사이버테러대응센터 (www.ctrc.go.kr / 1566-0112)

기타
홈페이지에 링크되어 있는 웹사이트들이 개인정보를 수집하는 개별적인 행위에 대해서는 본 "개인정보취급방침"이 적용되지 않음을 알려 드립니다.

고지의 의무
현 개인정보취급방침의 내용이 변경될 경우에는 개정 최소 7일전부터 홈페이지의 "공지사항"을 통해 고지 하겠습니다.</textarea>

                    </div>


                    <div id="check_box_button">


                        <div id="check_box_button_2">

                            <p style="font-size: 12px; margin-left: 20px; ">개인정보 수집 및 이용에 동의합니다</p>

                        </div>

                        <div id="check_box_button_1">

                            <input type="checkbox" name="agree2" value="1" id="check_2" style="margin-top: 12px;" required>

                        </div>



                    </div>


                </div>

                <div id="check_box">

                    <div id="check_box_title">

                        <p style="font-size: 12px; margin-left: 20px; font-weight: bold">[선택] 쇼핑정보 수신 동의</p>


                    </div>

                    <div id="check_box_content" >

                    <textarea id='check_box_content_text' readonly style="width:95%; height:140px; text-align:left;">개인정보보호법 제22조 제4항에 의해 선택정보 사항에 대해서는 기재하지 않으셔도 서비스를 이용하실 수 있습니다.

① 마케팅 및 광고에의 활용
신규 서비스(제품) 개발 및 맞춤 서비스 제공, 이벤트 및 광고성 정보 제공 및 참여기회 제공, 인구통계학적 특성에 따른 서비스 제공 및 광고 게재, 서비스의 유효성 확인, 접속빈도 파악 또는 회원의 서비스 이용에 대한 통계 등을 목적으로 개인정보를 처리합니다.

② LF는 서비스를 운용함에 있어 각종 정보를 서비스 화면, 전화, e-mail, SMS, 우편물, 앱푸시 등의 방법으로LF Members 회원에게 제공할 수 있으며, LF Members 마일리지 적립 및 소진/소멸 등, 의무적으로 안내되어야 하는 정보성 내용은 수신동의 여부와 무관하게 제공됩니다.</textarea>


                    </div>


                    <div id="check_box_button">


                        <div id="check_box_button_2">

                            <p style="font-size: 12px; margin-left: 20px; ">(선택) 광고성 정보 수신에 동의합니다</p>

                        </div>

                        <div id="check_box_button_1">

                            <input type="checkbox" name="agree3" value="1" id="check_3" style="margin-top: 12px;">

                        </div>



                    </div>

                </div>




                <div id="check_box_finish" style="text-align: end; margin-top: 20px;" >


                    <button type="button" class="button" id="checkbox_agree">계속하기</button>



                </div>

            </form><!-- /form -->


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
