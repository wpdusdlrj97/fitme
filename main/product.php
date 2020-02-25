<!--제품 상세 페이지-->
<?php
session_start();
$product=$_GET['product']; //제품의 식별을 위해 이전 페이지에서 GET방식으로 제품 식별을 위한 값을 넘겨 받는다.
$_SESSION['URL'] = 'http://49.247.136.36/main/product.php?product='.$product;//세션에 현재 페이지를 저장한다. ( 만일 로그인 시도가 일어날 경우에 되돌아 오기 위해 )
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from product where product_key='$product'");
$row = mysqli_fetch_array($qry);
//추후에 이메일을 상호명으로 바꿔야함


//아래서 사용할 데이터들을 각 변수에 저장한다
$s_n = $row['email'];
$get_shop_name = mysqli_query($connect,"select * from shop_name where email='$s_n'");
$get_s_n = mysqli_fetch_array($get_shop_name);
$category1 = $row['category1'];
$category2 = $row['category2'];
$shop_name = $get_s_n['name'];
$name = $row['name'];
$ex = $row['ex'];
$price = $row['price'];
$size = json_decode($row['size'],true);
$size_key = array_keys($size);
$content = $row['content'];
$detail_image = json_decode($row['detail_image'],true);
$fitme_image = $row['fitme_image'];
$line_position = $row['line_position'];
$stock = $row['stock'];
$date = $row['date'];
$color_name = json_decode($row['color'],true)['name'];
$color_rgb = json_decode($row['color'],true)['rgb'];
$email = $_SESSION['email'];
$likes = false;
$user_need_option=null;
//비교 카테고리와 사용자의 사이즈 키워드를 매칭시키기 위해 오브젝트로 생성
if($category1=='OUTER'||$category1=='TOP'||$category1=='ONEPIECE'){
    $user_need_option = ['총장'=>'상체길이','어깨너비'=>'어깨너비','가슴단면'=>'가슴둘레','소매길이'=>'팔길이','허리'=>'허리둘레','엉덩이'=>'힙둘레','허벅지'=>'허벅지둘레'];
}else{
    if($category1=='PANTS'){
        $user_need_option = ['총장'=>'다리길이','어깨너비'=>'어깨너비','가슴단면'=>'가슴둘레','소매길이'=>'팔길이','허리'=>'허리둘레','엉덩이'=>'힙둘레','밑단'=>'발목둘레','허벅지'=>'허벅지둘레'];
    }else{
        $user_need_option = ['총장'=>'다리길이','어깨너비'=>'어깨너비','가슴단면'=>'가슴둘레','소매길이'=>'팔길이','허리'=>'허리둘레','엉덩이'=>'힙둘레','허벅지'=>'허벅지둘레'];
    }
}
//비교이미지 경로 ( 사이즈 비교 카테고리와 매칭시키기 위해 오브젝트로 생성 )
$compare_image_location=null;
if($category1=='OUTER'||$category1=='TOP'){
    if($category2=='COAT'){
        $compare_image_location=['전체'=>'/web/compare/COAT/total_for_web.png','총장'=>'/web/compare/COAT/clothes_length/coat_upper_body_image_',
            '어깨너비'=>'/web/compare/COAT/shoulder/coat_shoulder_image_','가슴단면'=>'/web/compare/COAT/chest/coat_chest_image_','소매길이'=>'/web/compare/COAT/arm/coat_arm_image_'];
    }else{
        $compare_image_location=['전체'=>'/web/compare/TOP/total_for_web.png','총장'=>'/web/compare/TOP/clothes_length/upper_body_image_',
            '어깨너비'=>'/web/compare/TOP/shoulder/shoulder_image_','가슴단면'=>'/web/compare/TOP/chest/chest_image_','소매길이'=>'/web/compare/TOP/arm/arm_image_'];
    }
}else{
    if($category1=='SKIRT'){
        $compare_image_location=['전체'=>'/web/compare/SKIRT/total_for_web.png','총장'=>'/web/compare/SKIRT/clothes_length/skirt_leg_image_',
            '허리'=>'/web/compare/SKIRT/waist/skirt_waist_image_','엉덩이'=>'/web/compare/SKIRT/hip/skirt_hip_image_'];
    }else if($category1=='PANTS'){
        $compare_image_location=['전체'=>'/web/compare/PANTS/total_for_web.png','총장'=>'/web/compare/PANTS/clothes_length/leg_image_','허리'=>'/web/compare/PANTS/waist/waist_image_',
            '엉덩이'=>'/web/compare/PANTS/hip/hip_image_','허벅지'=>'/web/compare/PANTS/thigh/thigh_image_','밑단'=>'/web/compare/PANTS/ankle/ankle_image_'];
    }else if($category1=='ONEPIECE'){
        $compare_image_location=['전체'=>'/web/compare/ONEPIECE/total_for_web.png','총장'=>'/web/compare/ONEPIECE/clothes_length/onepiece_upper_body_image_'
            ,'어깨너비'=>'/web/compare/ONEPIECE/shoulder/onepiece_shoulder_image_','가슴단면'=>'/web/compare/ONEPIECE/chest/onepiece_chest_image_'
            ,'소매길이'=>'/web/compare/ONEPIECE/arm/onepiece_arm_image_'];
    }
}
$user_size=null;
if($email)
{
    $get_information = mysqli_query($connect,"select *from user_information where email='$email'");
    $result = mysqli_fetch_array($get_information);
    if($category1=='OUTER'||$category1=='TOP'||$category1=='ONEPIECE'){
        $user_size = ['상체길이'=>$result['top_length'],'어깨너비'=>$result['shoulder_length'],'가슴둘레'=>$result['chest_size'],'팔길이'=>$result['arm_length'],'허리둘레'=>$result['waist_size'],
            '힙둘레'=>$result['hip_size'],'발목둘레'=>$result['ankle_size'],'허벅지둘레'=>$result['thigh_size'],'키'=>$result['height_length']];
    }else{
        $user_size = ['다리길이'=>$result['leg_length'],'어깨너비'=>$result['shoulder_length'],'가슴둘레'=>$result['chest_size'],'팔길이'=>$result['arm_length'],'허리둘레'=>$result['waist_size'],
            '힙둘레'=>$result['hip_size'],'발목둘레'=>$result['ankle_size'],'허벅지둘레'=>$result['thigh_size'],'키'=>$result['height_length']];
    }
    $image_array = json_decode($result['photos'],true)['photo'];
    $location_array = json_decode($result['photos'],true)['location'];
    $default_image_size=array();
    for($i=0;$i<count($image_array);$i++)
    {
        array_push($default_image_size,getimagesize($image_array[$i]));
    }
    $likes_qry = mysqli_query($connect,"select * from likes where product_key=$product and email='$email'");
    $likes_result = mysqli_fetch_array($likes_qry);
    if($likes_result)
    {
        $likes = true;
    }
}
$likes_all = mysqli_query($connect,"select * from likes where product_key=$product");
$likes_all_result = mysqli_num_rows($likes_all);
// 상태 토큰으로 사용할 랜덤 문자열을 생성
$state = 'xyz';
// 세션 또는 별도의 저장 공간에 상태 토큰을 저장
$_SESSION['state'] = $state;

//리뷰가져오기
$all_count = null;
$text_count = null;
$photo_count = null;
$text_review_email = array();
$text_review_star = array();
$text_review_text = array();
$text_review_date = array();

$photo_review_email = array();
$photo_review_star = array();
$photo_review_text = array();
$photo_review_date = array();
$photo_review_photo = array();

$all_review_email = array();
$all_review_star = array();
$all_review_text = array();
$all_review_date = array();
$all_review_photo = array();

$qry = mysqli_query($connect,"select * from review where product_key=$product order by date desc;");
$all_count = mysqli_num_rows($qry);
$all_page=0;
$a_p_c=0;
while($row=mysqli_fetch_array($qry))
{
    if($a_p_c==10)
        break;
    array_push($all_review_email,$row['email']);
    array_push($all_review_star,$row['star']);
    array_push($all_review_text,$row['review_text']);
    array_push($all_review_date,$row['date']);
    array_push($all_review_photo,$row['photo']);
    $a_p_c++;
}

$qry = mysqli_query($connect,"select * from review where product_key=$product and photo is null order by date desc;");
$text_count = mysqli_num_rows($qry);
$text_page=0;
$t_p_c=0;
while($row=mysqli_fetch_array($qry))
{
    if($t_p_c==10)
        break;
    array_push($text_review_email,$row['email']);
    array_push($text_review_star,$row['star']);
    array_push($text_review_text,$row['review_text']);
    array_push($text_review_date,$row['date']);
    $t_p_c++;
}

$qry = mysqli_query($connect,"select * from review where product_key=$product and photo is not null order by date desc;");
$photo_count = mysqli_num_rows($qry);
$photo_page=0;
$p_p_c=0;
while($row=mysqli_fetch_array($qry))
{
    if($p_p_c==10)
        break;
    array_push($photo_review_email,$row['email']);
    array_push($photo_review_star,$row['star']);
    array_push($photo_review_text,$row['review_text']);
    array_push($photo_review_date,$row['date']);
    array_push($photo_review_photo,$row['photo']);
    $p_p_c++;
}
//Q&A 1페이지 가져오기
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from qna where product_key=$product order by date desc");
$qna_all_count = mysqli_num_rows($qry);
$qna_last_page = ceil($qna_all_count/10);
$qna_count=0;
$qna_key_array = array();
$qna_email_array = array();
$qna_state_array = array();
$qna_text_array = array();
$qna_date_array = array();
$qna_hidden_array = array();
$qna_answer_text_array = array();
$qna_answer_date_array = array();
while($row = mysqli_fetch_array($qry))
{
    if($qna_count<10)
    {
        array_push($qna_key_array,$row['qna_key']);
        array_push($qna_email_array,$row['email']);
        array_push($qna_date_array,$row['date']);
        array_push($qna_hidden_array,$row['hidden']);
        if($row['hidden']=='2'||($row['hidden']=='1'&&$row['email']==$email))
        {
            array_push($qna_text_array,$row['text']);
        }
        else
        {
            array_push($qna_text_array,null);
        }
        array_push($qna_state_array,$row['state']);
        $qna_key = $row['qna_key'];
        $qry2 = mysqli_query($connect,"select * from qna_answer where qna_key=$qna_key");
        $result = mysqli_fetch_array($qry2);
        if(($row['state']=='2'&&($row['email']==$email)))
        {
            array_push($qna_answer_date_array, date('Y/m/d', strtotime(substr($result['date'], 0, 7))));
            array_push($qna_answer_text_array,$result['text']);
        }
        else
        {
            array_push($qna_answer_date_array, date('Y/m/d', strtotime(substr($result['date'], 0, 7))));
            array_push($qna_answer_text_array,'비밀글입니다.');
        }
        $qna_count++;
    }
    else
    {
        break;
    }
}
mysqli_close($connect);
//코트만 다른 이미지 이므로 확인을 거치고 난 뒤 이미지 가져오기
if($category1=='OUTER'){
    if($category2=='COAT'){
        $size_image_url = "/web/compare/COAT/";
    }else{
        $size_image_url = "/web/compare/TOP/";
    }
}else{
    $size_image_url = "/web/compare/".$category1."/";
}
$need_not=0;
for($size_name_count=1;$size_name_count<count($size_key);$size_name_count++) {
    if ($size_key[$size_name_count] == "밑위") {
        $need_not++;
    }
    if ($category1 != "PANTS" && $size_key[$size_name_count] == "밑단") {
        $need_not++;
    }
}
$cookie_json= json_decode($_COOKIE['fitme_p'],true);
setcookie('fitme_p','1',time() - 86400 * 7);
for($cookie_count=0;$cookie_count<count($cookie_json);$cookie_count++){
    if($cookie_json[$cookie_count]==$product){
        array_splice($cookie_json,$cookie_count,1);
        $cookie_count--;
    }
}

if($cookie_json){
    if(count($cookie_json)>19){
        array_splice($cookie_json,19,1);
        array_unshift($cookie_json,$product);
    }else{
        array_unshift($cookie_json,$product);
    }
}else{
    $cookie_json = array($product);
}
$ar_cookie = json_encode($cookie_json,JSON_UNESCAPED_UNICODE);

setcookie('fitme_p', $ar_cookie, time() + 86400 * 7);

