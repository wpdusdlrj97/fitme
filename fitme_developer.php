<!DOCTYPE html>
<?php session_start(); ?>
<html>
    <head>
        <meta charset="utf-8" />
        <title>PHP Session Login Test</title>
    </head>
    <body>
        <h1>FitMe 개발자 페이지</h1>

        <?php echo "저는 {$_SESSION['name']}입니다.<br>";  ?>

        <button type="button" onclick="location.href='http://15.165.80.29/client/dashboard' ">앱 등록하기</button>

        <?php

        $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');


        $mysql_table = 'oauth_client_details';
        $mysql_col1 = 'client_id';
        $mysql_col2 = 'authorized_grant_types';
        $mysql_col3 = 'additional_information';
        $mysql_col4 = 'resource_ids';

        $name = $_SESSION['name'];

        //여기서 세션에 맞게 가져다주면 될듯
        $sql = "SELECT * FROM oauth_client_details where additional_information like '%$name%' ORDER BY resource_ids desc";


        $result = mysqli_query($con, $sql);


        while($info=mysqli_fetch_array($result)){

            echo $info[$mysql_col1]." | ";
            echo $info[$mysql_col2]." | ";
            echo $info[$mysql_col3]."<br/>\n";

        }

        mysqli_close($con);

        ?>


        <hr />

    </body>
</html>
