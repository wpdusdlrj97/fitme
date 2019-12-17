<?php
session_start();
//사진들을 임시로 저장처리하는 페이지

//echo count($_FILES['multi_file']['name']);
$email = $_SESSION['email'];
if($email)
{
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
    $count=0;
    $result_file_name = array();
    foreach ($_FILES['multi_file']['name'] as $f => $name)
    {
        $date = date("YmdHis");
        $name = '../../../temp_images/'.$email.$date.'_'.$count.'.jpg';
        $par_name = '/temp_images/'.$email.$date.'_'.$count.'.jpg';
        $abs_name = "http://49.247.136.36/shop/temp_images/".$email.$date."_".$count.".jpg";
        if(move_uploaded_file($_FILES['multi_file']['tmp_name'][$f],$name))
        {
            $count++;
            $qry = mysqli_query($con,"insert into temp_product_images values('$email','$par_name')");
            array_push($result_file_name,$abs_name);
        }
        else
        {
            $result_file_name=null;
            print_r($_FILES['multi_file']['error']);
        }
    }
    echo json_encode($result_file_name,JSON_UNESCAPED_UNICODE);
}else
{
    echo 'email';
}
?>