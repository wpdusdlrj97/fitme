<?php
// 스켈레톤, 이미지 전송 테스트용 php

//파일 경로에 넘겨받은 이미지 이름을 붙임
$email = $_POST['email'];
$location_head = $_POST['location_head'];
$location_waist = $_POST['location_waist'];
$location_foot = $_POST['location_foot'];

$file_path = '../user_resource/image/';
$data_name = $email.date("YmdHis").'.jpg';

$default_path = "http://49.247.136.36/user_resource/image/";

$default_path = $default_path.$data_name;

if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$file_path.$data_name))
{
    //echo '들어옴';
    $exif = exif_read_data($file_path);
    if (!empty($exif['Orientation'])) {
        switch ($exif['Orientation']) {
            case 3:
                $image = imagecreatefromjpeg($file_path);
                $rotate = imagerotate($image, 180, 0);
                imagejpeg($rotate,$file_path);
                imagedestroy($image);
                imagedestroy($rotate);
                break;
            case 6:
                $image = imagecreatefromjpeg($file_path);
                $rotate = imagerotate($image, -90, 0);
                imagejpeg($rotate,$file_path);
                imagedestroy($image);
                imagedestroy($rotate);
                break;
            case 8:
                $image = imagecreatefromjpeg($file_path);
                $rotate = imagerotate($image, 90, 0);
                imagejpeg($rotate,$file_path);
                imagedestroy($image);
                imagedestroy($rotate);
                break;
        }
    }
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
    $qry = mysqli_query($con,"select * from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    if($row['photos'])
    {
        $photos_data = json_decode($row['photos'],true);
        $jsondata['location'] = $photos_data['location'];
        $jsondata['photo'] = $photos_data['photo'];
        $location_array = array();
        array_push($location_array,$location_head);
        array_push($location_array,$location_waist);
        array_push($location_array,$location_foot);
        array_push($jsondata['location'],$location_array);
        array_push($jsondata['photo'],$default_path);
        $json = json_encode($jsondata,JSON_UNESCAPED_UNICODE);
        $qry2 = mysqli_query($con,"update user_information set photos='$json' where email='$email'");
    }
    else
    {
        $jsondata['location'] = array();
        $jsondata['photo'] = array();
        $location_array = array();
        array_push($location_array,$location_head);
        array_push($location_array,$location_waist);
        array_push($location_array,$location_foot);
        array_push($jsondata['location'],$location_array);
        array_push($jsondata['photo'],$default_path);
        $json = json_encode($jsondata,JSON_UNESCAPED_UNICODE);
        $qry2 = mysqli_query($con,"update user_information set photos='$json' where email='$email'");
    }
    $json = array("result"=>"성공");
    echo json_encode($json);
}
else
{
   // echo '실패';
    $json = array("result" => "실패");
    echo json_encode($json);
}
?>
