<?php
session_start();

$email = $_SESSION['email'];
$password = $_POST['password'];

//기존 비밀번호 암호화 -> DB값과 비교하기 위해서
$password_hash = hash("sha256", $password);


$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe');
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect, 'utf8');

$query = "SELECT * FROM resource_owner where username = '$email'";

$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);


if ($password_hash == $row['password']) { //전달받은 비밀번호와 DB의 비밀번호가 일치할 시 회원정보를 삭제하고 로그아웃으로 이동

    //resource_owner
    $query_resource = "DELETE FROM resource_owner WHERE username='$email'";
    $result_resource = mysqli_query($connect, $query_resource);

    if ($result_resource) { // resource_owner 테이블 삭제 후에 user_information 테이블 삭제

        //user_information
        $query_user = "DELETE FROM user_information WHERE email='$email'";
        $result_user = mysqli_query($connect, $query_user);

        if ($result_user) { // 로그아웃 페이지로 이동

            echo "<script>
                    alert('회원 탈퇴가 완료되었습니다');
                    location.href='http://49.247.136.36/fitme_logout.php'</script>";

        } else {
            echo "탈퇴 오류2";
        }


    } else {
        echo "탈퇴 오류1";
    }


} else { //비밀번호가 틀릴경우

    echo "<script>alert('잘못된 비밀번호입니다'); history.back();</script>";


}

?>

