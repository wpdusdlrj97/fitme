<?php
    $con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($con,'utf8');
    if($con){
        $qry = "select * from NANING9";
        mysqli_query($con,"set session character_set_connection=utf8;");
        mysqli_query($con,"set session character_set_result=utf8;");
        mysqli_query($con,"set session character_set_client=utf8;");
        $send = mysqli_query($con,$qry);
        $product_url = array();
        $product_wearing = array();
        $product_name = array();
        $product_price = array();
//        $product_color = array();
//        $product_top_category = array();
//        $product_detail_category = array();
//        $product_size = array();
        $row = mysqli_fetch_array($send);

        $count = 0;
        while($row = mysqli_fetch_array($send)){
            array_push($product_url,$row['product_url']);
            array_push($product_wearing,$row['product_wearing']);
            array_push($product_name,$row['product_name']);
            array_push($product_price,$row['product_price']);
//            array_push($product_color,$row['product_color']);
//            array_push($product_top_category,$row['product_top_category']);
//            array_push($product_detail_category,$row['product_detail_category']);
//            array_push($product_size,$row['product_size']);
            $count++;
        }
        $array_data['product_url']=$product_url;
        $array_data['product_wearing']=$product_wearing;
        $array_data['product_name']=$product_name;
        $array_data['product_price']=$product_price;
//        $array_data['product_color']=$product_color;
//        $array_data['product_top_category']=$product_top_category;
//        $array_data['product_detail_category']=$product_detail_category;
//        $array_data['product_size']=$product_size;

        echo json_encode($array_data, JSON_UNESCAPED_UNICODE);

    }
?>
