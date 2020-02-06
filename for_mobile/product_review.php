<?php
$category = $_GET['category'];
$page = $_GET['page'];
$product_key = $_GET['product_key'];
if($page&&$category)
{
    $count = null;
    $review_email = array();
    $review_star = array();
    $review_text = array();
    $review_date = array();
    $review_photo = array();
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    if($category==3)//Photo Review
    {
        $qry = mysqli_query($connect,"select * from review where product_key=$product_key and photo is not null order by date desc;");
        $count = mysqli_num_rows($qry);
    }
    else if($category==1)//Text Review
    {
        $qry = mysqli_query($connect,"select * from review where product_key=$product_key and photo is null order by date desc;");
        $count = mysqli_num_rows($qry);
    }
    else if($category==2)//All Review
    {
        $qry = mysqli_query($connect,"select * from review where product_key=$product_key order by date desc");
        $count = mysqli_num_rows($qry);
    }
    $page_count=0;
    $finish_count=0;
    while($row=mysqli_fetch_array($qry))
    {
        if($page*10<=$page_count)
        {
            if($finish_count==10)
            {
                break;
            }
            else
            {
                array_push($review_email,$row['email']);
                array_push($review_star,$row['star']);
                array_push($review_text,$row['review_text']);
                array_push($review_date,$row['date']);
                array_push($review_photo,$row['photo']);
            }
            $finish_count++;
        }
        else
        {
            $page_count++;
        }
    }
    mysqli_close($connect);
    $data['count']=$count;
    $data['review_email']=$review_email;
    $data['review_star']=$review_star;
    $data['review_text']=$review_text;
    $data['review_date']=$review_date;
    $data['review_photo']=$review_photo;
    echo json_encode($data,JSON_UNESCAPED_UNICODE);
}
?>