<?php
//원래라면 세션변수에 이메일이 저장되어 있어야한다.
session_start();
//쇼핑몰에서 넘어온 경우에는 아래 product부분에 제품번호가 들어있다.
//Session변수에 email이 존재하는지부터 확인해야한다.
if($_POST['email'])
{
    $_SESSION['email'] = $_POST['oauth_email'];

}
$email = $_SESSION['email'];
$product = $_GET['product'];
if(!$email) //현재 로그인이 안된 경우에는 로그인 페이지로 되돌려야한다.
{
    $_SESSION['URL'] = 'http://49.247.136.36/web/mainpage.php?product='.$product; //이 페이지로 다시 되돌아 오기 위해 세션에 이 페이지의 URL을 넣는다.

    $state = 'xyz';
    // 세션 또는 별도의 저장 공간에 상태 토큰을 저장
    $_SESSION['state'] = $state;

    echo '<script>location.href=\'http://15.165.80.29/oauth/authorize?client_id=ddb9468d-313f-42d7-a584-f7dd91696040&response_type=code&scope=read&state=xyz\'</script>'; //로그인 페이지로 이동한다.


}else
{
    //DB에 연결하는 코드이다.
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');

//DB에서 사용자 데이터 가져오기 ( email로 사용자를 조회한다 )
//가져온 데이터에는 사용자의 신체정보가 들어있다.
    $qry = mysqli_query($con,"select * from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    $my_tall = $row['height_length'];
    $my_leg_length = $row['leg_length'];
    $my_top_length = $row['top_length'];
    $my_waist = $row['waist_size'];
    $my_shoulder_length = $row['shoulder_length'];
    $my_chest = $row['chest_size'];
    $my_arm_length = $row['arm_length'];
    $my_thigh = $row['thigh_size'];
    $my_hip = $row['hip_size'];
    $my_ankle = $row['ankle_size'];

//가져온 사진 정보에는 JSON형태의 데이터가 들어가 있다.
//사진이 없는 경우에는 이전 페이지로 돌려보낸다. - 사진이 없는 사용자의 경우에는 아바타 같은것을 세워주는 방법도 생각해 봐야할듯
//JSON데이터를 배열로 변환한다.
    $photo = json_decode($row['photos'],true);
    if(!$photo)
    {
        Header("Location:/main/fitme_none_data.php?none_data=photo");
    }else if(!$my_tall){
        Header("Location:/main/fitme_none_data.php?none_data=tall");
    }

//사진 배열에서 사진의 경로와 필요한 관절 좌표들을 가져온다. ( 사진과 관절좌표는 동일한 인덱스로 0,1,2,3,4,5 와 같이 순차적으로 저장되어 있다. )
    $my_photo = $photo['photo'];
    $my_photo_location = $photo['location'];

//아래에서 이미지 태그의크기 지정에 사용될 원본 이미지의 크기이다.
    $size = getimagesize($my_photo[0]);
    $width = $size[0];
    $height = $size[1];
}
?>

<html>
<head>
<!--    현재 페이지에서 사용될 부트스트랩, Jquery, custom dialog, 폰트 등이 들어있다.-->
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Noto+Sans+KR&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Lobster&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>FITME</title>
    <style>
        body{
            font-family: 'Noto Sans KR', sans-serif;
        }
        /*페이지 상단부분의 사용자 신체정보와 정보수정 버튼이 있는 부분의 CSS*/
        #head_box{
            width:96%;
            height:60px;
            float:left;
            margin-left:2%;
            text-align:center;
        }
        /*페이지 상단 내부의 사용자 신체정보 CSS*/
        #head_box_text{
            /*font-family:'Lobster',cursive;*/
            height:30px;
            margin-top:12px;
            float:left;
            border:2px dimgrey solid;
            padding-left:20px;
            padding-right:20px;
            padding-top:5px;
            margin-left:2%;
            border-radius:5px;
        }
        /*페이지 상단 내부의 정보수정 버튼 CSS*/
        #modify_button{
            width:150px;
            background-color: dodgerblue;
            border: none;
            color:#fff;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 20px;
            margin-right: 2%;
            cursor: pointer;
            float:right;
            height:50px;
            margin-top:5px;
            border-radius : 10px;
            padding-top:10px;
        }
        /*페이지 상단 내부의 정보수정 버튼의 hover CSS*/
        #modify_button:hover {
            background-color: cornflowerblue;
        }
        /*페이지 내부에서 상단부를 제외한 CSS ( 중앙 박스라고 부르기 )*/
        #center_box{
            width: 96%;
            /*    높이는 임시로 설정*/
            height:90%;
            float:left;
            margin-left:2%;
        }
        /*중앙 박스에서 왼쪽 박스 --> 사용자의 사진과 드래그로 복사될 옷들이 존재할 부분이다.*/
        #left_box{
            width:58%;
            float:left;
            background-color:gainsboro;
        }
        /*중앙 박스에서 오른쪽 박스 --> 원본 옷들이 존재할 부분이다. */
        #right_box{
            width:40%;
            height:100%;
            float:right;
            border:1px solid;
        }
        /*왼쪽 박스에서 사용자의 사진이 들어갈 부분이다.*/
        #my_image{
            transition: all 0.3s ease-in-out;
            position:absolute;
            margin : 30px 0px 0px 30px;
        }
        /*오른쪽 박스에서 카테고리가 있는 부분이다.*/
        #table_list{
            width:100%;
            height:50px;
            cursor:pointer;
            text-align: center;
        }
        /*오른쪽 박스에서 카테고리가 있는 부분의 hover*/
        #table_list_td:hover{
            border-radius: 5px;
            background-color: indianred;
        }
        /*오른쪽 박스에서 옷 테이블이 있는 부분이다.*/
        #table{
            width:100%;
            margin-top:10px;
            border-top:1px gainsboro solid;
            border-bottom:1px gainsboro solid;
            text-align:center;
        }
        /*모달 공통사항*/
        .modal-content {
            border-radius: 0;
            border: none;
        }
        .modal-header {
            border-bottom-color: #EEEEEE;
            background-color: #FAFAFA;
        }
        /*우측에서 나오는 모달창*/
        .modal.right.fade .modal-dialog {
            right: -320px;
            -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
            -o-transition: opacity 0.3s linear, right 0.3s ease-out;
            transition: opacity 0.3s linear, right 0.3s ease-out;
        }
        /*우측에서 나오는 모달이며 튀어 나왔을때 우측에서 나와야 함으로 right:0 이다.*/
        .modal.right.fade.in .modal-dialog {
            right: 0;
        }

        /*좌측에서 나오는 모달창*/
        .modal.left.fade .modal-dialog{
            left: -320px;
            -webkit-transition: opacity 0.3s linear, left 0.3s ease-out;
            -moz-transition: opacity 0.3s linear, left 0.3s ease-out;
            -o-transition: opacity 0.3s linear, left 0.3s ease-out;
            transition: opacity 0.3s linear, left 0.3s ease-out;
        }
        /*좌측에서 나오는 모달이며 튀어 나왔을때 좌측에서 나와야 함으로 left:0 이다.*/
        .modal.left.fade.in .modal-dialog{
            left: 0;
        }
        /*좌우측 모달의 공통사항이다.*/
        .modal.left .modal-dialog,
        .modal.right .modal-dialog {
            position: fixed;
            margin: auto;
            width: 620px;
            height: 90%;
            text-align:center;
            -webkit-transform: translate3d(0%, 0, 0);
            -ms-transform: translate3d(0%, 0, 0);
            -o-transform: translate3d(0%, 0, 0);
            transform: translate3d(0%, 0, 0);
        }
        /*우측 모달의 중앙부분이다.*/
        .modal.right .modal-content {
            height: 100%;
            overflow-y: auto;
            border-bottom-left-radius: 10px;
            border-top-left-radius: 10px;
        }
        /*좌측 모달의 중앙부분이다.*/
        .modal.left .modal-content {
            height: 100%;
            overflow-y: auto;
            border-bottom-right-radius: 10px;
            border-top-right-radius: 10px;
        }
        /*좌우측 모달의 중앙부분이다.*/
        .modal.left .modal-body,
        .modal.right .modal-body{
            margin:30px 0px 50px 0px;
        }
        /*정보 수정에 사용될 모달의 사이즈이다.*/
        .modal-dialog.modal-80size {
            width: 900px;
            height: 100%;
            padding: 0;
        }
        /*정보 수정에 사용될 모달의 사이즈이다.*/
        .modal-content.modal-80size {
            height: auto;
            min-height: 80%;
            border-radius:10px;
        }
        /*정보 수정에 사용될 모달내부의 input입력창*/
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /*정보 수정에 사용될 모달내부의 input입력창의 label css*/
        #box_label {
            width:40%;
            float:left;
            padding-top:5px;
        }
        /*정보 수정에 사용될 모달내부의 input입력창 공통 css*/
        .form-control {
            width:40%;
            float:left;
            margin-left:20px;
        }
        /*왼쪽 박스의 사용자 사진에서 이미지 변경에 관한 부분이다.*/
        .img_prev, .img_next{
            cursor: pointer;
            position: absolute;
            top: 50%;
            padding: 15px;
            margin-top: -22px;
            color: white;
            font-weight: bold;
            font-size: 18px;
            transition: 0.6s ease;
        }
        /*왼쪽 박스의 사용자 사진에서 이미지 이전으로 넘기기*/
        .img_prev{
            margin-left:30px;
        }
        /*왼쪽 박스의 사용자 사진에서 이미지 넘기기 공통 hover*/
        .img_prev:hover, .img_next:hover {
            background-color: rgba(0,0,0,0.8);
        }
        /*왼쪽 박스의 사용자 사진에서 이미지 번호*/
        .img_number{
            color: #f2f2f2;
            font-size: 12px;
            padding: 8px 12px;
            position: absolute;
            margin-left:30px;
            margin-top:30px;
            top:60px;
            z-index:1000;
         }
        /*페이지 공통으로 scroll bark에 관한 css*/
        ::-webkit-scrollbar{width:13px; position:absolute;}
        ::-webkit-scrollbar-thumb{background-color:#c8c8c8; border-radius:5px;}
        ::-webkit-scrollbar-thumb:hover{background:#555;}
        ::-webkit-scrollbar-button { display: none; }
        /*::-webkit-scrollbar-button:start:decrement,::-webkit-scrollbar-button:end:increment{*/
        /*    width:13px; height:13px; background:#c8c8c8;*/
        /*}*/
    </style>
</head>
<body id="body">

<div id="head_box"><!--페이지 상단부 : 사용자의 신체정보와 정보수정 버튼이 들어갈 부분이다.-->
    <div id="head_box_text"><?php
        echo '키:'.$my_tall.'cm   팔길이:'.$my_arm_length.'cm   어깨:'.$my_shoulder_length.'cm   상체길이:'.$my_top_length.'cm   다리길이:'.$my_leg_length.
            'cm   가슴둘레:'.$my_chest.'cm   허리둘레:'.$my_waist.  'cm   허벅지둘레:'.$my_thigh.'cm   발목둘레:'.$my_ankle.'cm';
        ?></div> <!-- 사용자의 신체정보가 들어가있는 부분이다. 사용자 특정 신체와 옷의 특정 부분의 모든 수치 차이는 이 신체정보에 맞추어 보여준다. -->
    <div id="modify_button" type="button" data-toggle="modal" data-target="#modify_modal">정보수정</div> <!-- 사용자의 사진삭제와 신체정보를 수정할 수 있는 기능을 불러내는 버튼이다. -->
</div>

<div id="center_box"><!-- 페이지 상단부를 제외한 모든 부분이다. -->
    <div id="left_box"><!-- 좌측의 사용자의 사진과, 옷을 드래그해서 놓을수 있는 공간이 있는 부분이다. -->
        <div class="img_number">1 / <?php echo count($my_photo)?></div><!-- 사용자의 사진의 개수와 현재 출력된 사진의 번호가 적혀져있는 부분이다. -->
        <img id="my_image" src="<?php echo $my_photo[0];?>" style="align:center;"><!-- 사용자의 사진이 보여지는 부분이다. -->
        <a class="img_prev" onclick="img_change(0)">❮</a><!-- 이전 사진으로 넘기는 버튼이다. -->
        <a class="img_next" onclick="img_change(1)">❯</a><!-- 다음 사진으로넘기는 버튼이다. -->
        <div id="product_information_box" style="float:right; width:45%; margin:10px 10px 0px 0px; height:50px; display:none"> <!-- 제품을 드래그하거나 클릭했을 때 제품의 간단한 정보를 보여줄 부분이다. -->
            <div id="pi_box_product_size" style="width:50px; height:50px; border:2px black solid; float:left; border-radius:100%; color:white;
            font-weight:bold; text-align:center; padding-top:2px; background-color: black; font-size:26px;"></div><!-- 제품의 현재 사이즈를 보여줄 부분이다. -->
            <div id="pi_box_product_name" style="height:30px; margin-top:10px; width:80%; margin-left:10px; text-align: left; float:left; font-size:20px;"></div><!-- 제품의 이름을 보여줄 부분이다. -->
        </div>
    </div>

    <div id="right_box"><!-- 웹페이지 우측의 제품 카테고리와 제품목록이 있는 부분이다. -->
        <table id="table_list"><!-- 제품 카테고리 부분이다. 아래의 td태그로 총 4개의 카테고리로 분류한다. -->
            <td id="table_list_td" style="width:25%;"onclick="table_reload(0)">선택상품</td>
            <td id="table_list_td" style="width:25%;"onclick="table_reload(1)">Shop</td>
            <td id="table_list_td" style="width:25%;"onclick="table_reload(2)">찜한 상품</td>
            <td id="table_list_td" style="width:25%;"onclick="table_reload(3)">최근 본 상품</td>
        </table>
        <div id="table_line" style="width:20%; margin-left:2.5%; border:3px indianred solid;"></div> <!-- 제품 카테고리부분의 현재 선택한 카테고리를 나타내는 막대기 style은 초기값이며 유동적으로 변한다. -->
        <div id="table_div"> <!-- 제품 리스트가 있는 테이블을 감싸는 div이며 이부분을 부분 새로고침하여 테이블을 변경하는 중이다. -->
            <table id="table"> <!-- 제품 리스트가 있는 테이블이다. -->
                <!-- 제품 리스트 부분이며 이부분은 한줄을 임시로 만들어 두었다. 추가로 수정하여 동적으로 테이블에 제품들이 등록되도록 코드를 변경해야한다. -->
                <!-- 속성으로 제품마다 이 제품에 대한 서버의 식별값, 이미지경로, 제품이름, 제품사이즈, 이미지사이즈 등을 담고있다. -->
                <tr style="height:180px;">
                    <td onclick="image_move(this)" style="width:20%; border-right:1px gainsboro solid; background-image: url(<?php
                    mysqli_set_charset($con,'utf8');
                    $qry = "select * from product where product_key=$product";
                    $send = mysqli_query($con,$qry);
                    $row = mysqli_fetch_array($send);
                    echo $row['fitme_image'];
                    ?> ); background-size:100% 100%;" product-key="<?php echo $product;?>"
                        product-url="<?php echo $row['fitme_image'];?>" product-name="<?php echo $row['name'];?>" product-size="<?php echo str_replace("\"","@",$row['size']); ?>"
                        product-image-size="<?php $size_temp_array = getimagesize($row['fitme_image']);  echo $size_temp_array[0].'@'.$size_temp_array[1] ?>"
                    product-position="<?php echo str_replace("\"","@",$row['line_position'])?>""></td>
                    <td style="width:20%; border-right:1px gainsboro solid;">X</td>
                    <td style="width:20%; border-right:1px gainsboro solid;">X</td>
                    <td style="width:20%; border-right:1px gainsboro solid;">X</td>
                    <td>X</td>
                </tr>
            </table>
        </div>
    </div>
