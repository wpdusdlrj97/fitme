<?php
//핏미 기능에서 서버와 통신이 일어나는 모든것은 이 페이지를 거침
//추후에 사용자가 좋아요, 즐겨찾기 한 데이터를 같이 보내줘야 하기 때문에 사용자의 email을 받는다.
$email = $_GET['email'];//사용자에게 받은 이메일
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');

if($email)
{
    $category1 = $_GET['category1'];
    $category2 = $_GET['category2'];
    $qry = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2'");
    $product_key=array();   //제품 식별키
    $owner = array();       //제품 소유자 이메일
    $url = array();         //제품사진 경로
    $size = array();        //제품 제공사이즈
    $name = array();        //제품 이름
    $category1 = array();   //제품 대분류 카테고리
    $category2 = array();   //제품 상세 카테고리
    $line_position = array();   //제품의 총기장, 어깨너비를 알수 있는 좌표값 4개 ( 시작점, 끝점 ) - 기준은 제품사진의 원본 크기
    $pic_size = array();    //제품 사진크기 ( 원본 )
    while($row = mysqli_fetch_array($qry))
    {
        if($row['fitme_image'])
        {
            $pic_size_temp = getimagesize($row['fitme_image']);//사진의 원본 크기를 알아내는 함수
            $pic_size_array = array();//제품 사진크기 변수에 넣을 데이터를 만든다. ( 가로, 세로 )
            $pic_size_array[0] = $pic_size_temp[0];//사진 가로길이
            $pic_size_array[1] = $pic_size_temp[1];//사진 세로길이
            $json = json_encode($pic_size_array,JSON_UNESCAPED_UNICODE);
            array_push($pic_size,$pic_size_array);
            array_push($product_key,$row['product_key']);
            array_push($owner,$row['email']);
            array_push($url,$row['fitme_image']);
            array_push($size,$row['size']);
            array_push($name,$row['name']);
            array_push($category1,$row['category1']);
            array_push($category2,$row['category2']);
            array_push($line_position,$row['line_position']);
        }
    }
    mysqli_close($connect);
    //아래 코드로 여러 배열들을 하나의 오브젝트로 만든다
    $result['product_key'] = $product_key;
    $result['owner'] = $owner;
    $result['url'] = $url;
    $result['size'] = $size;
    $result['name'] = $name;
    $result['category1'] = $category1;
    $result['category2'] = $category2;
    $result['line_position'] = $line_position;
    $result['pic_size'] = $pic_size;

    //제이슨으로 변환하여 전송한다.
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
else
{
    //이메일 없으면 이걸 보낸다.
    $result = array("result" => "failed");
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}


?>
