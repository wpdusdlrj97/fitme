<?php
session_start();
$connect = mysqli_connect('localhost', 'FunIdeaDBUser', '*TeamNova2019*', 'FitMe');
mysqli_set_charset($connect, 'utf8');


$id = $_SESSION['id'];

//print_r($data);

$data = json_decode($_POST['data'], true);

print_r($data);


if ($data) {
    //문자열 데이터
    $product_key = $data['product_key'];
    $move = $data['move'];

    //배열 데이터
    $color = $data['color'];    //색상
    $size = $data['size'];      //사이즈
    $count = $data['count'];    //개수

    //Product_Key를 통해 조회해 가져오는 데이터 (상품명, 상품이미지, 상품가격)
    $query_product_info = "select * from product where product_key='$product_key'";
    $result_product_info = mysqli_query($connect, $query_product_info);
    $row_product_info = mysqli_fetch_assoc($result_product_info);

    $name = $row_product_info['name']; //상품명
    $image = $row_product_info['main_image']; //이미지
    $price = $row_product_info['price']; //상품가격





    if ($move == 'buy') { //상세페이지에서 바로 구매하기 버튼을 클릭할 시

        // 바로 주문 시 -> 1. 해당 id를 가진 데이터가 있는지 확인하고 지운
        //               2. 그 후에 데이터를 삽입한다

        $query_delete = "DELETE FROM order_form WHERE user_id='$id'";
        $result_delete = mysqli_query($connect, $query_delete);

        if ($result_delete) {

            for ($buy_product_count = 0; $buy_product_count < count($count); $buy_product_count++) {


                $query_order = "insert into order_form(user_id, product_key, product_name, product_image, product_size, product_color, product_count, product_amount) 
                                VALUES('$id','$product_key','$name','$image','$size[$buy_product_count]','$color[$buy_product_count]','$count[$buy_product_count]','$price')";
                $result_order = mysqli_query($connect, $query_order);

                // $color[$buy_product_count];
                // $size[$buy_product_count];
                // $count[$buy_product_count];
            }

            print_r("바로구매 아이디 - " . $id . "\n");
            print_r("바로구매 제품키 - " . $product_key . "\n");
            print_r("바로구매 - " . $move . "\n");

            print_r($color);
            print_r($size);
            print_r($count);

        } else {
            print_r("삭제 X");
        }

    } elseif ($move == 'cart') { //상세페이지에서 장바구니에 담기 버튼을 클릭했을 경우

        // 장바구니 담기 -> 1. 동일한 제품이 장바구니에 있는지 확인필요
        //                    (동일한 제품의 정의 - 색상, 사이즈까지 동일한 경우) -> 처리해줘야한다
        //                   동일한 제품이 있을 경우 동일한 제품이 있다고 안내한 후 그래도 장바구니에 담겠다고 하면 수량 + 필요
        //                2. 동일한 제품이 장바구니에 없을경우 장바구니에 담는다



        for ($cart_product_count = 0; $cart_product_count < count($count); $cart_product_count++) {


            $query_overlap="select * from cart_form where user_id='$id' and product_key='$product_key' and product_size='$size[$cart_product_count]' and product_color='$color[$cart_product_count]'";
            $result_overlap=mysqli_query($connect,$query_overlap);
            $total_rows_overlap = mysqli_num_rows($result_overlap);

            if($total_rows_overlap==0){ //중복이 안된경우 추가

                $query_cart = "insert into cart_form(user_id, product_key, product_size, product_color, product_count) VALUES('$id','$product_key','$size[$cart_product_count]','$color[$cart_product_count]','$count[$cart_product_count]')";
                $result_cart = mysqli_query($connect, $query_cart);

                if($result_cart){
                    print_r("중복이 안된경우 제품 키 - " . $product_key . "\n");
                    print_r("중복이 안된경우 제품 사이즈 - " . $size[$cart_product_count] . "\n");
                    print_r("중복이 안된경우 제품 색상 - " . $color[$cart_product_count] . "\n");
                    print_r("중복이 안된경우 제품 개수 - " . $count[$cart_product_count] . "\n");
                }else{
                    print_r("중복 안된 경우 실패");
                }



            }else{ //중복이 된경우 update

                $query_cart = "update cart_form set product_count=product_count+'$count[$cart_product_count]' where user_id='$id' and product_key='$product_key' and product_size='$size[$cart_product_count]' and product_color='$color[$cart_product_count]'";
                $result_cart = mysqli_query($connect, $query_cart);


                if($result_cart){
                    print_r("중복이 된경우 제품 키 - " . $product_key . "\n");
                    print_r("중복이 된경우 제품 사이즈 - " . $size[$cart_product_count] . "\n");
                    print_r("중복이 된경우 제품 색상 - " . $color[$cart_product_count] . "\n");
                    print_r("중복이 된경우 제품 개수 - " . $count[$cart_product_count] . "\n");
                }else{
                    print_r("중복 된 실패");
                }


            }

        }

        

    } else { //오류가 날 경우

        print_r("오류");

    }

    mysqli_close($connect);
}


?>