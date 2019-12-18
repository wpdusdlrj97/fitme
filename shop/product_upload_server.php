<?php
//제품을 등록하는 페이지, 옷입어보기 이미지는 한번의 검증을 더 거쳐야 하므로 임시 디렉터리에 저장한다.
session_start();
$email = $_SESSION['email'];
if($email)
{
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');

    $qry = mysqli_query($connect,"select *from user_information where email='$email'");
    $row = mysqli_fetch_array($qry);
    if($row['level']==1)
    {
        $number = $_POST['number'];
        //넘겨받은 데이터는 텍스트데이터
        if($number)
        {
            //데이터들을 넘겨받음 ( 받은 key를 기준으로 데이터를 저장한다 )
            $name = $_POST['name'];
            $ex = $_POST['ex'];
            $price = $_POST['price'];
            $category1 = $_POST['category1'];
            $category2 = $_POST['category2'];
            $size = $_POST['size'];
            $content = $_POST['content'];
            $stock = $_POST['stock'];
            $key = $_POST['key'];

            //만약 넘겨받은 content중 아래의 문자열이 있으면 본문에 이미지를 업로드 한것이므로 본문 이미지 경로를 수정해주고, 해당 이미지를 자원디렉터리로 옴겨준다.
            if(strpos($content,"http://49.247.136.36/shop/temp_images"))
            {
                $res = mysqli_query($connect,"select * from temp_product_images where email='$email'");
                while($rcv = mysqli_fetch_array($res))
                {
                    $tmp_url = "http://49.247.136.36/shop".$rcv['filename'];
                    if(strpos($content,$tmp_url))
                    {
                        $new_n = str_replace("/temp_images/","",$rcv['filename']);
                        $content = str_replace("http://49.247.136.36/shop/temp_images/".$new_n,"http://49.247.136.36/product_resource/image/detail_content/".$new_n,$content);
                        $command = "mv .".$rcv['filename']." ../product_resource/image/detail_content/".$new_n;
                        system($command);
                        $d_n = $rcv['filename'];
                        $new_qry = mysqli_query($connect,"delete from temp_product_images where filename='$d_n'");
                    }
                    else
                    {
                        unlink('.'.$rcv['filename']);
                        $d_n = $rcv['filename'];
                        $new_qry = mysqli_query($connect,"delete from temp_product_images where filename='$d_n'");
                    }
                }
            }

            //쿼리문으로 데이터를 저장한다.
            if($name&&$ex&&$price&&$category1&&$category2&&$size&&$content&&$stock&&$key)
            {
              $qry = mysqli_query($connect,"update product set name='$name',ex='$ex',price=$price,category1='$category1',category2='$category2',size='$size',content='$content',stock=$stock where product_key=$key");
            }
        }
        //넘겨받은 데이터는 파일 데이터
        else
        {
            if(count($_FILES['images']['name'])>2)
            {
                $email = $_SESSION['email'];
                $date = date("YmdHis");

                //0번째 파일은 메인이미지
                $main_file_path = '../product_resource/image/main/'.$email.$date.'_main.jpg';
                $main_url = "http://49.247.136.36/product_resource/image/main/".$email.$date.'_main.jpg';
                move_uploaded_file($_FILES['images']['tmp_name'][0],$main_file_path);

                //1번째 파일은 옷입어보기 이미지 - 임시 디렉터리에 저장(검증을 한번 더 거쳐야 함)
                $fitme_file_path = '../product_resource/image/fitme_temp/'.$email.$date.'_fitme.png';
                $fitme_url = "http://49.247.136.36/product_resource/image/fitme_temp/".$email.$date.'_fitme.png';
                move_uploaded_file($_FILES['images']['tmp_name'][1],$fitme_file_path);

                $detail_url_array=array();  //제품상세 페이지 상단의 이미지들을 저장할 배열
                for($i=2;$i<count($_FILES['images']['name']);$i++)
                {
                    $detail_file_path = '../product_resource/image/detail_main/'.$email.$date.'_detail_'.$i.'.jpg';
                    $detail_url = "http://49.247.136.36/product_resource/image/detail_main/".$email.$date.'_detail_'.$i.'.jpg';
                    move_uploaded_file($_FILES['images']['tmp_name'][$i],$detail_file_path);
                    array_push($detail_url_array,$detail_url);
                }
                $json = json_encode($detail_url_array,JSON_UNESCAPED_UNICODE);
                $qry = mysqli_query($connect,"insert into product(email,name,ex,price,category1,category2,size,content, main_image, detail_image,stock,date) values('$email','-','-',0,'-','-','-','-','$main_url','$json',0,$date);");
                $qry = mysqli_query($connect,"select * from product where email='$email' and date='$date'");
                $row = mysqli_fetch_array($qry);
                $key = $row['product_key'];
                $qry = mysqli_query($connect,"insert into product_approval values($key,'$fitme_url')");
                echo $key;
            }
        }
    }
    else
    {
        echo 'level';
    }
}
else{
    echo 'email';
}
?>
