<?php
// 스켈레톤, 이미지 전송 테스트용 php

$file_path = "./image/";
//파일 경로에 넘겨받은 이미지 이름을 붙임
$file_path = $file_path.basename($_FILES['uploaded_file']['name']);

$default_path = "http://49.247.136.36/yohan/image/";

$default_path = $default_path.basename($_FILES['uploaded_file']['name']);

if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$file_path))
{
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
    $json = array("result"=>"성공");
    echo json_encode($json);
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
    $qry = "delete from skeleton where image='$default_path'";
    mysqli_query($con,$qry);
    $qry = "insert into skeleton values('$default_path','1',null)";
    mysqli_query($con,$qry);
}
else
    {
        $json = array("result" => "실패");
        echo json_encode($json);
    }
?>
