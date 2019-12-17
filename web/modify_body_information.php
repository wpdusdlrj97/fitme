<?php
$number = $_POST['modify_number'];
if($number==0)
{
    $email = $_POST['modify_email'];
    $tall = $_POST['modify_tall'];
    $arm = $_POST['modify_arm'];
    $shoulder = $_POST['modify_shoulder'];
    $top = $_POST['modify_top'];
    $leg = $_POST['modify_leg'];
    $chest = $_POST['modify_chest'];
    $waist = $_POST['modify_waist'];
    $thigh = $_POST['modify_thigh'];
    $ankle = $_POST['modify_ankle'];
    $hip = $_POST['modify_hip'];
    $hip = 98; // 이거 임시로 하드코딩
    $product = $_POST['product_number'];
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
//사용자 데이터 가져오기 ( email로 사용자를 조회한다 )
//Session이 유지된 상태에만 가져올수 있도록 한다. - 현재는 하드코딩으로 email을 지정
    $qry = mysqli_query($con,"update user_information set shoulder_length='$shoulder', chest_size='$chest', arm_length='$arm', waist_size='$waist', thigh_size='$thigh', hip_size='$hip', ankle_size='$ankle', height_length='$tall', leg_length='$leg', top_length='$top' where email='$email'");
    echo "<script>location.href='./mainpage.php?name=android_hong_test&product=$product'</script>";
}
else if($number==1)
{
    $email = $_POST['email'];
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
    $qry = mysqli_query($con,"select photos from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    $data = json_decode($row[0],true);
    //DB에 저장되어있던 이미지 데이터들 ( 경로, 좌표 )
    $location = $data['location'];
    $temp_location = $location;
    $photo = $data['photo'];
    $temp_photo = $photo;
    //전달받은 이미지경로
    $image_array = $_POST['delete_image'];
    //배열에서 중복된 Value를 가졌으면 제거 ( 정렬X )
    for($pot=0;$pot<count($photo);$pot++)
    {
        for($cont=0;$cont<count($image_array);$cont++)
        {
            if($photo[$pot]==$image_array[$cont])
            {
                unset($temp_photo[$pot]);
                unset($temp_location[$pot]);
            }
        }
    }
    //서버에 존재하는 실제 이미지 제거
    for($cont=0;$cont<count($image_array);$cont++)
    {
        unlink(str_replace('http://49.247.136.36','..',$image_array[$cont]));
    }
    //중복 Value를 제외한 남은 배열들을 재정렬
    $photo = array_values($temp_photo);
    $location = array_values($temp_location);

    //DB에 재저장
    $json['location'] = $location;
    $json['photo'] = $photo;
    $data = json_encode($json,JSON_UNESCAPED_UNICODE);
    if(mysqli_query($con,"update user_information set photos='$data' where email='$email'"))
    {
        print_r('success');
    }
    else
    {
        print_r('fail');
    }
}
?>