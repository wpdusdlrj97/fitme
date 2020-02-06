<?php
//사용자의 정보를 보내줄 페이지
$email = $_POST['email'];//사용자에게 받은 이메일
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
if($email)
{
    //넘겨받은 사용자의 이메일로 DB를 조회한 후 사용자 정보를 보내준다.
    $qry = mysqli_query($connect,"select *from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    $data['phone'] = $row['phone'];
    $data['push_consent'] = $row['push_consent'];
    $data['sns_consent'] = $row['sns_consent'];
    $data['email_consent'] = $row['email_consent'];
    $data['selection_information'] = $row['selection_information'];
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
    $data['age'] = $row['age'];
    $photo_json = json_decode($row['photos'],true);
    mysqli_close($connect);
    $image_size_array = array();
    for($i=0;$i<count($photo_json['photo']);$i++)
    {
        $image_size = getimagesize($photo_json['photo'][$i]);
        $image_size_array_temp[0] = $image_size[0];
        $image_size_array_temp[1] = $image_size[1];
        array_push($image_size_array,$image_size_array_temp);
    }
    $photo_json['size']=$image_size_array;
    $data['photos'] = $photo_json;
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}else{
    $id = $_POST['id'];//사용자에게 받은 이메일
    $pw = $_POST['pw'];
    if($id&&$pw){

    }
}
?>
