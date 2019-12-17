<!DOCTYPE html>
<?php
session_start();

?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>PHP Session Login Test</title>
    </head>
    <body>
        <h1>FitMe 메인 홈페이지</h1>
        <?php
            if(!isset($_SESSION['email']) ) {
                //echo "<p>로그인을 해 주세요. <a href=\"fitme_login.php\">[로그인]</a></p>";
                $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read";
                echo "<p>로그인을 해 주세요. <a href=$login_url>[로그인]</a></p>";
                echo "<a href=\"/developer/index.php\">[개발자페이지]</a></p>";

            } else {
                $email = $_SESSION['email'];
                echo "<p><strong>$email</strong>님 환영합니다.</p>";
                echo "<p><a href=\"fitme_logout.php\">[로그아웃]</a></p>";
                echo "<p><a href=\"/developer/index.php\">[개발자페이지]</a></p>";
                echo "<p><a href=\"/shop/shop_main.php\">[관리자페이지]</a></p>";
                echo "<p><div onclick='mainpage()'>[옷입기페이지]</div></p>";
            }
        ?>
        <hr />
    </body>
<script>
    function mainpage()
    {
        window.open('/web/mainpage.php','FITME','height=' + screen.height + ',width=' + screen.width + 'fullscreen=yes');
    }
</script>
</html>
