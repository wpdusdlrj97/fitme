<?php
session_start();
$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
$qry = mysqli_query($con,"select *from user_information where email='$email'");
$row = mysqli_fetch_array($qry);
if($row['level']!=1)
{
    echo '<script>alert("로그인이 되어있는지 확인하세요");</script>';
    echo '<script>closeWindow();</script>';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>이미지 첨부</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jua&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
    <link rel="stylesheet" href="/api/css-loader.css">
    <style>
        .body{
            font-family: 'Jua', sans-serif;
        }
        .body label {
            margin:20px 0 20px 10px;
            width:150px;
            height:50px;
            display: inline-block;
            color: white;
            font-size: 18px;
            line-height: 50px;
            text-align: center;
            background-color: #BDBDBD;
            cursor: pointer;
            border: 1px solid #A4A4A4;
            border-radius: .25em;
        }
        .body label:hover {
            background-color: #A4A4A4;
        }
        .body label:active {
            background-color: #BDBDBD;
        }
        .body  input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
        .content{
            width:99%;
        }
        ::-webkit-scrollbar{width:13px; position:absolute;}
        ::-webkit-scrollbar-thumb{background-color:#c8c8c8; border-radius:5px;}
        ::-webkit-scrollbar-thumb:hover{background:#555;}
        ::-webkit-scrollbar-button { display: none; }
    </style>
</head>
<body id="imagephp_body" onload="initUploader();">
<!-- Loader -->
<div class="loader loader-default"></div>
<div class="wrapper">
    <div class="header">
        <h1>사진 첨부</h1>
    </div>
    <div class="body" style="border-bottom:1px grey solid;">
        <label for="input_image">첨 부</label>
        <input type="file" id="input_image" multiple>
    </div>
    <div class="content">
    </div>
    <div class="footer">
        <p><a href="#" onclick="closeWindow();" title="닫기" class="close">닫기</a></p>
        <ul>
            <li class="submit"><a href="#" onclick="upload();" title="등록" class="btnlink">등록</a> </li>
            <li class="cancel"><a href="#" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
        </ul>
    </div>
</div>
</body>
<script type="text/javascript">
    // <![CDATA[
    var image_array=new Array();
    var result_array;
    $('#input_image').change(function(){
        $('#imagephp_body').append("<div class=\"loader loader-default is-active\" style=\"float:left;\" data-text=\"잠시 기다려주세요\" data-blink ></div>");
        var files = this.files;
        var file_array = Array.prototype.slice.call(files);
        file_array.forEach(function(f){
            if(!f.type.match("image.*")){
                swal({
                    title: "Failed",
                    text: "이미지가 아닌 파일이 존재합니다.",
                    icon: "warning",
                    buttons: "확인",
                    dangerMode: true
                });
                return;
            }
            image_array.push(f);
            sel_file = f;
            var reader = new FileReader();
            reader.onload = function(e){
                object = "<div style=\"font-family: 'Jua', sans-serif; border:1px #E6E6E6 solid; width:45%; margin-left:2%; margin-top:15px; margin-bottom:25px; display:inline-block; text-align: center; float:left;\">";
                object += "<div class=\"name\" style=\"width:100%; line-height:50px; height:50px; float:left; border-bottom:1px grey solid; background-color:#6E6E6E; font-size:18px; color:white;\">"+f.name+"</div>";
                object +="<div class=\"file\" style=\"width:100%; float:left; height:200px;\"><img class=\"content_image\" src=\""+e.target.result+"\" style=\"margin-top:10px; max-width:100%; height:180px;\"></div>";
                object +="<div class='delete_file' style=\"cursor:pointer; float:left;  width:100%; background-color:#6E6E6E; color:white; border-top:1px grey solid; height:40px; line-height:40px; font-size:17px;\">취소</div></div>";
                $(".content").append(object);
                $('.delete_file').hover(function() {
                    $(this).css("background-color", "#A4A4A4");
                }, function(){
                    $(this).css("background-color", "#6E6E6E");
                });

                $('.delete_file').click(function(){
                    if($(this).parent('div').index()!=-1)
                    {
                        console.log('삭제할인덱스:'+$(this).parent('div').index());
                        image_array.splice($(this).parent('div').index(),1);
                    }
                    $(this).parent('div').remove()
                });
            };
            reader.readAsDataURL(f);
        });
        $('.loader-default').remove();
        $('#input_image').val("");
    });

    function done() {
        if (typeof(execAttach) == 'undefined') { //Virtual Function
            return;
        }
        var _mockdata = new Array();
        for(var i=0;i<image_array.length;i++)
        {
            var name =  image_array[i]['name'];
            var size = image_array[i]['size'];
            _mockdata = {
                'imageurl': result_array[i],
                'filename':name,
                'filesize': size,
                'imagealign': 'C',
                'originalurl': result_array[i],
                'thumburl': result_array[i],
                'width':'656'
            };
            execAttach(_mockdata);
        }
        closeWindow();
    }

    function upload()
    {
        if(image_array.length>0)
        {
            $('#imagephp_body').append("<div class=\"loader loader-default is-active\" style=\"float:left;\" data-text=\"잠시 기다려주세요\" data-blink ></div>");
            var formData = new FormData();
            for(var i=0;i<image_array.length;i++)
            {
                formData.append("multi_file[]",image_array[i]);
            }
            $.ajax({
                type:"POST",
                url:"./upload_temp.php",
                data : formData,
                contentType : false,
                processData : false,
                success: function(string){
                    if(string!='email')
                    {
                        result_array = JSON.parse(string);
                        done();
                    }
                    else
                    {
                        swal({
                            title: "이미지 등록",
                            text: "로그인 하셔야합니다.",
                            icon: "warning",
                            buttons: ["네"],
                            dangerMode: true
                        }).then((willDelete) => {
                            closeWindow();
                    });
                    }
                    $('.loader-default').remove();
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
        else
        {
            swal({
                title: "본문 이미지첨부",
                text: "이미지를 첨부하세요",
                icon: "warning",
                dangerMode: true
            });
        }

    }

    function initUploader(){
        var _opener = PopupUtil.getOpener();
        if (!_opener) {
            alert('잘못된 경로로 접근하셨습니다.');
            return;
        }

        var _attacher = getAttacher('image', _opener);
        registerAction(_attacher);
    }
    // ]]>
</script>
</html>