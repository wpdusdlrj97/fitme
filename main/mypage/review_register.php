<?php
session_start();
if($_SESSION['email'])
{
    $review_text = $_POST['review_text'];
    $review_star =  $_POST['review_star'];
    $product_key = $_POST['product_key'];
    $date = date("YmdHis");
    $email = $_SESSION['email'];
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    if($_FILES['review_file']['name']) //포토리뷰
    {
        $detail_file_path = '../../user_resource/review/'.$email.$date.'_review_.jpg';
        $detail_url = 'http://49.247.136.36/user_resource/review/'.$email.$date.'_review_.jpg';
        move_uploaded_file($_FILES['review_file']['tmp_name'],$detail_file_path);
        $qry = mysqli_query($connect,"insert into review values($product_key,'$email',$review_star,'$review_text',$date,'$detail_url')");
    }
    else    //텍스트리뷰
    {
        $qry = mysqli_query($connect,"insert into review(product_key,email,star,review_text,date) values($product_key,'$email',$review_star,'$review_text',$date)");
    }
    $qry = mysqli_query($connect,"update product set review_count=review_count+1 where product_key=$product_key");

    echo '<script> history.back(); </script>';
}
else
{
    echo 'email';
}
?>