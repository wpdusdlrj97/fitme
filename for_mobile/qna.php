<?php
//최초 GET 방식으로 넘어온 데이터가 존재하는지 확인을 한 뒤 존재하면 데이터 조회, 존재하지 않으면 데이터 삽입 처리를 진행한다.
$product_key = $_GET['product_key'];//제품키를 넘겨받는다.
$page = $_GET['page'];//화면에 보여줄 페이지 번호를 넘겨받는다.
$email = $_GET['email'];
if($product_key&&$page) //넙겨받은 데이터가 있는 경우에만 동작
{
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    $qry = mysqli_query($connect,"select * from qna where product_key=$product_key order by date desc");
    $page_number = ($page*10)-10;
    $now_number=0;
    $qna_count=0;
    $qna_key_array = array();
    $email_array = array();
    $state_array = array();
    $text_array = array();
    $date_array = array();
    $hidden_array = array();
    $answer_text_array = array();
    $answer_date_array = array();
    while($row = mysqli_fetch_array($qry))
    {
        if($now_number==$page_number)
        {
            if($qna_count<10)
            {
                array_push($qna_key_array,$row['qna_key']);
                array_push($email_array,$row['email']);
                array_push($date_array,$row['date']);
                array_push($hidden_array,$row['hidden']);
                if($row['hidden']=='2'||($row['hidden']=='1'&&$row['email']==$email))
                {
                    array_push($text_array,$row['text']);
                }
                else
                {
                    array_push($text_array,null);
                }
                array_push($state_array,$row['state']);
                $qna_key = $row['qna_key'];
                $qry2 = mysqli_query($connect,"select * from qna_answer where qna_key=$qna_key");
                $result = mysqli_fetch_array($qry2);
                if(($row['state']=='2'&&($row['email']==$email)))
                {
                    array_push($answer_date_array, date('Y/m/d', strtotime(substr($result['date'], 0, 7))));
                    array_push($answer_text_array,$result['text']);
                }
                else
                {
                    array_push($answer_date_array, date('Y/m/d', strtotime(substr($result['date'], 0, 7))));
                    array_push($answer_text_array,'비밀글입니다.');
                }
                $qna_count++;
            }
            else
            {
                break;
            }
        }
        else
        {
            $now_number++;
        }
    }
    mysqli_close($connect);
    $qna_data['qna_key'] = $qna_key_array;
    $qna_data['email'] = $email_array;
    $qna_data['state'] = $state_array;
    $qna_data['text'] = $text_array;
    $qna_data['date'] = $date_array;
    $qna_data['hidden'] = $hidden_array;
    $qna_data['answer_text'] = $answer_text_array;
    $qna_data['answer_date'] = $answer_date_array;
    echo json_encode($qna_data,JSON_UNESCAPED_UNICODE);
}
else    //넘겨받은 데이터가 없는 경우에는 POST 방식으로 데이터를 넘겨받는다.
{
    $number = $_POST['number'];
    $connect = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe');
    mysqli_set_charset($connect,'utf8');
    if($number==1)
    {
        //넘겨받은 데이터를 토대로 테이블에 insert시킨다.
        $product_key = $_POST['product_key'];
        $email = $_POST['email'];
        $text = $_POST['text'];
        $hidden = $_POST['hidden'];
        $date = date("YmdHis");
        mysqli_query($connect,"insert into qna(product_key,email,state,text,date,hidden) values($product_key,'$email','1','$text',$date,'$hidden');");
    }
    else if($number==2)
    {
        //넘겨받은 데이터를 토대로 수정
        $qna_key = $_POST['qna_key'];
        $text = $_POST['text'];
        $date = date("YmdHis");
        mysqli_query($connect,"update qna set text='$text', modify_date=$date where qna_key=$qna_key");
    }
    mysqli_close($connect);
}
?>