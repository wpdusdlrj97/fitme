<?php
session_start(); //세션을 유지한다.
/*
이 페이지에서 가장 먼저 해야할것은 접속한 사용자가 일반사용자인지 관리자, 즉 쇼핑몰 인지를 확인 하여야한다.
DB에서 user_information테이블에서 level이 사용자 권한을 나타낸다.
level이 0이라면 일반사용자이며 1 이상이라면 이 페이지를 이용할 권한을 가지고 있는것이다.
 */
$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.
if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/shop/shop_main.php'; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    //csrf 공격에 대응하기 위한 state 값 설정
    function generate_state() {
        $mt = microtime();
        $rand = mt_rand();
        return md5($mt . $rand);
    }

    // 상태 토큰으로 사용할 랜덤 문자열을 생성
    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    $login_url = "http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=".$state;
    echo "<meta http-equiv='refresh' content='0; url=$login_url'>";
    //echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read\'</script>'; //로그인 페이지로 이동한다.
}
else
{
    //로그인이 되어있는 상태
    //접근권한을 DB에서 조회해야 한다.
    $qry = mysqli_query($con,"select * from user_information where email='$email'");
    $row_level = mysqli_fetch_array($qry);
    if($row_level['level']!='1') //접근권한이 일반 사용자인 경우에는 에러페이지로 넘긴다.
    {
        echo '<script> location.href="http://49.247.136.36/wrong_access.php"; </script>';
    }
}

//임시 이미지 테이블을 조회해서 기존에 존재하던 이미지들을 전부 제거한다.
$qry = mysqli_query($con,"select * from temp_product_images where email='$email'");
while($row = mysqli_fetch_array($qry))
{
    unlink('.'.$row['filename']);
}
$qry = mysqli_query($con,"delete from temp_product_images where email='$email'");

