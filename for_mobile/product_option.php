<?php
$option = $_GET['option'];
$search = $_GET['search'];
$now_page = $_GET['page'];
$shop = $_GET['shop_name'];
if($option)
{
    $start_page=$now_page*20;
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    $qry = null;
    if($shop){
        //쇼핑몰 페이지
        //카테고리 빼오기
        $qry = mysqli_query($connect,"select distinct category1 from product where email='$shop'");
        $search_shop_category = array();
        $search_product_key = array();
        $search_product_name = array();
        $search_product_price = array();
        $search_product_image = array();
        $search_product_color = array();
        while($row = mysqli_fetch_array($qry)){
            array_push($search_shop_category,$row['category1']);
        }
        if($search)
        {
            //검색기능으로 쇼핑몰 페이지에서 상품 불러오기
        }
        else
        {
            $category1=$_GET['category1'];
            echo '뭔데';
            if($category1)
            {
                $qry2 = mysqli_query($connect,"select * from product where category1='$category1'");
                if($option=='최신순')
                {
                    $qry = mysqli_query($connect,"select * from product where category1='$category1' order by date desc limit $start_page,20");
                }
                else if($option=='인기순')
                {
                    $qry = mysqli_query($connect,"select * from product where category1='$category1' order by likes desc limit $start_page,20");
                }
                else if($option=='리뷰많은순')
                {
                    $qry = mysqli_query($connect,"select * from product where category1='$category1' order by review_count desc limit $start_page,20");
                }
                else if($option=='낮은가격순')
                {
                    $qry = mysqli_query($connect,"select * from product where category1='$category1' order by price asc limit $start_page,20");
                }
            }
            else
            {
                $qry2 = mysqli_query($connect,"select * from product");
                if($option=='최신순')
                {
                    $qry = mysqli_query($connect,"select * from product order by date desc limit $start_page,20");
                }
                else if($option=='인기순')
                {
                    $qry = mysqli_query($connect,"select * from product order by likes desc limit $start_page,20");
                }
                else if($option=='리뷰많은순')
                {
                    $qry = mysqli_query($connect,"select * from product order by review_count desc limit $start_page,20");
                }
                else if($option=='낮은가격순')
                {
                    $qry = mysqli_query($connect,"select * from product order by price asc limit $start_page,20");
                }
            }
        }
        $all_product_count = mysqli_num_rows($qry2);
        while($row = mysqli_fetch_array($qry))
        {
            array_push($search_product_key,$row['product_key']);
            array_push($search_product_name,$row['name']);
            array_push($search_product_price,number_format($row['price']));
            array_push($search_product_image,$row['main_image']);
            array_push($search_product_color,json_decode($row['color'],true)['rgb']);
        }
        $result['shop_category'] = $search_shop_category;
        $result['product_key'] = $search_product_key;
        $result['product_name'] = $search_product_name;
        $result['product_price'] = $search_product_price;
        $result['product_image'] = $search_product_image;
        $result['product_color'] = $search_product_color;
        $result['all_product_count'] = $all_product_count;
    }else{
        if($search)
        {
            $qry2 = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%')");
            if($option=='최신순')
            {
                $qry = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%') order by date desc limit $start_page,20");
            }
            else if($option=='인기순')
            {
                $qry = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%') order by likes desc limit $start_page,20");
            }
            else if($option=='리뷰많은순')
            {
                $qry = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%') order by review_count desc limit $start_page,20");
            }
            else if($option=='낮은가격순')
            {
                $qry = mysqli_query($connect,"select * from product where (category1 = '$search')||(category2 = '$search')||(name like '%$search%')||(ex like '%$search%') order by price asc limit $start_page,20");
            }
        }
        else
        {
            $category1=$_GET['category1'];
            $category2=$_GET['category2'];
            if($category1)
            {
                if($category2)
                {
                    $qry2 = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2'");
                    if($option=='최신순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2' order by date desc limit $start_page,20");
                    }
                    else if($option=='인기순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2' order by likes desc limit $start_page,20");
                    }
                    else if($option=='리뷰많은순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2' order by review_count desc limit $start_page,20");
                    }
                    else if($option=='낮은가격순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' and category2='$category2' order by price asc limit $start_page,20");
                    }
                }
                else
                {
                    $qry2 = mysqli_query($connect,"select * from product where category1='$category1'");
                    if($option=='최신순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' order by date desc limit $start_page,20");
                    }
                    else if($option=='인기순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' order by likes desc limit $start_page,20");
                    }
                    else if($option=='리뷰많은순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' order by review_count desc limit $start_page,20");
                    }
                    else if($option=='낮은가격순')
                    {
                        $qry = mysqli_query($connect,"select * from product where category1='$category1' order by price asc limit $start_page,20");
                    }
                }
            }
            else
            {
                $qry2 = mysqli_query($connect,"select * from product");
                if($option=='최신순')
                {
                    $qry = mysqli_query($connect,"select * from product order by date desc limit $start_page,20");
                }
                else if($option=='인기순')
                {
                    $qry = mysqli_query($connect,"select * from product order by likes desc limit $start_page,20");
                }
                else if($option=='리뷰많은순')
                {
                    $qry = mysqli_query($connect,"select * from product order by review_count desc limit $start_page,20");
                }
                else if($option=='낮은가격순')
                {
                    $qry = mysqli_query($connect,"select * from product order by price asc limit $start_page,20");
                }
            }
        }
        $all_product_count = mysqli_num_rows($qry2);
        $search_product_key = array();
        $search_product_shop = array();
        $search_product_name = array();
        $search_product_price = array();
        $search_product_image = array();
        $search_product_color = array();
        while($row = mysqli_fetch_array($qry))
        {
            $shop_email = $row['email'];
            $qry2 = mysqli_query($connect,"select name from shop_name where email='$shop_email'");
            $result = mysqli_fetch_array($qry2);
            array_push($search_product_key,$row['product_key']);
            array_push($search_product_shop,$result['name']);
            array_push($search_product_name,$row['name']);
            array_push($search_product_price,number_format($row['price']));
            array_push($search_product_image,$row['main_image']);
            array_push($search_product_color,json_decode($row['color'],true)['rgb']);
        }
        $result['product_key'] = $search_product_key;
        $result['product_shop'] = $search_product_shop;
        $result['product_name'] = $search_product_name;
        $result['product_price'] = $search_product_price;
        $result['product_image'] = $search_product_image;
        $result['product_color'] = $search_product_color;
        $result['all_product_count'] = $all_product_count;
    }
    mysqli_close($connect);
    echo json_encode($result,JSON_UNESCAPED_UNICODE);
}
else
{
    echo 'failed';
}
?>