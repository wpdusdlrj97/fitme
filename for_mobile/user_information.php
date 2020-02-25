<?php
//사용자의 정보를 보내줄 페이지
$id = $_POST['id'];//사용자에게 받은 이메일
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
if($id)
{
    //넘겨받은 사용자의 이메일로 DB를 조회한 후 사용자 정보를 보내준다.
    $qry = mysqli_query($connect,"select *from user_information where id='$id'");
    $row = mysqli_fetch_array($qry);
    $data['email'] = $row['email'];
    $data['level'] = $row['level'];
    $data['name'] = $row['name'];
    $data['age'] = $row['age'];
    $data['sex'] = $row['sex'];
    $data['phone'] = $row['phone'];
    $data['tel'] = $row['tel'];
    $data['address'] = $row['address'];
    $data['push_consent'] = $row['push_consent'];
    $data['sns_consent'] = $row['sns_consent'];
    $data['email_consent'] = $row['email_consent'];
    $data['photos'] = $row['photos'];
//    $temp = $row['photos'];
//    $data['location'] = json_decode($temp,true)['location'];
//    $data['photo'] = json_decode($temp,true)['photo'];
    $data['shoulder_length'] = $row['shoulder_length'];
    $data['chest_size'] = $row['chest_size'];
    $data['arm_length'] = $row['arm_length'];
    $data['waist_size'] = $row['waist_size'];
    $data['thigh_size'] = $row['thigh_size'];
    $data['hip_size'] = $row['hip_size'];
    $data['ankle_size'] = $row['ankle_size'];
    $data['height_length'] = $row['height_length'];
    $data['leg_length'] = $row['leg_length'];
    $data['top_length'] = $row['top_length'];
    $data['weight'] = $row['weight'];

    mysqli_close($connect);
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}
?>
