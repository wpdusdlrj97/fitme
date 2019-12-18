<?php
//모바일 플랫폼에서 카테고리 목록을 가져올때 사용하는 페이지
$connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
mysqli_set_charset($connect,'utf8');
$qry = mysqli_query($connect,"select * from category");
$category1 = array();
$category2 = array();
$offer_option = array();
$offer_size = array();
while($row = mysqli_fetch_array($qry))
{
    array_push($category1,$row['name']);
    array_push($category2,$row['detail_category']);
    array_push($offer_option,$row['offer_option']);
    array_push($offer_size,$row['offer_size']);
}
$data['category1'] = $category1;
$data['category2'] = $category2;
$data['offer_option'] = $offer_option;
$data['offer_size'] = $offer_size;
echo json_encode($data,JSON_UNESCAPED_UNICODE);
?>