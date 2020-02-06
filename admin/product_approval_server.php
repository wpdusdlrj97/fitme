<?php
session_start();
$email = $_SESSION['email'];
if($email)
{
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');

    //권한 확인
    $qry = mysqli_query($connect,"select *from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    if($row['level']==1)
    {
        //전달받은 키값과 제품너비, 길이 좌표
        $key = $_POST['key'];
        $line_position = $_POST['line_position'];
        $qry = mysqli_query($connect,"select * from product_approval where product_key='$key'");
        $row = mysqli_fetch_array($qry);
        $mv_img_location = str_replace("/fitme_temp/","/fitme/",$row['fitme_image']);
        $row_location = $row['fitme_image'];
        $split_str = explode('_fitme.',$row['fitme_image']);
        $tmp_name = $split_str[0].'_fitme.png';
        $filename = str_replace("http://49.247.136.36/product_resource/image/fitme_temp/","",$tmp_name);
        $unlink_filename = str_replace("http://49.247.136.36/product_resource/image/fitme_temp/","",$row['fitme_image']);
        $qry = mysqli_query($connect,"update product set fitme_image='$mv_img_location', line_position='$line_position' where product_key=$key");
        $qry = mysqli_query($connect,"delete from product_approval where product_key=$key");
        //전달받은 이미지가 있는지 확인
        if($_FILES['uploaded_file']['name'])
        {
            echo '이미지 잇음';
            move_uploaded_file($_FILES['uploaded_file']['tmp_name'],'../product_resource/image/fitme/'.$filename);
            unlink("../product_resource/image/fitme_temp/".$unlink_filename);
        }
        else
        {
            $command = "mv ../product_resource/image/fitme_temp/".$filename." ../product_resource/image/fitme/".$filename;
            system($command);
            echo '이미지 없음';
        }
    }else
    {
        echo 'level';
    }
}else{
    echo 'email';
}
?>