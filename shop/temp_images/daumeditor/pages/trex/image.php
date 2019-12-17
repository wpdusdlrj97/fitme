<?php
session_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>FitMe 제품상세 이미지</title>
    <script src="../../js/popup.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="../../css/popup.css" type="text/css"  charset="utf-8"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        body{
            font-family: 'Jua', sans-serif;
        }
        .filebox label {
            display: inline-block;
            color: #fff;
            width:110px;
            text-align: center;
            margin-left:5%;
            height:45px;
            font-size: 17px;
            line-height: 45px;
            vertical-align: middle;
            background-color: #BDBDBD;
            cursor: pointer;
            border: 1px solid #A4A4A4;
            border-radius: .25em;
            -webkit-transition: background-color 0.2s;
            transition: background-color 0.2s;
        }
        .filebox label:hover {
            background-color: #A4A4A4;
        }
        .filebox label:active {
            background-color: #BDBDBD;
        }
        .filebox input[type="file"] {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }
        ::-webkit-scrollbar{width:13px; position:absolute;}
        ::-webkit-scrollbar-thumb{background-color:#c8c8c8; border-radius:5px;}
        ::-webkit-scrollbar-thumb:hover{background:#555;}
        ::-webkit-scrollbar-button { display: none; }
        .tr_hv:hover{
            background-color:#FBEFF2;
        }
        .delete:hover{
            background-color:#A4A4A4;
        }
    </style>
</head>
<body onload="initUploader();">
<div class="wrapper">
    <div class="header" style="height:40px;">
        <h1>사진 첨부</h1>
    </div>
    <div class="body">
        <div class="input_box" style="margin:15px 0 5px 0;">
            <form id="porudct_upload_to_server" action="./product_upload_server.php" method="post"  enctype="multipart/form-data">
                <input class="real_input_file" multiple type="file" style="display:none">
                <div class="filebox"> <label for="ex_file">업로드</label> <input multiple type="file" id="ex_file"> </div>
            </form>
        </div>
        <div class="input_box_name_array" style="border-top:1px solid black; border-bottom:1px solid black; width:100%; height:450px; overflow-y: scroll">
            <table class="input_table" style="width:90%; margin-left:5%; text-align: center; border-collapse:separate; border-spacing:0 5px;">
                <thead style="font-family: 'Jua', sans-serif;">
                <td style="width:40%; font-size:15px;"></td>
                <td style="width:45%; font-size:15px;"></td>
                <td style="width:15%; font-size:15px;"></td>
                </thead>
                <tbody>
                </tbody>
            </table>

        </div>
    </div>
    <div class="footer" style="float:left; width:100%; padding:10px 0 10px 0; height:50px;">
        <ul>
            <li class="submit"><a href="#" onclick="upload();" title="등록" class="btnlink">등록</a> </li>
            <li class="cancel"><a href="#" onclick="closeWindow();" title="취소" class="btnlink">취소</a></li>
        </ul>
    </div>
</div>
</body>
<script type="text/javascript">
    // <![CDATA[
    var post_file_array = new Array();
    var result_array;
    $('#ex_file').change(function(){
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
            post_file_array.push(f);
            sel_file = f;
            var reader = new FileReader();
            reader.onload = function(e){
                var object = "<tr class=\"tr_hv\" style=\"border-radius:10px;\"><td class='td_name' style=\"border-bottom:1px grey solid; overflow:hidden; padding:10px;\">"+f['name']+"</td>";
                object+="<td style=\"border-bottom:1px grey solid;\"><img style=\"margin:10px 0 10px 0; border-radius:10px; border:1px grey solid; height:150px;\" src=\""+e.target.result+"\">";
                object+="</td><td style=\"border-bottom:1px grey solid;\"><div class=\"delete\" onclick=\"remove_img(this)\" style=\"cursor:pointer; color:white; background-color:#D8D8D8; line-height:40px; margin-left:10%; width:80%; height:40px; font-size:18px; border-radius:5px; font-family: 'Jua', sans-serif;\">취소</div>";
                object+="</td></tr>";
                $(".input_table tbody").append(object);
            };
            reader.readAsDataURL(f);
        });
    });

    function upload()
    {
        if(post_file_array.length<1)
        {
            swal({
                title: "제품 등록",
                text: "이미지를 첨부하세요",
                icon: "warning",
                dangerMode: true
            });
        }else
        {
            var formData = new FormData();
            for(var i=0;i<post_file_array.length;i++)
            {
                formData.append("multi_file[]",post_file_array[i]);
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

                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    }

    //이미지 등록 취소
    function remove_img(object)
    {
        for(var i=0;i<post_file_array.length;i++)
        {
            if(post_file_array[i]['name']==$(object).parent('td').parent('tr').children('.td_name').text()){
                post_file_array.splice(i,1);
            }
        }
        $(object).parent('td').parent('tr').remove();
    }



    function done() {
        if (typeof(execAttach) == 'undefined') { //Virtual Function
            return;
        }
        var _mockdata = new Array();
        for(var i=0;i<post_file_array.length;i++)
        {
            var name =  post_file_array[i]['name'];
            var size = post_file_array[i]['size'];
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