//echo $cookie_json.'<br>';
//for($cook_c=0;$cook_c<count($cookie_json);$cook_c++){
//    if($cookie_json[$cook_c]==$product){
//        array_splice($cookie_json,$cook_c,1);
//        break;
//    }
//}
//print_r($cookie_json);
//if($cookie_json){
//    if(count($cookie_json)==5){
//        //마지막 인덱스 삭제후 0번인덱스에 삽입
//        $cookie_json = array_pop($cookie_json);
//        array_unshift($cookie_json,$product);
//    }else{
//        //0번 인덱스에 삽입
//        array_unshift($cookie_json,$product);
//    }
//    print_r($cookie_json);
//}else{
//    $cookie_json = array();
//    array_unshift($cookie_json,$product);
//}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oswald|Work+Sans|Suranna&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/api/swiper.css">
    <link rel="stylesheet" href="/api/swiper.min.css">
    <script src="/api/swiper.js"></script>
    <script src="/api/swiper.min.js"></script>
    <script src="/api/selectric/jquery.selectric.min.js"></script>
    <link rel="stylesheet" href="/api/selectric/selectric.css">
    <title>FITME</title>
    <style>
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        body{ padding:0; margin:0; -ms-user-select: none; -moz-user-select: -moz-none; -webkit-user-select: none; -khtml-user-select: none; user-select:none; }
        #product_body{ width:1300px; margin:0 auto; overflow-x:hidden; }
        .product_top_contents{ float:left; margin-top:50px; margin-left:15px; }
        .product_top_parents_category, .product_top_parents_none_place{ font-size:13px; color:#6E6E6E; font-family: 'Noto Sans KR', sans-serif; float:left; cursor:pointer; }
        .product_top_parents_category:hover, .product_top_parents_none_place:hover{ transition:all 200ms linear; color:#A4A4A4; }
        .product_detail_contents_top{ float:left; width:100%; margin-top:20px; }
        .product_detail_top_images{ float:left; width:574px; }
        .product_detail_top_image{ width:100%; height:574px; background-size:100% 100%; }
        .product_detail_top_image_list{ float:left; width:100%; margin-top:10px; }
        .product_detail_top_next_image{ float:left; width:80px; height:80px; margin:5px; background-size:100% 100%; cursor:pointer; }
        .product_detail_top_next_image:hover{ transition:all 200ms linear; border:1px black solid; }
        .product_detail_top_text_box{ float:right; margin-right:15px; width:520px; }
        .product_detail_top_name{ float:left; width:100%; font-size:28px; font-family: 'Lato', sans-serif; }
        .product_detail_top_ex{ float:left; width:100%; font-size:14px; margin-top:20px; font-family: 'Noto Sans KR', sans-serif; }
        .product_detail_top_none_place{ float:left; width:100%; border-top:1px lightgrey solid; margin:30px 0 30px 0; }
        .product_detail_top_table{ width:100%; float:left; font-family: 'Noto Sans KR', sans-serif; }
        .product_detail_top_table_tr{ height:40px; }
        .product_detail_top_table_td1{ width:50%; text-align:left; font-size:13px; color:#848484;  }
        .product_detail_top_table_td2{ width:50%; text-align:right; font-size:14px; }
        .product_detail_top_table_color, .product_detail_top_table_size{ font-size:13px; width:130px; text-align:center; float:right; height:30px; margin-top:0px; }
        input[type="number"]::-webkit-outer-spin-button, input[type="number"]::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .product_detail_top_add_product_count_input:focus, .product_detail_top_table_color:focus, .product_detail_top_table_size:focus{ outline:none; }
        .product_detail_top_add_place{ float:left; width:100%; margin-top:30px; font-family: 'Lato', sans-serif; }
        .product_detail_top_add_product{ float:left; width:100%; height:100px; border-bottom:1px #D8D8D8 solid; }
        .product_detail_top_add_product_left{ float:left; width:45%; height:100%; }
        .product_detail_top_add_product_name{ float:left; max-height:54px; min-height:30px; width:100%; margin-top:14px; font-size:12px; overflow:hidden; }
        .product_detail_top_add_product_color{ float:left; height:30px; width:100%; margin-top:6px; font-size:11px; color:#6E6E6E; }
        .product_detail_top_add_product_right{ float:left; width:55%; height:100%; }
        .product_detail_top_add_product_count{ float:left; height:30px; margin-top:35px; border-top:1px #BDBDBD solid; border-bottom:1px #BDBDBD solid; text-align: center; font-size:12px; }
        .product_detail_top_add_product_count_decrease{ float:left; width:20px; border-left:1px #BDBDBD solid; border-right:1px #BDBDBD solid; line-height:30px; cursor:pointer; }
        .product_detail_top_add_product_count_input{ float:left; width:35px; border:none; height:27px; font-size:11px; text-align:center; }
        .product_detail_top_add_product_count_increase{ float:left; width:20px; border-left:1px #BDBDBD solid; border-right:1px #BDBDBD solid; line-height:30px; cursor:pointer; }
        .product_detail_top_add_product_delete{ float:right; cursor:pointer; width:20px; height:20px; text-align: center; border-radius:1px; font-size:11px; line-height:18px; margin-top:40px; background:#848484; color:white; }
        .product_detail_top_add_product_price{ float:right; height:30px; margin-top:35px; line-height:30px; font-size:12px; margin-right:10px; }
        .swiper-container { width: 100%; height: 100%;}
        .swiper-slide { text-align: center; width:100%; height:100%; font-size: 18px; background: #fff; display: -webkit-box; display: -ms-flexbox; display: -webkit-flex; display: flex; -webkit-box-pack: center;
            -ms-flex-pack: center; -webkit-justify-content: center; justify-content: center; -webkit-box-align: center; -ms-flex-align: center; -webkit-align-items: center; align-items: center; }
        .product_detail_top_buttons{ float:left; margin-top:50px; width:100%; height:130px; font-family: 'Lato', sans-serif; }
        .product_buy_it_now_button{ float:left; width:100%; height:55px; margin-bottom:20px; cursor:pointer; }
        .product_add_to_cart_button, .product_like_it_button{ width:45%; height:51px; border:2px solid; cursor:pointer; }
        .product_top_buttons_text{ float:left; line-height:53px; padding-left:20px; font-size:15px; }
        .product_top_buttons_arrow{ float:right; line-height:53px; padding-right:20px; font-size:25px; }
        .product_top_buttons_like_image{ float:left; margin:10px 10px 10px 20px; width:31px; height:31px; background-size:100% 100%; }
        .product_top_buttons_like_text{ float:left; color:black; margin-top:23px; font-size:11px; }
        .hidden_770_bottom_place{ display:none; position:fixed; bottom:0; width:100%; background:black; z-index:100; font-family: 'Lato', sans-serif; }
        .hidden_770_hidden_product_place{ float:left; width:100%; height:0; background:white; }
        .hidden_770_add_place{ float:left; width:100%; font-family: 'Lato', sans-serif; }
        .hidden_770_bottom_button1{ float:left; height:50px; line-height:48px; text-align:center; color:white; font-size:12px; cursor:pointer; }
        .hidden_770_bottom_button2{ float:right; width:66px; height:50px; background:#D8D8D8; cursor:pointer; }
        .hidden_770_like_image{ float:left; width:30px; height:30px; margin:10px 0 0 17px; background-size:100% 100%; }
        .product_detail_top_add_place_move{ float:left; width:100%; }
        .product_total_price{ margin-top:20px; float:left; width:100%; height:40px; line-height:40px; font-family: 'Lato', sans-serif; color:#424242; }
        .product_total_price_text{ font-size:17px; }
        .top_center_none_place{ float:left; width:100%; margin:30px 0 30px 0; }
        .product_category_box{ width:340px; margin:0 auto; }
        .product_category_text{ float:left; width:100px; height:70px; line-height:68px; text-align:center; letter-spacing: 1.2px; font-size:16px; font-family: 'Suranna', serif; cursor:pointer; color:#A4A4A4; }
        .product_category_text:hover{ transition:all 200ms linear; color:black; }
        .product_category_text_slash{ float:left; width:20px; height:70px; line-height:68px; text-align:center; font-size:11px; font-family: 'Lato', sans-serif; color:#A4A4A4; }
        .product_category_box_parents_hidden{ width:100%; height:1px; float:left; opacity:0; }
        .product_category_box_parents{ float:left; width:100%; background:white; z-index:500; }
        .product_category_contents_box{ margin:15px; float:left; border-top:1px #D8D8D8 solid; }
        #product_category_contents{ float:left; width:100%; margin-top:30px; font-family: 'Lato', sans-serif; }
        .hidden_770_hidden_product_place{ overflow-y:auto; }
        .hidden_770_option_box{ width:100%; float:left; }
        .hidden_770_add_place{ float:left; margin-top:30px; width:94%; margin-left:3%; }
        .hidden_770_price_box{ float:left; width:94%; margin-left:3%; margin-bottom:40px; }
        .review_top_box{ float:left; width:100%; height:50px; padding:20px 0 20px 0; border-bottom:1px #D8D8D8 solid; font-family: 'Suranna', serif; }
        .review_top_left_text{ float:left; line-height:49px; font-size:20px; letter-spacing: 1.2px; }
        .review_top_right_box{ float:right; font-size:13px; }
        .review_top_right_text{ float:right; line-height:49px; cursor:pointer; color:#A4A4A4; letter-spacing: 1.2px; font-family: 'Suranna', serif; }
        .review_top_right_text:hover{ transition:all 200ms linear; color:black; }
        .review_top_right_slash{ float:right; line-height:49px; font-size:11px; padding:0 2vw 0 2vw; color:#D8D8D8; }
        .product_review_star { width:100px; margin-top:15px;float:left; margin-left:10px; }
        .product_review_star,.product_review_star span { display:inline-block; height:18.5px; overflow:hidden; background:url('/web/icon/star.png')no-repeat; }
        .product_review_star span{ background-position:left bottom; line-height:0; vertical-align:top; }
        .product_review_list{ float:left; width:100%; }
        .product_review_none{ float:left; width:100%; height:300px; line-height:299px; text-align:center; margin:10px 0 10px 0; }
        .product_review{ float:left; width:100%; margin:10px 0 10px 0; padding-bottom:10px; border-bottom:1px #BDBDBD solid; }
        .product_review_left{ float:left; width:60%; }
        .product_review_left_top{ float:left; width:100%; }
        .product_review_userid{ float:left; font-size:19px; height:50px; line-height:49px; }
        .product_review_left_text_box{ float:left; width:100%; font-size:12px; height:95px; overflow:hidden; }
        .product_reivew_left_none_place{ float:left; width:100%; height:1px; }
        .product_review_left_text_box_more{ float:left; margin:5px 0 5px 0; padding:5px 10px 5px 0; color:#610B0B; font-size:14px; font-weight:bold; cursor:pointer; }
        .product_review_left_photo_box{ margin-top:20px;float:left; max-width:130px; height:150px; cursor:pointer; }
        .product_review_right{ float:left; margin-left:2%; width:38%; }
        #review_photo_modal { display: none; position: fixed; z-index: 200; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); }
        .review_photo_modal_content { border-radius:10px; opacity:0; background-color: #fefefe; margin-left: 30%; margin-right:30%; margin-top:50px; padding: 20px; border: 1px solid #888; width: 40%; }
        .review_photo_modal_close { color: #aaa; font-size: 28px; font-weight: bold; float:right; position:absolute; left:70%; }
        .review_photo_modal_close:hover, .review_photo_modal_close:focus { color: black; text-decoration: none; cursor: pointer; }
        .product_review_next_page{ width:40%; cursor:pointer; border:1px #BDBDBD solid; margin-left:30%; font-size:14px; line-height:59px; text-align:center; height:60px; float:left; color:black; }
        .product_review_next_page:hover{ background:#BDBDBD; font-weight:bold; }
        .product_review_right_text_box1, .product_review_right_text_box2{ float:left; font-size:14px; margin-right:25px; color:#585858; }
        .product_review_right_line_hidden{ display:none; float:left; width:100%; height:1px; margin:15px 0 15px 0; }
        .product_category_qna_box{ float:left; width:100%; font-family: 'Suranna', serif; }
        .product_category_qna_top_text{ float:left; width:100%; height:50px; line-height:49px; font-size:34px; margin-bottom:40px; text-align:center; color:#8B8B8B; }
        .product_category_qna_contents_table{ float:left; width:100%; margin-bottom:10px; font-family: 'Lato', sans-serif; }
        .product_category_qna_contents_ul_p{ float:left; width:100%; margin:0; padding:0; list-style:none; height:46px; border-top:1px #E6E6E6 solid; border-bottom:1px #E6E6E6 solid; font-size:14px; text-align:center; }
        .product_category_qna_contents_li_p1{ float:left; width:10%; line-height:45px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_li_p2{ float:left; width:13%; line-height:45px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_li_p3{ float:left; width:40%; margin-left:2%; line-height:45px; height:100%; padding:0; list-style:none; }
        .product_category_qna_contents_li_p4{ float:left; width:25%; line-height:45px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_li_p5{ float:left; width:10%; line-height:45px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_ul_c{ float:left; width:100%; margin:0; padding:0; list-style:none; height:55px; border-bottom:1px #E6E6E6 solid; font-size:11px; text-align:center; cursor:pointer; }
        .product_category_qna_contents_ul_c:hover{ background:#F2F2F2; }
        .product_category_qna_contents_li_c1{ float:left; width:10%; line-height:54px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_li_c2{ float:left; width:13%; line-height:54px; height:100%; margin:0; padding:0; list-style:none; }
        .product_category_qna_contents_li_c3{ float:left; width:40%; margin-left:2%; text-align:left; line-height:54px; height:100%; padding:0; list-style:none; overflow:hidden; text-overflow: ellipsis; white-space:nowrap; }
        .product_category_qna_contents_li_c4{ float:left; width:25%; line-height:54px; height:100%; margin:0; padding:0; list-style:none; overflow:hidden; }
        .product_category_qna_contents_li_c5{ float:left; width:10%; line-height:54px; height:100%; margin:0; padding:0; list-style:none; }
        .qna_contents_li_c3_hidden_box{ float:left; }
        .qna_contents_li_c3_hidden_image{ float:right; width:20px; height:20px; margin-top:17px; background-image:url('/web/icon/lock.png'); background-size:100% 100%; }
        .qna_contents_li_c3_hidden_text{ float:left; width:54%; margin-left:1%; text-align:left; }
        #qna_modal{ font-family: 'Noto Sans KR', sans-serif; display: none; position: fixed; z-index: 200; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4); }
        .qna_modal_center{ width:400px; margin:0 auto; }
        .qna_modal_content{ opacity:0; float:left; border-radius:10px; background-color: #fefefe; padding: 20px; border: 1px solid #888; width: 100%; margin-top:150px; }
        .qna_modal_top{ float:left; width:100%; height:40px; }
        .qna_modal_title{ float:left; font-size:18px; line-height:40px; }
        .qna_modal_close{ color: #aaa; font-size: 28px; font-weight: bold; float:right; cursor:pointer; }
        .qna_modal_close:hover, .qna_modal_close:focus { color: black; text-decoration: none; cursor: pointer; }
        .qna_modal_product_name_box{ float:left; font-size:14px; width:100%; height:40px; margin-top:30px; }
        .qna_modal_product_name_left{ float:left;width:50px; text-align:left; color:#8B8B8B; }
        .qna_modal_product_name_right{ float:left; overflow:hidden; margin-left:20px; text-align:left; }
        .qna_modal_product_qna_box{ float:left; font-size:14px; width:100%; margin-top:5px; }
        .qna_modal_product_qna_left{ float:left; width:50px; text-align:left; color:#8B8B8B; }
        .qna_modal_product_qna_right{ font-size:13px; outline:none; float:left; border-radius:5px; height:200px; padding:10px; width:308px; margin-left:20px; text-align:left; }
        .qna_ok_btn{ width:110px; cursor:pointer; height:40px; border:1px #D8D8D8 solid; float:right; margin-top:20px; font-size:13px; line-height:39px; text-align:center; }
        .qna_ok_btn:hover{ background:black; color:white; border:1px black solid; transition:all 100ms linear; }
        .qna_modal_product_hidden_box{ float:left; font-size:14px; width:100%; height:40px; margin-top:5px; }
        .qna_modal_product_hidden_left{ float:left;width:50px; text-align:left; color:#8B8B8B; }
        .qna_modal_product_hidden_right{ float:left; width:15px; height:15px; margin-left:20px; }
        .product_category_qna_contents_write{ float:left; width:100%; }
        .product_qna_write_button{ float:right; text-align:center; border:1px #D8D8D8 solid; cursor:pointer; line-height:35px; width:100px; height:35px; font-size:14px; }
        .product_category_qna_answer_ul_c{ float:left; width:100%; margin:0; padding:0; list-style:none; background:#F2F2F2; border-bottom:1px #E6E6E6 solid; cursor:pointer; font-size:11px; }
        .product_category_qna_answer_state{ padding:0; list-style:none; margin-left:20%; width:10%; height:100%; font-size:24px; text-align:center; float:left; line-height:54px; }
        .product_category_qna_answer_text{ float:left; width:34%; margin-left:1%; height:100%; padding:0; list-style:none; line-height:54px; font-weight:bold; }
        .product_category_qna_answer_id{ text-align:center; width:25%; float:left; padding:0; list-style:none; margin:0; line-height:54px; }
        .product_category_qna_answer_date{ text-align:center; width:10%; float:left; padding:0; list-style:none; margin:0; line-height:54px; }
        .product_category_qna_open_ul_c{ float:left; width:100%; height:100%; border-bottom:1px #E6E6E6 solid; margin:0; padding:0; list-style:none; background:#F2F2F2; }
        .product_category_qna_open_text{ margin-left:25%; padding:0; list-style:none; float:left; width:40%; font-size:11px; text-align:left; line-height:54px; }
        /*Q&A 수정버튼*/
        /*.product_category_qna_open_button{ float:right; margin-right:10px; margin-top:10px; line-height:35px; width:100px; font-size:11px; text-align:center; border:1px #BDBDBD solid; height:35px; cursor:pointer; background:white; }*/
        .product_category_qna_contents_page{ float:left; width:100%; height:40px; text-align:center; margin-bottom:50px; }
        .prev{ height:30px; line-height:30px; margin:0 10px 0 0; padding:5px; cursor:pointer; color:black; }
        .next{ height:30px; line-height:30px; margin:0 0 0 10px; padding:5px; cursor:pointer; color:black; }
        .page{ height:30px; line-height:30px; margin:0 5px 0 5px; padding:5px; cursor:pointer; color:#8B8B8B; }
        .page:hover{ transition:all 100ms linear; color:black; }
        .prev:hover, .next:hover{ font-weight:bold; transition:all 100ms linear; }
        .product_information_size_table_bottom{ margin-top:10px; text-align: right; margin-right:10px; font-size:12px; float:right; }
        .product_preview_size_image_box{ float:left; width:500px; padding:15px 0 15px 0;  text-align:center; height:530px; }
        .product_preview_size_image_category{ width:100%; height:50px; font-size:14px; font-family: 'Work Sans', sans-serif; border-spacing:0; }
        .product_preview_size_image_category_td{ text-align:center; padding-bottom:15px; color:#848484; cursor:pointer; border-bottom:1px #DBDBDB solid; }
        .product_preview_size_image_category_td:hover{ font-weight:bold; color:#8A2908; transition:all 100ms linear; border-bottom:1px #8A2908 solid; }
        .product_preview_size_image{ max-height:400px; margin-top:15px; max-width:400px; }
        .product_preview_size_table_box{ float:right; width:calc(100% - 530px); }
        .product_preview_size_table_title{ float:left; width:100%; font-weight:bold; margin-bottom:10px; margin-top:10px; font-size:20px; text-align:center; color:#8A4B08; font-family: 'Suranna', serif; }
        .product_preview_size_table_p{ float:left; width:100%; font-size:12px; }
        .product_preview_size_table_p_h_tr{ float:left; width:100%; margin:0; padding:0; line-height:40px; list-style:none; text-align:center; height:40px; }
        .product_preview_size_table_p_h_td_first{ float:left; width:5px; height:100%; }
        .product_preview_size_table_p_h_td{ float:left; font-weight:bold; font-size:13px; background:#FAFAFA; margin:0; padding:0; list-style:none; height:100%; }
        .product_preview_size_table_p_b_tr{ float:left; width:100%; margin:0; padding:0; line-height:40px; list-style:none; text-align:center; height:40px; cursor:pointer; }
        .product_preview_size_table_p_b_tr:hover{ transition:all 100ms linear; background:#D8D8D8; }
        .product_preview_size_table_p_b_td_first{ float:left; width:5px; height:100%; }
        .product_preview_size_table_p_b_td{ float:left; margin:0; padding:0; list-style:none; height:100%; }
        .product_preview_size_table_m{ float:left; width:100%; font-size:11px; }
        .product_preview_size_table_m_h_tr{ float:left; width:100%; margin:0; padding:0; line-height:40px; list-style:none; text-align:center; height:40px; }
        .product_preview_size_table_m_h_td{ float:left; font-weight:bold; font-size:12px; background:#FAFAFA; margin:0; padding:0; list-style:none; height:100%; }
        .product_preview_size_table_m_b_tr{ float:left; width:100%; margin:0; padding:0; line-height:39px; list-style:none; text-align:center; height:40px; font-size:11px; }
        .product_preview_size_table_m_b_td{ float:left; padding:0; list-style:none; height:39px; }
        .product_preview_user_size_input{ width:100%; height:calc(100% - 2px); font-size:10px; border:none; outline:none; text-align:center; }
        .product_preview_compare_text{ float:left; width:calc(100% - 2px); padding:20px 0 20px 0; font-size:16px; color:#8A2908; text-align:center; font-weight:bold; border:#D8D8D8 1px solid; }
        .product_preview_all_box{ float:left; margin-bottom:50px; }
        .product_preview_clothes_all_box{ float:left; width:100%; margin-bottom:50px; }
        .product_preview_clothes_title_box{ cursor:pointer; }
        .product_preview_clothes_title_image{ float:left; width:20px; height:20px; margin:55px 0 0 0; opacity:0.5; }
        .product_preview_clothes_title_text{ float:left; width:200px; height:70px; line-height:70px; margin-top:30px; text-align:center; font-size:30px; color:#848484; font-family: 'Suranna', serif; }
        .product_preview_clothes_title_line{ float:left; width:calc( 100% - 220px ); height:1px; margin-top:66px; border-top:1px #BDBDBD solid; }
        .product_preview_clothes_contents_box{ float:left; width:80%; margin-left:10%; }
        .product_preview_contents_box{ height:480px; margin-bottom:50px; margin-top:30px; float:left; width:100%; }
        .product_preview_contents_user_image_box{ float:left; height:100%; width:49%; border:1px #E6E6E6 solid; text-align:center; overflow:hidden; }
        .product_preview_contents_user_image{ height:100%; }
        .product_preview_contents_image_box{ float:left; height:100%; width:50%; }
        .product_preview_content_product_information{ float:left; border-top:1px #E6E6E6 solid; border-left:1px #E6E6E6 solid; border-right:1px #E6E6E6 solid; text-align:center; height:50px; width:100%; line-height:50px; font-size:17px; }
        .product_preview_content_product_image_box{ float:left; width:100%; border:1px #E6E6E6 solid; cursor:pointer; }
        .product_preview_content_product_image{ float:left; width:200px; margin-left:calc(50% - 100px); }
        .product_preview_content_product_image_box:hover{ border:1px #848484 solid; transition:all 200ms linear; }
        .product_preview_size_check_box_all{ text-align:center; font-size:12px; float:left; width:100%; border-bottom:1px #E6E6E6 solid; border-left:1px #E6E6E6 solid; border-right:1px #E6E6E6 solid; }
        .product_preview_content_size_change_select{ width:100%; height:30px; float:left; margin-bottom:5px; }
        .product_preview_size_check_box{ width:calc(50% - 20px); float:left; padding:10px; }
        .product_preview_size_check_text{ float:left; height:20px; line-height:20px; }
        .product_preview_size_check_image{ margin-top:3px; float:left; height:15px; width:15px; margin-left:3px; }
        .product_preview_content_product_information_title{ width:100%; float:left; }
        .hidden_770_preview_product_image{ display:none; bottom:100%; left:calc(100% - 70px); width:60px; height:60px; position:relative; overflow:hidden; border-radius:100%; background:white; border:1px #E6E6E6 solid; }
        .hidden_770_preview_product_image:hover{ background:#D8D8D8; transition:all 200ms linear; cursor:pointer; }
        @media (max-width:1320px)
        {
            #product_body{ width:100%; }
            .product_detail_top_name{ font-size:26px; transition:all 200ms linear; }
            .product_detail_top_add_product_left{ width:45%; transition:all 200ms linear; }
            .product_detail_top_add_product_right{ width:50%; transition:all 200ms linear; }
            .product_detail_top_add_product_name{ font-size:12px; transition:all 200ms linear; }
            .product_detail_top_add_product_color{ font-size:11px; transition:all 200ms linear; }
            .product_detail_top_add_product_price{ font-size:12px; transition:all 200ms linear; }
        }
        /*상품 3개씩 보여주기*/
        @media (max-width:1120px)
        {
            .product_detail_top_name{ font-size:24px; transition:all 200ms linear; }
            .product_detail_top_ex{ font-size:12px; transition:all 200ms linear; }
            .product_detail_top_table_td1{ font-size:12px; transition:all 200ms linear; }
            .product_detail_top_table_td2{ font-size:12px; transition:all 200ms linear; }
            .product_detail_top_table_color{ font-size:11px; transition:all 200ms linear; }
            .product_detail_top_add_product_left{ width:40%; transition:all 200ms linear; }
            .product_detail_top_add_product_right{ width:60%; transition:all 200ms linear; }
            .product_detail_top_add_product_name{ font-size:11px; transition:all 200ms linear; }
            .product_detail_top_add_product_color{ font-size:10px; transition:all 200ms linear; }
            .product_detail_top_add_product_price{ font-size:10px; transition:all 200ms linear; }
            .product_detail_top_text_box{ margin-top:0; }
            .product_review_right_line_hidden{ display:block;}
            .product_review_right_text_box1, .product_review_right_text_box2{ margin-right:0; width:50%; text-align:center; transition:all 200ms linear; }
        }
        @media (max-width:990px)
        {
            .product_top_contents{ display:none; }
            .product_detail_top_text_box{ float:left; margin-top:40px; }
            .product_detail_top_add_product_left{ width:45%; transition:all 200ms linear; }
            .product_detail_top_add_product_right{ width:50%; transition:all 200ms linear; }
            .product_detail_top_add_product_name{ font-size:12px; transition:all 200ms linear; }
            .product_detail_top_add_product_color{ font-size:11px; transition:all 200ms linear; }
            .product_detail_top_add_product_price{ font-size:12px; transition:all 200ms linear; }
            #head_category_place{ display:none; }
            .product_review_next_page{ width:50%; margin-left:25%; }
            .product_preview_size_table_box{ width:100%; }
            .product_preview_size_image_box{ width:100%; }
            .product_preview_contents_box{ height:320px; }
            .product_preview_content_product_image{ float:left; width:100px; margin-left:calc(50% - 50px); }
            .product_preview_size_check_box_all{ font-size:10px; }

        }
        @media (max-width:770px)
        {
            .product_detail_top_table{ display:none }
            .product_detail_top_add_place{ display:none }
            .product_total_price{ display:none }
            .product_detail_top_buttons{ display:none }
            .product_add_to_cart_button{ display:none }
            .product_like_it_button{ display:none }
            .product_detail_top_image_list{ display:none }
            .hidden_770_bottom_place{ display:block; }
            .product_total_price_text{ font-size:20px; }
            .product_category_box{ width:100%; }
            .product_category_text{ width:30%; }
            .product_category_text_slash{ width:5%; }
            .product_review_left{ width:100%; transition:all 200ms linear; }
            .product_review_right{ margin-left:0; margin-top:20px; width:100%; transition:all 200ms linear; }
            .product_review_next_page{ width:60%; margin-left:20%; }
            .review_top_left_text{ font-size:18px; letter-spacing: 1.1px; transition:all 200ms linear; }
            .review_top_right_box{ font-size:12px; letter-spacing: 1.1px; transition:all 200ms linear; }
            .product_category_qna_contents_ul_c{ font-size:10px; }
            .product_category_qna_answer_ul_c{ font-size:10px; }
            .product_category_qna_open_text{ font-size:10px; }
            .product_preview_size_check_box_all{ font-size:12px; }
            .product_preview_contents_box{ height:480px; }
            .product_preview_clothes_contents_box{ margin-left:0; width:100%; }
            .product_preview_contents_user_image_box, .product_preview_contents_image_box{ border:none; width:100%; }
            .product_preview_content_product_image{ float:left; width:100%; margin-left:0; }
            .product_preview_contents_user_image_box{ width:100%; }
            .product_preview_content_product_information{ border-bottom:1px #E6E6E6 solid;  }
            .product_preview_content_product_image_box{ display:none }
            .hidden_770_preview_product_image{ display:block; }
        }
        @media(max-width:600px)
        {
            .review_top_box{ height:100px; }
            .review_top_left_text{ font-size:15px; letter-spacing: 1px; width:100%; margin-left:10px; text-align:center; transition:all 200ms linear; }
            .review_top_right_box{ font-size:11px; letter-spacing: 1px; width:100%; text-align:center; transition:all 200ms linear; float:left; }
            .review_top_right_text{ width:32%; float:left; margin:0; padding:0; }
            .review_top_right_slash{ width:1%; float:left; margin:0; padding:0; }
            .product_category_text{ font-size:14px; }
            .product_category_text_slash{ font-size:9px; }
            .qna_modal_center{ width:100%; margin:0; height;100%; }
            .qna_modal_content{ width:93%; margin-left:1px; padding:3%; margin-top:0; border-radius:0; }
            .product_category_qna_contents_ul_c{ font-size:9px; }
            .product_category_qna_answer_ul_c{ font-size:9px; }
            .qna_modal_product_qna_right{ width:60%; }
            .product_category_qna_open_text{ font-size:9px; }
            .product_preview_size_image_category{width:100%;}
        }
        @media(max-width:400px){
            .product_preview_contents_box{ height:320px; }
            .product_preview_all_box{ width:100%; }
        }
    </style>
</head>
<body>
<div id="header"></div>
<script>
    $('#header').load("./head.php");
</script>
<div id="product_body">
<!--    상단 카테고리 -->
    <div class="product_top_contents">
        <div class="product_top_parents_category" onclick="location.href='/main/main.php'">HOME&nbsp;&nbsp;</div>
        <div class="product_top_parents_none_place">></div>
        <div class="product_top_parents_category" onclick="location.href='/main/category.php?category1=<?php echo $category1?>'" >&nbsp;&nbsp;<?php echo $category1?>&nbsp;&nbsp;</div>
        <div class="product_top_parents_none_place">></div>
        <div class="product_top_parents_category" style="color:black;" onclick="location.href='/main/category.php?category1=<?php echo $category1?>&category2=<?php echo $category2?>'">&nbsp;&nbsp;<?php echo $category2?></div>
    </div>
<!--    상단부 이미지, 상품 간단 정보등이 들어갈 공간-->
    <div class="product_detail_contents_top">
        <div class="product_detail_contents_top_p_l" style="float:left; margin-left:15px;">
            <div class="product_detail_top_images">
                <div class="product_detail_top_image">
<!--                    swiper plugin 사용 -->
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php for($detail_image_count=0;$detail_image_count<count($detail_image);$detail_image_count++){?>
                                <div class="swiper-slide">
                                    <img class="swiper-image" src="<?php echo $detail_image[$detail_image_count]?>" style="max-width:100%; height:100%;">
                                </div>
                            <?php }?>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
<!--                이미지 thumbnail -->
                <div class="product_detail_top_image_list">
                    <?php for($detail_image_count=0;$detail_image_count<count($detail_image);$detail_image_count++) if($detail_image_count==0){?>
                        <div class="product_detail_top_next_image" style="border:1px black solid; background-image:url('<?php echo $detail_image[$detail_image_count]?>')" ></div>
                    <?php }else{?>
                        <div class="product_detail_top_next_image" style="border:1px white solid; background-image:url('<?php echo $detail_image[$detail_image_count]?>')" ></div>
                    <?php }?>
                </div>
            </div>
        </div>
        <div class="product_detail_top_text_box">
            <div class="product_detail_top_name"><?php echo $name?></div>
            <div class="product_detail_top_ex"><?php echo $ex?></div>
            <div class="product_detail_top_none_place"></div>
            <table class="product_detail_top_table">
                <tr class="product_detail_top_table_tr">
                    <td class="product_detail_top_table_td1">PRICE</td>
                    <td class="product_detail_top_table_td2" style="font-size:17px;"><?php echo number_format($price)?> won</td>
                </tr>
                <tr class="product_detail_top_table_tr">
                    <td class="product_detail_top_table_td1">DELIVERY</td>
                    <td class="product_detail_top_table_td2">무료배송</td>
                </tr>
                <tr class="product_detail_top_table_tr">
                    <td class="product_detail_top_table_td1">MILEAGE</td>
                    <td class="product_detail_top_table_td2"><?php echo number_format($price/100)?> won</td>
                </tr>
                <tr class="product_detail_top_table_tr">
                    <td class="product_detail_top_table_td1">SIZE</td>
                    <td id="size_parents" class="product_detail_top_table_td2">
                        <select class="product_detail_top_table_size">
                            <option class="product_detail_top_table_size_option" selected>SIZE 선택</option>
                            <?php for($i=0;$i<count($size["SIZE"]);$i++){?>
                                <option class="product_detail_top_table_size_option"><?php echo $size["SIZE"][$i]?></option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="product_detail_top_table_tr">
                    <td class="product_detail_top_table_td1">COLOR</td>
                    <td id="color_parents" class="product_detail_top_table_td2">
                        <select class="product_detail_top_table_color">
                            <option class="product_detail_top_table_color_option" selected>COLOR 선택</option>
                            <?php
                            for($color_count=0;$color_count<count($color_name);$color_count++)
                            {?>
                                <option class="product_detail_top_table_color_option"><?php echo $color_name[$color_count]?></option>
                            <?php }
                            ?>
                        </select>
                    </td>
                </tr>
            </table>
            <div class="product_detail_top_add_place">
                <div class="product_detail_top_add_place_move">

                </div>
            </div>
            <div class="product_total_price">
                <div class="product_total_price_text">Total Price : 0 won</div>
            </div>
            <div class="product_detail_top_buttons">
                <div class="product_buy_it_now_button" style="background:#0A122A;">
                    <div class="product_top_buttons_text" style="color:white;">BUY IT NOW</div>
                    <div class="product_top_buttons_arrow" style="color:white;">></div>
                </div>
                <div class="product_add_to_cart_button" style="float:left;">
                    <div class="product_top_buttons_text" style="color:black;">ADD TO CART</div>
                    <div class="product_top_buttons_arrow">></div>
                </div>
                <div class="product_like_it_button" style="float:right;">
                    <div class="product_top_buttons_like_image" style="<?php if($likes){?> background-image:url('/web/icon/heart_red.png'); <?php }else{?> background-image:url('/web/icon/heart_white.png'); <?php }?>"></div>
                    <div class="product_top_buttons_like_text"><?php echo $likes_all_result?>명이 좋아합니다.</div>
                </div>
            </div>
        </div>
    </div>
    <div class="top_center_none_place"></div>
</div>
<!--상품정보, 입어보기, 리뷰 등 카테고리 (스크롤 에 따라 화면 상단에 붙도록 설정함)-->
<div class="product_category_box_parents_hidden"></div>
<div class="product_category_box_parents">
    <div class="product_category_box">
        <div class="product_category_text" style="color:black;">Information</div>
        <div class="product_category_text_slash">/</div>
        <div class="product_category_text">Review(<?php echo $all_count?>)</div>
        <div class="product_category_text_slash">/</div>
        <div class="product_category_text">Q&A(<?php echo $qna_all_count?>)</div>
    </div>
</div>
<div id="product_body">
    <div class="product_category_contents_box">
        <!--        상품 정보       -->
        <div id="product_category_contents" class="product_category_contents1" style="display:block;">
            <div class="product_preview_all_box">
                <?php
                if($email&&$image_array&&$line_position){?>
                    <div class="product_preview_clothes_all_box">
                        <div class="product_preview_clothes_title_box">
                            <img class="product_preview_clothes_title_image" src="/web/icon/collapse.png">
                            <div class="product_preview_clothes_title_text">Pre Dress</div>
                            <div class="product_preview_clothes_title_line"></div>
                        </div>
                        <div class="product_preview_clothes_contents_box">
                            <div class="hidden_770_preview_title" style="width:100%; float:left;"></div>
                            <div class="product_preview_contents_box">
                                <div id="fitme_image_parent" class="product_preview_contents_user_image_box">
                                    <img class="product_preview_contents_user_image" head="<?php echo $location_array[0][0] ?>" pelvis="<?php echo $location_array[0][1] ?>" foot="<?php echo $location_array[0][2] ?>" src="<?php echo $image_array[0];?>">
                                    <div class="hidden_770_preview_product_image"></div>
                                </div>
                                <div class="product_preview_contents_image_box">
                                    <div class="product_preview_content_product_information_title">
                                        <div class="product_preview_content_product_information"><?php echo $name;?> (size : <?php echo $size['SIZE'][0]?>)</div>
                                    </div>

                                    <div class="product_preview_content_product_image_box">
                                        <img class="product_preview_content_product_image" src="<?php echo $fitme_image;?>">
                                    </div>
                                    <div class="product_preview_size_check_box_all">
                                        <select class="product_preview_content_size_change_select">
                                            <?php for($i=0;$i<count($size["SIZE"]);$i++){?>
                                                <option class="product_preview_content_size_option"><?php echo $size["SIZE"][$i]?></option>
                                            <?php } ?>
                                        </select>
                                        <?php
                                        for($size_check_count=1;$size_check_count<count($size_key);$size_check_count++){ if($size_key[$size_check_count]!='밑위'){ if($category1!='PANTS'&&$size_key[$size_check_count]!='밑단'){
                                            if($user_size[$user_need_option[$size_key[$size_check_count]]]){
                                                if($size[$size_key[$size_check_count]][0]!='-'){?>
                                                    <div class="product_preview_size_check_box" key="<?php echo $size_key[$size_check_count]?>">
                                                        <div class="product_preview_size_check_text"></div>
                                                        <img class="product_preview_size_check_image" src="/web/icon/arrow_up.png">
                                                    </div>
                                                <?php }}?>
                                        <?php }else{
                                            if($user_size[$user_need_option[$size_key[$size_check_count]]]){
                                                if($size[$size_key[$size_check_count]][0]!='-'){?>
                                                <div class="product_preview_size_check_box" key="<?php echo $size_key[$size_check_count]?>">
                                                    <div class="product_preview_size_check_text"></div>
                                                    <img class="product_preview_size_check_image" src="/web/icon/arrow_up.png">
                                                </div>
                                            <?php }}}}}?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php }?>

                <div class="product_preview_size_image_box" >
                    <table class="product_preview_size_image_category">
                        <td class="product_preview_size_image_category_td" style="border-bottom:2px #8A2908 solid; font-weight:bold; color:#8A2908;">전체</td>
                        <?php for($preview_size_count=1;$preview_size_count<count($size_key);$preview_size_count++){
                            if($size_key[$preview_size_count]!="밑위"){
                                if($category1!="PANTS"){
                                    if($size_key[$preview_size_count]!="밑단"){
                                        if($preview_size_count==1){?>
                                            <td class="product_preview_size_image_category_td"><?php echo $size_key[$preview_size_count]?></td>
                                        <?php }else{?>
                                            <td class="product_preview_size_image_category_td"><?php echo $size_key[$preview_size_count]?></td>
                                        <?php }
                                    }
                                }else{
                                    if($preview_size_count==1){?>
                                        <td class="product_preview_size_image_category_td"><?php echo $size_key[$preview_size_count]?></td>
                                    <?php }else{?>
                                        <td class="product_preview_size_image_category_td"><?php echo $size_key[$preview_size_count]?></td>
                                    <?php }
                                }
                            }
                        }?>
                    </table>
                    <div class="preivew_size_select_box" style="width:100%; height:30px; float:left;">
                        <select class="preview_size_select" style="width:100px; height:28px; float:left; margin-top:4px;">
                            <?php for($i=0;$i<count($size["SIZE"]);$i++){?>
                                <option class="preview_size_select_option"><?php echo $size["SIZE"][$i]?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <img class="product_preview_size_image" src="<?php echo $size_image_url?>total_for_web.png">
                </div>
                <div class="product_preview_size_table_box">
                    <div class="product_preview_size_table_title">Product SIZE</div>
                    <div class="product_preview_size_table_p">
                        <ul class="product_preview_size_table_p_h_tr">
                            <li class="product_preview_size_table_p_h_td_first"></li>
                            <?php for($preview_size_count=0;$preview_size_count<count($size_key);$preview_size_count++){ if($preview_size_count==0){?>
                                <li class="product_preview_size_table_p_h_td" style="width:calc(<?php echo 100/count($size_key).'%'?> - <?php echo 5/count($size_key).'px'?> );"><?php echo $size_key[$preview_size_count]?></li>
                            <?php }else{?>
                                <li class="product_preview_size_table_p_h_td" style="width:calc(<?php echo 100/count($size_key).'%'?> - <?php echo 5/count($size_key).'px'?> );"><?php echo $preview_size_count.'. '.$size_key[$preview_size_count]?></li>
                            <?php }}?>
                        </ul>
                        <?php
                        for($preview_size_count_k=0;$preview_size_count_k<count($size['SIZE']);$preview_size_count_k++){?>
                            <ul class="product_preview_size_table_p_b_tr">
                                <?php if($preview_size_count_k==0){?>
                                    <li class="product_preview_size_table_p_b_td_first" style="background:#8A2908;"></li>
                                <?php }else{?>
                                    <li class="product_preview_size_table_p_b_td_first"></li>
                                <?php } for($preview_size_count=0;$preview_size_count<count($size_key);$preview_size_count++){
                                    if($preview_size_count_k==0){?>
                                        <li class="product_preview_size_table_p_b_td" style="background:#D8D8D8; width:calc(<?php echo 100/count($size_key).'%'?> - <?php echo 5/count($size_key).'px'?> );"><?php echo $size[$size_key[$preview_size_count]][$preview_size_count_k]?></li>
                                    <?php }else{?>
                                        <li class="product_preview_size_table_p_b_td" style="width:calc(<?php echo 100/count($size_key).'%'?> - <?php echo 5/count($size_key).'px'?> );"><?php echo $size[$size_key[$preview_size_count]][$preview_size_count_k]?></li>
                                    <?php }}?>
                            </ul>
                        <?php }?>
                        <div class="product_information_size_table_bottom">&diams; 기준 : 단면 / &diams; 단위 : cm</div>
                    </div>
                    <div class="product_preview_size_table_title">My SIZE</div>
                    <div class="product_preview_size_table_m">
                        <ul class="product_preview_size_table_m_h_tr">
                            <?php for($size_name_count=1;$size_name_count<count($size_key);$size_name_count++){ if($size_key[$size_name_count]!="밑위"){ if($category1!="PANTS"){
                                if($size_key[$size_name_count]!="밑단"){?>
                                    <li class="product_preview_size_table_m_h_td" style="width:<?php echo 100/(count($size_key)-1-$need_not)?>%"><?php echo $user_need_option[$size_key[$size_name_count]]?></li>
                                <?php }
                            }else{?>
                                <li class="product_preview_size_table_m_h_td" style="width:<?php echo 100/(count($size_key)-1-$need_not)?>%"><?php echo $user_need_option[$size_key[$size_name_count]]?></li>
                            <?php }}}?>
                        </ul>
                        <ul class="product_preview_size_table_m_b_tr">
                            <?php
                            if($email){ for($size_name_count=1;$size_name_count<count($size_key);$size_name_count++){ if($size_key[$size_name_count]!="밑위"){ if($category1!="PANTS"){if($size_key[$size_name_count]!="밑단"){?>
                                <li class="product_preview_size_table_m_b_td" style="background:#FAFAFA; width:<?php echo 100/(count($size_key)-1-$need_not)?>%; margin:0;"><?php echo $user_size[$user_need_option[$size_key[$size_name_count]]]?></li>
                            <?php }}else{?>
                                <li class="product_preview_size_table_m_b_td" style="background:#FAFAFA; width:<?php echo 100/(count($size_key)-1-$need_not)?>%; margin:0;"><?php echo $user_size[$user_need_option[$size_key[$size_name_count]]]?></li>
                            <?php }}}
                            }else{
                                for($size_name_count=1;$size_name_count<count($size_key);$size_name_count++){
                                    if($size_key[$size_name_count]!="밑위"){
                                        if($category1!="PANTS"){
                                            if($size_key[$size_name_count]!="밑단"){
                                                if($size_name_count==1){?>
                                                    <li class="product_preview_size_table_m_b_td" style="margin-left:1px; border:1px #D8D8D8 solid; width:calc(<?php echo 100/(count($size_key)-1-$need_not).'%'?> - 3px); line-height:0;">
                                                        <input class="product_preview_user_size_input" placeholder="cm" type="number">
                                                    </li>
                                                <?php }else{?>
                                                    <li class="product_preview_size_table_m_b_td" style="border-right:1px #D8D8D8 solid; border-top:1px #D8D8D8 solid; border-bottom:1px #D8D8D8 solid; width:calc(<?php echo 100/(count($size_key)-1-$need_not).'%'?> - 1px); margin:0; line-height:0;">
                                                        <input class="product_preview_user_size_input" placeholder="cm" type="number">
                                                    </li>
                                                <?php }
                                            }
                                        }else{
                                            if($size_name_count==1){?>
                                                <li class="product_preview_size_table_m_b_td" style="margin-left:1px; border:1px #D8D8D8 solid; width:calc(<?php echo 100/(count($size_key)-1-$need_not).'%'?> - 3px); line-height:0;">
                                                    <input class="product_preview_user_size_input" placeholder="cm" type="number">
                                                </li>
                                            <?php }else{?>
                                                <li class="product_preview_size_table_m_b_td" style="border-right:1px #D8D8D8 solid; border-top:1px #D8D8D8 solid; border-bottom:1px #D8D8D8 solid; width:calc(<?php echo 100/(count($size_key)-1-$need_not).'%'?> - 1px); margin:0; line-height:0;">
                                                    <input class="product_preview_user_size_input" placeholder="cm" type="number">
                                                </li>
                                            <?php }
                                        }
                                    }
                                }
                            }?>
                        </ul>
                        <div class="product_information_size_table_bottom">&diams; 기준 : 둘레 / &diams; 단위 : cm</div>
                    </div>
                </div>
                <div class="product_preview_compare_text">상품과 사이즈 비교를 해보세요</div>
                <!--      미리 입어보기 공간 (사용자 사진에 제품 이미지를 올리는 방식      -->
            </div>
<!--            상품 정보         -->
            <?php echo $content?>
        </div>
        <!--        리뷰       -->
        <div id="product_category_contents" class="product_category_contents2" style="display:none;">
            <div class="review_top_box">
                <div class="review_top_left_text">Total Review : <?php echo $all_count?></div>
                <div class="review_top_right_box">
                    <div class="review_top_right_text">Photo Review(<?php echo $photo_count?>)</div>
                    <div class="review_top_right_slash">/</div>
                    <div class="review_top_right_text">Text Review(<?php echo $text_count?>)</div>
                    <div class="review_top_right_slash">/</div>
                    <div class="review_top_right_text" style="color:black;">All(<?php echo $all_count?>)</div>
                </div>
            </div>
<!--            리뷰 목록 들어올 공간-->
            <div class="product_review_list">
                <?php if($all_count<1){?>
<!--                    리뷰 없을 때-->
                    <div class="product_review_none">작성된 리뷰가 없습니다.</div>
                <?php }else{ for($review_c=0;$review_c<$a_p_c;$review_c++){ ?>
<!--                    최초 리뷰 - all -->
                    <div class="product_review">
                        <div class="product_review_left">
                            <div class="product_review_left_top">
                                <div class="product_review_userid"><?php echo $all_review_email[$review_c]?></div>
                                <span class="product_review_star">
                                    <span style="width:<?php echo ((float)$all_review_star[$review_c]*20)?>%;"></span>
                                </span>
                            </div>
                            <div class="product_review_left_text_box">
                                <?php echo $all_review_text[$review_c]?>
                            </div>
                            <div class="product_reivew_left_none_place"></div>
                            <div class="product_review_left_text_box_more">...더보기</div>
                            <div class="product_reivew_left_none_place"></div>
                            <?php  if($all_review_photo[$review_c]){ ?>
                                <img class="product_review_left_photo_box" src="<?php echo $all_review_photo[$review_c]?>">
                            <?php } ?>
                        </div>
                        <div class="product_review_right">
                            <div class="product_review_right_box" style="float:left; width:calc(100% - 30px); padding:15px; background:white;">
                                <div class="product_review_right_top" style="width:100%; height:40px; line-height:39px; margin-bottom:20px; text-align:center; font-size:15px; color:#424242;">Shop Information</div>
                                <div class="product_review_right_text" style="float:left; font-size:14px; color:#848484;" >Black / Free </div>
                                <div class="product_review_right_text" style="float:left; font-size:14px; color:#585858; margin-left:15px;">- 조금 작아요</div>
                                <div class="product_review_right_line" style="float:left; width:100%; height:1px; background:#BDBDBD; margin:15px 0 15px 0;" ></div>
                                <div class="product_review_right_text_box1">키 - 181cm</div>
                                <div class="product_review_right_text_box1">몸무게 - 70kg</div>
                                <div class="product_review_right_line_hidden"></div>
                                <div class="product_review_right_text_box2">상의 - 100</div>
                                <div class="product_review_right_text_box2">하의 - 30</div>
                                <div class="product_review_right_text_box_hidden" style="float:left; width:100%;"></div>
                                <div class="product_review_right_line" style="float:left; width:100%; height:1px; background:#BDBDBD; margin:15px 0 15px 0;" ></div>
                                <div class="product_review_right_photos" style="float:left; width:100%; height:150px; line-height:149px; text-align:center; background:#F2F2F2;">사용자 포토리뷰 모음</div>
                            </div>
                        </div>
                    </div>
                    <?php }
                    if($a_p_c<$all_count)
                    {?>
                        <div class="product_review_next_page" onclick='next_page()'>Next Review</div>
                    <?php }}?>
            </div>
        </div>
        <!--        Q&A       -->
        <div id="product_category_contents" class="product_category_contents3" style="display:none;">
            <div class="product_category_qna_box">
                <div class="product_category_qna_top_text">Q&A</div>
                <div class="product_category_qna_contents_table">
                    <ul class="product_category_qna_contents_ul_p">
                        <li class="product_category_qna_contents_li_p1">No</li>
                        <li class="product_category_qna_contents_li_p2">State</li>
                        <li class="product_category_qna_contents_li_p3">Subject</li>
                        <li class="product_category_qna_contents_li_p4">Id</li>
                        <li class="product_category_qna_contents_li_p5">Date</li>
                    </ul>
                    <?php
                    for($qna_c=0;$qna_c<count($qna_key_array);$qna_c++)
                    {?>
                        <ul class="product_category_qna_contents_ul_c">
                            <li class="product_category_qna_contents_li_c1"><?php echo $qna_all_count-$qna_c?></li>
                            <?php if($qna_state_array[$qna_c]=='1'){ ?>
                                <li class="product_category_qna_contents_li_c2">답변대기</li>
                            <?php }else{ ?>
                                <li class="product_category_qna_contents_li_c2" style="font-weight:bold;">답변완료</li>
                            <?php }?>
                            <?php if($qna_text_array[$qna_c]==null){?>
                                <li class="product_category_qna_contents_li_c3">
                                    <div class="qna_contents_li_c3_hidden_box">
                                        <div class="qna_contents_li_c3_hidden_image"></div>
                                    </div>
                                    <div class="qna_contents_li_c3_hidden_text">비밀글입니다.</div>
                                </li>
                            <?php }else{?>
                                <li class="product_category_qna_contents_li_c3"><?php echo $qna_text_array[$qna_c]; ?></li>
                            <?php }?>
                            <li class="product_category_qna_contents_li_c4"><?php echo $qna_email_array[$qna_c]?></li>
                            <li class="product_category_qna_contents_li_c5"><?php echo date('Y/m/d',strtotime(substr($qna_date_array[$qna_c],0,7)))?></li>
                        </ul>
                    <?php }
                    ?>
                </div>
                <div class="product_category_qna_contents_write">
                    <div class="product_qna_write_button">Write</div>
                </div>
                <div class="product_category_qna_contents_page">
                    <a class="prev"><</a>
                    <a class="page" style="color:black;">1</a>
                    <?php for($qna_page_count=1;$qna_page_count<($qna_all_count/10);$qna_page_count++){
                        if($qna_page_count>9){
                            break;
                        }
                        ?>
                        <a class="page"><?php echo $qna_page_count+1?></a>
                    <?php }?>
                    <a class="next">></a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="footer"></div>
<script>
    $('#footer').load("./foot.php");
</script>
</body>
<!--모바일 용 구매 버튼 ( 770픽셀 이하 )-->
<div class="hidden_770_bottom_place">
    <div class="hidden_770_hidden_product_place">
        <div class="hidden_770_option_box">
        </div>
        <div class="hidden_770_add_place">
        </div>
        <div class="hidden_770_price_box"></div>
    </div>
    <div class="hidden_770_bottom_button1" style="background:#585858;">ADD TO CART</div>
    <div class="hidden_770_bottom_button1" style="background:#1C1C1C;">BUY IT NOW</div>
    <div class="hidden_770_bottom_button2">
        <div class="hidden_770_like_image" style="<?php if($likes){?> background-image:url('/web/icon/heart_red.png'); <?php }else{?> background-image:url('/web/icon/heart_white.png'); <?php }?>"></div>
    </div>
</div>

<!--포토리뷰 이미지 모달창 ( 이미지 클릭시 생성 )-->
<div id="review_photo_modal" class="review_photo_modal">
    <!-- Modal content -->
    <div class="review_photo_modal_content">
        <span class="review_photo_modal_close">&times;</span>
        <img class="review_photo_modal_image" style="width:100%;">
    </div>
</div>

<!--Q&A 모달창-->
<div id="qna_modal" class="qna_modal">
    <div class="qna_modal_center">
        <div class="qna_modal_content">
            <div class="qna_modal_top">
                <div class="qna_modal_title">상품문의</div>
                <span class="qna_modal_close">&times;</span>
            </div>
            <div class="qna_modal_product_name_box">
                <div class="qna_modal_product_name_left">상품명</div>
                <div class="qna_modal_product_name_right"><?php echo $name?></div>
            </div>
            <div class="qna_modal_product_hidden_box">
                <div class="qna_modal_product_hidden_left">비밀글</div>
                <input type="checkbox" class="qna_modal_product_hidden_right" checked>
            </div>
            <div class="qna_modal_product_qna_box">
                <div class="qna_modal_product_qna_left">문의</div>
                <textarea class="qna_modal_product_qna_right" placeholder="1000자 이내의 문의 내용을 입력해주세요" maxlength="1000"></textarea>
            </div>
            <div class="qna_ok_btn">작성</div>
        </div>
    </div>
</div>

<script>
    var price = <?php echo $price?>;
    var is770_porudct_place_open=false; //770픽셀 이하의 제품구매 공간 펼침유무 변수 초기화
    var resize_count=null;//화면 리사이징 끝난후 함수 실행을 위한 정수를 저장할 변수 ( 시간 함수 활용 )
    var now_category=0; //최초 카테고리 ( 상품 정보 )
    var next_category=0;    //클릭한 카테고리
    var iscategory_running=false;   //현재 카테고리변경 이벤트가 일어나고 있는지 확인;
    var p_scrollValue=0;  //현재 스크롤 값
    var category_top=0; //카테고리상단부 위치 ( 특정 위치에서 동적 이동 )
    var review_category_index=2;//현재 리뷰 카테고리 인덱스
    var review_category_page=0;
    var review_category_change=false;//현재 리뷰 카테고리가 바뀌고 있는지 확인할 변수
    var qna_answer_text = <?php echo json_encode($qna_answer_text_array)?>;
    var qna_answer_date = <?php echo json_encode($qna_answer_date_array)?>;
    var qna_page=1; //qna 페이지
    var qna_page_node_index=0;  //qna 페이지 노드 인덱스
    var qna_last_page = <?php echo $qna_last_page?>;    //qna 마지막 페이지
    var need_option_for_preview = <?php echo json_encode($user_need_option)?>;   //제공 옵션과 사용자 데이터의 비교를 위한 오브젝트
    var product_size_table_tr = 0;  //Product SIZE의 행번호
    var preview_category = 0; //preview 카테고리의 열번호
    var product_size_table_td = 0;
    var compare_image_location = <?php echo json_encode($compare_image_location)?>; //비교 이미지 경로를 가지고 있는 오브젝트
    var likes = false;
    var likes_count = parseInt("<?php echo $likes_all_result?>");
    <?php
    if($likes){?>
        likes = true;
    <?php }?>
    console.log('<?php echo json_encode($cookie_json)?>');
    //찜 기능 클릭시 이벤트
    $('.product_like_it_button').click(function(){
        like_this_product(this);
    });
    $('.hidden_770_bottom_button2').click(function(){
        like_this_product(this);
    });

    //찜 기능 클릭시 호출되는 함수
    function like_this_product(object)
    {
        var email = '<?php echo $email?>';
        var product_key = '<?php echo $product?>';
        if(email){
            var data=null;
            if(likes){
                data={number:'1',email:email,product_key:product_key};
            }else{
                data={number:'0',email:email,product_key:product_key};
            }
            console.log(data);
            $.ajax({
                type:"POST",
                url:"/main/likes_server.php",
                data : data,
                dataType : "text",
                success: function(string){
                    if(likes){
                        likes_count--;
                        likes = false;
                        $('.product_top_buttons_like_image').css("background-image","url('/web/icon/heart_white.png')");
                        $('.hidden_770_like_image').css("background-image","url('/web/icon/heart_white.png')");
                    }else{
                        likes = true;
                        likes_count++;
                        $('.product_top_buttons_like_image').css("background-image","url('/web/icon/heart_red.png')");
                        $('.hidden_770_like_image').css("background-image","url('/web/icon/heart_red.png')");
                    }
                    $('.product_top_buttons_like_text').text(likes_count+"명이 좋아합니다.");
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }else{
            location.href="http://49.247.136.36/main/fitme_session_login.php";
        }
    }


    <?php if($location_array&&$fitme_image&&$line_position){?>
        //사용자 좌표경로 최초 값, 상품 입혀보기 기능에서 사이즈 비교 default 값
        //옷입어보기 기능에 포함되는 사이즈 비교 텍스트를 작성하기 위한 코드
        var user_size = <?php echo json_encode($user_size)?>;
        var product_size = <?php echo json_encode($size)?>;
        var now_user_image_index = 0;//현재 사용자 이미지 인덱스
        var default_image_size = <?php echo json_encode($default_image_size)?>;//원본이미지사이즈
        var head = $('.product_preview_contents_user_image').attr("head")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];      //머리 좌표
        var pelvis = $('.product_preview_contents_user_image').attr("pelvis")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];   //골반 좌표
        var foot = $('.product_preview_contents_user_image').attr("foot")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];       //발끝 좌표
        var product_width, product_height;//제품 이미지내의 상품 너비, 높이
        var product_pic_height, product_pic_width;    //이미지 자체의 너비, 높이
        for(var size_check_count=0;size_check_count<$('.product_preview_size_check_box').length;size_check_count++){
            var size_check_p_size = product_size[$('.product_preview_size_check_box').eq(size_check_count).attr("key")][0];
            var size_check_u_size = user_size[need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]];
            if($('.product_preview_size_check_box').eq(size_check_count).attr("key")=='가슴단면'||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='엉덩이'
                ||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='허리'||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='허벅지'
                ||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='밑단'){
                size_check_p_size*=2;
            }
            if(size_check_p_size>size_check_u_size){
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : "+(size_check_p_size-size_check_u_size).toFixed(1)+"(cm)");
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/arrow_up.png");
            }else if(size_check_p_size<size_check_u_size){
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : "+(size_check_u_size-size_check_p_size).toFixed(1)+"(cm)");
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/arrow_down.png");
            }else{
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : 0(cm)");
                $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/equal.png");
            }
        }

        //옷입혀보기 이미지 클릭 이벤트 ( 오브젝트 생성 )
        //생성할 오브젝트의 크기를 지정해줘야함 ( image width, height )
        $('.product_preview_content_product_image').click(function(){
            if($('#product_fitme_image').length<1){
                var predressing_index = $('.product_preview_content_size_change_select option').index($('.product_preview_content_size_change_select option:selected'));//현재 사이즈 인덱스
                var category1 = '<?php echo $category1?>';//카테고리 확인을 위한 변수
                var line_position = JSON.parse(<?php echo json_encode($line_position)?>);
                var temp_width = 1;//임시 가로길이를 잡아주기 위한 변수
                //상품 이미지 내의 실제 상품 크기
                if(category1=='SKIRT'||category1=='PANTS'){
                    //foot - pelvis = x(총장 픽셀)
                    product_height = (foot-pelvis)*(product_size['총장'][predressing_index])/(<?php if($user_size['다리길이']){ echo $user_size['다리길이']; }else{ echo $user_size['키']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
                    temp_width = 1.2;
                }else{
                    //foot - head = x(총장 픽셀)
                    product_height = (foot-head)*(product_size['총장'][predressing_index])/(<?php if($user_size['키']){ echo $user_size['키']; }else{ echo $user_size['다리길이']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
                }
                //상품 이미지 자체 크기
                product_pic_height = product_height*(<?php echo getImagesize($fitme_image)[1];?>)/(line_position['y_bottom']-line_position['y_top']);
                product_pic_width = (<?php echo getImagesize($fitme_image)[0]; ?>)*product_pic_height/(<?php echo getImagesize($fitme_image)[1]; ?>)*temp_width;    //사진 가로픽셀 ( 임시용 )
                //상품 이미지 오브젝트 생성
                var div = document.createElement('img');
                div.id = 'product_fitme_image';
                document.getElementById('fitme_image_parent').appendChild(div);
                $(div).attr("src","<?php echo $fitme_image?>")
                    .css({
                        "width":product_pic_width,
                        "height":product_pic_height,
                        "z-index":"5",
                        "cursor":"pointer",
                        "position":"relative",
                        "top":-$('.product_preview_contents_box').height()+product_pic_height/2
                    })
                    .draggable({containment:'parent'});
            }
        });
        //옷입히기 기능 사이즈 변경 이벤트
        $('.product_preview_content_size_change_select').change(function(){
            var predressing_index = $('.product_preview_content_size_change_select option').index($('.product_preview_content_size_change_select option:selected'));//현재 사이즈 인덱스
            $('.product_preview_content_product_information').text("<?php echo $name.'(size : ' ?>"+$('.product_preview_content_size_change_select option:selected').text()+')');
            head = $('.product_preview_contents_user_image').attr("head")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];      //머리 좌표
            pelvis = $('.product_preview_contents_user_image').attr("pelvis")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];   //골반 좌표
            foot = $('.product_preview_contents_user_image').attr("foot")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];       //발끝 좌표
            if($('#product_fitme_image').length>0){
                //상품크기를 변경시켜야함
                var category1 = '<?php echo $category1?>';//카테고리 확인을 위한 변수
                var line_position = JSON.parse(<?php echo json_encode($line_position)?>);
                var temp_width=1;
                //상품 이미지 내의 실제 상품 크기
                if(category1=='SKIRT'||category1=='PANTS'){
                    //foot - pelvis = x(총장 픽셀)
                    product_height = (foot-pelvis)*(product_size['총장'][predressing_index])/(<?php if($user_size['다리길이']){ echo $user_size['다리길이']; }else{ echo $user_size['키']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
                    temp_width=1.2;
                }else{
                    //foot - head = x(총장 픽셀)
                    product_height = (foot-head)*(product_size['총장'][predressing_index])/(<?php if($user_size['키']){ echo $user_size['키']; }else{ echo $user_size['다리길이']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
                }
                //상품 이미지 자체 크기
                product_pic_height = product_height*(<?php echo getImagesize($fitme_image)[1];?>)/(line_position['y_bottom']-line_position['y_top']);
                product_pic_width = (<?php echo getImagesize($fitme_image)[0]; ?>)*product_pic_height/(<?php echo getImagesize($fitme_image)[1]; ?>)*temp_width;    //사진 가로픽셀 ( 임시용 )
                $('#product_fitme_image').css({"width":product_pic_width, "height":product_pic_height});
            }
            //사이즈비교 텍스트를 변경시켜줘야함 ( 옷입히기 기능 내부 )
            for(var size_check_count=0;size_check_count<$('.product_preview_size_check_box').length;size_check_count++){
                var size_check_p_size = product_size[$('.product_preview_size_check_box').eq(size_check_count).attr("key")][predressing_index];
                var size_check_u_size = user_size[need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]];
                if($('.product_preview_size_check_box').eq(size_check_count).attr("key")=='가슴단면'||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='엉덩이'
                    ||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='허리'||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='허벅지'
                    ||$('.product_preview_size_check_box').eq(size_check_count).attr("key")=='밑단'){
                    size_check_p_size*=2;
                }
                if(size_check_p_size>size_check_u_size){
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : "+(size_check_p_size-size_check_u_size).toFixed(1)+"(cm)");
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/arrow_up.png");
                }else if(size_check_p_size<size_check_u_size){
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : "+(size_check_u_size-size_check_p_size).toFixed(1)+"(cm)");
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/arrow_down.png");
                }else{
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_text').text(need_option_for_preview[$('.product_preview_size_check_box').eq(size_check_count).attr("key")]+" : 0(cm)");
                    $('.product_preview_size_check_box').eq(size_check_count).children('.product_preview_size_check_image').attr("src","/web/icon/equal.png");
                }
            }
        });
    <?php }?>

    //상품 입어보기 기능 사용중 화면 크기가 변할 경우 이벤트
    function resize_control_for_predressing(){
        <?php if($location_array&&$fitme_image&&$line_position) {?>
        head = $('.product_preview_contents_user_image').attr("head")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];      //머리 좌표
        pelvis = $('.product_preview_contents_user_image').attr("pelvis")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];   //골반 좌표
        foot = $('.product_preview_contents_user_image').attr("foot")*$('.product_preview_contents_box').height()/default_image_size[now_user_image_index][1];       //발끝 좌표
        var predressing_index = $('.product_preview_content_size_change_select option').index($('.product_preview_content_size_change_select option:selected'));//현재 사이즈 인덱스
        //상품크기를 변경시켜야함
        var category1 = '<?php echo $category1?>';//카테고리 확인을 위한 변수
        var line_position = JSON.parse(<?php echo json_encode($line_position)?>);
        var temp_width=1;
        //상품 이미지 내의 실제 상품 크기
        if(category1=='SKIRT'||category1=='PANTS'){
            //foot - pelvis = x(총장 픽셀)
            product_height = (foot-pelvis)*(product_size['총장'][predressing_index])/(<?php if($user_size['다리길이']){ echo $user_size['다리길이']; }else{ echo $user_size['키']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
            temp_width=1.2;
        }else{
            //foot - head = x(총장 픽셀)
            product_height = (foot-head)*(product_size['총장'][predressing_index])/(<?php if($user_size['키']){ echo $user_size['키']; }else{ echo $user_size['다리길이']; }?>);   //제품 높이픽셀 ( 제품사진 내부의 제품의 좌표 픽셀 )
        }
        //상품 이미지 자체 크기
        product_pic_height = product_height*(<?php echo getImagesize($fitme_image)[1];?>)/(line_position['y_bottom']-line_position['y_top']);
        product_pic_width = (<?php echo getImagesize($fitme_image)[0]; ?>)*product_pic_height/(<?php echo getImagesize($fitme_image)[1]; ?>)*temp_width;    //사진 가로픽셀 ( 임시용 )
        $('#product_fitme_image').css({
            "width":product_pic_width,
            "height":product_pic_height,
            "top":-$('.product_preview_contents_box').height()+product_pic_height/2
        });
        <?php }?>
    }

    //옷입혀보기 접기 펼치기 이벤트
    $('.product_preview_clothes_title_box').click(function(){
        if($(this).children('.product_preview_clothes_title_image').attr("src")=='/web/icon/collapse.png'){
            var url = '/web/icon/expand.png';
            $(this).children('.product_preview_clothes_title_image').attr("src",url);
            $('.product_preview_clothes_contents_box').fadeOut(300);
            $('.product_preview_clothes_contents_box').fadeTo("slow",0);
        }else{
            var url = '/web/icon/collapse.png';
            $(this).children('.product_preview_clothes_title_image').attr("src",url);
            $('.product_preview_clothes_contents_box').fadeIn(300);
            $('.product_preview_clothes_contents_box').fadeTo("slow",1);
        }
    });

    //장바구니 or 바로구매 기능 클릭시 이벤트
    $('.product_buy_it_now_button').click(function(){
        if($('.product_detail_top_add_product').length>0){
            var buy_product = new Object;
            buy_product_size= new Array;
            buy_product_color = new Array;
            buy_product_count = new Array;
            for(var p_count=0;p_count<$('.product_detail_top_add_product').length;p_count++)
            {
                buy_product_size.push($('.product_detail_top_add_product').eq(p_count).attr('size'));
                buy_product_color.push($('.product_detail_top_add_product').eq(p_count).attr('color'));
                buy_product_count.push($('.product_detail_top_add_product').eq(p_count).children('.product_detail_top_add_product_right').
                children('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val());
            }
            buy_product.size = buy_product_size;
            buy_product.color = buy_product_color;
            buy_product.count = buy_product_count;
            buy_product.product_key = '<?php echo $product?>';
            buy_product.move = 'buy';
            var data = JSON.stringify(buy_product);
            $.ajax({
                type:"POST",
                url:"/main/buy_or_cart.php",
                data : {'data':data},
                dataType : "text",
                success: function(string){
                    console.log('바로구매');
                   
                    location.href="http://49.247.136.36/main/cart/purchase_html.php";



                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }else{
            alert('구매하실 상품 옵션을 선택하세요');
        }
    });
    $('.product_add_to_cart_button').click(function(){
        if($('.product_detail_top_add_product').length>0){
            var buy_product = new Object;
            buy_product_size= new Array;
            buy_product_color = new Array;
            buy_product_count = new Array;
            for(var p_count=0;p_count<$('.product_detail_top_add_product').length;p_count++)
            {
                buy_product_size.push($('.product_detail_top_add_product').eq(p_count).attr('size'));
                buy_product_color.push($('.product_detail_top_add_product').eq(p_count).attr('color'));
                buy_product_count.push($('.product_detail_top_add_product').eq(p_count).children('.product_detail_top_add_product_right').
                children('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val());
            }
            buy_product.size = buy_product_size;
            buy_product.color = buy_product_color;
            buy_product.count = buy_product_count;
            buy_product.product_key = '<?php echo $product?>';
            buy_product.move = 'cart';
            var data = JSON.stringify(buy_product);
            $.ajax({
                type:"POST",
                url:"/main/buy_or_cart.php",
                data : {'data':data},
                dataType : "text",
                success: function(string){
                    console.log(string);
                    if(confirm('장바구니에 담았습니다.\n장바구니로 이동하시겠습니까?')==true){
                        console.log('장바구니 이동');
                        location.href="http://49.247.136.36/main/cart/cart_html.php";
                    }
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }else{
            alert('구매하실 상품 옵션을 선택하세요');
        }
    });

    //preview 기능 코드
    /*
    ----------------------------------------------- 카테고리 이동 -----------------------------------------------
     - My SIZE에 해당 카테고리의 내 사이즈 정보가 있어야 함 ( 로그인한 경우 & 내 사이즈 정보가 있는 경우 )
     - My SIZE에 해당 카테고리의 사이즈 정보를 입력해야 함 ( 로그인하지 않거나, 내 사이즈정보가 없는 경우 )
     - Product SIZE에 해당 카테고리의 상품 사이즈 정보가 있어야 함
    */
    $('.product_preview_size_image_category_td').click(function(){
        //현재 카테고리를 중복해서 눌렀는지 확인한다.
        if(preview_category!=$(this).index()){
            if($(this).css("color")!="#8A2908"){
                var verification1=false;
                var verification2=false;
                var user_size_index=null;
                var product_size=null;
                var my_size=null;
                var category1 = '<?php echo $category1?>';
                var category2 = '<?php echo $category2?>';
                if('<?php echo $category1?>'=='ONEPIECE'&&($(this).text()=='허리'||$(this).text()=='엉덩이')){
                    alert('준비중입니다.');
                }else{
                    if($(this).index()==0){
                        $('.product_preview_size_table_m_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
                        $('.product_preview_user_size_input').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
                        $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","font-weight":"normal"});
                        $('.product_preview_size_image_category_td').css({"color":"#848484;","border-bottom":"1px #DBDBDB solid","transition":"all 100ms linear","font-weight":"normal"});
                        $(this).css({"color":"#8A2908","border-bottom":"2px #8A2908 solid","transition":"all 100ms linear","font-weight":"bold"});
                        $('.product_preview_size_image').attr("src",compare_image_location[$(this).text()]);
                        preview_category=0;
                        product_size_table_td=0;
                        $('.product_preview_compare_text').text("상품과 사이즈 비교를 해보세요");
                    }else{
                        //사용자의 데이터가 존재하는지 확인, 사용자가 직접 입력한 데이터가 존재하는지 확인
                        for(var m_size=0;m_size<$('.product_preview_size_table_m_h_td').length;m_size++){
                            if($('.product_preview_size_table_m_h_td').eq(m_size).text()==need_option_for_preview[$(this).text()]){
                                if($('.product_preview_user_size_input').eq(m_size).length>0){
                                    if($('.product_preview_user_size_input').eq(m_size).val().length>0){
                                        user_size_index = m_size;
                                        my_size = $('.product_preview_user_size_input').eq(m_size).val();
                                        verification1 = true;
                                    }else{
                                        alert('MySIZE에서 '+need_option_for_preview[$(this).text()]+'를 입력해주세요');
                                    }
                                }else{
                                    if($('.product_preview_size_table_m_b_td').eq(m_size).text()!='-'&&$('.product_preview_size_table_m_b_td').eq(m_size).text()!=null){
                                        user_size_index=m_size;
                                        my_size = $('.product_preview_size_table_m_b_td').eq(m_size).text();
                                        verification1=true;
                                    }else{
                                        alert('마이페이지에서 '+need_option_for_preview[$(this).text()]+'를 입력해주세요');
                                    }
                                }
                            }
                        }
                        //Product SIZE의 해당 카테고리에 필요한 사이즈정보가 존재하는지 확인한다.
                        var p_td_index = $(this).index();
                        if($(this).text()=="밑단"&&category1=="PANTS"){
                            p_td_index++;
                        }
                        if($('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq($(this).index()).text()!='-'){
                            product_size = $('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq(p_td_index).text();
                            verification2=true;
                        }else{
                            alert('사이즈를 제공하지 않습니다.');
                        }
                        //모든 검증이 완료됬을 때
                        if(verification1&&verification2){
                            product_size_table_td = p_td_index;
                            preview_category=$(this).index();
                            $('.product_preview_size_table_m_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
                            $('.product_preview_user_size_input').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
                            $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px"});
                            $('.product_preview_size_image_category_td').css({"color":"#848484;","border-bottom":"1px #DBDBDB solid","transition":"all 100ms linear","font-weight":"normal"});
                            $(this).css({"color":"#8A2908","border-bottom":"2px #8A2908 solid","transition":"all 100ms linear","font-weight":"bold"});
                            $('.product_preview_size_table_m_b_td').eq(user_size_index).css({"transition":"all 200ms linear","font-weight":"bold","color":"#DF0101","font-size":"13px"});
                            $('.product_preview_user_size_input').eq(user_size_index).css({"transition":"all 200ms linear","font-weight":"bold","color":"#DF0101","font-size":"13px"});
                            $('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq(p_td_index).css(
                                {"transition":"all 200ms linear","font-weight":"bold","color":"#DF0101","font-size":"13px"});
                            compare_image_text($(this),product_size,my_size,category1,category2);
                        }
                    }
                }
            }
        }
    });

    /*
    ---------------------------------------Product SIZE를 변경했을 때(Click)-----------------------------------------
    조건은 Product SIZE의 테이블에서 클릭이벤트가 일어났을 경우
    css를 변경 한 뒤, compare 시작 ( 이미지 변경 및 텍스트 변경 )
    */
    $('.product_preview_size_table_p_b_tr').click(function(){
        var index = $(this).index()-1;
        var last_td = product_size_table_td;
        var category1 = '<?php echo $category1?>';
        var category2 = '<?php echo $category2?>';
        var product_size;
        var my_size;
        if(product_size_table_tr!=index){
            product_size_table_tr=index;
            $(".preview_size_select option:eq("+product_size_table_tr+")").prop("selected",true);
            $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","background":"white"});
            $('.product_preview_size_table_p_b_td_first').css({"transition":"all 200ms linear","background":"white"});
            $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","font-weight":"normal"});
            $('.product_preview_size_table_p_b_tr').eq(index).children('li').css({"transition":"all 200ms linear","background":"#D8D8D8"});
            $('.product_preview_size_table_p_b_tr').eq(index).children('li').eq(0).css({"transition":"all 200ms linear","background":"#8A2908"});
            if(preview_category!=0){
                $('.product_preview_size_table_p_b_tr').eq(index).children('.product_preview_size_table_p_b_td').eq(last_td).css(
                    {"transition":"all 200ms linear","font-weight":"bold","color":"#DF0101","font-size":"13px"});
            }
            if(last_td!=0){
                //카테고리 '전체'가 아닐경우만 동작
                product_size = $('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq(last_td).text();
                if(product_size=='-'){
                    alert('상품이 해당 사이즈를 제공하지 않습니다.');
                }else{
                    for(var m_size=0;m_size<$('.product_preview_size_table_m_h_td').length;m_size++){
                        if($('.product_preview_size_table_m_h_td').eq(m_size).text()==need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]){
                            if($('.product_preview_user_size_input').eq(m_size).length>0){
                                if($('.product_preview_user_size_input').eq(m_size).val().length>0){
                                    my_size = $('.product_preview_user_size_input').eq(m_size).val();
                                }else{
                                    alert('MySIZE에서 '+need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]+'를 입력해주세요');
                                    compare_number_one();
                                    return;
                                }
                            }else{
                                if($('.product_preview_size_table_m_b_td').eq(m_size).text()!='-'&&$('.product_preview_size_table_m_b_td').eq(m_size).text()!=null){
                                    my_size = $('.product_preview_size_table_m_b_td').eq(m_size).text();
                                }else{
                                    alert('마이페이지에서 '+need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]+'를 입력해주세요');
                                    compare_number_one();
                                    return;
                                }
                            }
                        }
                    }
                    compare_image_text($('.product_preview_size_image_category_td').eq(preview_category),product_size,my_size,category1,category2);
                }
            }
        }
    });
    /*----------------------------------------------- Product SIZE 변경(Select BOX) -----------------------------------------------
      위와 동일
    */
    $('.preview_size_select').change(function(){
        var index = $(".preview_size_select option").index( $(".preview_size_select option:selected"));
        var last_td = product_size_table_td;
        var category1 = '<?php echo $category1?>';
        var category2 = '<?php echo $category2?>';
        var product_size;
        var my_size;
        if(product_size_table_tr!=index){
            product_size_table_tr=index;
            $(".preview_size_select option:eq("+product_size_table_tr+")").prop("selected",true);
            $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","background":"white"});
            $('.product_preview_size_table_p_b_td_first').css({"transition":"all 200ms linear","background":"white"});
            $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","font-weight":"normal"});
            $('.product_preview_size_table_p_b_tr').eq(index).children('li').css({"transition":"all 200ms linear","background":"#D8D8D8"});
            $('.product_preview_size_table_p_b_tr').eq(index).children('li').eq(0).css({"transition":"all 200ms linear","background":"#8A2908"});
            if(preview_category!=0){
                $('.product_preview_size_table_p_b_tr').eq(index).children('.product_preview_size_table_p_b_td').eq(last_td).css(
                    {"transition":"all 200ms linear","font-weight":"bold","color":"#DF0101","font-size":"13px"});
            }
            if(last_td!=0){
                //카테고리 '전체'가 아닐경우만 동작
                product_size = $('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq(last_td).text();
                if(product_size=='-'){
                    alert('상품이 해당 사이즈를 제공하지 않습니다.');
                }else{
                    for(var m_size=0;m_size<$('.product_preview_size_table_m_h_td').length;m_size++){
                        if($('.product_preview_size_table_m_h_td').eq(m_size).text()==need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]){
                            if($('.product_preview_user_size_input').eq(m_size).length>0){
                                if($('.product_preview_user_size_input').eq(m_size).val().length>0){
                                    my_size = $('.product_preview_user_size_input').eq(m_size).val();
                                }else{
                                    alert('MySIZE에서 '+need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]+'를 입력해주세요');
                                    compare_number_one();
                                    return;
                                }
                            }else{
                                if($('.product_preview_size_table_m_b_td').eq(m_size).text()!='-'&&$('.product_preview_size_table_m_b_td').eq(m_size).text()!=null){
                                    my_size = $('.product_preview_size_table_m_b_td').eq(m_size).text();
                                }else{
                                    alert('마이페이지에서 '+need_option_for_preview[$('.product_preview_size_image_category_td').eq(preview_category).text()]+'를 입력해주세요');
                                    compare_number_one();
                                    return;
                                }
                            }
                        }
                    }
                    compare_image_text($('.product_preview_size_image_category_td').eq(preview_category),product_size,my_size,category1,category2);
                }
            }
        }
    });


    /*---------------------------------------My SIZE를 변경했을 때(회원이 아닌 경우)-----------------------------------------
      조건
      1. My SIZE의 input태그의 값이 변경되었을 때
      2. My SIZE의 input태그의 값에 해당하는 카테고리를 보고있는 경우
      css를 변경 한 뒤, compare 시작 ( 이미지 변경 및 텍스트 변경 )
    */
    $('.product_preview_user_size_input').change(function(){
        var last_td = product_size_table_td;
        var category1 = '<?php echo $category1?>';
        var category2 = '<?php echo $category2?>';
        var product_size;
        var my_size;
        if($(this).val().length>0&&last_td!=0){
            //카테고리 '전체'가 아닐경우만 동작
            product_size = $('.product_preview_size_table_p_b_tr').eq(product_size_table_tr).children('.product_preview_size_table_p_b_td').eq(last_td).text();
            for(var input_c=0;input_c<$('.product_preview_user_size_input').length;input_c++){
                if($('.product_preview_user_size_input').eq(input_c).css("color")=="rgb(223, 1, 1)"){
                    my_size = $('.product_preview_user_size_input').eq(input_c).val();
                }
            }
            compare_image_text($('.product_preview_size_image_category_td').eq(preview_category),product_size,my_size,category1,category2);
        }
    });

    function compare_number_one(){
        preview_category=0;
        product_size_table_td=0;
        $('.product_preview_size_table_m_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
        $('.product_preview_user_size_input').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"11px"});
        $('.product_preview_size_table_p_b_td').css({"transition":"all 200ms linear","font-weight":"normal","color":"black","font-size":"12px","font-weight":"normal"});
        $('.product_preview_size_image_category_td').css({"color":"#848484;","border-bottom":"1px #DBDBDB solid","transition":"all 100ms linear","font-weight":"normal"});
        $('.product_preview_size_image_category_td').eq(preview_category).css({"color":"#8A2908","border-bottom":"2px #8A2908 solid","transition":"all 100ms linear","font-weight":"bold"});
        $('.product_preview_size_image').attr("src",compare_image_location['전체']);
        $('.product_preview_compare_text').text("상품과 사이즈 비교를 해보세요");
    }

    //비교 이미지와 비교결과 텍스트를 바꾸는 함수
    function compare_image_text(object, p_size, m_size,c_1,c_2)
    {
        var category1 = c_1;
        var category2 = c_2;
        var product_size = p_size;
        var my_size = m_size;
        //비교 이미지 변경
        // $('.product_preview_size_image').attr("src",compare_image_location[$(this).text()])
        if($(object).text()=='가슴단면'||$(object).text()=='엉덩이'||$(object).text()=='허리'||$(object).text()=='허벅지'||$(object).text()=='밑단'){
            product_size*=2;
        }
        var text="";
        var c_location = compare_image_location[$(object).text()];
        var temp_number;
        var temp_compare_number;
        if(category1=="TOP"||category1=="OUTER"){
            if(category2=="COAT"){
                if($(object).text()=="총장"){
                    c_location +=compare_number(57,-3,3,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 총장이 상체에서 "+(product_size-my_size).toFixed(1)+"cm 만큼 내려옵니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 총장이 상체에서 "+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 총장이 상체길이와 일치합니다.";
                    }
                }else if($(object).text()=="어깨너비"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 어깨너비가 "+(product_size-my_size).toFixed(1)+"cm 만큼 넓습니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 어깨너비가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 어깨너비와 일치합니다.";
                    }
                }else if($(object).text()=="가슴단면"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 가슴둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 가슴둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 가슴둘레와 일치합니다.";
                    }
                }else if($(object).text()=="소매길이"){
                    c_location +=compare_number(10,-6,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 소매길이가 팔목에서"+(product_size-my_size).toFixed(1)+"cm 만큼 내려갑니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 소매길이가 팔목에서"+(my_size-product_size).toFixed(1)+"cm 만큼 올라갑니다.";
                    }else{
                        text = "상품 소매길이가 팔목과 일치합니다.";
                    }
                }
            }else{
                if($(object).text()=="총장"){
                    c_location +=compare_number(14,-6,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 총장이 상체에서 "+(product_size-my_size).toFixed(1)+"cm 만큼 내려옵니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 총장이 상체에서 "+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 총장이 상체길이와 일치합니다.";
                    }
                }else if($(object).text()=="어깨너비"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 어깨너비가 "+(product_size-my_size).toFixed(1)+"cm 만큼 넓습니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 어깨너비가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 어깨너비와 일치합니다.";
                    }
                }else if($(object).text()=="가슴단면"){
                    c_location +=compare_number(12,-12,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 가슴둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 가슴둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 가슴둘레와 일치합니다.";
                    }
                }else if($(object).text()=="소매길이"){
                    c_location +=compare_number(8,-8,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 소매길이가 팔목에서"+(product_size-my_size).toFixed(1)+"cm 만큼 내려갑니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 소매길이가 팔목에서"+(my_size-product_size).toFixed(1)+"cm 만큼 올라갑니다.";
                    }else{
                        text = "상품 소매길이가 팔목과 일치합니다.";
                    }
                }
            }
        }else{
            if(category1=="SKIRT"){
                if($(object).text()=="총장"){
                    c_location +=compare_number(8,-50,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 총장이 발목에서 "+(product_size-my_size).toFixed(1)+"cm 만큼 내려옵니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 총장이 발목에서 "+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 총장이 다리길이와 일치합니다.";
                    }
                }else if($(object).text()=="엉덩이"){
                    c_location +=compare_number(12,-12,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 힙둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 힙둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 힙둘레와 일치합니다.";
                    }
                }else if($(object).text()=="허리"){
                    c_location +=compare_number(8,-6,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 허리둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 허리둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 허리둘레와 일치합니다.";
                    }
                }
            }else if(category1=="PANTS"){
                if($(object).text()=="총장"){
                    var return_c_n = compare_number(45,-9,3,-product_size,-my_size);
                    if(return_c_n=="0_3.png"){
                        return_c_n="3_6.png";
                    }
                    c_location += return_c_n;
                    if(my_size-product_size<0){
                        text = "상품 총장이 발목에서 "+(product_size-my_size).toFixed(1)+"cm 만큼 내려갑니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 총장이 발목에서 "+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 총장이 다리길이와 일치합니다.";
                    }
                }else if($(object).text()=="밑단"){
                    var return_c_n = compare_number(8,-2,2,product_size,my_size);
                    if(return_c_n=="6_8.png"){
                        return_c_n="4_6.png";
                    }
                    c_location += return_c_n;
                    if(my_size-product_size<0){
                        text = "상품 밑단둘레가 발목둘레보다"+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 밑단둘레가 발목둘레보다"+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 밑단둘레와 발목둘레가 일치합니다.";
                    }
                }else if($(object).text()=="엉덩이"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 힙둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 힙둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 힙둘레와 일치합니다.";
                    }
                }else if($(object).text()=="허벅지"){
                    c_location +=compare_number(10,-4,2,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 허벅지둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 허벅지둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 허벅지둘레와 일치합니다.";
                    }
                }else if($(object).text()=="허리"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 허리둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 허리둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 허리둘레와 일치합니다.";
                    }
                }
            }else if(category1=="ONEPIECE"){
                if($(object).text()=="총장"){
                    c_location +=compare_number(80,0,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 총장이 상체에서 "+(product_size-my_size).toFixed(1)+"cm 만큼 내려옵니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 총장이 상체에서 "+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 총장이 상체길이와 일치합니다.";
                    }
                }else if($(object).text()=="어깨너비"){
                    c_location +=compare_number(4,-4,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 어깨너비가 "+(product_size-my_size).toFixed(1)+"cm 만큼 넓습니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 어깨너비가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 어깨너비와 일치합니다.";
                    }
                }else if($(object).text()=="가슴단면"){
                    c_location +=compare_number(8,-8,4,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 가슴둘레가 "+(product_size-my_size).toFixed(1)+"cm 만큼 큽니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 가슴둘레가 "+(my_size-product_size).toFixed(1)+"cm 만큼 작습니다.";
                    }else{
                        text = "상품 가슴둘레와 일치합니다.";
                    }
                }else if($(object).text()=="소매길이"){
                    c_location +=compare_number(18,-9,3,product_size,my_size);
                    if(my_size-product_size<0){
                        text = "상품 소매길이가 팔목부터"+(product_size-my_size).toFixed(1)+"cm 만큼 내려갑니다.";
                    }else if(my_size-product_size>0){
                        text = "상품 소매길이가 팔목에서"+(my_size-product_size).toFixed(1)+"cm 만큼 올라옵니다.";
                    }else{
                        text = "상품 소매길이가 팔목과 일치합니다.";
                    }
                }
            }
        }
        $('.product_preview_size_image').attr("src",c_location);
        $('.product_preview_compare_text').text(text);
    }

    //이미지 compare 경로 구하는 함수
    function compare_number(max_exceed,min_exceed,number,p_number,my_number)
    {
        var plus_number = 0;
        var dif_number;
        if(p_number==my_number)
            return '0.png';
        else{
            if(p_number-my_number>0){
                dif_number = p_number-my_number;
                while(plus_number<dif_number){
                    if(plus_number==max_exceed){
                        return max_exceed+'_exceed.png';
                    }else{
                        plus_number+=number;
                    }
                }
                return (plus_number-number)+'_'+(plus_number)+'.png';
            }else{
                dif_number = my_number-p_number;
                while(plus_number<dif_number){
                    if(plus_number==(-min_exceed)){
                        return min_exceed+'_exceed.png';
                    }else{
                        plus_number+=number;
                    }
                }
                return (-plus_number+number)+'_'+(-plus_number)+'.png';
            }
        }
    }

    //Q&A 페이징 클릭시 이벤트 ( 숫자클릭, prev , next 클릭 )
    $('.page').click(function(){
        if($(this).text()!=qna_page){
            $('.page').css("color","#8B8B8B");
            $(this).css("color","black");
            qna_page=parseInt($(this).text());
            qna_page_node_index=$(this).index()-1;
            $('.product_category_qna_contents_ul_c').remove();
            $('.product_category_qna_answer_ul_c').remove();
            $('.product_category_qna_open_ul_c').remove();
            qna_page_change(qna_page);
        }
    });
    //이전 버튼 (page prev)
    $('.prev').click(function(){
        if(qna_page-1!=0){
            qna_page--;
            qna_page_node_index--;
            $('.page').css("color","#8B8B8B");
            if(qna_page_node_index<0){
                //페이지 번호 새로 생성
                $('.page').remove();
                var page = null;
                page = "<a class='page'>"+(qna_page-9)+"</a>";
                for(var p_c=8;p_c>-1;p_c--){
                    page+="<a class='page'>"+(qna_page-p_c)+"</a>";
                }
                $('.prev').after(page);
                $('.page').click(function(){
                    if($(this).text()!=qna_page){
                        $('.page').css("color","#8B8B8B");
                        $(this).css("color","black");
                        qna_page=parseInt($(this).text());
                        qna_page_node_index=$(this).index()-1;
                        $('.product_category_qna_contents_ul_c').remove();
                        $('.product_category_qna_answer_ul_c').remove();
                        $('.product_category_qna_open_ul_c').remove();
                        qna_page_change(qna_page);
                    }
                });
                qna_page_node_index=9;
            }
            $('.page').eq(qna_page_node_index).css("color","black");
            $('.product_category_qna_contents_ul_c').remove();
            $('.product_category_qna_answer_ul_c').remove();
            $('.product_category_qna_open_ul_c').remove();
            qna_page_change(qna_page);
        }
    });
    //다음 버튼(page next)
    $('.next').click(function(){
        if(qna_page<qna_last_page){
            qna_page++;
            qna_page_node_index++;
            $('.page').css("color","#8B8B8B");
            if(qna_page_node_index>9){
                //페이지 번호 새로 생성
                $('.page').remove();
                var page = null;
                page = "<a class='page'>"+qna_page+"</a>";
                for(var p_c=1;p_c<10;p_c++){
                    if((qna_page+p_c)>qna_last_page)
                        break;
                    else
                        page+="<a class='page'>"+(qna_page+p_c)+"</a>";
                }
                $('.prev').after(page);
                $('.page').click(function(){
                    if($(this).text()!=qna_page){
                        $('.page').css("color","#8B8B8B");
                        $(this).css("color","black");
                        qna_page=parseInt($(this).text());
                        qna_page_node_index=$(this).index()-1;
                        $('.product_category_qna_contents_ul_c').remove();
                        $('.product_category_qna_answer_ul_c').remove();
                        $('.product_category_qna_open_ul_c').remove();
                        qna_page_change(qna_page);
                    }
                });
                qna_page_node_index=0;
            }
            $('.page').eq(qna_page_node_index).css("color","black");
            $('.product_category_qna_contents_ul_c').remove();
            $('.product_category_qna_answer_ul_c').remove();
            $('.product_category_qna_open_ul_c').remove();
            qna_page_change(qna_page);
        }
    });
    //페이지 숫자를 변경하면서 qna 리스트를 페이지에 맞게 변경한다.
    function qna_page_change(page)
    {
        var qna_product_key = '<?php echo $product?>';
        var qna_email = '<?php echo $email?>';
        $.ajax({
            type:"GET",
            url:"/for_mobile/qna.php",
            data : {'product_key':qna_product_key,'email':qna_email,'page':page},
            dataType : "text",
            success: function(string){
                var result_array = JSON.parse(string);
                //답변글을 변수에 저장
                qna_answer_date = result_array['answer_date'];
                qna_answer_text = result_array['answer_text'];
                //qna목록에 노드 추가
                var qna_node="";
                for(var n_c=0;n_c<result_array['qna_key'].length;n_c++){
                    qna_node += "<ul class='product_category_qna_contents_ul_c'><li class='product_category_qna_contents_li_c1'>"+(parseInt('<?php echo $qna_all_count?>')-((page-1)*10)-n_c)+"</li>";
                    if(result_array['state'][n_c]=='1'){
                        qna_node += "<li class='product_category_qna_contents_li_c2'>답변대기</li>";
                    }else{
                        qna_node += "<li class='product_category_qna_contents_li_c2' style='font-weight:bold;'>답변완료</li>";
                    }
                    if(result_array['text'][n_c]==null){
                        qna_node += "<li class='product_category_qna_contents_li_c3'><div class='qna_contents_li_c3_hidden_box'><div class='qna_contents_li_c3_hidden_image'></div></div>";
                        qna_node += "<div class='qna_contents_li_c3_hidden_text'>비밀글입니다.</div></li>";
                    }else{
                        qna_node += "<li class='product_category_qna_contents_li_c3'>"+result_array['text'][n_c]+"</li>";
                    }
                    qna_node += "<li class='product_category_qna_contents_li_c4'>"+result_array['email'][n_c]+"</li>";
                    qna_node += "<li class='product_category_qna_contents_li_c5'>"+result_array['date'][n_c].substr(0,4)+'/'+result_array['date'][n_c].substr(4,2)+'/'+result_array['date'][n_c].substr(6,2)+"</li></ul>";
                }
                $('.product_category_qna_contents_ul_p').after(qna_node);

                //추가한 노드들에 클릭이벤트 생성
                $('.product_category_qna_contents_ul_c').click(function(){
                    $('.product_category_qna_contents_ul_c').css({"background":"none"});
                    $('.product_category_qna_answer').css("display","none");
                    $('.product_category_qna_answer_ul_c').remove();
                    $('.product_category_qna_open_ul_c').remove();
                    $(this).css({"background":"#F2F2F2"});
                    var node="<ul class='product_category_qna_open_ul_c'>";
                    if($(this).children('.product_category_qna_contents_li_c3').children('.qna_contents_li_c3_hidden_text').text()=='비밀글입니다.')
                    {
                        node += "<li class='product_category_qna_open_text'><div class='qna_contents_li_c3_hidden_box'>";
                        node += "<div class='qna_contents_li_c3_hidden_image'></div></div><div class='qna_contents_li_c3_hidden_text'>비밀글입니다.</div></li></ul>";
                    }
                    else
                    {
                        node += "<li class='product_category_qna_open_text'>"+$(this).children('.product_category_qna_contents_li_c3').text()+"</li></ul>";
                    }
                    if($(this).children('.product_category_qna_contents_li_c2').text()=="답변완료"){
                        $(this).children('.product_category_qna_answer').css("display","block");
                        node+="<ul class=\"product_category_qna_answer_ul_c\"><li class=\"product_category_qna_answer_state\">&rdca;</li><li class=\"product_category_qna_answer_text\">"+qna_answer_text[$(this).index()-1]+"</li>";
                        node+="<li class=\"product_category_qna_answer_id\"><?php echo $shop_name?></li><li class=\"product_category_qna_answer_date\">"+qna_answer_date[$(this).index()-1]+"</li></ul>";
                    }
                    $(this).after(node);
                });
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }

    //Q&A Contents 클릭시 이벤트 ( 펼치기, 답변완료 내용도 보여주기 )
    $('.product_category_qna_contents_ul_c').click(function(){
        $('.product_category_qna_contents_ul_c').css({"background":"none"});
        $('.product_category_qna_answer').css("display","none");
        $('.product_category_qna_answer_ul_c').remove();
        $('.product_category_qna_open_ul_c').remove();
        $(this).css({"background":"#F2F2F2"});
        var node="<ul class='product_category_qna_open_ul_c'>";
        if($(this).children('.product_category_qna_contents_li_c3').children('.qna_contents_li_c3_hidden_text').text()=='비밀글입니다.')
        {
            node += "<li class='product_category_qna_open_text'><div class='qna_contents_li_c3_hidden_box'>";
            node += "<div class='qna_contents_li_c3_hidden_image'></div></div><div class='qna_contents_li_c3_hidden_text'>비밀글입니다.</div></li></ul>";
        }
        else
        {
            node += "<li class='product_category_qna_open_text'>"+$(this).children('.product_category_qna_contents_li_c3').text()+"</li></ul>";
        }
        if($(this).children('.product_category_qna_contents_li_c2').text()=="답변완료"){
            $(this).children('.product_category_qna_answer').css("display","block");
            node+="<ul class=\"product_category_qna_answer_ul_c\"><li class=\"product_category_qna_answer_state\">&rdca;</li><li class=\"product_category_qna_answer_text\">"+qna_answer_text[$(this).index()-1]+"</li>";
            node+="<li class=\"product_category_qna_answer_id\"><?php echo $shop_name?></li><li class=\"product_category_qna_answer_date\">"+qna_answer_date[$(this).index()-1]+"</li></ul>";
        }
        $(this).after(node);
    });

    //Q&A write 버튼 클릭시 이벤트 ( 모달 생성 )
    $('.product_qna_write_button').click(function(){
        //로그인유무 체크
        var email = '<?php echo $email?>';
        if(email)
        {
            $('#qna_modal').css({"display":"block"});
            $('.qna_modal_content').fadeIn(50);
            $('.qna_modal_content').fadeTo("slow",1);
        }
        else
        {
            location.href="http://49.247.136.36/main/fitme_session_login.php";
        }
    });
    //Q&A 작성 버튼 클릭시 이벤트 ( Q&A 등록 )
    $('.qna_ok_btn').click(function(){
        var qna_product_key = '<?php echo $product?>';
        var number = 1;
        var qna_email = '<?php echo $email?>';
        var text = $('.qna_modal_product_qna_right').val().replace(/ /gi,'&nbsp').replace(/\n/gi,'<br>').replace(/\"/gi,'&quot');
        var hidden=1;
        if($('.qna_modal_product_hidden_right').is(":checked")){ hidden=1; }else{ hidden=2; }

        if(text.length<1){
            alert('문의 내용을 입력하세요')
        }
        else if(text.length>1000){
            alert('문의 내용이 제한 길이를 넘었습니다.')
        }else{
            $.ajax({
                type:"POST",
                url:"/for_mobile/qna.php",
                data : {'product_key':qna_product_key,'number':number,'email':qna_email,'text':text,'hidden':hidden},
                dataType : "text",
                success: function(string){
                    $('.qna_modal_product_qna_right').val("");
                    $('.qna_modal_content').css("opacity","0");
                    $('#qna_modal').css({"display":"none"});
                    $('.page').css("color","#8B8B8B");
                    $('.page').eq(0).css("color","black");
                    qna_page=1;
                    qna_page_node_index=0;
                    $('.product_category_qna_contents_ul_c').remove();
                    $('.product_category_qna_answer_ul_c').remove();
                    $('.product_category_qna_open_ul_c').remove();
                    qna_page_change(1);
                },
                error: function(xhr, status, error) {
                    alert(error);
                }
            });
        }
    });

    //리뷰 페이징 처리 ( 다음 페이지 불러오는 코드 )
    function next_page()
    {
        review_category_page++;
        var temp_index=review_category_index;
        if(temp_index==0)
        {
            temp_index=3;
        }
        $.ajax({
            type:"GET",
            url:"/for_mobile/product_review.php",
            data : {'category':temp_index,'product_key':<?php echo $product?>,'page':review_category_page},
            dataType : "text",
            success: function(string){
                if(string)
                {
                    var data = JSON.parse(string);
                    $('.product_review_next_page').remove();

                    var review_refresh=null;    //태그가 들어갈 변수
                    for(var r_c=0;r_c<data['review_email'].length;r_c++)
                    {
                        review_refresh="<div class='opacity_box opacity_box_isstart' style='opacity:0; width:100%; float:left;'><div class=\"product_review\"><div class=\"product_review_left\"><div class=\"product_review_left_top\"><div class=\"product_review_userid\">"+data['review_email'][r_c]+"</div>";
                        review_refresh+="<span class=\"product_review_star\"><span style=\"width:"+parseFloat(data['review_star'][r_c])*20+"%;\"></span></span></div>";
                        review_refresh+="<div class=\"product_review_left_text_box\">"+data['review_text'][r_c]+"</div><div class=\"product_reivew_left_none_place\"'></div>";
                        review_refresh+="<div class=\"product_review_left_text_box_more\">...더보기</div><div class=\"product_reivew_left_none_place\"></div>";
                        if(data['review_photo'][r_c]){
                            review_refresh+="<img class=\"product_review_left_photo_box\" src=\""+data['review_photo'][r_c]+"\">";
                        }
                        //추후에 리뷰 우측의 사용자의 구매 색상, 사이즈와 사용자 신체정보 일부를 보여줄 공간 ( 아직 UI에 대한 고민중 )
                        review_refresh+="</div><div class=\"product_review_right\"></div></div>";
                        $('.product_review_list').append(review_refresh);
                    }
                    if(parseInt(data['count'])>review_category_page*10+10)//다음페이지가 존재할 때 ( 페이징 처리 )
                    {
                        $('.product_review_list').append("<div class=\"product_review_next_page\" onclick='next_page()'>Next Review</div>");
                    }
                    $('.product_review_list').append("</div>");

                    //클릭 이벤트도 추가
                    $('.product_review_left_photo_box').click(function(){
                        $('.review_photo_modal_image').attr("src",$(this).attr("src"));
                        $('#review_photo_modal').css({"display":"block"});
                        $('.review_photo_modal_content').fadeIn(100);
                        $('.review_photo_modal_content').fadeTo("slow",1);

                    });
                    $('.product_review_left_text_box_more').click(function(){
                        if($(this).parents('.product_review_left').children('.product_review_left_text_box').css("height")=='95px')
                        {
                            $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","auto");
                            $(this).text("리뷰 접기");
                        }
                        else
                        {
                            $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","95px");
                            $(this).text("...더보기");
                        }
                    });
                    $('.opacity_box_isstart').fadeIn(400);
                    $('.opacity_box_isstart').fadeTo("slow",1);
                    setTimeout(function(){
                        //리뷰 더보기 기능을 숨기거나 보여줌
                        $('.opacity_box').removeClass('opacity_box_isstart');
                        show_more_text(review_category_page);
                    },200);
                    review_category_change=false;

                }
            },
            error: function(xhr, status, error) {
                alert(error);
            }
        });
    }

    //리뷰 카테고리 ( all , text , photo ) 클릭 이벤트
    $('.review_top_right_text').click(function(){
        if(!review_category_change&&($(this).index()/2)!=review_category_index)
        {
            review_category_page=0;
            review_category_change=true;
            $('.review_top_right_text').eq(review_category_index).css({
                "transition":"all 200ms linear",
                "color":"#A4A4A4"
            });
            $(this).css({
                "transition":"all 200ms linear",
                "color":"black"
            });
            review_category_index = $(this).index()/2;
            $('.product_review_list').css("opacity","0");
            setTimeout(function(){
                var review_count = 0;//전체 개수
                var page_count=0;//페이징 처리된 개수
                var email_array;
                var text_array;
                var star_array;
                var photo_array=null;
                $('.product_review_list').css("display","none");
                $('.product_review_list').children().remove();
                if(review_category_index==0)    //photo review
                {
                    review_count = <?php echo $photo_count?>;
                    page_count=<?php echo $p_p_c?>;
                    email_array = <?php echo json_encode($photo_review_email)?>;
                    text_array = <?php echo json_encode($photo_review_text)?>;
                    star_array = <?php echo json_encode($photo_review_star)?>;
                    photo_array = <?php echo json_encode($photo_review_photo)?>;
                }
                else if(review_category_index==1)   //text review
                {
                    review_count = <?php echo $text_count?>;
                    page_count=<?php echo $t_p_c?>;
                    email_array = <?php echo json_encode($text_review_email)?>;
                    text_array = <?php echo json_encode($text_review_text)?>;
                    star_array = <?php echo json_encode($text_review_star)?>;
                }
                else    //all review
                {
                    review_count = <?php echo $all_count?>;
                    page_count=<?php echo $a_p_c?>;
                    email_array = <?php echo json_encode($all_review_email)?>;
                    text_array = <?php echo json_encode($all_review_text)?>;
                    star_array = <?php echo json_encode($all_review_star)?>;
                    photo_array = <?php echo json_encode($all_review_photo)?>;
                }
                var review_refresh=null;    //태그가 들어갈 변수
                if(review_count<1)//리뷰가 없을 때
                {
                    review_refresh = "<div class=\"product_review_none\">작성된 리뷰가 없습니다.</div>";
                    $('.product_review_list').append(review_refresh);
                }
                else    //리뷰가 있을 때
                {
                    for(var r_c=0;r_c<page_count;r_c++)
                    {
                        review_refresh="<div class=\"product_review\"><div class=\"product_review_left\"><div class=\"product_review_left_top\"><div class=\"product_review_userid\">"+email_array[r_c]+"</div>";
                        review_refresh+="<span class=\"product_review_star\"><span style=\"width:"+parseFloat(star_array[r_c])*20+"%;\"></span></span></div>";
                        review_refresh+="<div class=\"product_review_left_text_box\">"+text_array[r_c]+"</div><div class=\"product_reivew_left_none_place\"'></div>";
                        review_refresh+="<div class=\"product_review_left_text_box_more\">...더보기</div><div class=\"product_reivew_left_none_place\"></div>";
                        if(photo_array){
                            if(photo_array[r_c]!=null)
                            {
                                review_refresh+="<img class=\"product_review_left_photo_box\" src=\""+photo_array[r_c]+"\">";
                            }
                        }
                        //추후에 리뷰 우측의 사용자의 구매 색상, 사이즈와 사용자 신체정보 일부를 보여줄 공간 ( 아직 UI에 대한 고민중 )
                        review_refresh+="</div><div class=\"product_review_right\"></div></div>";
                        $('.product_review_list').append(review_refresh);
                    }
                    if(review_count>page_count)//다음페이지가 존재할 때 ( 페이징 처리 )
                    {
                        $('.product_review_list').append("<div class=\"product_review_next_page\" onclick='next_page()'>Next Review</div>");
                    }
                }

                //클릭 이벤트도 추가
                $('.product_review_left_photo_box').click(function(){
                    $('.review_photo_modal_image').attr("src",$(this).attr("src"));
                    $('#review_photo_modal').css({"display":"block"});
                    $('.review_photo_modal_content').fadeIn(100);
                    $('.review_photo_modal_content').fadeTo("slow",1);

                });
                $('.product_review_left_text_box_more').click(function(){
                    if($(this).parents('.product_review_left').children('.product_review_left_text_box').css("height")=='95px')
                    {
                        $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","auto");
                        $(this).text("리뷰 접기");
                    }
                    else
                    {
                        $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","95px");
                        $(this).text("...더보기");
                    }
                });
                setTimeout(function(){
                    //리뷰 더보기 기능을 숨기거나 보여줌
                    $('.product_review_list').css("display","block");
                    $('.product_review_list').fadeIn(400);
                    $('.product_review_list').fadeTo("slow",1);
                    show_more_text(0);
                },200);
                review_category_change=false;
            },300);
        }
    });
    //더보기 기능 추가
    function show_more_text(number)
    {
        for(var review_m_count=number;review_m_count<$('.product_review').length;review_m_count++)
        {
            if($('.product_review_left_text_box').eq(review_m_count).prop('scrollHeight')>95)
            {
                $('.product_review_left_text_box').eq(review_m_count).parents('.product_review_left').children('.product_review_left_text_box_more').css("display","block");
            }
            else
            {
                $('.product_review_left_text_box').eq(review_m_count).parents('.product_review_left').children('.product_review_left_text_box_more').css("display","none");
            }
        }
    }

    //모달 종료버튼
    $('.review_photo_modal_close').click(function(){
        $('.review_photo_modal_content').css("opacity","0");
        $('#review_photo_modal').css({"display":"none"});
    });
    //qna 모달 종료 버튼
    $('.qna_modal_close').click(function(){
        $('.qna_modal_content').css("opacity","0");
        $('#qna_modal').css({"display":"none"});
    });
    $(window).click(function(event){
        var p_modal = document.getElementById('review_photo_modal');
        var qna_modal = document.getElementById('qna_modal');
        if (event.target == p_modal) {
            $('.review_photo_modal_content').css("opacity","0");
            $('#review_photo_modal').css({"display":"none"});
        }
        else if(event.target == qna_modal){
            $('.qna_modal_content').css("opacity","0");
            $('#qna_modal').css({"display":"none"});
        }
    });
    //리뷰 이미지 클릭시 이벤트
    $('.product_review_left_photo_box').click(function(){
        $('.review_photo_modal_image').attr("src",$(this).attr("src"));
        $('#review_photo_modal').css({"display":"block"});
        $('.review_photo_modal_content').fadeIn(100);
        $('.review_photo_modal_content').fadeTo("slow",1);
    });
    //더보기 클릭시 이벤트 ( 최초-all )
    $('.product_review_left_text_box_more').click(function(){
        if($(this).parents('.product_review_left').children('.product_review_left_text_box').css("height")=='95px')
        {
            console.log('리뷰접기 들어옴');
            $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","100%");
            $(this).text("리뷰 접기");
        }
        else
        {
            console.log('리뷰펼치기 들어옴');
            $(this).parents('.product_review_left').children('.product_review_left_text_box').css("height","95px");
            $(this).text("...더보기");
        }
    });
    //카테고리 클릭 이벤트
    $('.product_category_text').click(function(){
        var temp_next_category = $(this).index()/2;
        if(temp_next_category!=now_category&&!iscategory_running)
        {
            next_category = $(this).index()/2;
            iscategory_running=true;
            $('.product_category_text').css({"transition":"all 200ms linear", "color":"#A4A4A4"});
            $(this).css({"transition":"all 200ms linear", "color":"black"});
            $('.product_category_contents'+(now_category+1)).fadeOut(300);
            $('.product_category_contents'+(now_category+1)).fadeTo("slow",0);
            setTimeout(function() {
                $('.product_category_contents'+(now_category+1)).css("display","none");
                $('.product_category_contents'+(next_category+1)).css({"display":"block","opacity":"0"});
                $('.product_category_contents'+(next_category+1)).fadeIn(300);
                $('.product_category_contents'+(next_category+1)).fadeTo("slow",1);
                if(temp_next_category==2)
                {
                    show_more_text(0);
                }
                setTimeout(function(){
                    now_category=parseInt(next_category);
                    iscategory_running=false;
                },300);
            }, 300);
        }
    });

    //추가한 태그 ( 상품 정보 ) 자식이미지태그 모두 css조절
    for(tag_count=0;tag_count<$('.product_category_contents1').children('p').children('img').length;tag_count++)
    {
        $('.product_category_contents1').children('p').children('img').eq(tag_count).css("width","100%");
    }

    //모든 카테고리가 보여질 경우 마우스를 올려두었을 때의 이벤트
    $('.category').hover(function(){
        $('.category').css("display","block");
    },function(){
        $('.category').css("display","none");
    });

    //화면 스크롤시 이벤트 ( 제품 카테고리가 상단에 보여지도록 설정 )
    $(window).scroll(function () {
        p_scrollValue = $(document).scrollTop();
        if($(window).width()<974)
        {
            if(p_scrollValue+54>category_top)
            {
                $('.product_category_box_parents').css({"position":"fixed","top":"54px"});
                $('.product_category_box_parents_hidden').css("height","70px");
                $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
                $('.product_category_contents_box').css({"border-top":"none"});
            }
            else
            {
                $('.product_category_box_parents').css({"position":"static","top":"0px"});
                $('.product_category_box_parents_hidden').css("height","1px");
                $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
                $('.product_category_contents_box').css({"border-top":"1px #D8D8D8 solid"});
            }
        }
        else
        {
            if(p_scrollValue+$('#head_category_place').height()>category_top)
            {
                $('.product_category_box_parents').css({"position":"fixed","top":$('#head_category_place').height()});
                $('.product_category_box_parents_hidden').css("height","70px");
                $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
                $('.product_category_contents_box').css({"border-top":"none"});
            }
            else
            {
                $('.product_category_box_parents').css({"position":"static","top":"0px"});
                $('.product_category_box_parents_hidden').css("height","1px");
                $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
                $('.product_category_contents_box').css({"border-top":"1px #D8D8D8 solid"});
            }
        }
    });

    //770픽셀 이하의 제품구매, 장바구니 버튼 클릭시 이벤트
    $('.hidden_770_bottom_button1').click(function(){
        if(!is770_porudct_place_open)   //펼쳐지지 않은 경우에만 펼치기
        {
            is770_porudct_place_open=true;
            $('.product_detail_top_table_size').css({"width":"100%","height":"50px","margin-bottom":"10px"});
            $('.product_detail_top_table_color').css({"width":"100%","height":"50px","margin-bottom":"10px"});
            $('.hidden_770_price_box').append($('.product_total_price_text'));
            $('.hidden_770_option_box').append($('.product_detail_top_table_size'));
            $('.hidden_770_option_box').append($('.product_detail_top_table_color'));
            $('.hidden_770_add_place').append($('.product_detail_top_add_place_move'));
            $('.hidden_770_hidden_product_place').css({
                "height":"300px",
                "transition":"all 200ms linear",
                "margin-bottom":"0px"
            });
        }else{
            var text_for_move = $(this).text();
            if($('.product_detail_top_add_product').length>0){
                var buy_product = new Object;
                buy_product_size= new Array;
                buy_product_color = new Array;
                buy_product_count = new Array;
                for(var p_count=0;p_count<$('.product_detail_top_add_product').length;p_count++)
                {
                    buy_product_size.push($('.product_detail_top_add_product').eq(p_count).attr('size'));
                    buy_product_color.push($('.product_detail_top_add_product').eq(p_count).attr('color'));
                    buy_product_count.push($('.product_detail_top_add_product').eq(p_count).children('.product_detail_top_add_product_right').
                    children('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val());
                }
                buy_product.size = buy_product_size;
                buy_product.color = buy_product_color;
                buy_product.count = buy_product_count;
                buy_product.product_key = '<?php echo $product?>';
                if(text_for_move=='BUY IT NOW'){
                    buy_product.move = 'buy';
                }else{
                    buy_product.move = 'cart';
                }
                var data = JSON.stringify(buy_product);
                $.ajax({
                    type:"POST",
                    url:"/main/buy_or_cart.php",
                    data : {'data':data},
                    dataType : "text",
                    success: function(string){
                        console.log(string);
                        if(text_for_move=='BUY IT NOW'){
                            console.log('바로구매 이동');
                            location.href="http://49.247.136.36/main/cart/purchase_html.php";
                        }else{
                            if(confirm('장바구니에 담았습니다.\n장바구니로 이동하시겠습니까?')==true){
                                console.log('장바구니 이동')
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert(error);
                    }
                });
            }else{
                alert('구매하실 상품 옵션을 선택하세요');
            }
        }
    });
    //몸통 클릭시 이벤트
    $('#product_body').click(function(){
        if(is770_porudct_place_open)    //770픽셀 이하의 구매공간이 펼쳐져 있는 경우에
        {
            $('.product_detail_top_add_place').append($('.product_detail_top_add_place_move'));
            $('.product_detail_top_table_size').css({"width":"130px","height":"30px","margin-bottom":"0px"});
            $('.product_detail_top_table_color').css({"width":"130px","height":"30px","margin-bottom":"0px"});
            $('.product_total_price').append($('.product_total_price_text'));
            $('#color_parents').append($('.product_detail_top_table_color'));
            $('#size_parents').append($('.product_detail_top_table_size'));
            is770_porudct_place_open=false;
            $('.hidden_770_hidden_product_place').css({
                "height":"0px",
                "transition":"all 200ms linear",
                "margin-bottom":"0px"
            });
        }
    });


    //최초 페이지 접근 이벤트
    category_top=$('.product_category_box_parents_hidden').offset().top;
    if($(window).width()<974)
    {
        if($(window).width()>753){
            resize_control_for_predressing();
            $('.product_preview_contents_box').append($('.product_preview_contents_image_box'));
            $('.product_preview_content_product_information_title').append($('.product_preview_content_product_information'));
            $('.product_preview_content_product_image_box').append($('.product_preview_content_product_image'));
        }else if($(window).width()<754){
            resize_control_for_predressing();
            $('.hidden_770_preview_title').append($('.product_preview_content_product_information'));
            $('.product_preview_clothes_contents_box').append($('.product_preview_contents_image_box'));
            $('.hidden_770_preview_product_image').append($('.product_preview_content_product_image'));
        }else if($(window).width()<384){
            resize_control_for_predressing();
        }
        if(p_scrollValue+54>category_top)
        {
            $('.product_category_box_parents').css({"position":"fixed","top":"54px"});
            $('.product_category_box_parents_hidden').css("height","70px");
            $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
        }
        else
        {
            $('.product_category_box_parents').css({"position":"static","top":"0px"});
            $('.product_category_box_parents_hidden').css("height","1px");
            $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
        }
    }
    else
    {
        if(p_scrollValue+$('#head_category_place').height()>category_top)
        {
            $('.product_category_box_parents').css({"position":"fixed","top":$('#head_category_place').height()});
            $('.product_category_box_parents_hidden').css("height","70px");
            $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
        }
        else
        {
            $('.product_category_box_parents').css({"position":"static","top":"0px"});
            $('.product_category_box_parents_hidden').css("height","1px");
            $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
        }
    }
    if($(window).width()>973)
    {
        $('.head_fixed_margin').css("margin-bottom","56px");
        if($(window).width()>1300)
        {
            $('.product_detail_top_images').css({"width":"650px"});
            $('.product_detail_top_image').css({"height":"650px", "width":"650px"});
            $('.product_detail_top_next_image').css({"width": (636)/7,"height":(636)/7});
            $('.product_detail_contents_top').css("width","1270px");
            $('.product_detail_top_text_box').css("width","520px");
            $('.product_category_contents_box').css("width","1270px");
        }
        else
        {
            $('.product_detail_top_images').css("width",$(window).width()/2);
            $('.product_detail_top_image').css({"height":$(window).width()/2, "width":$(window).width()/2});
            $('.product_detail_top_next_image').css({
                "width": ($(window).width()/2-14)/7,
                "height":($(window).width()/2-14)/7
            });
            $('.product_detail_top_text_box').css("width",($(window).width()/2-130));
            $('.product_detail_contents_top').css("width",$(window).width()-15);
            $('.product_category_contents_box').css("width",$(window).width()-30);
        }
    }
    else
    {
        $('.product_detail_top_text_box').css({"width":$(window).width()-30,"margin-left":"15px"});
        $('.product_detail_top_images').css("width",$(window).width()-30);
        $('.product_detail_top_image').css({"width":$(window).width()-30, "height":$(window).width()-30});
        $('.product_detail_contents_top').css("width",$(window).width()-15);
        $('.product_category_contents_box').css("width",$(window).width()-30);
        $('.product_detail_top_next_image').css({
            "width": ($(window).width()/2-14)/7,
            "height":($(window).width()/2-14)/7,
        });
        if($(window).width()<754)
        {
            $('.hidden_770_bottom_button1').css("width",($(window).width()-67)/2);
            if(is770_porudct_place_open)    //770픽셀 이하의 구매공간이 펼쳐져 있는 경우에
            {
                $('#color_parents').append($('.product_detail_top_table_color'));
                $('#size_parents').append($('.product_detail_top_table_size'));
                $('.product_total_price').append($('.product_total_price_text'));
                $('.product_detail_top_table_size').css({"width":"130px","height":"30px","margin-bottom":"0px"});
                $('.product_detail_top_table_color').css({"width":"130px","height":"30px","margin-bottom":"0px"});
                $('.product_detail_top_add_place').append($('.product_detail_top_add_place_move'));
                is770_porudct_place_open=false;
                $('.hidden_770_hidden_product_place').css({
                    "height":"0px",
                    "margin-bottom":"0px"
                });
            }
        }
    }
    clearTimeout( resize_count );
    resize_count = setTimeout( resizeDone, 50 );
    //화면 크기 리사이징 이벤트
    $(window).resize(function(){
        category_top=$('.product_category_box_parents_hidden').offset().top;
        if($(window).width()<974)
        {
            if($(window).width()>753){
                resize_control_for_predressing();
                $('.product_preview_contents_box').append($('.product_preview_contents_image_box'));
                $('.product_preview_content_product_information_title').append($('.product_preview_content_product_information'));
                $('.product_preview_content_product_image_box').append($('.product_preview_content_product_image'));
            }else if($(window).width()<754){
                resize_control_for_predressing();
                $('.hidden_770_preview_title').append($('.product_preview_content_product_information'));
                $('.product_preview_clothes_contents_box').append($('.product_preview_contents_image_box'));
                $('.hidden_770_preview_product_image').append($('.product_preview_content_product_image'));
            }else if($(window).width()<384){
                resize_control_for_predressing();
            }
            if(p_scrollValue+54>category_top)
            {
                $('.product_category_box_parents').css({"position":"fixed","top":"54px"});
                $('.product_category_box_parents_hidden').css("height","70px");
                $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
            }
            else
            {
                $('.product_category_box_parents').css({"position":"static","top":"0px"});
                $('.product_category_box_parents_hidden').css("height","1px");
                $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
            }
        }
        else
        {
            resize_control_for_predressing();
            if(p_scrollValue+$('#head_category_place').height()>category_top)
            {
                $('.product_category_box_parents').css({"position":"fixed","top":$('#head_category_place').height()});
                $('.product_category_box_parents_hidden').css("height","70px");
                $('.product_category_box_parents').css({"border-bottom":"1px #D8D8D8 solid","border-top":"1px #D8D8D8 solid"});
            }
            else
            {
                $('.product_category_box_parents').css({"position":"static","top":"0px"});
                $('.product_category_box_parents_hidden').css("height","1px");
                $('.product_category_box_parents').css({"border-bottom":"none","border-top":"none"});
            }
        }
        if($(window).width()>973)
        {
            $('.head_fixed_margin').css("margin-bottom","56px");
            if($(window).width()>1300)
            {
                $('.product_detail_top_images').css({"width":"650px"});
                $('.product_detail_top_image').css({"height":"650px", "width":"650px"});
                $('.product_detail_top_next_image').css({"width": (636)/7,"height":(636)/7});
                $('.product_detail_contents_top').css("width","1270px");
                $('.product_detail_top_text_box').css("width","520px");
                $('.product_category_contents_box').css("width","1270px");
            }
            else
            {
                $('.product_detail_top_images').css("width",$(window).width()/2);
                $('.product_detail_top_image').css({"height":$(window).width()/2, "width":$(window).width()/2});
                $('.product_detail_top_next_image').css({
                    "width": ($(window).width()/2-14)/7,
                    "height":($(window).width()/2-14)/7
                });
                $('.product_detail_top_text_box').css("width",($(window).width()/2-130));
                $('.product_detail_contents_top').css("width",$(window).width()-15);
                $('.product_category_contents_box').css("width",$(window).width()-30);
            }
        }
        else
        {
            $('.product_detail_top_text_box').css({"width":$(window).width()-30,"margin-left":"15px"});
            $('.product_detail_top_images').css("width",$(window).width()-30);
            $('.product_detail_top_image').css({"width":$(window).width()-30, "height":$(window).width()-30});
            $('.product_detail_contents_top').css("width",$(window).width()-15);
            $('.product_category_contents_box').css("width",$(window).width()-30);
            $('.product_detail_top_next_image').css({
                "width": ($(window).width()/2-14)/7,
                "height":($(window).width()/2-14)/7,
            });
            if($(window).width()<754)
            {
                $('.hidden_770_bottom_button1').css("width",($(window).width()-67)/2);
                if(is770_porudct_place_open)    //770픽셀 이하의 구매공간이 펼쳐져 있는 경우에
                {
                    $('#color_parents').append($('.product_detail_top_table_color'));
                    $('#size_parents').append($('.product_detail_top_table_size'));
                    $('.product_total_price').append($('.product_total_price_text'));
                    $('.product_detail_top_table_size').css({"width":"130px","height":"30px","margin-bottom":"0px"});
                    $('.product_detail_top_table_color').css({"width":"130px","height":"30px","margin-bottom":"0px"});
                    $('.product_detail_top_add_place').append($('.product_detail_top_add_place_move'));
                    is770_porudct_place_open=false;
                    $('.hidden_770_hidden_product_place').css({
                        "height":"0px",
                        "margin-bottom":"0px"
                    });
                }
            }
        }
        clearTimeout( resize_count );
        resize_count = setTimeout( resizeDone, 100 );
    });
    //화면 리사이즈가 끝났을 때 이벤트 ( 배치가 맞는지 한번 더 재배열 )
    function resizeDone()
    {
        resize_control_for_predressing();
        $('.swiper-slide').css("width","100%");

        if($(window).width()<972)
        {
            $('.head_fixed_margin').css("margin-bottom","0px");
        }
        if($(window).width()<754)
        {
            $('.hidden_770_bottom_button1').css("width",($(window).width()-67)/2)
        }
    }

    //색상, 사이즈 선택시 이벤트 ( 제품을 선택한 것 )
    $('.product_detail_top_table_size').change(function(){
        if($('.product_detail_top_table_size option').index($('.product_detail_top_table_size option:selected'))!=0&&$('.product_detail_top_table_color option').index($('.product_detail_top_table_color option:selected'))!=0)
        {
            add_product($('.product_detail_top_table_color option:selected').val(),$('.product_detail_top_table_size option:selected').val());
            $(".product_detail_top_table_color option:eq(0)").prop("selected",true);
            $(".product_detail_top_table_size option:eq(0)").prop("selected",true);
        }

    });
    $('.product_detail_top_table_color').change(function(){
        if($('.product_detail_top_table_size option').index($('.product_detail_top_table_size option:selected'))!=0&&$('.product_detail_top_table_color option').index($('.product_detail_top_table_color option:selected'))!=0)
        {
            add_product($('.product_detail_top_table_color option:selected').val(),$('.product_detail_top_table_size option:selected').val());
            $(".product_detail_top_table_color option:eq(0)").prop("selected",true);
            $(".product_detail_top_table_size option:eq(0)").prop("selected",true);
        }

    });

    //제품 추가(구매를 위한) 함수
    function add_product(col_val,size_val)
    {
        //노드 추가

        // //중복확인
        for(var select_count=0;select_count<$('.product_detail_top_add_product').length;select_count++)
        {
           if($('.product_detail_top_add_product').eq(select_count).attr("size")==size_val&&$('.product_detail_top_add_product').eq(select_count).attr("color")==col_val)
           {
               alert('이미 선택된 상품입니다.');
               return;
           }
        }
        var node="<div class=\"product_detail_top_add_product\" size=\""+size_val+"\" color=\""+col_val+"\" style=\"display:none;\"><div class=\"product_detail_top_add_product_left\"><div class=\"product_detail_top_add_product_name\"><?php echo $name;?></div>";
        node+="<div class=\"product_detail_top_add_product_color\">-&nbsp;"+$('.product_detail_top_table_color').val()+"&nbsp;/&nbsp;"+$('.product_detail_top_table_size').val()+"</div></div>";
        node+="<div class=\"product_detail_top_add_product_right\"><div class=\"product_detail_top_add_product_count\"><div class=\"product_detail_top_add_product_count_decrease\" onclick='count(this, -1)'>-</div>";
        node+="<input onkeyup='keyup_f(this)' type=\"number\" class=\"product_detail_top_add_product_count_input\" value=\"1\"><div class=\"product_detail_top_add_product_count_increase\" onclick='count(this, 1)'>+</div>";
        node+="</div><div class=\"product_detail_top_add_product_delete\">x</div><div class=\"product_detail_top_add_product_price\">"+comma(price)+" won</div></div></div>";

        $('.product_detail_top_add_place_move').append(node);
        //애니메이션 효과(생성)
        $('.product_detail_top_add_product').fadeIn(400);
        $('.product_detail_top_add_product').fadeTo("slow",1);
        ////삭제버튼 클릭
        $('.product_detail_top_add_product_delete').click(function(){
           //애니메이션 효과
           var p_node = $(this).parents('.product_detail_top_add_product');
           $(p_node).fadeOut(400);
           $(p_node).fadeTo("slow",0);
           setTimeout(function() {
               //삭제
               $(p_node).remove();
               //TOTAL PRICE변경
               var number=0;
               for(var add_c=0;add_c<$('.product_detail_top_add_product_count_input').length;add_c++)
               {
                   number += parseInt($('.product_detail_top_add_product_count_input').eq(add_c).val());
               }
               $('.product_total_price_text').text("Total Price : "+comma(number*price)+" won");
           }, 500);
        });
        var number=0;
        for(var add_c=0;add_c<$('.product_detail_top_add_product_count_input').length;add_c++)
        {
           number += parseInt($('.product_detail_top_add_product_count_input').eq(add_c).val());
        }
        $('.product_total_price_text').text("Total Price : "+comma(number*price)+" won");
        $('.product_detail_top_add_product_count_input').change(function(){
           var value = $(this).val();
           if(!isNaN(value))
           {
               if(value>0)
               {
                   $(this).parents('.product_detail_top_add_product_count').parents('.product_detail_top_add_product_right').children('.product_detail_top_add_product_price').text(comma(price*value)+' won');
               }
               else
               {
                   value=1;
                   $(this).parents('.product_detail_top_add_product_count').parents('.product_detail_top_add_product_right').children('.product_detail_top_add_product_price').text(comma(price*value)+' won');
                   $(this).parents('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val(value);
                   alert('최소 주문수량은 1개 입니다.');
               }
               var number=0;
               for(var add_c=0;add_c<$('.product_detail_top_add_product_count_input').length;add_c++)
               {
                   number += parseInt($('.product_detail_top_add_product_count_input').eq(add_c).val());
               }
               $('.product_total_price_text').text("Total Price : "+comma(number*price)+" won");
           }
           else
           {
               alert('수량을 제대로 입력하세요');
           }
        });
    }

    //상품의 수량이 변경될 때 이벤트(input 태그 직접 변경)
    function keyup_f(object)
    {
        var value = $(object).val();
        if(!isNaN(value))
        {
            $(object).parents('.product_detail_top_add_product_count').parents('.product_detail_top_add_product_right').children('.product_detail_top_add_product_price').text(comma(price*value)+' won');
            var number=0;
            for(var add_c=0;add_c<$('.product_detail_top_add_product_count_input').length;add_c++)
            {
                number += parseInt($('.product_detail_top_add_product_count_input').eq(add_c).val());
            }
            $('.product_total_price_text').text("Total Price : "+comma(number*price)+" won");
        }
    }

    //상품의 수량이 변경될 때 이벤트(버튼 클릭 변경)
    function count(object, num)
    {
        var count = $(object).parents('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val();
        var p_count = parseInt(count);
        if(parseInt(p_count)+num<1)
        {
            alert('최소 주문수량은 1개 입니다.');
        }
        else
        {
            $(object).parents('.product_detail_top_add_product_count').children('.product_detail_top_add_product_count_input').val(p_count+num);
            $(object).parents('.product_detail_top_add_product_count').parents('.product_detail_top_add_product_right').children('.product_detail_top_add_product_price').text(comma(price*(p_count+num))+' won');
            var number=0;
            for(var add_c=0;add_c<$('.product_detail_top_add_product_count_input').length;add_c++)
            {
                number += parseInt($('.product_detail_top_add_product_count_input').eq(add_c).val());
            }
            $('.product_total_price_text').text("Total Price : "+comma(number*price)+" won");
        }
    }


    //세자리 단위마다 콤마를 찍는 함수
    function comma(num){
        var len, point, str;
        num = num + "";
        point = num.length % 3 ;
        len = num.length;
        str = num.substring(0, point);
        while (point < len) {
            if (str != "") str += ",";
            str += num.substring(point, point + 3);
            point += 3;
        }
        return str;
    }

    //이미지 슬라이드에 관한 스크립트 ( swiper )

    var now_image_index = 0;//현재 이미지 인덱스
    //메인 이미지들중 한가지 클릭시 이벤트
    $('.product_detail_top_next_image').click(function(){
        $('.product_detail_top_next_image').css({
            "transition":"all 200ms linear",
            "border":"1px white solid"
        });
        $(this).css({
            "transition":"all 200ms linear",
            "border":"1px black solid"
        });
        //이미지 인덱스 변경
        now_image_index=$(this).index();
        swiper.slideTo($(this).index(), 400, function(){})
    });
    var swiper = new Swiper('.swiper-container', {
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        on:{
            transitionEnd:function(){
                $('.product_detail_top_next_image').css({
                    "border":"1px white solid"
                });
                $('.product_detail_top_next_image').eq($('.swiper-slide-active').index()).css({
                    "border":"1px black solid"
                });
                //이미지 인덱스 변경
                now_image_index=$('.swiper-slide-active').index();
            },
        },
    });
    $(window).ready(function(){
        setTimeout(function(){
            category_top=$('.product_category_box_parents_hidden').offset().top;
        },200);
    });
</script>
</html>
