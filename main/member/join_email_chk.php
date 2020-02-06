<?php
$conn=mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe') or die ("connect fail");

$email=$_GET['useremail'];

$query="select count(*) from user_information where email='$email'";
$result=mysqli_query($conn,$query);
$row=mysqli_fetch_array($result);

mysqli_close($conn);
?>

<script>
    var row="<?=$row[0]?>";
    if(row==1){
        parent.document.getElementById("chk_email2").value="0";
        parent.alert("해당 이메일로 가입된 계정이 존재합니다");
    }
    else{
        parent.document.getElementById("chk_email2").value="1";
        parent.alert("사용 가능합니다");
    }
</script>