//위의 단계를 지나오고 나서 카테고리와 옵션들을 가져온다.
$qry = mysqli_query($con,"select * from category");
$category1_array=array();
$category2_array=array();
$offer_option = array();
$offer_size = array();
while($row = mysqli_fetch_array($qry))
{
    array_push($category1_array,$row['name']);
    array_push($category2_array,$row['detail_category']);
    array_push($offer_option,$row['offer_option']);
    array_push($offer_size,$row['offer_size']);
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <title>FitMe Admin</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Jua&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./product_upload.css">
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
<div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <a class="navbar-brand" href="shop_main.php">
            <img src="assets/img/admin_logo.png" style="width:30%; height:300%" />
        </a>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li>
                    <a href="shop_main.php" ><i class="fa fa-desktop "></i>관리자홈</a>
                </li>
                <li  class="active-link">
                    <a href="product_upload.php"><i class="fa fa-table "></i>제품등록</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-qrcode "></i>제품관리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-qrcode "></i>리뷰관리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-bar-chart-o"></i>추가카테고리</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- /. NAV SIDE  -->
    <div id="page-wrapper">
        <div id="page-inner">
            <div class="row">
                <div class="col-lg-12">
                    <h2>제품등록</h2>
                </div>
                <div style="width:100%; float:left;">
                    <div id="body">
                        <table id="center_table">
                            <tr class="center_table_tr">
                                <td class="center_table_first_td">제품명</td>
                                <td class="center_table_first_write_content">
                                    <input class="product_upload_top_product_name" type="text">
                                </td>
                                <td class="product_upload_top_porduct_name_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">상품설명</td>
                                <td class="center_table_write_content">
                                    <input class="product_upload_top_product_guid" type="text">
                                </td>
                                <td id="center_table_check_place" class="product_upload_porduct_guide_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">가격</td>
                                <td class="center_table_write_content">
                                    <input type="number" class="product_upload_top_product_price">
                                </td>
                                <td id="center_table_check_place" class="product_upload_porduct_guide_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">재고</td>
                                <td class="center_table_write_content">
                                    <input type="number" class="product_upload_top_product_stock">
                                </td>
                                <td id="center_table_check_place" class="product_upload_porduct_guide_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">카테고리 ①</td>
                                <td class="center_table_write_content">
                                    <select class="proudct_upload_top_product_category1">
                                        <option>선택</option>
                                        <?php
                                        for($count=0;$count<count($category1_array);$count++)
                                        {?>
                                            <option><?php echo $category1_array[$count]?></option>
                                        <?php }
                                        ?>
                                    </select>
                                </td>
                                <td id="center_table_check_place" class="product_upload_porduct_category1_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">카테고리 ②</td>
                                <td class="center_table_write_content">
                                    <select class="proudct_upload_top_product_category2">
                                        <option>선택</option>
                                    </select>
                                </td>
                                <td id="center_table_check_place" class="product_upload_porduct_category2_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">색상(선택)</td>
                                <td class="center_table_write_content">
                                    추후에 추가
                                </td>
                                <td id="center_table_check_place" class="product_upload_offer_size_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">제공 사이즈</td>
                                <td class="center_table_write_content">
                                    <div class="offer_size_div">
                                        <select class="product_upload_top_addsize">
                                            <option>사이즈추가(cm)</option>
                                        </select>
                                    </div>
                                    <div class="offer_size_div">
                                        <table class="product_upload_top_size_table">
                                            <thead>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="offer_size_bottom"></div>
                                    </div>
                                </td>
                                <td id="center_table_check_place" class="product_upload_offer_size_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">옷 입히기 이미지</td>
                                <td class="center_table_write_content">
                                    <div id="product_upload_top_right">
                                        <div class="upload_fitme_box">
                                            <form id="porudct_upload_to_server" action="./product_upload_server.php" method="post"  enctype="multipart/form-data">
                                                <label for="input_image">첨부</label>
                                                <input type="file" id="input_image" name="uploaded_file">
                                                <input type="text" id="input_product_name" name="input_product_name" style="display:none">
                                                <input type="text" id="input_product_category1" name="input_product_category1" style="display:none">
                                                <input type="text" id="input_product_category2" name="input_product_category2" style="display:none">
                                                <input type="text" id="input_product_size" name="input_product_size" style="display:none">
                                                <!--                        제품목록중 대표이미지와 제품상세페이지의 대표이미지들도 첨부해야한다.-->
                                            </form>
                                            <div class="upload_fitme_box_image_name"></div>
                                        </div>
                                        <div id="product_upload_top_image_box">
                                            <img id="product_upload_top_image" style="width:99%;"/>
                                        </div>
                                    </div>
                                </td>
                                <td id="center_table_check_place" class="product_upload_fitme_image_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">대표 이미지(제품목록)</td>
                                <td class="center_table_write_content">
                                    <div class="product_list_image">
                                        <label for="list_image_input" style="width:100%; height:100%;"></label>
                                        <input type="file" id="list_image_input" style="display:none">
                                    </div>
                                    <img class="product_list_image_choose">
                                </td>
                                <td id="center_table_check_place" class="product_upload_main_image_check"></td>
                            </tr>

                            <tr class="center_table_tr">
                                <td class="center_table_td">대표 이미지(제품상세)</td>
                                <td class="center_table_write_content">
                                    <div class="product_detail_image">
                                        <label for="detail_image_input" style="width:100%; height:100%;"></label>
                                        <input type="file" id="detail_image_input" multiple style="display:none">
                                    </div>
                                    <div class="product_detail_image_input_box">
                                    </div>
                                </td>
                                <td id="center_table_check_place" class="product_upload_detail_image_check"></td>
                            </tr>
                            <tr class="center_table_tr">
                                <td class="center_table_td">본문 내용(제품상세)</td>
                                <td class="center_table_write_content">
                                    <div class="detail_content" style="width:97%; margin-left:3%; margin-top:15px; margin-bottom:15px; height:870px;">
                                        <form name="tx_editor_form" id="tx_editor_form" action="product_upload_server.php" method="post" enctype="multipart/form-data" accept-charset="utf-8">
                                            <?php
                                            include_once("./daumeditor/editor.html")
                                            ?>
                                        </form>
                                    </div>
                                </td>
                                <td id="center_table_check_place" class="product_upload_main_image_check"></td>
                            </tr>

                        </table>
                    </div>
                    <button onclick="product_upload_top_post()" class="btn btn-primary" style="float:right; width:130px; height:50px; margin-bottom:50px; text-align:center; margin-right:2%; margin-top:20px; font-size:1.2em">등록</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="footer">
    <div class="row">
        <div class="col-lg-12" >
            &copy;  2014 yourdomain.com | Design by: <a href="http://binarytheme.com" style="color:#fff;" target="_blank">www.binarytheme.com</a>
        </div>
    </div>
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<!-- JQUERY SCRIPTS -->
<script src="assets/js/jquery-1.10.2.js"></script>
<!-- BOOTSTRAP SCRIPTS -->
<script src="assets/js/bootstrap.min.js"></script>
<!-- CUSTOM SCRIPTS -->
<script src="assets/js/custom.js"></script>
<script>
    //DB에서 불러온 카테고리 목록과 제공 사이즈, 옵션 목록들을 불러와서 넣어준다.
    var category1 = <?php echo json_encode($category1_array)?>;
    var category2 = <?php echo json_encode($category2_array)?>;
    var offer_option = <?php echo json_encode($offer_option)?>;
    var offer_size = <?php echo json_encode($offer_size)?>;
    var width_line=0;
    var height_line=0;
    var div1x_click=false;
    var div2x_click=false;
    var div1y_click=false;
    var div2y_click=false;
    var fitme_image;
    var detail_image = new Array();
    var list_image;

    //////////########$$$$$$$**********이미지 다중업로드가 필요한 부분이므로 file 배열로 관리할 예정이다. 추후에 코드 수정으로 넣도록 하자
    /*
    상세페이지의 메인 이미지를 등록하는 곳에서
    이미지들을 선택 완료한 경우에 동작하는 코드이다.
    선택이 완료된 이미지는 동적으로 미리보기 이미지를 화면에 생성한다.
    ** 들어온 이미지는 여러개일 수 있으므로 반복문으로 검증을 거쳐야 한다.
    */
    $('#detail_image_input').change(function(){
        var files = this.files;
        var file_array = Array.prototype.slice.call(files);
        file_array.forEach(function(f){
            if(!f.type.match("image.*")){
                swal({
                    title: "Failed",
                    text: "이미지가 아닌 파일이 존재합니다.",
                    icon: "warning",
                    buttons: "false",
                    dangerMode: true
                });
                return;
            }
            detail_image.push(f);
            sel_file = f;
            var reader = new FileReader();
            reader.onload = function(e){
                object = "<div class=\"product_detail_image_div\" style=\"width:180px; height:200px; margin:15px; display:inline-block;\">";
                object +="<img class=\"product_detail_image_img\" src=\""+e.target.result+"\" style=\"width:170px; height:170px; float:left;\">";
                object +="<button class=\"product_detail_image_delete\" style=\"width:170px; height:35px; margin-top:5px; float:left;\">취소</button></div>";
                $(".product_detail_image_input_box").append(object);

                /*
                아래 코드는 상세페이지의 메인 이미지를 등록하는 곳에서
                선택한 이미지를 삭제하는 코드이다.
                이미지 객체를 담고있는 배열에서도 해당 이미지를 삭제해준다.
                */
                $('.product_detail_image_delete').click(function(){
                    if($(this).parent('div').index()!=-1)
                    {
                        console.log('삭제할인덱스:'+$(this).parent('div').index());
                        detail_image.splice($(this).parent('div').index(),1);
                    }
                    $(this).parent('div').remove()
                });
            };
            reader.readAsDataURL(f);
        });
        if($('.product_detail_image_input_box').css("display")=="none")
        {
            $('.product_detail_image_input_box').css({"display":"block", "width":($('.center_table_write_content').width()-20)+"px"});
        }
    });
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /*
    메인 이미지 등록 아이콘을 클릭할 경우 input file이 동작되며
    file을 선택시 아래 코드가 실행된다.
    아래 코드는 선택한 파일이 이미지인지 확인 후 이미지라면 미리보기에 등록하는 코드이다.
    */
    $('#list_image_input').change(function(){
        var files = this.files;
        var file_array = Array.prototype.slice.call(files);
        file_array.forEach(function(f){
            if(!f.type.match("image.*")){
                swal({
                    title: "Failed",
                    text: "이미지가 아닙니다.",
                    icon: "warning",
                    buttons: "false",
                    dangerMode: true
                });
                this.files=null;
                return;
            }
            list_image=f;
            sel_file = f;
            var reader = new FileReader();
            reader.onload = function(e){
                $('.product_list_image_choose').attr("src",e.target.result);
                $('.product_list_image_choose').css("display","block");
            };
            reader.readAsDataURL(f);
        });
    });

    $(document).ready(function() {
        $('#input_image').on("change", change_image);
    });
    function change_image(e)
    {
        var files = this.files;
        var success = false;
        var file_array = Array.prototype.slice.call(files);
        file_array.forEach(function(f){
            if(!f.type.match("image.*")){
                swal({
                    title: "Failed",
                    text: "이미지가 아닙니다.",
                    icon: "warning",
                    buttons: "false",
                    dangerMode: true
                });
                success=false;
                return;
            }
            success=true;
            sel_file = f;
            fitme_image=f;
            var reader = new FileReader();
            reader.onload = function(e){
                $('#product_upload_top_image').attr("src",e.target.result);
                $('#product_upload_top_image_box').css("border","1px grey solid");
            };
            reader.readAsDataURL(f);
        });
        if(success)
        {
            $('.product_upload_top_line').css("display","block");
            $('.upload_fitme_box_image_name').text(this.files[0].name);
        }
    }

    /*
    카테고리1번의 옵션을 바꿀 경우 이전에 선택해둔 사이즈 테이블과, 카테고리2번이 전부 초기화 되고 카테고리2번은 카테고리 1번에 맞추어 다시 셋팅된다.
    */
    $(".proudct_upload_top_product_category1").change(function(){
        $('.proudct_upload_top_product_category2').val("선택"); //카테고리2번을 0번인덱스 : "선택"으로 바꾼다.
        var option_count = $('.proudct_upload_top_product_category2 option').size(); //카테고리 2 번의 옵션의 개수를 가져온다. 아래코드로 전부 지우는 for문을 돌리기 위헤 가져오는 것이다.
        for (var i=1;i<option_count;i++)// 카테고리 2번의 옵션을 전부 지워준다 ( 0번인덱스 "선택"을 제외한 )
        {
            $('.proudct_upload_top_product_category2 option').eq(1).remove();
        }
        if($(this).val()!="선택")//카테고리1번에 따라 카테고리2번의 option 노드들을 추가해야함
        {
            var index=0;
            for(var number=0;number<category1.length;number++)
            {
                if(category1[number]==$(this).val())
                {
                    index=number;
                }
            }
            for(var i=0;i<JSON.parse(category2[index]).length;i++) //선택한 카테고리에 맞는 세부 카테고리를 찾고 세부카테고리의 개수만큼 반복하며 세부카테고리의 이름을 순서대로 옵션에 추가한다.
            {
                $('.proudct_upload_top_product_category2').append("<option>"+JSON.parse(category2[index])[i]+"</option>");
            }
        }
        $('.product_upload_top_size_table thead td').remove();
        $('.product_upload_top_size_table tbody tr').remove();
    });
    /*
    카테고리 2번이 바뀔 경우 이전에 추가했던 사이즈 테이블이 초기화 되며 카테고리에 맞는 사이즈 선택 옵션이 바뀌게 된다.
     */
    $('.proudct_upload_top_product_category2').change(function(){ //카테고리 2번을 바꿨을 경우
        $('.product_upload_top_size_table thead td').remove();
        $('.product_upload_top_size_table tbody tr').remove();
        if($(this).val()!="선택")
        {
            var option_count = $('.product_upload_top_addsize option').size(); //사이즈 카테고리의 옵션의 개수를 가져온다. 아래코드로 전부 지우는 for문을 돌리기 위헤 가져오는 것이다.
            for (var i=1;i<option_count;i++)// 사이즈카테고리의 옵션을 전부 지워준다 ( 0번인덱스 "사이즈추가(cm)"를 제외한 )
            {
                $('.product_upload_top_addsize option').eq(1).remove();
            }

            var index=0;
            for(var number=0;number<category1.length;number++)
            {
                if(category1[number]==$('.proudct_upload_top_product_category1').val())
                {
                    index=number;
                }
            }
            for(var i=0;i<JSON.parse(offer_size[index]).length;i++) //선택한 카테고리에 맞는 사이즈 옵션을 찾고 사이즈 옵션의 개수만큼 반복하며 사이즈 옵션 이름을 순서대로 옵션에 추가한다.
            {
                $('.product_upload_top_addsize').append("<option>"+JSON.parse(offer_size[index])[i]+"</option>");
            }

            for(var i=0;i<JSON.parse(offer_option[index]).length;i++) //선택한 카테고리에 맞게 사이즈 테이블을 추가한다.
            {
                var percent = 94/JSON.parse(offer_option[index]).length;
                if(i==0)
                {
                    $('.product_upload_top_size_table thead').append("<td style='width:"+percent+"%; height:40px; background-color:#CCCCCC;'>"+JSON.parse(offer_option[index])[i]+"</td>");
                }else
                {
                    $('.product_upload_top_size_table thead').append("<td style='width:"+percent+"%; border-left:0.1px white solid; height:40px; background-color:#CCCCCC;'>"+JSON.parse(offer_option[index])[i]+"</td>");
                }
            }
            $('.product_upload_top_size_table thead').append("<td style='width:6%; height:40px;'></td>");
        }
        else
        {
            $('.product_upload_top_size_table thead td').remove();
        }
    });
    $('.product_upload_top_addsize').change(function(){ //사이즈를 추가할때는 thead의 td태그의 개수만큼 반복하여 태그를 생성한다.
        var value="<tr style='cursor:pointer;'><td style='border-top:0.1px white solid; height:40px; background-color:#CCCCCC;'>"+$('.product_upload_top_addsize').val()+"</td>";
        for(var i=1;i<$('.product_upload_top_size_table thead td').length;i++)
        {
            if(i!=1)
            {
                if((i+1)==$('.product_upload_top_size_table thead td').length)
                {
                    var url = "../web/icon/delete_icon.png";
                    value+="<td style='height:40px;'><div type='number' onclick='button_click(this)' style='background-image:url("+url+"); background-size:100% 100%; text-align:center; margin-left:10%; width:90%; height:40px;'></div></td>";
                }
                else
                {
                    value+="<td style='border-left:0.1px #CCCCCC solid; height:40px;'><input type='number' style='text-align:center; width:100%; height:40px;'></td>";
                }
            }
            else
            {
                value+="<td style='height:40px;'><input type='number' style='text-align:center; width:100%; height:40px;'></td>";
            }
        }
        value+="</tr>";
        $('.product_upload_top_size_table tbody').append(value);
        $('.product_upload_top_addsize option:selected').remove();
        $(this).val()!="사이즈추가(cm)"
    });
    //사이즈테이블의 행을 삭제할 때 호출되는 함수
    function button_click(object)
    {
        swal({
            title: "사이즈삭제",
            text: "정말 "+$(object).parent().parent().children().eq(0).text()+"사이즈를 삭제 하시겠습니까?",
            icon: "warning",
            buttons: ["아니오","네"],
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                $(object).parent().parent().remove();
                var option_count = $('.product_upload_top_addsize option').size(); //사이즈 카테고리의 옵션의 개수를 가져온다. 아래코드로 전부 지우는 for문을 돌리기 위헤 가져오는 것이다.
                for (var i=1;i<option_count;i++)// 사이즈카테고리의 옵션을 전부 지워준다 ( 0번인덱스 "사이즈추가(cm)"를 제외한 )
                {
                    $('.product_upload_top_addsize option').eq(1).remove();
                }
                var index=0;
                for(var number=0;number<category1.length;number++)
                {
                    if(category1[number]==$('.proudct_upload_top_product_category1').val())
                    {
                        index=number;
                    }
                }
                for(var i=0;i<JSON.parse(offer_size[index]).length;i++) //선택한 카테고리에 맞는 사이즈 옵션을 찾고 사이즈 옵션의 개수만큼 반복하며 사이즈 옵션 이름을 순서대로 옵션에 추가한다.
                {
                    $('.product_upload_top_addsize').append("<option>"+JSON.parse(offer_size[index])[i]+"</option>");
                }
                //이미 추가되어있는 사이즈 옵션은 지워준다.
                for(var i=0;i<$('.product_upload_top_size_table tbody tr').length;i++)
                {
                    for(var size_option=1;size_option<$('.product_upload_top_addsize option').length;size_option++)
                    {
                        if($('.product_upload_top_addsize option').eq(size_option).val()==$('.product_upload_top_size_table tbody tr').eq(i).children().eq(0).text())
                        {
                            $('.product_upload_top_addsize option').eq(size_option).remove();
                        }
                    }
                }
                swal("해당 사이즈를 삭제했습니다.", {
                    icon: "success"
                });
            } else {
                swal("사이즈 삭제를 취소했습니다.");
    }
    });
    }

    //등록 버튼 클릭시 동작하는 함수 - 검증을 거친 뒤 서버로 전송한다.
    function product_upload_top_post()
    {
        if($('.product_upload_top_product_name').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "제품명을 입력하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('.product_upload_top_product_guid').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "상품 설명을 입력하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('.product_upload_top_product_price').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "상품 가격을 입력하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('.product_upload_top_product_stock').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "상품 재고를 입력하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('.proudct_upload_top_product_category1').val()=="선택")
        {
            swal({
                title: "제품 등록",
                text: "카테고리1을 선택하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('.proudct_upload_top_product_category2').val()=="선택")
        {
            swal({
                title: "제품 등록",
                text: "카테고리2를 선택하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('#input_image').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "옷입히기 이미지를 등록하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('#list_image_input').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "대표 이미지를(제품목록) 등록하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else if($('#detail_image_input').val().length<1)
        {
            swal({
                title: "제품 등록",
                text: "대표 이미지를(제품상세) 등록하세요",
                icon: "warning",
                dangerMode: true
            });
        }
        else
        {
            //사이즈를 제대로 입력했는지 검증하는곳이다.
            if($('.product_upload_top_size_table tbody tr').length>0)   //제일먼저 사이즈가 존재하는지 확인한다. 사이즈가 존재 해야만 조건문을 통과할 수 있다.
            {
                var size_array=new Object();    //사이즈표를 담을 객체를 생성한다.
                success=true;//사이즈표검증 통과를 참으로 만들어둔다. 하지만 아래 검증을 거치며 거짓으로 바뀔 수 있다.
                //카테고리별 제공하는 부위가 다르므로 테이블 헤드 내부의 td태그만큼 반복한다.
                for(var i=0;i<($('.product_upload_top_size_table thead td').length-1);i++)  //마지막에 삭제버튼이 들어가있는 태그를 제외한 상단 태그만큼 반복한다.
                {
                    size_array[$($('.product_upload_top_size_table thead td')[i]).text()] = new Array();
                    for(var ii=0;ii<$('.product_upload_top_size_table tbody tr').length;ii++)
                    {
                        if(i==0)
                        {
                            size_array[$($('.product_upload_top_size_table thead td')[i]).text()].push($($('.product_upload_top_size_table tbody tr').eq(ii).children('td')[i]).text());
                        }
                        else
                        {
                            if($($('.product_upload_top_size_table tbody tr').eq(ii).children('td')[i]).children('input').val().length<1)
                            {
                                var head = $($('.product_upload_top_size_table thead td')[i]).text();
                                if(head=="총장"||head=="어깨너비"||head=="허리")
                                {
                                    swal({
                                        title: "제품 등록",
                                        text: "총장, 어깨너비, 허리는 필수 입력사항입니다.",
                                        icon: "warning",
                                        dangerMode: true
                                    });
                                    success=false;
                                }
                                size_array[$($('.product_upload_top_size_table thead td')[i]).text()].push("-");
                            }
                            else
                            {
                                size_array[$($('.product_upload_top_size_table thead td')[i]).text()].push($($('.product_upload_top_size_table tbody tr').eq(ii).children('td')[i]).children('input').val());
                            }
                        }
                    }
                }
                if(success)
                {
                    $('#input_product_size').val(JSON.stringify(size_array));
                    Editor.save();
                }
            }
            else
            {
                swal({
                    title: "제품 등록",
                    text: "사이즈를 1개 이상 추가해주세요",
                    icon: "warning",
                    dangerMode: true
                });
            }
        }
    }


    // 아래부분은 daumeditor/editor.html 의 자바스크립트 함수들이다.
    /**
     * Editor.save()를 호출한 경우 데이터가 유효한지 검사하기 위해 부르는 콜백함수로
     * 상황에 맞게 수정하여 사용한다.
     * 모든 데이터가 유효할 경우에 true를 리턴한다.
     * @function
     * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
     * @returns {Boolean} 모든 데이터가 유효할 경우에 true
     */
    function validForm(editor) {
        // Place your validation logic here

        // sample : validate that content exists
        var validator = new Trex.Validator();
        var content = editor.getContent();
        if (!validator.exists(content)) {
            swal({
                title: "제품 등록",
                text: "본문 내용을(제품상세) 입력하세요",
                icon: "warning",
                dangerMode: true
            });
            return false;
        }
        return true;
    }

    /**
     * Editor.save()를 호출한 경우 validForm callback 이 수행된 이후
     * 실제 form submit을 위해 form 필드를 생성, 변경하기 위해 부르는 콜백함수로
     * 각자 상황에 맞게 적절히 응용하여 사용한다.
     * @function
     * @param {Object} editor - 에디터에서 넘겨주는 editor 객체
     * @returns {Boolean} 정상적인 경우에 true
     */
    function setForm(editor) {
        swal({
            title: "제품 등록",
            text: "제품을 FitMe에 등록 시겠습니까?",
            icon: "warning",
            buttons: ["아니오","네"],
            dangerMode: true
        }).then((willDelete) => {
            if (willDelete) {
                var images = new FormData();
                images.append("images[]",list_image);
                images.append("images[]",fitme_image);
                for(var i=0;i<detail_image.length;i++)
                {
                    images.append("images[]",detail_image[i]);
                }
                $.ajax({
                    type:"POST",
                    url:"./product_upload_server.php",
                    data : images,
                    contentType : false,
                    processData : false,
                    success: function(string){
                        if(string=='level')
                        {
                            swal({
                                title: "제품 등록",
                                text: "등록 권한이 부족합니다.",
                                icon: "warning",
                                buttons: ["네"],
                                dangerMode: true
                            }).then((willDelete) => {
                                location.href="http://49.247.136.36/main/main.php";
                        });
                        }
                        else if(string=='email')
                        {
                            swal({
                                title: "제품 등록",
                                text: "로그인 하셔야합니다.",
                                icon: "warning",
                                buttons: ["네"],
                                dangerMode: true
                            }).then((willDelete) => {
                                location.href="http://49.247.136.36/main/main.php";
                        });
                        }
                        $.ajax({
                            type:"POST",
                            url:"./product_upload_server.php",
                            data : {name:$('.product_upload_top_product_name').val(),ex:$('.product_upload_top_product_guid').val(),category1:$('.proudct_upload_top_product_category1').val()
                                ,category2:$('.proudct_upload_top_product_category2').val(),size:$('#input_product_size').val(),content:editor.getContent(),price:$('.product_upload_top_product_price').val(),
                                number:'submit',key:string,stock:$('.product_upload_top_product_stock').val()},
                            dataType : "text",
                            success: function(string){
                                swal({
                                    title: "제품 등록",
                                    text: "제품을 정상적으로 등록했습니다.",
                                    icon: "warning",
                                    buttons: ["네"],
                                    dangerMode: true
                                }).then((willDelete) => {
                                    location.href="http://49.247.136.36/shop/product_upload.php";
                            });
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            }else{
                swal("등록을 취소했습니다.");
    }
    });
    }
</script>
</body>
</html>