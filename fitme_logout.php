<?php
    session_start();

    //FitMe 메인 홈페이지의 세션을 종료시키고
    session_destroy();

	  //인증서버의 로그아웃 페이지로 이동해 인증서버 세션 또한 종료
    $logout_url="http://15.165.80.29/logout";

    echo "<meta http-equiv='refresh' content='0; url=$logout_url'>";

?>