</div>

<!-- 페이지 상단 우측의 정보수정 버튼을 클릭시 나오는 모달창이다. 부트스트랩을 이용하여 만들었다. -->
<div class="modal fade" id="modify_modal" tabindex="-1" role="dialog" aria-labelledby="my80sizeModalLabel">
    <div class="modal-dialog modal-80size" role="document" id="modify_modal_content">
        <div class="modal-content modal-80size">
            <div class="modal-header" style="border-radius:10px;"> <!-- 모달의 상단부분이다. -->
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <!-- 모달창을 닫는 버튼이다. -->
                <h4 class="modal-title" id="myModalLabel" style="text-align: center;">신체정보수정</h4> <!-- 모달의 상단의 텍스트 부분이다. -->
            </div>
            <div class="modal-body" id="modify_modal_body" style="text-align: center; border:1px solid;"><!-- 모달의 중앙 부분이다. -->
                <div class="modify_photos" style="overflow:hidden; height:580px; margin-top:10px; margin-bottom:10px;"><!-- 모달 중앙의 가장 상단의 사진들이 보여지는 부분이다. -->
                    <div class="photo_left"style="background-image:url('<?php echo $my_photo[0]?>'); background-size:100% 100%; float:left; width:360px; height:570px;
                            margin-top:10px; margin-left:10px;"></div> <!-- 사진들중 좌측의 큰 사진 부분이다. -->
                    <div id="modify_photos_list" style="border:1px solid; width:438px; height:525px; float:right; margin:10px 0px 0px 10px;"><!-- 사진들중 우측의 사진목록 을 감싼 부분이다. -->
                        <!-- 사진목록 부분으로 db에 등록된 사용자의 사진들을 모두 출력한다. 공통적으로 관리하기 위해 class는 thumbnail로 공통이며 id는 제각각 다르다. -->
                        <?php
                        for($num = 0 ; $num<count($my_photo) ; $num++) {
                            ?>
                            <div id="thumbnail_<?php echo $num ?>" class="thumbnail"
                                 onclick="thumbnail_change(<?php echo $num ?>,this)"
                                 style="background-image:url('<?php echo $my_photo[$num] ?>');
                                         background-size:100% 100%; float:left; width:135px; height:240px; margin:5px;"></div>
                            <?php
                        }
                        ?>
                    </div>
                    <div id="modify_photos_delete" onclick="photos_delete()" style="cursor:pointer; border:1px solid; width:438px; font-size:20px; background-color:#E8F5FF;
                    height:40px; float:right; margin:5px 0px 0px 10px;"><!-- 사진 목록에서 선택한 사진들을 삭제하는 버튼이다. -->
                        <div style="width:240px; height:40px; float:left;"><!-- 버튼내부의 왼쪽부분이다. -->
                            <img src="./icon/delete_icon.png" style="max-height:40px;float:right;"><!-- 버튼내부의 왼쪽부분에는 쓰레기통 이미지를 넣었다. -->
                        </div>
                        <div id="modify_photos_delete_text" style="float:left; padding-top:10px;"></div><!-- 버튼내부의 오른부분에는 현재 선택한 이미지 개수를 출력하기 위해 div공간을 만들어 두었다. -->
                    </div>
                </div>
                <div style="width:96%; height:3px; margin-left:2%; border-top:1px darkgrey solid;"></div> <!-- 사용자 사진들과 아래 신체정보를 구분짓기 위한 선이다. -->
                <form method="post" action="./modify_body_information.php"><!-- 사용자의 변경된 신체정보를 서버에 전송하기 위한 form 태그이다. -->
                    <div class="modify_body_information" style="width:90%; margin-left:5%; font-size:16px;">
                        <!-- 사용자의 변경된 신체정보를 서버에 전송하기 위한 form 태그이다. 아래는 사용자 식별 및 서버 처리 구분을 위한 데이터, 서버에 데이터 전송 후 되돌아왔을 때 위치를 잡기위한 데이터이다. -->
                        <input class="product_hidden" style="display:none;" name="product_number" value="<?php echo $product?>">
                        <input class="modify_email_hidden" style="display:none;" name="modify_email" value="<?php echo $email?>">
                        <input class="modify_number_hidden" style="display:none;" name="modify_number" value="0">
                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                        <!-- 아래 box class로 감싼 부분에는 신체정보에 관해 입력할 수 있는 input태그와 input태그의 label이 들어있다. -->
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_tall_value">키</div>
                            <input id="modify_tall_value" type="number" class="form-control" name="modify_tall" value="<?php echo $my_tall?>">
                        </div>
                        <div class="box" style=" width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_arm_value">팔길이</div>
                            <input id="modify_arm_value" class="form-control" type="number" name="modify_arm" value="<?php echo $my_arm_length?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_shoulder_value">어깨</div>
                            <input id="modify_shoulder_value" class="form-control" type="number" name="modify_shoulder" value="<?php echo $my_shoulder_length?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_top_value">상체길이</div>
                            <input id="modify_top_value" class="form-control" type="number" name="modify_top" value="<?php echo $my_top_length?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_leg_value">다리길이</div>
                            <input id="modify_leg_value" class="form-control" type="number" name="modify_leg" value="<?php echo $my_leg_length?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_chest_value">가슴둘레</div>
                            <input id="modify_chest_value" class="form-control" type="number" name="modify_chest" value="<?php echo $my_chest?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_waist_value">허리둘레</div>
                            <input id="modify_waist_value" class="form-control" type="number" name="modify_waist" value="<?php echo $my_waist?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_thigh_value">허벅지둘레</div>
                            <input id="modify_thigh_value" class="form-control" type="number" name="modify_thigh" value="<?php echo $my_thigh?>">
                        </div>
                        <div class="box" style="width:30%; float:left; margin:10px; 0px 0px 10px;">
                            <div id="box_label" for="modify_ankle_value">발목둘레</div>
                            <input id="modify_ankle_value" class="form-control" type="number" name="modify_ankle" value="<?php echo $my_ankle?>">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-default" value="수정" style="width:200px; vertical-align: center; margin-top:40px; border: none; font-size:20px; cursor:pointer" > <!-- submit으로 클릭시 form태그가 작동한다. ( 서버로 데이터 전송 ) -->
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 제품의 상세정보(모든 사이즈 정보)를 담고있는 모달창에 대한 태그이다. -->
<div class="modal right fade" id="myModalR" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button> <!-- 모달창을 닫는 버튼이다. -->
                <h4 class="modalR-title" id="myModalLabel2"></h4><!-- 제품의 이름이 들어갈 부분으로 선택한 제품에 따라서 동적으로 변경된다. -->
            </div>

            <div class="modal-body"><!-- 모달의 중앙부분이다. -->
                <div id="modalR-size" style="margin:10px 0px 0px 10px; padding:10px 15px 10px 15px; border-radius:50%;
                 background-color:black; color:white; float:left; text-align:center; font-size:20px; padding:"></div><!-- 선택한 제품의 사이즈를 나타내는 부분으로 선택한 제품에 따라서 동적으로 변경된다. -->
                <img id="modalR-img" src="<?php echo $my_photo[0];?>" style="max-width:45%;"><!-- 제품 이미지가 들어올 부분으로 선택한 제품에 따라서 동적으로 변경된다. -->
                <table id="modalR-table" style="text-align: center; width:90%; margin-top:10px; font-size:10px; margin-left:5%;"><!-- 선택한 제품의 모든 사이즈를 표 형태로 보여주는 부분이다. -->
                    <thead style="background-color:gainsboro;">
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <div style="margin-top:50px;"></div>
                <div id="modalR_button" style="width:100%; height:100px;"></div>
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<!--아래는 제품과 사용자의 신체정보를 비교할 수 있는 모달창에 대한 태그이다. -->
<div class="modal left fade" id="myModalL" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> <!-- 모달창을 닫는 버튼 -->
                <h4 class="modalL-title" id="myModalLabel"></h4> <!-- 사용자가 제품과 신체를 비교하기 위해 선택한 제품의 특정 부분을 text형태로 넣어줄 부분이다. -->
            </div>
            <table id="modalL_table" style="margin-top:10px; margin-left:10px; width:580px; height:40px;"></table><!-- 제품이 제공하는 툭정 부위를 카테고리화 해 두었다. ( 현재는 모든 카테고리를 출력하지만 추후에 사용자가 잴 수 있는 부분일 경우에만 출력하도록 변경해야한다. -->
            <div class="modal-body" id="modalL-body" style="width:600px; font-size:15px; font-weight:bold">
                <div id="modalL-img-box" style="width:570px;"> <!-- 사용자 신체, 제품 부위의 시각화 기능을 감싼 부분 -->
                    <img id="modalL-img" style="width:80%;"><!-- 제품과 사용자의 신체의 길이,둘레 차이를 시각화 하여 보여주기 위한 태그이다. -->
                </div>
                <div id="modalL-temp-text"></div> <!-- 사용자와 제품의 특정부위를 비교하여 길이차를 텍스트로 표현해 준 부분이다. -->
            </div>
        </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

</body><!-- container -->

<script>
    $('#body').css({"width":$(window).width()+"px", "height":$(window).height()+"px"});
    console.log('윈도우창크기'+$(window).width());
    console.log('윈도우창크기'+$(window).height());
    var fitme_category = {"아우터":["가디건","재킷","집업","점퍼","야상","코트","패딩"],"상의":["티셔츠","니트","셔츠","맨투맨","후드","블라우스","나시"],"스커트":["미니","미디","롱"],
        "바지":["일자바지","슬랙스","반바지","와이드팬츠","스키니팬츠","부츠컷팬츠","조커팬츠","치마바지","멜빵바지","크롭팬츠","배기팬츠","레깅스"],"원피스":["미니","미디","롱","투피스","점프수트"],"기타":["기타"]};

    var delete_image_array = new Array; //이 변수는 정보수정에서 사용자가 삭제를 위해 선택한 이미지들의 절대경로명을 저장할 배열이며, 이 절대경로는 서버 내부에서 사용자의 이미지를 식별할 데이터이다.
    var double_click = true; //이미지 더블클릭 방지 ( 정보수정창에서 삭제할 이미지를 더블클릭함에 있어서 방지하기 위한 변수 )
    var all_click_count=0; //이 변수는 제품을 선택(클릭), 선택취소(클릭한 제품을 또 클릭)를 식별하기 위한 변수이다.
    /*
    이 변수는 제품을 선택(클릭), 선택취소(클릭한 제품을 또 클릭했을 때)와 그 외의 클릭을 식별하기 위한 변수이다.
    이 변수는 페이지 내부의 어떤 부분을 클릭하더라도 1이 되며 -> 이 변수가 1일 경우에는 모든 제품이 선택 취소가 된다.
    하지만 제품을 선택한 경우에도 이 변수가 +1이 되어서 제품을 선택한 경우에는(all_click_count가 1인 경우) 이 변수는 0으로 변경한다.
    따라서 제품을 선택한 경우에는 이 변수는 아무 동작을 하지 않고 제품 이외의 클릭이 있을 경우에는 모든 제품이 선택 취소가 된다.
    */
    var body_click=1;

    var product_category=0;//제품과 사용자의 신체정보를 비교할 때 비교할 특정 부위 카테고리의 개수를 저장할 변수이다.

    /*
    image_array = DB에서 조회하여 찾은 사용자 사진들의 절대경로 문자열을 Json에서 Array 형태로 변경하여 저장 ( 초기에 단 한번만 DB에서 넣어준다.   추후에는 이미지 삭제시에 동적으로 변경된다. )
    JsonImage = image_array에서 사용할 수 있도록 문자열들을 치환하여 저장
    my_photo_count = JsonImage의 개수(사용자 사진의 개수)를 저장한 변수이다.          정보 수정 기능에서 사용자의 이미지 목록부분의 스크롤의 생성 유무를 결정한다.
    */
    var image_array = '<?php echo json_encode($my_photo)?>';
    var JsonImage = JSON.parse(image_array.replace(/"/gi,"\""));
    var my_photo_count = JsonImage.length;

    //사용자의 사진이 7개 이상일 경우에는 정보 수정 기능에서 사용자의 이미지 목록의 스크롤을 생성시킨다.
    if(JsonImage.length>6)
    {
        $('#modify_photos_list').css({"overflow-y":"scroll","width":"455px"});
        $('#modify_photos_delete').css({"width":"455px"});
    }

    var now_image=1;    //페이지 좌측의 이미지 내부에 보여지는 사용자 이미지의 번호이다. 최초에는 1로 지정한다.
    var center_box_height = $("#center_box").height();  //페이지의 중앙부분을 감싼 부분의 높이이다. 이 높이를 사용하여 페이지 좌측의 이미지를 감싼 부분의 높이를 결정한다.
    $("#left_box").height(center_box_height);   //페이지 좌측의 이미지를 감싼 부분의 높이를 위에서 구한 변수의 높이로 지정한다.
    $("#my_image").height(center_box_height/10*9);  //페이지 좌측의 이미지의 높이는 부모 노드의 90%로 설정한다.    이 높이에 따라 이미지 가로해상도는 비율에맞게 축소, 확대 된다.

    /*
    이미지 변경버튼(next)의 위치를 지정해 주기위해 아래의 과정을 거친다.
    1. 리사이즈된 이미지의 가로 픽셀을 구한다.
    2. 이미지의 가로픽셀에서 버튼의 가로픽셀을 뺀다.
    3. 2번의 결과값에서 이미지의 좌측 공백픽셀을 더한다.
    4. 나온 결과값을 버튼의 좌측 공백으로 지정한다.
    */
    var width = $("#my_image").width();
    var a_left = width-$('.img_next').width()+parseFloat($("#my_image").css('left').replace('px',''));
    $(".img_next").css({"left":a_left});

    //이미지의 원본 가로픽셀과 세로픽셀을 구한다.
    //구한 원본 이미지의 픽셀과 리사이징한 이미지의 픽셀과의 비율 차이를 통해 사용자의 관절 위치를 재조정한다.
    var default_image_width = <?php echo $width;?>;
    var default_image_height = <?php echo $height; ?>;

    //관절구조를 저장할 Array를 생성시킨다.
    var skeleton_array = new Array();
    /*
    위에서 생성시킨 Array에 리사이징한 이미지에 맞추어 관절좌표를 구해서 저장한다.
    0번 인덱스 : 사용자의 머리Y축 좌표
    1번 인덱스 : 사용자의 허리Y축 좌표
    2번 인덱스 : 사용자의 발끝Y축 좌표
     */
    <?php
    for($i=0;$i<3;$i++){ ?>
    var i = <?php echo (int)$i; ?>;
    var default_dot = <?php echo (double)$my_photo_location[0][$i]; ?>;
    skeleton_array[i] = width*default_dot/default_image_width + 30;
    <?php } ?>

    /*
    사진을 삭제할 때 호출되는 함수이다.
    사진 삭제는 정보수정 버튼을 통해 생성되는 모달창 내부에서 할 수 있다.
     */
    function photos_delete()
    {
        //삭제할 사진이 존재할 경우에만 작동한다.
        if(delete_image_array.length>0)
        {
            //만약 모든 사진을 삭제하게 된다면 FitMe기능을 사용할 수 없으므로 이전페이지로 되돌아간다.
            //사용자에게 위와같이 FitMe기능을 사용할 수 없다는 안내문 형식의 메세지를 보여주고 삭제한다면 FitMe페이지의 이전페이지로 되돌아가게 된다.
            if(delete_image_array.length==JsonImage.length)
            {
                swal({
                    title: "사진 삭제",
                    text: "사진을 전부 삭제하면 더이상 FitMe 기능을 이용할 수 없습니다.    정말 삭제하시겠습니까?",
                    icon: "warning",
                    buttons: ["아니오","네"],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"./modify_body_information.php",
                            data : {modify_number : "1", delete_image : delete_image_array, email : "<?php echo $email?>"},
                            dataType : "text",
                            success: function(string){
                                if(string=="success")
                                {
                                    history.go(-1);
                                }else if(string=="fail")
                                {
                                    swal("사진삭제에 실패했습니다.", {
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                        });
                    } else {
                        //사진삭제 안내 메세지에서 삭제를 취소할 경우에는 아래와 같이 삭제를 위해 선택한 사진들이 선택 취소가 된다.
                        var temp = new Array;
                        delete_image_array = temp;
                        $('.thumbnail').css("border","none");
                        $('#modify_photos_delete_text').text(" ");
                        swal("사진 삭제를 취소했습니다.");
                    }
                    });
            }
            else
            {
                //사진 삭제 후에도 한개이상의 사진이 남아있을 경우에 아래 코드가 작동한다.
                //삭제할 사진 개수를 안내해주며 정말 삭제할꺼냐는 경고 메세지를 보여준다.
                swal({
                    title: "사진 삭제",
                    text: "정말 "+delete_image_array.length+"개의 사진을 삭제 하시겠습니까?",
                    icon: "warning",
                    buttons: ["아니오","네"],
                    dangerMode: true,
                })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type:"POST",
                            url:"./modify_body_information.php",
                            data : {modify_number : "1", delete_image : delete_image_array, email : "<?php echo $email?>"},
                            dataType : "text",
                            success: function(string){
                                if(string=="success")
                                {
                                    /*
                                    사진들이 정상적으로 삭제될 경우에 작동하는 기능들
                                    1. 사진삭제완료 메세지를 보여준다.
                                    2. 기존에 삭제를 위해 선택한 사진들을 삭제시킨다.
                                    3. 존재하는 사진들의 절대경로를 저장한 JsonImage 배열을 재구성한다. - 삭제된 사진을 없애는 작업
                                    4. 보여주는 사진을 삭제하지않고 여전히 존재하는 사진들 중 0번째 인덱스의 사진으로 보여준다.
                                    5. 신체정보수정 외부의에서 페이지 좌측의 이미지개수와, 보여지는 이미지 또한 존재하는 이미지의 개수와, 존재하는 이미지로 변경한다.
                                     */
                                    swal("사진을 삭제했습니다.", {
                                        icon: "success",
                                    });
                                    for(var number=0;number<$('.thumbnail').length;number++)
                                    {
                                        var object = $('.thumbnail')[number];
                                        if($(object).css("border")=="5px solid rgb(51, 51, 51)")
                                        {
                                            $(object).remove();
                                            JsonImage.splice(number,1);
                                            number--;
                                        }
                                    }
                                    var temp = new Array;
                                    delete_image_array = temp;
                                    $('#modify_photos_delete_text').text(" ");
                                    $('.photo_left').css("background-image","url('"+JsonImage[0]+"')");
                                    my_photo_count = JsonImage.length;
                                    now_image=1;
                                    $('.img_number').text(now_image+" / "+my_photo_count);
                                    $("#my_image").attr("src",JsonImage[now_image-1]);
                                    if(JsonImage.length<7)
                                    {
                                        $('#modify_photos_list').css({"overflow-y":"hidden","width":"438px"});
                                        $('#modify_photos_delete').css({"width":"438px"});
                                    }
                                }else if(string=="fail")
                                {
                                    swal("사진삭제에 실패했습니다.", {
                                        icon: "error",
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                alert(error);
                            }
                        });
                    } else {
                        //사진삭제 안내 메세지에서 삭제를 취소할 경우에는 아래와 같이 삭제를 위해 선택한 사진들이 선택 취소가 된다.
                        var temp = new Array;
                        delete_image_array = temp;
                        $('.thumbnail').css("border","none");
                        $('#modify_photos_delete_text').text(" ");
                        swal("사진 삭제를 취소했습니다.");
                    }
                    });
            }
        }
    }

    //정보수정 모달창 내부의 이미지 삭제를 위해 사진을 클릭했을 때 동작하는 함수이다.
    function thumbnail_change(number,object)
    {
        if(double_click) //이 변수가 true일 경우에만 동작
        {
            double_click=false; //이함수가 동작하는 동안에는 이 함수를 중복 호출시킬수 없도록
            /*
        만약 클릭한 이미지가 이미 클릭되어 있는 경우 ( 삭제 취소를 위한 클릭 )
        1. 해당 이미지를 선택했다고 구분짓기 위해 두껍게 변경한 테두리를 없앤다.
        2. 삭제를 위해 저장한 삭제이미지 배열에 선택 취소한 해당 이미지를 제거한다.
         */
            if($('#'+object.id).css("border")=="5px solid rgb(51, 51, 51)")
            {
                $('#'+object.id).css("border","none");
                var temp_array = new Array;
                for(var i=0;i<delete_image_array.length;i++)
                {
                    if(delete_image_array[i]!=JsonImage[number])
                    {
                        temp_array.push(delete_image_array[i]);
                    }
                }
                delete_image_array = temp_array;
            }
            else
            {
                /*
                만약 클릭한 이미지가 이전에 클릭되지 않았을 경우 ( 삭제를 위한 클릭 )
                1. 해당 이미지를 선택했다고 구분짓기 위해 테두리를 두껍게 변경한다.
                2. 삭제를 위해 저장한 삭제이미지 배열에 선택한 해당 이미지를 추가한다.
                 */
                $('#'+object.id).css("border","5px solid");
                delete_image_array.push(JsonImage[number]);
            }
            //이미지목록 좌측에 크게 보여지는 이미지를 클릭한 이미지로 변경한다.
            $('.photo_left').css("background-image","url('"+JsonImage[number]+"')");

            //이미지목록 하단에 선택한 이미지 개수를 변경한다.
            //만약 삭제를 위해 선택한 이미지 개수가 1개 이하라면 텍스트는 삭제한다.
            if(delete_image_array.length<1)
            {
                $('#modify_photos_delete_text').text(" ");
            }
            else
            {
                $('#modify_photos_delete_text').text("("+delete_image_array.length+")");
            }

            setTimeout(function(){
                double_click = true; //다시 이 함수를 사용할 수 있도록 변경
            },200);//0.2초로 하면 더블클릭을 방지 할 수 있음.. -> 테스트 결과
        }
    }

    //페이지 좌측의 사용자 이미지를 변경하는 함수이다.
    function img_change(a)
    {
        /*
        매개변수 a는 prev인지(이전사진) next인지(다음사진) 구분하기 위한 변수이다.
        a가 0일 경우에는 이전사진으로 변경하며
        a가 1일 경우에는 다음사진으로 변경한다.
        현재 보여주는 이미지번호를 저장한 now_image의 번호를 변경하며 이미지를 변경한다.
        만약 보여줄 이미지가 없는 경우 ( now_image가 1일때 이전이미지 , now_image가 사진개수와 동일할 때 다음 이미지 )에는 사진이 변경되지 않는다.
         */
        if(a==0)
        {
            if(now_image>1)
            {
                now_image--;
            }
        }
        else if(a==1)
        {
            if(now_image<my_photo_count)
            {
                now_image++;
            }
        }
        $('.img_number').text(now_image+" / "+my_photo_count);
        $("#my_image").attr("src",JsonImage[now_image-1]);
    }


    //////////////////////////////////////////////////////////////////// 코드 수정, 추가 작업 1순위 ////////////////////////////////////////////////////////////////////////////

    function category_click2(a,b)
    {
        // console.log(a+" / "+b);
        $("#table").empty();
        $("#table").append("<tr style='height:60px;'><td style='width:100%;' colspan='5'><button class='btn btn-primary' style='width:100px; height:40px;' onclick='category_click(\""+a+"\")';>뒤로가기</button></td></tr>");
        <?php
        $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
        mysqli_set_charset($con,'utf8');
        $qry = "select * from product";
        $send = mysqli_query($con,$qry);
        $number = mysqli_num_rows($send);
        $key_array=array();
        $url_array=array();
        $name_array=array();
        $size_array = array();
        $line_array = array();
        $category1= array();
        $category2 = array();
        while($row = mysqli_fetch_array($send)){
            array_push($key_array,$row['product_key']);
            array_push($url_array,$row['fitme_image']);
            array_push($name_array,$row['name']);
            array_push($category1,$row['category1']);
            array_push($category2,$row['category2']);
            array_push($size_array, str_replace("\"","@",$row['size']));
            array_push($line_array, str_replace("\"","@",$row['line_position']));
        }
        ?>
        $("#table").append("<tr style='height:1px; border-bottom:1px grey solid;'><td style='width:20%;'></td><td style='width:20%;'></td><td style='width:20%;'></td><td style='width:20%;'></td><td style='width:20%;'></td></tr>");
        var add_table="";
        var number_con=0;
        <?php
        for($array_count=0;$array_count<$number;$array_count++){
            ?>
        var category1 = '<?php echo $category1[$array_count];?>';
        var category2 = '<?php echo $category2[$array_count];?>';
            if(category1==a&&category2==b)
            {
                if(number_con==0)
                {
                    add_table+="<tr style='height:180px'>";
                }
                add_table+="<td onclick='image_move(this)' style='width:20%; border-bottom:1px gainsboro solid; border-right:1px gainsboro solid; background-image: url(\" <?php echo $url_array[$array_count]?> \"); background-size:100% 100%;' product-key=\"<?php echo $key_array[$array_count]?>\" product-url=\"<?php echo $url_array[$array_count]?>\" product-name=\"<?php echo $name_array[$array_count]?>\" product-size=\"<?php echo $size_array[$array_count];?>\" product-image-size=\"<?php $size_temp_array = getimagesize($url_array[$array_count]);  echo $size_temp_array[0] . '@' . $size_temp_array[1] ?>\" product-position=\"<?php echo $line_array[$array_count]; ?>\"></td>";
                var hm=false;
                if(number_con==4){
                    hm=true;
                }
                <?php
                    if($array_count+1==$number){
                        ?> hm=true; <?php
                    }
                    ?>
                if(hm){
                    number_con = 0;
                    add_table += "</tr>";
                }
                else
                {
                    number_con++;
                }
            } <?php
        } ?>
        $("#table").append(add_table);
    }


    function category_click(a)
    {
        $("#table").empty();
        var category = "";
        category +="<tr style=height:60px; border-bottom:1px grey solid;><td colspan='3'><button class='btn btn-primary' style='width:100px; height:40px;' onclick='table_reload(1)';>뒤로가기</button></td></tr>";
        recount=0;
        for(var i=0;i<fitme_category[a].length;i++)
        {
            if(recount==0)
            {
                category +="<tr style='height:150px'>";
            }
            category +="<td style='width:33%;'><div onclick='category_click2(\""+a+"\",\""+fitme_category[a][i]+"\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px; border-radius:100%; background-color:black; width:60%; margin-left:20%; height:100px; color:white;'>"+fitme_category[a][i]+"</div></td>";
            recount++;
            if(recount==3)
            {
                category +="</tr>";
                recount=0;
            }
        }
        $("#table").append(category);
        $('.category_hover')
            .css({"font-family":"\'Lobster\',cursive","font-size":"1.3em"})
            .hover(function(){
                $(this).css("background-color","#787878");
            }, function(){
                $(this).css({"background-color": "black"});
            });
    }

    //이부분은 페이지 우측에 옷 목록을 나열한 테이블에 대한 함수이며, 테이블 상단의 카테고리 클릭시 작동하는 함수이다.
    function table_reload(arg){
        if(arg==0){
            //가장 첫번째 카테고리이다. - 첫번째 카테고리는 선택한 옷만 출력되도록 설정해 두었다.
            document.getElementById('table_line').style.marginLeft='2.5%';
            $("#table_div").load(document.URL+" #table");
        }else if(arg==1){
            //두번째 카테고리이다. - 두번째 카테고리는 우리 서비스에서 가지고있는 모든 옷들을 보여주도록 설정해 준다.
            document.getElementById('table_line').style.marginLeft='27.5%';

            //두번째 카테고리에서는 제일 처음 제품 카테고리를 보여준다.
            $("#table").empty();
            var category = "";
            category +="<tr style='height:150px;'>";
            category +="<td style='width:33%;'><div onclick='category_click(\"아우터\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px; border-radius:100%; background-color:black; width:40%; margin-left:30%;  height:100px; color:white;'>outer</div></td>";
            category +="<td style='width:33%;'><div onclick='category_click(\"상의\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px;border-radius:100%; background-color:black; width:40%; margin-left:30%; height:100px; color:white;'>top</div></td>";
            category +="<td style='width:33%;'><div onclick='category_click(\"스커트\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px;border-radius:100%; background-color:black; width:40%; margin-left:30%; height:100px; color:white;'>skirt</div></td>";
            category +="</tr>";
            category +="<tr style='height:150px;'>";
            category +="<td style='width:33%;'><div onclick='category_click(\"바지\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px;border-radius:100%; background-color:black; width:40%; margin-left:30%; height:100px; color:white;'>pants</div></td>";
            category +="<td style='width:33%;'><div onclick='category_click(\"원피스\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px;border-radius:100%; background-color:black; width:40%; margin-left:30%; height:100px; color:white;'>onepiece</div></td>";
            category +="<td style='width:33%;'><div onclick='category_click(\"기타\")' class='category_hover' style='cursor:pointer; vertical-align: middle; line-height:100px;border-radius:100%; background-color:black; width:40%; margin-left:30%; height:100px; color:white;'>기타</div></td>";
            category +="</tr>";
            $("#table").append(category);
            $('.category_hover')
                .css({"font-family":"\'Lobster\',cursive","font-size":"1.3em"})
                .hover(function(){
                    $(this).css("background-color","#787878");
                }, function(){
                    $(this).css({"background-color": "black"});
                });
        }else if(arg==2){
            //3번째 카테고리이다. 추후에 찜한 제품들을 보여줄 예정이다.
            document.getElementById('table_line').style.marginLeft='52.5%';
        }else if(arg==3){
            //4번째 카테고리이다. 추후에 가장최근에 본 제품 여러개를 보여줄 예정이다.
            document.getElementById('table_line').style.marginLeft='77.5%';
        }else{
            //존재하지 않는 카테고리를 URL에 입력햇을 경우 첫번째 카테고리를 보여주도록 설정한다.
            document.getElementById('table_line').style.marginLeft='2.5%';
        }
    }

    //////////////////////////////////////////////////////////////////// 코드 수정, 추가 작업 1순위 ////////////////////////////////////////////////////////////////////////////

    var click_zindex = 1; //동적으로 생성되는 오브젝트들의 zindex를 설정할 변수이다. 생성된 옷들을 클릭할 때마다 1씩 증가하며 다음 옷을 생성할 때 이 변수를 통해 zindex를 지정해준다.
    var click_product; //제품이미지 클릭시 해당제품 객체를 저장한다. -> 나중에 제품 클릭시 선택, 선택취소 기능에 사용하기 위한 변수이다.

    /*
    제품 이미지 동적 생성 및 제품 이미지 드래그 이동을 위한 함수이다.
    기존에 페이지 우측에 존재하는 제품 이미지목록 테이블에서 제품 태그를 클릭하면 동작한다.
    매개변수는 클릭한 태그 자체이다.
     */
    function image_move(object)
    {
        /*
        아래 제품 선택, 선택 취소에 관한 변수 두개 ( all_click_count와 body_click )를 0으로 초기화 시킨다.
         */
        all_click_count=0;
        body_click=0;

        /*
        기존에 생성되어 있던 모든 제품들을 선택 취소하게 되는 것이므로
        제품이 선택되면 보여지게 되는 버튼들을 모두 숨긴다. -> display:none
         */
        $('.clothes_buttons').css({"display":"none"});
        $('#product_information_box').css({"display":"none"});

        /*
        클릭시 매개변수로 가져온 태그의 속성에는 제품에 관한 데이터가 들어있다.
        이 데이터를 각 변수에 저장한다. -> 제품식별키, 제품이미지경로, 제품이름, 제품사이즈, (제품 총장, 어깨, 허리 등) 제품크기의 기준점을 잡을 좌표
         */
        var product_key = $(object).attr("product-key");
        var product_url = $(object).attr("product-url");
        var product_name = $(object).attr("product-name");
        var product_size = $(object).attr("product-size");
        var product_position = $(object).attr("product-position");

        /*
        아래부터는 제품 이미지의 픽셀을 설정하기 위해 하는 작업이다.
        기준은 페이지 내부에 접근할 때 가져온 사용자의 이미지의 관절 좌표들을 토대로 설정한다.
         */
        //제품 이미지의 원본크기를 가져온다.
        var temp = $(object).attr("product-image-size").split('@');
        var clothes_image_default_width = temp[0]; // 원본 이미지의 가로픽셀
        var clothes_image_default_height = temp[1]; // 원본 이미지의 세로픽셀


        //내 실제키를 가져온다.
        var my_tall = <?php echo $my_tall; ?>;
        //내 실제 다리길이를 가져온다.
        var my_leg_length = <?php echo $my_leg_length; ?>;
        //스켈레톤상 내 픽셀 길이를 가져온다.
        var my_tall_pixel = skeleton_array[2]-skeleton_array[0];
        //스켈레톤상 내 픽셀 다리길이를 가져온다.
        var my_leg_length_pixel = skeleton_array[2] - skeleton_array[1];
        //제품의 사이즈를 가져온다. 가져온 데이터는 배열 형태로 변수에 저장된다.
        var JsonData = JSON.parse(product_size.replace(/@/gi,"\""));
        var JsonLine = JSON.parse(product_position.replace(/@/gi,"\""));
        //같은옷을 추가로 넣으면 기존 옷은 제거한다.
        $('#'+product_key).remove();
        //div 생성 이 div는 제품 객체이며 내부에 이미지, 제품사이즈조절버튼, 전체 사이즈보기버튼, 내 신체와 비교해보기 버튼 등이 들어간다.
        var div = document.createElement('div');
        document.getElementById('left_box').appendChild(div); //페이지 좌측 영역의 자식노드로 들어간다.
        var type = null; //해당 옷이 상의인지, 하의인지 구분하기 위한 변수이다. 하의는 바지인지 치마인지 추후에 구분해 줄 예정이다.

        var product_height = JsonData['총장']['0']; //제품의 Y축, 즉 제품의 실제 세로 길이 이다. 최초 생성은 최소사이즈를 기준으로 생성시킨다.
        var product_width = null; // 제품의 X축 픽셀을 결정하기 위해 실제 제품의 특정 부위의 가로 길이를 저장할 변수이다.

        //////////////////////////////////////사이즈 맞춰줘야함 ( 현재 임시 )

        if(JsonData['가슴단면']){
            /*
            상의 or 아우터일 경우
            type변수에는 0의 값을 넣고 배열에 각 제공 부위를 담는다.
            */
            type=0;
            product_width = JsonData['어깨너비']['0'];
        }else{
            /*
            하의일 경우
            type변수에는 0의 값을 넣고 배열에 각 제공 부위를 담는다.
            */
            type=1;
            product_width = JsonData['허리']['0'];
        }
        var type_array = Object.keys(JsonData);//제품이 제공하는 부위를 담을 배열 변수이다.

        //이미지 픽셀 길이를 정해준다. ( 옷의 크기와 비교를 하며 픽셀을 맞추어준다. )
        //현재 옷의 길이부분은 거의 정확하게 맞추었으며 옷의 Width는 아직 정확하게 맞추지 못했다. @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
        var clothes_w = JsonLine["x_right"]-JsonLine["x_left"]; //원본 이미지 내부의 옷의 width
        var clothes_y =  JsonLine["y_bottom"]-JsonLine["y_top"]; //원본 이미지 내부의 옷의 height
        product_height_img = clothes_image_default_height*product_height/clothes_y;
        if(type==0){
            div.style.height= my_tall_pixel*product_height_img/my_tall;
            div.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height+70;
            // div.style.width= my_tall_pixel*(product_width*clothes_image_default_width/clothes_x_pixel)/my_tall+70;
        }else if(type==1){
            div.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
            div.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3+70;
        }

        //추가한 옷은 다른 태그영역 위에 올라갈수 있도록(겹쳤을 때 최상단으로 보여지도록) 포지션을 설정해준다.
        div.style.zIndex=click_zindex;
        click_zindex++; // 다음에 생성되거나 다른 제품클릭시 해당 제품이 더 상단에 올라올 수 있도록 이 변수를 1 증가시킨다.

        //영역내부에 옷 div태그에 이미지를 넣어주고 id값을 설정해준다. id값은 유일한 값으로 설정한다. ( 제품 식별 키 )
        div.id=product_key;

        //옷 태그에 이미지에 대한 정보를 넣어준다. ( 현재 선택된 사이즈, 현재 선택된 사이즈의 이름 )
        $('#'+div.id).attr("now-size","0");
        $('#'+div.id).attr("now-size-name",JsonData['SIZE']['0']);

        //제품 객체 내부에 생성할 이미지 객체이다. 생성할 태그는 div이다.
        var img = document.createElement('div');
        document.getElementById(div.id).appendChild(img); // 제품 노드 내부의 자식 노드로 들어가게 된다.
        img.id=product_key+'img'; // 이미지 객체의 아이디를 설정한다. (유일한 값)

        //아래 코드들로 이미지의 픽셀 크기를 지정해준다.
        if(type==0){
            img.style.height=my_tall_pixel*product_height_img/my_tall;
            img.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height;
            img.style.backgroundSize=(clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height)+"px "+ (my_tall_pixel*product_height_img/my_tall)+"px";
        }else if(type==1){
            img.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
            img.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3;
            img.style.backgroundSize=(clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3)+"px "+ (my_leg_length_pixel*product_height_img/my_leg_length)+"px";
        }
        //생성한 이미지의 css에 배경이미지로 제품 이미지를 등록하고, 제품 객체 좌측에 위치하도록 설정한다.
        img.style.backgroundImage="url("+product_url+")";
        $('#'+img.id)
            .css({
                "float":"left"
            });

        /*
        제품 객체 내부에 제품 전체 사이즈보기 버튼을 생성한다.
        해당 버튼을 클릭하게 되면 우측에서 모달창이 생성되며 해당 모달창 내부에 제품의 실제 사이즈들을 표로 보여주며
        현재 내가 선택한 사이즈가 어떤것인지와 제품이름이 무엇인지를 함께 보여준다.
        */
        var  detail_button = document.createElement('div'); // 해당 버튼은 div이다.
        document.getElementById(div.id).appendChild(detail_button); // 버튼은 제품객체 내부의 자식노드로 들어간다.
        detail_button.id='image_detail_button'; // 버튼의 아이디를 설정한다.
        detail_button.className = 'clothes_buttons'; // 버튼의 클래스를 설정한다.
        detail_button.style.backgroundImage="url(\"./icon/list.png\")"; // 버튼의 배경 이미지를 설정한다.
        detail_button.style.backgroundSize="100% 100%"; // 버튼의 배경 이미지 사이즈를 설정한다.
        //버튼의 css를 설정한다.
        $(detail_button)
            .css({
                "float":"right",
                "width":"40px",
                "height":"40px",
                "margin-bottom":"10px",
                "border":"none",
                "cursor":"pointer",
                "outline":"0",
                "border-radius":"8px",
                "display":"none"
            })
            .hover(function(){
                $(this).css("background-color","#9999FF");
            }, function(){
                $(this).css({"background-color": "transparent"});
            })
            //해당 버튼을 클릭했을 때 동작하는 코드이다.
            .click(function(){
                body_click=0; // 제품을 클릭한것을 식별하기 위한 값을 넣어준다. 이 변수가 1이 들어가면 제품 객체의 선택 취소임으로 0을 넣어준다.

                //클릭한 옷은 최상단으로 오도록 설정하고 다음 클릭을 위해 변수에 값을 1 증가시킨다.
                $(this).css('z-index',click_zindex);
                click_zindex++;

                //모달창 내부에 옷에대한 상세정보를 적어준다.
                //추후에 모달 내부에 이용자의 신체 치수와 옷을 착용한 모델의 사진또한 같이 보여주도록 할 예정이다.@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
                $(".modalR-title").text(product_name); // 모달 상단의 제목 부분이다. 이공간에는 제품의 이름을 넣어준다.
                $("#modalR-img").attr("src",product_url); // 제품 이미지를 넣어준다.
                var size_array = new Array(); // 제품 사이즈를 표로 만들기 위해 제품의 사이즈가 들어갈 배열을 생성시킨다.

                // 기존에 만들어진 테이블을 제거한다. ( 이전에 다른 제품 사이즈보기 기능을 사용했을 경우에 이미 테이블이 존재함으로 )
                $("#modalR-table thead td").remove();
                $("#modalR-table tbody tr").remove();

                /*
                위에서 생성한 size_array 배열은 Key - Value 형태로 저장할 것이며
                각 Key값은 type_array라는 제품이 제공하는 사이즈의 각 부위이다.
                Value값은 Key에 해당하는 부위의 사이즈들을 순차적으로 집어넣을 것이다.
                아래 for문은 테이블의 최상단, 즉 사이즈의 카테고리들을 넣을것이다.
                */
                for(var i=0;i<type_array.length;i++){
                    if(i==0){
                        for(var ii=0;ii<JsonData[type_array[i]].length;ii++){
                            size_array[ii]=new Array();
                        }
                    }
                    //테이블의 최상단 0번행에 태그들을 생성시키며 각 태그에 위의 for문으로 만든 카테고리명들을 넣는다.
                    if(i==0){
                        var option = "<td style=\"border-right:1px white solid; border-bottom:1px white solid; border-left:1px gainsboro solid;  width:"+100/type_array.length+"%; height:40px;\">"+type_array[i]+"</td>";
                    }else{
                        if(i+1==type_array.length){
                            var option = "<td style=\"border-right:1px gainsboro solid; border-bottom:1px white solid;  width:"+100/type_array.length+"%; height:40px;\">"+type_array[i]+"</td>";
                        }else{
                            var option = "<td style=\"border-right:1px white solid; border-bottom:1px white solid;  width:"+100/type_array.length+"%; height:40px;\">"+type_array[i]+"</td>";
                        }
                    }

                    //위에서 생성시킨 태그들을 테이블의 thead태그 내부에 넣는다.
                    $('#modalR-table thead').append(option);

                    //위에서 넣은 size_array배열에 Key값(제공 부위) 내부에 해당 부위의 사이즈들을 넣는다.
                    for(var ii=0;ii<JsonData[type_array[i]].length;ii++){
                        var array_temp = JsonData[type_array[i]];
                        size_array[ii][i]=array_temp[ii];
                    }
                }

                //태그들을 생성시켜서 표 형태를 완성시킨다.
                //for문을 사용하여 위의 for문에서 넣은 size_array의 값들을 이용하여 사이즈를 넣는다.
                for(var i=0;i<size_array.length;i++){
                    var value = "<tr>";
                    for(var ii=0;ii<size_array[i].length;ii++){
                        if(ii==0){
                            if(size_array[i].length>ii+1){
                                value += "<td style=\"height:40px; background-color:gainsboro; border-right:1px white solid; border-bottom:1px white solid; \">"+size_array[i][ii]+"</td>";
                            }else{
                                value += "<td style=\"height:40px; background-color:gainsboro; border-right:1px white solid; \">"+size_array[i][ii]+"</td>";
                            }
                        }else{
                            value += "<td style=\"border:1px gainsboro solid;\">"+size_array[i][ii]+"</td>";
                        }
                    }
                    value += "</tr>";
                    $('#modalR-table tbody').append(value);
                }
                //제품의 현재 선택된 사이즈를 표 내부에 색상이 다르게 표현하여 보여준다.
                var child_count = $("#modalR-table tbody").children().eq(0).children().size();
                var now_size = $(div).attr("now-size");
                for(var index=0;index<child_count;index++){
                    $("#modalR-table tbody").children().eq(now_size).children().eq(index).css("background-color","#FFCCCC")
                }
                $("#modalR-size").text($(div).attr("now-size-name"));

                //위의 코드들로 완성한 모달창 내부를 화면상에 생성한다.
                $("#myModalR").modal("show");
            });

        /*
        사이즈를 올리는 버튼을 생성한다.
        해당 버튼을 통해 사이즈를 올릴 수 있다.
        사이즈는 실제 제품의 최대 사이즈를 넘지 않는다.
        */
        var  sizeup_button = document.createElement('button');  //버튼을 생성한다.
        document.getElementById(div.id).appendChild(sizeup_button); // 생성한 버튼은 제품 객체의 내부의 자식노드로 들어간다.
        sizeup_button.id='image_sizeup_button'; //버튼의 아이디를 지정한다.
        sizeup_button.className = 'clothes_buttons';    //버튼의 클래스를 지정한다.
        sizeup_button.style.backgroundImage="url(\"./icon/sizeup.png\")"; //버튼의 배경 이미지를 지정한다.
        sizeup_button.style.backgroundSize="100% 100%"; //버튼의 배경 이미지 사이즈를 지정한다.
        //버튼의 css를 지정한다.
        $(sizeup_button)
            .css({
                "float":"right",
                "width":"40px",
                "height":"40px",
                "margin-bottom":"10px",
                "border":"none",
                "cursor":"pointer",
                "outline":"0",
                "border-radius":"8px",
                "display":"none"
            })
            .hover(function(){
                $(this).css("background-color","#9999FF");
            }, function(){
                $(this).css({"background-color": "transparent"});
            })

            /*
            제품 클릭시 동작하는 코드들을 작성한다.
            제품 클릭시 제품 객체와 제품 객체 내부의 제품 이미지의 크기를 증가시킨다.
             */
            .click(function(){
                body_click=0; //제품을 클릭한것으로 간주함으로 해당 변수를 0으로 만든다.

                /*
                현재 사이즈와 제품이 제공하는 사이즈를 비교하기 위해 제품 카테고리 이름을 배열의 key형태로 생성시키고 초기화시킨다.
                 */
                var size_array = new Array();
                for(var i=0;i<type_array.length;i++) {
                    if(i==0){
                        for(var ii=0;ii<JsonData[type_array[i]].length;ii++){
                            size_array[ii]=new Array();
                        }
                    }
                }
                //제품객체의 현재사이즈를 알아보기위해 now-size속성을 조회하여 현재 사이즈를 알아온다. ( 이 속성에는 0,1,2,3,4... 즉 Int형태의 데이터가 담겨있다. )
                var now_size_forbutton = $(div).attr("now-size");
                //현재 사이즈와 제공사이즈의 비교를 통해 최대크기인지 아닌지를 구분한다.
                if(parseInt(now_size_forbutton)+2>size_array.length){ //제품이 이미 최대크기일 경우
                    alert('가장 큰 사이즈입니다.');
                }else{
                    //제품이 아직 최대크기가 아닐경우
                    now_size_forbutton++; //현재 사이즈가 저장되어있는 변수를 1 증가시킨다.
                    $(div).attr("now-size-name",JsonData['SIZE'][now_size_forbutton]); //제품 객체 내부의 속성중 현재 사이즈의 이름을 새롭게 지정한다.
                    $(div).attr("now-size",now_size_forbutton);//제품 객체 내부의 속성중 현재 사이즈 번호를 새롭게 지정한다.
                    var size_array = $(div).attr("now-size-name").split('('); // 44(26~29) 형태로 저장되어있는 사이즈 이름을 split함수를 통해 앞의 사이즈만 추출한다.
                    $('#pi_box_product_size').text(size_array[0]); // 페이지 좌측 영역 내부의 우측 상단에 존재하는 현재 선택한 제품의 사이즈를 변경한다.
                    //이미지 픽셀 길이를 정해준다.
                    product_height = JsonData['총장'][now_size_forbutton]; //옷의 크기 픽셀을 변경하기 위해 제품에서 현재 선택한 사이즈의 실제 길이를 가져온다.
                    product_height_img = clothes_image_default_height*product_height/clothes_y;

                    //제품 객체와 제품 객체 내부의 제품 이미지객체의 크기를 재조정한다.
                    if(type==0){
                        div.style.height=my_tall_pixel*product_height_img/my_tall;
                        img.style.height=my_tall_pixel*product_height_img/my_tall;
                        div.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height+70;
                        img.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height;
                        img.style.backgroundSize=(clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height)+"px "+ (my_tall_pixel*product_height_img/my_tall)+"px";
                    }else if(type==1){
                        product_width = JsonData['허리'][now_size_forbutton];
                        div.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
                        img.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
                        div.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3+70;
                        img.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3;
                        img.style.backgroundSize=(clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3)+"px "+ (my_leg_length_pixel*product_height_img/my_leg_length)+"px";
                    }
                }
            });

        /*
        사이즈를 내리는 버튼을 생성한다.
        해당 버튼을 통해 사이즈를 내릴 수 있다.
        사이즈는 실제 제품의 최소 사이즈밑으로 내려가지 않는다.
        */
        var  sizedown_button = document.createElement('button');  //버튼을 생성한다.
        document.getElementById(div.id).appendChild(sizedown_button); // 생성한 버튼은 제품 객체의 내부의 자식노드로 들어간다.
        sizedown_button.id='image_sizedown_button'; //버튼의 아이디를 지정한다.
        sizedown_button.className = 'clothes_buttons'; //버튼의 클래스를 지정한다.
        sizedown_button.style.backgroundImage="url(\"./icon/sizedown.png\")"; //버튼의 배경 이미지를 지정한다.
        sizedown_button.style.backgroundSize="100% 100%"; //버튼의 배경 이미지 사이즈를 지정한다.
        //버튼의 css를 지정한다.
        $(sizedown_button)
            .css({
                "float":"right",
                "width":"40px",
                "height":"40px",
                "margin-bottom":"10px",
                "border":"none",
                "cursor":"pointer",
                "outline":"0",
                "border-radius":"8px",
                "display":"none"
            })
            .hover(function(){
                $(this).css("background-color","#9999FF");
            }, function(){
                $(this).css({"background-color": "transparent"});
            })

            /*
            제품 클릭시 동작하는 코드들을 작성한다.
            제품 클릭시 제품 객체와 제품 객체 내부의 제품 이미지의 크기를 감소시킨다.
            */
            .click(function(){
                body_click=0;//제품을 클릭한것으로 간주함으로 해당 변수를 0으로 만든다.
                //제품객체의 현재사이즈를 알아보기위해 now-size속성을 조회하여 현재 사이즈를 알아온다. ( 이 속성에는 0,1,2,3,4... 즉 Int형태의 데이터가 담겨있다. )
                var now_size_forbutton = $(div).attr("now-size");
                if(parseInt(now_size_forbutton)==0){ // 현재 사이즈가 0일 경우에는 이미 최소 크기이다.
                    alert('가장 작은 사이즈입니다.');
                }else{
                    //제품이 최소 크기가 아닐경우
                    now_size_forbutton--; //현재 사이즈가 저장되어있는 변수를 1 감소시킨다.
                    $(div).attr("now-size-name",JsonData['SIZE'][now_size_forbutton]);//제품 객체 내부의 속성중 현재 사이즈의 이름을 새롭게 지정한다.
                    $(div).attr("now-size",now_size_forbutton);//제품 객체 내부의 속성중 현재 사이즈 번호를 새롭게 지정한다.
                    var size_array = $(div).attr("now-size-name").split('(');// 44(26~29) 형태로 저장되어있는 사이즈 이름을 split함수를 통해 앞의 사이즈만 추출한다.
                    $('#pi_box_product_size').text(size_array[0]);// 페이지 좌측 영역 내부의 우측 상단에 존재하는 현재 선택한 제품의 사이즈를 변경한다.
                    //이미지 픽셀 길이를 정해준다.
                    product_height = JsonData['총장'][now_size_forbutton]; //옷의 크기 픽셀을 변경하기 위해 제품에서 현재 선택한 사이즈의 실제 길이를 가져온다.
                    product_height_img = clothes_image_default_height*product_height/clothes_y;
                    //제품 객체와 제품 객체 내부의 제품 이미지객체의 크기를 재조정한다.
                    if(type==0){
                        div.style.height=my_tall_pixel*product_height_img/my_tall;
                        img.style.height=my_tall_pixel*product_height_img/my_tall;
                        div.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height+70;
                        img.style.width=clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height;
                        img.style.backgroundSize=(clothes_image_default_width*(my_tall_pixel*product_height_img/my_tall)/clothes_image_default_height)+"px "+ (my_tall_pixel*product_height_img/my_tall)+"px";
                    }else if(type==1){
                        product_width = JsonData['허리'][now_size_forbutton];
                        div.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
                        img.style.height=my_leg_length_pixel*product_height_img/my_leg_length;
                        div.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3+70;
                        img.style.width=clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3;
                        img.style.backgroundSize=(clothes_image_default_width*(my_leg_length_pixel*product_height_img/my_leg_length)/clothes_image_default_height*1.3)+"px "+ (my_leg_length_pixel*product_height_img/my_leg_length)+"px";
                    }
                }
            });
        /*
        제품 길이비교 버튼을 생성시킨다.
        해당 버튼을 통해 사용자와 제품과의 각 부위의 길이를 비교해볼 수 있다.
        */
        var  zoom_button = document.createElement('button');//버튼을 생성한다.
        document.getElementById(div.id).appendChild(zoom_button);// 생성한 버튼은 제품 객체의 내부의 자식노드로 들어간다.
        zoom_button.id='zoom_button';//버튼의 아이디를 지정한다.
        zoom_button.className = 'clothes_buttons';//버튼의 클래스를 지정한다.
        zoom_button.style.backgroundImage="url(\"./icon/zoom.png\")";//버튼의 배경 이미지를 지정한다.
        zoom_button.style.backgroundSize="100% 100%";//버튼의 배경 이미지 사이즈를 지정한다.
        //버튼의 css를 지정한다.
        $(zoom_button)
            .css({
                "float":"right",
                "width":"40px",
                "height":"40px",
                "margin-bottom":"10px",
                "border":"none",
                "cursor":"pointer",
                "outline":"0",
                "border-radius":"8px",
                "display":"none"
            })
            .hover(function(){
                $(this).css("background-color","#9999FF");
            }, function(){
                $(this).css({"background-color": "transparent"});
            })
            .click(function(){
                /*
                길이비교 버튼 클릭시 동작하는 코드이다.
                길이비교 버튼을 클릭하면 페이지 좌측에 모달창이 생성된다.
                모달창 내부 상단에는 비교할 카테고리 이름을 보여준다.
                모달창 내부 상단2번째에는 비교할 카테고리 목록을 보여주며 해당 카테고리 클릭시 그 카테고리에 맞는 길이비교를 한다.
                사용자와 제품의 현재사이즈의 각 카테고리의 길이비교를 시각화 하여 보여주며, Cm차이 단위를 알려준다.
                */
                var table_value=""; // 생성시킬 카테고리 태그를 저장할 변수
                product_category = 0; // 생성시킬 카테고리의 개수를 저장할 변수

                //기존에 생성되어있던 카테고리목록을 제거한다.
                for(var count=0;count<10;count++)
                {
                    $('#modalL_table_td').remove();
                }

                /*
                아래 코드들을 통해 각 카테고리를 td태그 형태로 생성시킨다.
                click이벤트를 두어 해당 카테고리 클릭시 이벤트를 준다. -> 이벤트는 카테고리에 맞는 길이비교를 시각화 하여 보여주는 기능이다.
                 */
                var count_temp=1;
                console.log(type_array);
                for(var count=1;count<type_array.length;count++)
                {
                    if(JsonData[type_array[count]][0]!='-'&&type_array[count]!='밑위')
                    {
                        var data = JsonData[type_array[count]][$(div).attr('now-size')];
                        var str = type_array[count];
                        if(type_array[2]=='어깨너비')
                        {
                            table_value += "<td id='modalL_table_td' onclick='zoomin(0,"+(count_temp-1)+","+data+",\""+str+"\")'>"+type_array[count]+"</td>";
                        }
                        else
                        {
                            table_value += "<td id='modalL_table_td' onclick='zoomin(1,"+(count_temp-1)+","+data+",\""+str+"\")'>"+type_array[count]+"</td>";
                        }
                        count_temp++;
                        product_category++;
                    }
                }

                //위에서 생성한 td태그들은 모달창의 테이블 내부의 자식노드로 들어간다.
                $('#modalL_table').append(table_value);
                //테이블의 css를 설정한다.
                $('#modalL_table').css({
                    "text-align":"center",
                    "vertical-align":"middle",
                    "cursor":"pointer"
                });

                /*
                최초 모달창 실행시 보여지는 길이비교 를 정해주기 위한 코드이다.
                어깨너비가 존재한다면 상의이며 존재하지 않는다면 하의라고 가정한다.
                상의던, 하의던 모달창이 실행되면 가장 먼저 총장을 길이비교해주기 위해 onlcik내부에 들어가있는 zoomin함수를 실행시킨다.
                 */
                if(type_array[2]=='어깨너비')
                {
                    zoomin(0,0,JsonData['총장'][$(div).attr('now-size')],'총장');
                }
                else
                {
                    zoomin(1,0,JsonData['총장'][$(div).attr('now-size')],'총장');
                }

                //위의 코드들로 완성한 모달창 내부를 화면상에 생성한다.
                $("#myModalL").modal("show");
            });

        /*
        제품 객체를 클릭하거나, 드래그했을때의 이벤트이다.
        드래그 이벤트로 제품을 이동시킬 수 있도록 한다.
        클릭 이벤트로 해당제품의 선택, 선택취소 이벤트가 일어나도록 한다.
        제품이 선택 된다면 해당 제품의 각 버튼이 활성화 된다, 즉 보여준다. ( display:block )
        제품이 선택 취소 된다면 해당 제품의 각 버튼이 비활성화 된다, 즉 숨긴다. ( display:none )
         */
        $(div)
            //draggable을 통해 드래그 이동이 가능하도록 설정하고 containment:'parent'를 통해 보모 노드 내부에서만 드래그 이동이 가능하도록 설정한다.
            //여기서 부모 노드는 페이지 좌측 영역이다.
            .draggable({containment:'parent'})
            //제품 객체의 css를 설정한다.
            .css({
                "cursor":"pointer",
                "left":"600px",
                "top":"100px",
                "position":"absolute"
            })
            //마우스를 눌렀을때의 이벤트이다.
            .mousedown(function(){
                //제품 객체를 선택했다고 가정함으로 해당 객체가 가장 최상단으로 올 수 있도록 설정한다.
                $(this).css('z-index',click_zindex);
                click_zindex++;

                //일단 모든 제품들의 모든 버튼들을 비활성화 시킨다.
                $('.clothes_buttons').css({"display":"none"});

                //현재 선택한 제품의 버튼들만 활성화 시킨다.
                $(detail_button).css({"display":"block"});
                $(sizeup_button).css({"display":"block"});
                $(sizedown_button).css({"display":"block"});
                $(zoom_button).css({"display":"block"});

                //현재 선택된 제품의 사이즈와, 해당 제품의 이름을 페이지 좌측 영역내부의 우측 상단에 표시해준다.
                var size_array = $(this).attr("now-size-name").split('(');
                $('#pi_box_product_size').text(size_array[0]);
                $('#pi_box_product_name').text(product_name);
                $('#product_information_box').css({"display":"block"}); // 표시된 사이즈, 제품이름의 부모 노드를 활성화 시킨다. ( 화면상에 보여준다 )

                /*
                선택한 제품이 이전에 선택한 제품인지 확인하는 절차가 필요하다.
                만약 선택한 제품을 다시 선택한 경우에는 선택 취소로 가정한다. --> ex) 제품을 클릭 -> 클릭 했을 경우
                취소된 제품은 모든버튼을 비활성화 시키고 페이지 좌측 영역 내부의 우측 상단의 제품이름, 제품사이즈를 비활성화 시켜야한다.
                 */
                if(click_product == div){
                    if(all_click_count==0){
                        all_click_count=1;
                        body_click=0;
                    }
                }else{
                    all_click_count=1;
                    body_click=0;
                }
                click_product = div; // 현재 선택한 제품을 특정변수에 넣어서 다음에 클릭했을 때 비교할 수 있도록한다.
            });
    }
    $('body').click(function(){
        if(body_click==0){ //제품을 클릭했을 경우에 body_click이 0이며 body_click만 1로 변경하고 아무 동작하지 않는다.
            body_click=1;
        }else{ // body_click이 1일때 동작하며 모든 버튼과, 페이지 좌내부 우상단의 제품이름, 사이즈를 비활성화 시킨다.      다음 클릭을 위하여 all_click_count를 0으로 초기화한다.
            $('.clothes_buttons').css({"display":"none"});
            $('#product_information_box').css({"display":"none"});
            all_click_count=0;
        }
    });

    /*
    제품의 각 부위 길이비교 기능을 위한 함수이다.
    제품 길이비교 버튼을 통해 생성된 모달창에서 상단의 카테고리 클릭시 동작하는 이벤트이다.
    **매개변수**
    type = 상, 하의를 구분할 변수
    number = 현재 선택된 카테고리
    size = 제품의 실사이즈
    str = 제품 카테고리 이름
    */
    function zoomin(type,number,size,str){

        /*
        아래 코드들은 선택된 카테고리를 식별하기 위한 코드들이다.
        현재 선택중인 카테고리는 배경색이 변경된다.
        카테고리가 변경되면 모든 색삭을 초기화 시키고 재지정한다.
        매개변수 number는 이 코드를 작동시키기 위해서 사용한다. ( 선택된 카테고리가 무엇인지 식별을 위해 )
         */
        for(var count=0;count<product_category;count++)
        {
            $("#modalL_table").children().eq(count).css({"border-radius":"10px", "background-color":"white"});
            if(number!=count)
            {
                $("#modalL_table").children().eq(count).hover(function(){
                    $(this).css("background-color","indianred");
                }, function(){
                    $(this).css("background-color","white");
                });
            }else
            {
                $("#modalL_table").children().eq(count).hover(function(){
                    $(this).css("background-color","indianred");
                }, function(){
                    $(this).css("background-color","indianred");
                });
            }
        }
        $("#modalL_table").children().eq(number).css({"background-color":"indianred"});

        /*
        특정 부위 길이 비교는 미리 선정해둔 아바타의 특정 부위를 확대시켜 보여주며
        특정 부위에 div태그들과 해당 태그들의 색상을 변경시켜 실루엣 형태로 옷을 입은 것처럼 보여준다.
        또한 실루엣 위에 div태그로 직선을 긋고 직선 옆에 해당 부위의 실제 길이를 cm로 표기해주어 해당 실루엣의 길이감을 나타내준다.
        사용자의 특정 신체부위의 길이를 위와 동일하게 div태그로 생성시키고 배경 이미지를 길이감을 보여줄수 있는 이미지로 설정하여 보여준다. 또한 이미지 옆에 사용자 신체부위의 실제 길이를 적어준다.
        길이차가 난다면 그 길이차를 시각화 하여 보여준다.
        우측 하단에는 실제 길이차를 텍스트 형태로 표시해준다. ex)'xxxx에서 xxCm만큼 내려옵니다.'

        *** 자세히 ***
        아바타에 사용자가 입력한 신체부위 길이들을 대입하면 픽셀당 Cm를 알아낼 수 있다.
        위의 과정으로 제품 길이를 통하여 실루엣의 픽셀 길이를 정할 수 있다.
        만약 길이감이 아닌 둘레를 보여줘야 할 경우에는 실루엣과 직선으로 표시해주지 않고 타원 형태로 부위 둘레와 사용자의 신체부위 둘레를 표시해준 뒤
        텍스트 형태로 사용자 신체부위와, 제품 실제 길이를 Cm형태로 타원 근처에 표시해준다.
        우측 하단은 동일하게 실제 둘레차를 텍스트 형태로 표시해준다. ex)'xxxx가 Cm가량 작습니다.'
         */

        //아래 for문을 통해 기존에 생성되어있던 div들을 제거한다.
        for(var re=1;re<14;re++)
        {
            $('#line'+re).remove();
        }
        //상의일 경우에 동작하는 코드이다.
        if(type==0){
            if(str=='총장'){ //상의에서 총장 카테고리일 때 동작하는 코드이다.
                var my_top_length = <?php echo $my_top_length ?>;
                var top_pixel = 115;
                var product_length = top_pixel*size/my_top_length;
                $('#modalL-img').attr("src","./icon/human.png");
                $("#modalL-img-box").append("<div id='line1' style='background-image:url(\"../web/icon/arrow2.png \"); background-size:100% 100%; left:150px; top:82px; position:absolute; " +
                    "width:30px; height:"+top_pixel+"px;'></div>");
                $("#modalL-img-box").append("<div id='line3' style='z-index:10; left:20px; top:100px; position:absolute; color:red;'></div>");
                $("#line3").text("내 상체길이 : "+my_top_length+"cm");
                $("#modalL-img-box").append("<div id='line5' style='background-color:#FFCAD5; opacity:0.99; transform-origin:0% 0%; transform:rotate(75deg); border-top-left-radius:15px;" +
                    " left:350px; top:78px; position:absolute; width:80px; height:30px;'></div>");
                $("#modalL-img-box").append("<div id='line6' style='background-color:#FFCAD5; opacity:0.99; transform-origin:0% 0%; transform:rotate(-75deg); border-top-right-radius:15px;" +
                    " left:228px; top:156px; position:absolute; width:80px; height:30px;'></div>");
                $("#modalL-img-box").append("<div id='line7' style='background-color:#FFCAD5; opacity:1; border-top-left-radius:15px; border-top-right-radius:15px; left:253px; top:82px; " +
                    "position:absolute; width:94px; height:"+product_length+"px;'></div>");
                $("#modalL-img-box").append("<div id='line8' style='border-left:5px red solid; padding-left:10px; color:red; left:253px; top:82px; position:absolute; " +
                    "height:"+product_length+"px;'></div>");
                var new_line = $("#line8").text("\n\n제품 총기장 : "+size+"cm");
                new_line.html(new_line.html().replace(/\n/g,'<br/>'));
                if(my_top_length<size){
                    $("#modalL-img-box").append("<div id='line9' style='border-top-right-radius: 50%; border-bottom-right-radius: 50%; border-right:5px blue dashed; padding-left:10px; color:red; " +
                        "left:"+(253-(product_length-top_pixel)/2)+"px; top:"+(83+top_pixel)+"px; position:absolute; " +
                        "height:"+(product_length - top_pixel-2)+"px; width:"+(product_length - top_pixel)+"px;'></div>");
                    $("#modalL-img-box").append("<div id='line10' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line10").text("상체에서 "+(size-my_top_length).toFixed(2)+"cm 가량 내려옵니다.");
                }else if(my_top_length>size){
                    $("#modalL-img-box").append("<div id='line9' style='border-left:5px red solid; padding-left:10px; color:red; left:253px; top:"+(83+product_length)+"px; position:absolute; " +
                        "height:"+(top_pixel-product_length)+"px;'></div>");
                    $("#modalL-img-box").append("<div id='line10' style='border-top-right-radius: 50%; border-bottom-right-radius: 50%; border-right:5px blue dashed; padding-left:10px; color:red; " +
                        "left:"+(253-(top_pixel-product_length)/2)+"px; top:"+(83+product_length)+"px; position:absolute; " +
                        "height:"+(top_pixel-product_length)+"px; width:"+(top_pixel-product_length)+"px;'></div>");
                    $("#modalL-img-box").append("<div id='line11' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line11").text("상체에서 "+(my_top_length-size).toFixed(2)+"cm 가량 올라갑니다.");
                }
                temp_text="총기장";
            }else if(str=='어깨너비'){ //상의에서 어깨너비 카테고리일 때 동작하는 코드이다.
                //어깨 길이차이 보여주기
                var my_shoulder = <?php echo $my_shoulder_length?>;
                var top_pixel = 400*size/my_shoulder;
                var top_left = 94 - (top_pixel - 400)/2;
                if(top_pixel>520)
                {
                    top_pixel = 520;
                    top_left = 34;
                }
                if(top_pixel<285)
                {
                    top_pixel = 285;
                    top_left = 151;
                }
                $('#modalL-img').attr("src","./icon/shoulder.png");
                $("#modalL-img-box").append("<div id='line1' style='z-index:11; background-image:url(\"../web/icon/arrow.png \"); color:red; text-align:left; background-size:100% 100%; left:119px; top:226px; position:absolute; width:350px; height:60px;'></div>");
                $("#line1").text("내 어깨 : "+my_shoulder+"cm");
                $("#modalL-img-box").append("<div id='line2' style='color:red; border-top-left-radius:70px; border-top-right-radius:70px; background-color:#FFCAD5; opacity:0.7; top:270px; position:absolute; left:"+(top_left)+"px; width:"+(top_pixel)+"px; height:200px;'></div>");
                $("#modalL-img-box").append("<div id='line3' style='border-top:7px red solid; color:red; text-align:left; left:"+(top_left+25)+"px; top:300px; position:absolute; width:"+(top_pixel-50)+"px; height:30px;'></div>");
                var new_line = $("#line3").text("\n제품 어깨 : "+size+"cm");
                new_line.html(new_line.html().replace(/\n/g,'<br/>'));
                if(my_shoulder<size)
                {
                    $("#modalL-img-box").append("<div id='line4' style='border-bottom:5px blue dashed; border-bottom-left-radius:50%; border-bottom-right-radius:50%; color:red; left:469px; top:280px; " +
                        "position:absolute; width:"+((top_pixel-50)+(top_left+25)-469)+"px; height:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line5' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line5").text("양쪽어깨가 각각"+((size-my_shoulder)/2).toFixed(2)+"cm 가량 큽니다.");
                }else if(my_shoulder>size)
                {
                    $("#modalL-img-box").append("<div id='line4' style='border-top:4px red solid; color:red; left:"+(top_left+top_pixel-24)+"px; top:300px; position:absolute; width:"+(468-(top_left+top_pixel-25))+"px; height:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line5' style='border-bottom:5px blue dashed; border-bottom-left-radius:50%; border-bottom-right-radius:50%; " +
                        "color:red; left:"+(top_left+top_pixel-24)+"px; top:275px; position:absolute; width:"+(468-(top_left+top_pixel-25))+"px; height:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line6' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line6").text("양쪽어깨가 각각"+((my_shoulder-size)/2).toFixed(2)+"cm 가량 작습니다.");
                }else
                {
                    $("#modalL-img-box").append("<div id='line4' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line4").text("제품 어깨 넓이가 내 어깨와 동일합니다.");
                }

                temp_text="어깨너비";
            }else if(str=='가슴단면'){ //상의에서 가슴단면 카테고리일 때 동작하는 코드이다.
                var my_chest = <?php echo $my_chest?>;
                var product_chest = size*2;
                var product_with = 232+(product_chest-my_chest);
                var product_left = 183-(product_chest-my_chest)/2;
                var my_right = 415;
                var my_center = 180+(415-180)/2;
                $('#modalL-img').attr("src","./icon/waist.png");
                $("#modalL-img-box").append("<div id='line1' style='border-radius:50%; color:red; background-color:black; border-left:2px red dashed; border-right:2px red dashed;  border-top:2px red dashed; border-bottom:5px red solid; left:183px; top:185px; position:absolute; width:232px; height:30px;'></div>");
                $("#modalL-img-box").append("<div id='line2' style='left:220px; top:150px; width:160px; position:absolute; color:red;'></div>");
                $("#modalL-img-box").append("<div id='line3' style='color:red; border-left:2px red solid; border-right:2px red solid; left:183px; top:185px; position:absolute; width:232px; height:30px;'></div>");
                $("#line2").text("내 가슴둘레 : "+my_chest+"cm");
                $("#modalL-img-box").append("<div id='line4' style='border-radius:50%; border-bottom:5px red solid; border-left:2px red dashed; border-right:2px red dashed; border-top:2px red dashed; left:"+product_left+"px; top:230px; position:absolute; width:"+product_with+"px; height:30px;'></div>");
                $("#modalL-img-box").append("<div id='line5' style='left:220px; top:270px; width:160px; position:absolute; color:red;'></div>");
                $("#modalL-img-box").append("<div id='line6' style='color:red; border-left:2px blue solid; border-right:2px blue solid; left:"+product_left+"px; top:230px; position:absolute; width:"+product_with+"px; height:30px;'></div>");
                $("#line5").text("제품 가슴둘레 : "+product_chest+"cm");
                $("#modalL-img-box").append("<div id='line7' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; opacity:0.8; left:400px; top:370px; width:200px; height:100px; position:absolute; color:red;'></div>");
                if(product_chest>my_chest)
                {
                    $("#line7").text((product_chest-my_chest).toFixed(2)+"cm 만큼 여유가 있습니다.");
                }
                else if(my_chest>product_chest)
                {
                    $("#line7").text((my_chest-product_chest).toFixed(2)+"cm 만큼 작습니다.");
                }
                temp_text="가슴둘레";
            }else if(str=='소매길이'){//상의에서 소매길이 카테고리일 때 동작하는 코드이다.
                var my_arm_length = <?php echo $my_arm_length?>;
                var product_arm_length_pixel = size*370/my_arm_length;
                if(product_arm_length_pixel>450){
                    product_arm_length_pixel=450;
                }
                if(product_arm_length_pixel<60){
                    product_arm_length_pixel=60;
                }
                $("#modalL-img-box").append("<div id='line1' style='border-top-left-radius:10%; border-top-right-radius:100px; z-index:1;transform-origin:0% 0%; transform:rotate(-10deg); background-color:black; left:408px; top:24px; position:absolute; width:80px; height:170px;'></div>");
                $('#modalL-img').attr("src","./icon/arm.png");
                $("#modalL-img-box").append("<div id='line2' style='background-image:url(\"../web/icon/arrow.png \"); transform-origin:0% 0%; color:red; text-align:center;" +
                    " background-size:100% 100%; transform:rotate(-72deg); left:230px; top:340px; position:absolute; width:340px; height:60px;'></div>");
                $("#modalL-img-box").append("<div id='line3' style='z-index:10; left:180px; top:180px; position:absolute; color:red;'></div>");
                $("#line3").text("내 팔길이 : "+my_arm_length+"cm");
                $("#modalL-img-box").append("<div id='line4' style='background-color:#FFCAD5; border-bottom:10px red solid; transform-origin:0% 0%; opacity:0.95; border-bottom-left-radius:30px;" +
                    " transform:rotate(108deg); left:477px; top:40px; position:absolute; width:"+product_arm_length_pixel+"px; height:80px;'></div>");
                $("#modalL-img-box").append("<div id='line5' style='z-index:10; left:390px; top:90px; position:absolute; color:red;'></div>");
                $("#line5").text("제품 팔길이 : "+size+"cm");
                $("#modalL-img-box").append("<div id='line6' style='border-bottom:5px red solid; transform-origin:0% 0%; border-bottom-left-radius:30px;" +
                    " transform:rotate(108deg); left:477px; top:40px; position:absolute; width:370px; height:80px;'></div>");
                if(my_arm_length>size)
                {
                    $("#modalL-img-box").append("<div id='line7' style='border-bottom:5px blue dashed; transform-origin:0% 100%;" +
                        "transform:rotate(-72deg); border-bottom-left-radius:50%; border-bottom-right-radius:50%; left:312px; top:326px; position:absolute; " +
                        "width:"+(370-product_arm_length_pixel)+"px; height:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line8' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line8").text("손목에서 "+(my_arm_length-size).toFixed(2)+"cm 만큼 올라옵니다.");
                }
                else if(my_arm_length<size)
                {
                    $("#modalL-img-box").append("<div id='line7' style='border-top:5px blue dashed; transform-origin:0% 100%;" +
                        "transform:rotate(108deg); border-top-left-radius:50%; border-top-right-radius:50%; left:270px; top:310px; position:absolute; " +
                        "width:"+(product_arm_length_pixel-366)+"px; height:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line8' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line8").text("손목에서 "+(size-my_arm_length).toFixed(2)+"cm 만큼 내려옵니다.");
                }
                else
                {
                    $("#modalL-img-box").append("<div id='line7' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line7").text("제품 팔기장이 손목에 위치합니다.");
                }

                temp_text="팔길이";
            }
        }else if(type==1){ //하의일 때 동작하는 코드이다.
            if(str=='총장')//아직 치마 카테고리가 존재하지 않아서 미리 만들어둠
            {
                str='총장_바지'
            }
            if(str=='총장_바지') //총장-바지 카테고리 일 때 동작하는 코드이다.
            {
                $('#modalL-img').attr("src","./icon/reg.png");
                var my_leg_length = <?php echo $my_leg_length; ?>;
                var product_leg_length_pixel = size*395/my_leg_length;
                if(product_leg_length_pixel>455)
                {
                    product_leg_length_pixel=455;
                }
                if(product_leg_length_pixel<80)
                {
                    product_leg_length_pixel=80;
                }
                $("#modalL-img-box").append("<div id='line1' style='background-color:#FAF1C2; border-bottom-left-radius:30px; border-bottom-right-radius:30px; opacity:0.98; left:224px; top:15px; position:absolute; width:150px; height:"+product_leg_length_pixel+"px;'></div>");
                $("#modalL-img-box").append("<div id='line2' style='left:294px; top:90px; position:absolute; width:10px; height:380px; background-color:white; '></div>");
                $("#modalL-img-box").append("<div id='line3' style='left:294px; top:90px; transform:rotate(1deg); transform-origin:0% 0%; position:absolute; width:10px; height:380px; background-color:white; '></div>");
                $("#modalL-img-box").append("<div id='line4' style='left:294px; top:90px; transform:rotate(-1deg); transform-origin:0% 0%; position:absolute; width:10px; height:380px; background-color:white; '></div>");
                $("#modalL-img-box").append("<div id='line5' style='left:193px; top:90px; transform:rotate(-1.5deg); transform-origin:0% 0%; position:absolute; width:30px; height:380px; background-color:white; '></div>");
                $("#modalL-img-box").append("<div id='line6' style='left:374px; top:90px; transform:rotate(1.5deg); transform-origin:0% 0%; position:absolute; width:30px; height:380px; background-color:white; '></div>");
                $("#modalL-img-box").append("<div id='line7' style='border-left:5px red solid; left:250px; top:15px; position:absolute; height:"+product_leg_length_pixel+"px;'></div>");
                $("#modalL-img-box").append("<div id='line8' style='z-index:10; left:260px; top:"+product_leg_length_pixel/2+"px; position:absolute; color:red;'></div>");
                $("#line8").text("제품 총기장 : "+size+"cm");
                $("#modalL-img-box").append("<div id='line9' style='background-image:url(\"../web/icon/arrow2.png \"); background-size:100% 100%; left:50px; top:15px; position:absolute; width:50px; height:395px;'></div>");
                $("#modalL-img-box").append("<div id='line10' style='z-index:10; left:90px; top:200px; position:absolute; color:red;'></div>");
                $("#line10").text("내 다리길이 : "+my_leg_length+"cm");
                if(my_leg_length>size)
                {
                    $("#modalL-img-box").append("<div id='line11' style='border-left:5px red solid; left:275px; top:"+(product_leg_length_pixel+16)+"px; position:absolute; " +
                        "height:"+(410-product_leg_length_pixel-16)+"px;'></div>");
                    $("#modalL-img-box").append("<div id='line12' style='border-right:5px blue dashed; border-top-right-radius:50%; border-bottom-right-radius:50%; left:250px; " +
                        "top:"+(product_leg_length_pixel+16)+"px; position:absolute; height:"+(410-product_leg_length_pixel-16)+"px; width:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line13' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line13").text("발끝부터 "+((my_leg_length-size).toFixed(2))+"cm 만큼 올라갑니다.");
                }
                else if(my_leg_length<size)
                {
                    $("#modalL-img-box").append("<div id='line11' style='border-right:5px blue dashed; border-top-right-radius:50%; border-bottom-right-radius:50%; left:225px; " +
                        "top:410px; position:absolute; height:"+(product_leg_length_pixel+15-410)+"px; width:50px;'></div>");
                    $("#modalL-img-box").append("<div id='line12' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line12").text("발끝부터 "+(size-my_leg_length).toFixed(2)+"cm 만큼 내려옵니다.");
                }else
                {
                    $("#modalL-img-box").append("<div id='line11' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                        "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                    $("#line12").text("바지 밑단이 발끝까지 옵니다.");
                }
                temp_text = "하의 총기장";
            }
            else if(str=='허리')//허리 카테고리 일 때 동작하는 코드이다.
            {
                var my_waist = <?php echo $my_waist?>;
                var product_waist = size*2;
                var product_with = 185+(product_waist-my_waist)*2;
                $('#modalL-img').attr("src","./icon/bottom.png");
                $("#modalL-img-box").append("<div id='line1' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; border-right:2px red solid; " +
                    "border-top:2px red dashed; left:206px; top:140px; position:absolute; width:185px; height:20px;'></div>");
                $("#modalL-img-box").append("<div id='line2' style='z-index:10; left:260px; top:110px; position:absolute; color:red;'></div>");
                $("#line2").text("내 허리둘레 : "+my_waist+"cm");
                $("#modalL-img-box").append("<div id='line3' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; border-right:2px red solid; " +
                    "border-top:2px red dashed; left:206px; top:175px; position:absolute; width:"+product_with+"px; height:20px;'></div>");
                $("#modalL-img-box").append("<div id='line4' style='z-index:10; left:260px; top:210px; position:absolute; color:red;'></div>");
                $("#line4").text("제품 허리둘레 : "+product_waist+"cm");
                $("#modalL-img-box").append("<div id='line5' style='border-left:2px red solid; left:205px; top:130px; height:80px; position:absolute;'></div>");
                temp_text = "허리둘레";
                $("#modalL-img-box").append("<div id='line11' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                    "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                if(product_waist>my_waist)
                {
                    $("#line11").text("허리 둘레가 "+(product_waist-my_waist).toFixed(2)+"cm 만큼 여유가 있습니다.");
                }else if(my_waist>product_waist)
                {
                    $("#line11").text("허리 둘레가 "+(my_waist-product_waist).toFixed(2)+"cm 만큼 작습니다.");
                }else
                {
                    $("#line11").text("제품과 허리 둘레가 동일합니다.");
                }

            }
            else if(str=='허벅지')//허벅지 카테고리 일 때 동작하는 코드이다.    둘레같은 경우에는 너무 미세한 차이임으로 시각화가 힘들다고 판단하여 픽셀의 차이를 *2하여 보여준다.
            {
                $('#modalL-img').attr("src","./icon/thigh.png");
                var my_thigh = <?php echo $my_thigh?>;
                var product_thigh = size*2;
                var product_with = 148+(product_thigh-my_thigh)*2;
                console.log("허벅지둘레"+product_thigh);
                $("#modalL-img-box").append("<div id='line1' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; " +
                    "border-right:2px red solid; border-top:2px red dashed; left:129px; top:150px; position:absolute; width:148px; height:20px;'></div>");
                $("#modalL-img-box").append("<div id='line2' style='z-index:10; left:130px; top:120px; position:absolute; color:red;'></div>");
                $("#line2").text("내 허벅지둘레 : "+my_thigh+"cm");
                $("#modalL-img-box").append("<div id='line3' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; " +
                    "border-right:2px red solid; border-top:2px red dashed; left:318px; top:150px; position:absolute; width:"+product_with+"px; height:20px;'></div>");
                $("#modalL-img-box").append("<div id='line4' style='z-index:10; left:315px; top:120px; position:absolute; color:red;'></div>");
                $("#line4").text("제품 허벅지둘레 : "+product_thigh+"cm");
                temp_text = "허벅지둘레";
                $("#modalL-img-box").append("<div id='line5' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                    "opacity:0.9; left:370px; top:380px; width:230px; height:80px; position:absolute; color:red;'></div>");
                if(product_thigh>my_thigh)
                {
                    $("#line5").text("허벅지 둘레가 "+(product_thigh-my_thigh).toFixed(2)+"cm 만큼 여유가 있습니다.");
                }else if(my_thigh>product_thigh)
                {
                    $("#line5").text("허벅지 둘레가 "+(my_thigh-product_thigh).toFixed(2)+"cm 만큼 작습니다.");
                }else
                {
                    $("#line5").text("제품과 허벅지 둘레가 동일합니다.");
                }
            }
            else if(str=='밑단')//밑단 카테고리 일 때 동작하는 코드이다.
            {
                $('#modalL-img').attr("src","./icon/ankle.png");
                var my_ankle = <?php echo $my_ankle?>;
                var product_ankle = size*2;
                var product_with = 69+(product_ankle-my_ankle)*2;
                $("#modalL-img-box").append("<div id='line1' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; border-right:2px red solid; " +
                    "border-top:2px red dashed; left:172px; top:184px; position:absolute; width:69px; height:15px;'></div>");
                $("#modalL-img-box").append("<div id='line2' style='z-index:10; left:130px; top:150px; position:absolute; color:red;'></div>");
                $("#line2").text("내 발목둘레 : "+my_ankle+"cm");
                $("#modalL-img-box").append("<div id='line3' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; border-right:2px red solid; " +
                    "border-top:2px red dashed; left:359px; top:184px; position:absolute; width:"+product_with+"px; height:15px;'></div>");
                $("#modalL-img-box").append("<div id='line4' style='z-index:10; left:330px; top:150px; position:absolute; color:red;'></div>");
                $("#line4").text("제품 밑단둘레 : "+product_ankle+"cm");
                temp_text = "밑단둘레";
                $("#modalL-img-box").append("<div id='line5' style='border:1px grey solid; border-top-left-radius:10px; padding-top:30px; border-top-right-radius:10px; background-color:white; " +
                    "opacity:0.9; left:370px; top:380px; width:230px; height:100px; position:absolute; color:red;'></div>");
                if(product_ankle>my_ankle)
                {
                    $("#line5").text("밑단 둘레가 발목 둘레보다 "+(product_ankle-my_ankle).toFixed(2)+"cm 만큼 여유가 있습니다.");
                }else if(my_ankle>product_ankle)
                {
                    $("#line5").text("밑단 둘레가 발목 둘레보다 "+(my_ankle-product_ankle).toFixed(2)+"cm 만큼 작습니다.");
                }else
                {
                    $("#line5").text("제품의 밑단과 발목 둘레가 동일합니다.");
                }
            }
            else if(str=='엉덩이')//엉덩이 카테고리 일 때 동작하는 코드이다. - 아직 만들지 않았다. 추후에 엉덩이 둘레카테고리가 존재하는 제품이 있다면 만들어야 한다.
            {
                var my_hip = <?php echo $my_hip?>;
                $('#modalL-img').attr("src","./icon/bottom.png");
                $("#modalL-img-box").append("<div id='line6' style='border-radius:50%; border-bottom:2px red solid; border-left:2px red solid; border-right:2px red solid; border-top:2px red dashed; left:229px; top:70px; position:absolute; width:139px; height:20px;'></div>");
                temp_text = "엉덩이둘레";
            }
        }
        $(".modalL-title").text(temp_text);

        //위의 코드로 모달창 내부를 완성시키고 아래 코드로 모달창을 페이지에 생성시킨다.
        $("#myModalL").modal("show");
    }
    if(typeof Object.values === 'undefined') {
        Object.values = function(obj) {
            var array = new Array();
            for (var key in obj) {
                array.push(obj[key]);
            }
            return array;
        }
    }

    if(typeof Object.keys === 'undefined') {
        Object.keys = function(obj) {
            var array = new Array();
            for (var key in obj) {
                array.push(obj[key]);
            }
            return array;
        }
    }
</script>

</html>
