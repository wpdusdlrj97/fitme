
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
session_start();

$id = $_POST['username'];
$password = $_POST['password'];

//기존 비밀번호 암호화 -> DB값과 비교하기 위해서
$password_hash = hash("sha256", $password);


$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
//DB 가져올때 charset 설정 (안해줄시 한글 깨짐)
mysqli_set_charset($connect,'utf8');

$query ="SELECT * FROM resource_owner where username = '$id' and password='$password_hash'";

$result = mysqli_query($connect, $query);

$row = mysqli_fetch_assoc($result);

$total = mysqli_num_rows($result);



if ($total==1) {


    $query_id ="SELECT * FROM user_information where id = '$id'";

    $result_id = mysqli_query($connect, $query_id);

    $row_id = mysqli_fetch_assoc($result_id);


    //FitMe 메인서버의 이메일 세션 저장하고
    $_SESSION['id'] = $id;
    $_SESSION['email'] = $row_id['email'];
    //스프링으로 아이디/비번을 뿌려준다


    
    ?>


    <script>
        window.onload = function(){
            //인증서버에 로그인 보내기
            post_to_url('http://15.165.80.29/login', {'username':'<?php echo $id;?>','password':'<?php echo $password;?>'});
            //post_to_url('http://localhost:8080/login', {'username':'yohan@gmail.com','password':'1234'});
        }
    </script>



<?php  }else{

    echo "<script>alert('잘못된 이메일 혹은 비밀번호입니다'); history.back();</script>";


}

?>


<script>
    /*
 * path : 전송 URL
 * params : 전송 데이터 {'q':'a','s':'b','c':'d'...}으로 묶어서 배열 입력
 * method : 전송 방식(생략가능)
 */
    function post_to_url(path, params, method) {
        method = method || "post"; // Set method to post by default, if not specified.
        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        for (var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    }


</script>
