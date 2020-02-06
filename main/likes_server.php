<?php
session_start();
if($_SESSION['email'])
{
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
    mysqli_set_charset($connect,'utf8'); //문자셋을 지정한다.
    $number = $_POST['number']; //삽입할지, 지울지 결정하는 변수
    $email = $_POST['email'];   //좋아요 클릭한사람 이메일
    $product_key = $_POST['product_key'];   //좋아요 클릭당한 제품
    if($number=='1')    //좋아요 지우기
    {
        if(mysqli_query($connect,"delete from likes where email='$email' and product_key = $product_key"))
        {
            $qry = mysqli_query($connect,"select * from likes where product_key=$product_key");
            $qry = mysqli_query($connect,"update product set likes=likes-1 where product_key=$product_key");
            echo mysqli_num_rows($qry);
        }
        else
        {
            echo 'failed';
        }
//            echo '좋아요 지우기 : '.$email.$product_key;
    }
    else if($number=='0')   //좋아요 삽입하기
    {
        if(mysqli_query($connect,"insert into likes values($product_key,'$email')"))
        {
            $qry = mysqli_query($connect,"select * from likes where product_key=$product_key");
            $qry = mysqli_query($connect,"update product set likes=likes+1 where product_key=$product_key");
            echo mysqli_num_rows($qry);
        }
        else
        {
            echo 'failed';
        }
    }
    mysqli_close($connect);
}

?>