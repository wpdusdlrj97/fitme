<?php

$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');


$mysql_table = 'oauth_client_details';
$mysql_col1 = 'client_id';
$mysql_col2 = 'client_secret';
$mysql_col3 = 'scope';


$sql = "SELECT * FROM ".$mysql_table;


$result = mysqli_query($con, $sql);


while($info=mysqli_fetch_array($result)){

    echo $info[$mysql_col1]." | ";
    echo $info[$mysql_col2]." | ";
    echo $info[$mysql_col3]."<br/>\n";

}

mysqli_close($con);

?>
