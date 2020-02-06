


<!-- 주소 검색 -->
<script src="http://code.jquery.com/jquery-latest.min.js"></script>






<body>

<div id="category_line"></div>
<div id="category_left_box">
    <div class="categories_title">CATEGORIES</div>
    <div class="categories_contents">
        <div class="categories_contents_text"><a href="http://49.247.136.36/main/category.php">전체</a></div>
    </div>
    <?php
    for ($i = 0; $i < count($category1); $i++) {
        ?>
        <div class="categories_contents">
            <div class="categories_contents_text"><?php echo $category1[$i] ?></div>
            <div class="categories_more"></div>
        </div>
        <div class="categories_contents_detail">
            <div class="add_category"><a
                    href="http://49.247.136.36/main/category.php?category1=<?php echo $category1[$i] ?>">ALL</a>
            </div>
            <?php
            for ($count_d = 0; $count_d < count(json_decode($category2[$i])); $count_d++) { ?>
                <div class="add_category"><a
                        href="http://49.247.136.36/main/category.php?category1=<?php echo $category1[$i] ?>&category2=<?php echo json_decode($category2[$i])[$count_d] ?>"><?php echo json_decode($category2[$i])[$count_d] ?></a>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>
<div id="category_right_box">
    <div class="category_right_title"> order</div>

    <div class="product_list">
        <br><br><br>

        <div class="form-style-2">
            <div class="form-style-2-heading">상품 정보</div>
            <table id="customers">
                <tr style="border: 1px solid #ddd;">
                    <th><input type="checkbox" name="chk_info" value="HTML"></th>
                    <th>이미지</th>
                    <th>상품명/옵션</th>
                    <th>판매가</th>
                    <th>수량</th>
                    <th>적립금</th>
                    <th>배송비</th>


                </tr>
                <tbody style="border: 1px solid #ddd;">

                <td width="5%" align="center"><input type="checkbox" name="chk_info" value="HTML"></td>
                <td width="10%" align="center"><img
                        src="http://49.247.136.36/product_resource/image/main/yohan@gmail.com20191220211834_main.jpg"
                        alt="My Image" width="90" height="90" style="margin-bottom: 3px;"></td>
                <td width="20%" align="center"><?php echo '메모리 MA-1 항공점퍼3colors'; ?><br>
                    <?php echo '[옵션 - Black, L]'; ?></td>
                <td width="10%" align="center"><?php echo '2,000원'; ?></td>
                <td width="10%" align="center"><?php echo '1'; ?></td>
                <td width="10%" align="center"><?php echo '20원'; ?></td>
                <td width="10%" align="center"><?php echo '무료'; ?></td>


                </tbody>


            </table>

        </div>


        <br><br><br><br><br>


        <div class="form-style-2">
            <div class="form-style-2-heading">주문 정보</div>

            <label for="field2"><span>배송지 선택<span class="required">*</span> </span>
                <input type='radio' name='address_choice' value='new' checked/>신규배송지
                &nbsp;&nbsp;&nbsp;<input type='radio' name='address_choice' value='basic'/>기본배송지(구매자정보)</label>
            <hr>

            <label for="field1"><span>주문하시는 분 <span class="required">*</span></span>
                <input type="text" class="input-field" name="buyer_name" id="buyer_name" value="조제연"/></label>
            <hr>
            <label><span>주소<span class="required">*</span> </span><input type="text" class="input-field"
                                                                         name="buyer_postcode" id="buyer_postcode"
                                                                         style="width:80px; height:26px;"
                                                                         readonly/>
                <button type="button" onclick="openZipSearch()">우편번호 검색</button>
            </label>
            <label><span></span> <input type="text" class="input-field" name="buyer_addr1" id="buyer_addr1"
                                        style="width:300px; height:30px;"
                                        readonly/> </label>
            <label><span></span> <input type="text" class="input-field" name="buyer_addr2" id="buyer_addr2"
                                        style="width:300px; height:30px;"/>
            </label>
            <hr>

            <label><span>일반전화<span class="required">*</span></span><input type="text" class="tel-number-field"
                                                                          name="tel_no_1" value="" maxlength="4"/> -
                <input type="text" class="tel-number-field" name="tel_no_2" value="" maxlength="4"/> - <input
                    type="text" class="tel-number-field" name="tel_no_3" value="" maxlength="10"/></label>
            <label><span>휴대전화<span class="required">*</span></span><input type="text" class="tel-number-field"
                                                                          name="phone_no_1" id="phone_no_1" value="010"
                                                                          maxlength="4"/> -
                <input type="text" class="tel-number-field" name="phone_no_2" id="phone_no_2" value="9488" maxlength="4"/> -
                <input
                    type="text" class="tel-number-field" name="phone_no_3" id="phone_no_3" value="3402" maxlength="10"/></label>
            <hr>
            <label for="field2"><span>Email <span class="required">*</span></span><input type="text" class="input-field"
                                                                                         name="buyer_email"
                                                                                         id="buyer_email"
                                                                                         value="wpdusdlrj97@gmail.com"/></label>
            <hr>
            <label for="field5"><span>배송메시지 </span><textarea name="field5" class="textarea-field"></textarea></label>
            <hr>


        </div>

        <br><br><br>


        <div class="form-style-2">
            <div class="form-style-2-heading">결제 정보</div>

            <div class="info_box">

                <label for="field1"><span>총 주문금액</span><input type="text" class="input-field" name="buy_amount"
                                                              id="buy_amount"
                                                              style="width:10%; height:3%; text-align: end; border:none;"
                                                              value="2,000" readonly/> 원</label>
                <hr>
                <label for="field1"><span>총 할인금액</span><input type="text" class="input-field" name="field1"
                                                              style="width:10%; height:3%; text-align: end; border:none;" value="0"/> 원</label>
                <hr>
                <label for="field1"><span>부가 결제</span><input type="text" class="input-field" name="field1"
                                                             style="width:10%; height:3%; text-align: end; border:none;" value="0"/> 원</label>
                <hr>
                <label for="field1"><span>적립금</span><input type="text" class="input-field" name="field1"
                                                           style="width:10%; height:3%; text-align: end; border:none;"
                                                           value="20"/> 원</label>
                <hr>

                <label for="field1"><span>결제수단 <span class="required">*</span></span>
                    <div id="radioArea">
                        <input type="radio" name="radioName" value="card"/>카드결제
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="radioName" value="trans"/>실시간 계좌이체
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="radioName" value="phone"/>휴대폰 결제
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="radioName" value="none_bank"/>무통장입금
                        &nbsp;&nbsp;&nbsp;<input type="radio" name="radioName" value="vbank"/>가상계좌
                    </div>


                </label>
                <hr>
                <label for="field1">
                    <div id="changeTextArea" style="width: 600px;">
                        <div id="change_card">
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;최소 결제 가능 금액은 결제금액에서 배송비를 제외한 금액입니다.
                            <br><br>
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.
                        </div>
                        <div id="change_trans">
                            예금주명 &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-field" name="trans_buyer_name" id="trans_buyer_name"
                                                                value=""/>
                            <br><br>
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.
                        </div>
                        <div id="change_phone">
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.
                        </div>
                        <div id="change_none_bank">
                            입금자명 - &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="input-field" name="field1"
                                                                  value=""/>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;입금은행 - &nbsp;&nbsp;&nbsp;&nbsp;<select name="none_bank_account" style="height: 3%">
                                <option value="none">---선택해주세요--- </option>
                                <option value="fitme_bank">우리은행:1002893121128 주식회사 FitMe </option>
                            </select>

                            <br><br>
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.
                        </div>
                        <div id="change_vbank">
                            <img src="message.png" alt="My Image" width="15" height="15" style="margin-bottom: 3px;">
                            &nbsp;&nbsp;소액 결제의 경우 PG사 정책에 따라 결제 금액 제한이 있을 수 있습니다.
                        </div>
                    </div>
                </label>
                <hr>


            </div>

            <div class="info_box_30" style="text-align: center; border: 3px black;">


                <div id="changeTextArea_button">
                    <div id="change_card_button">
                        <br>
                        <h5 style="font-weight:bold">카드 결제</h5> <h5>최종 결제 금액</h5>
                        <h3 style="font-weight:bold">2,000원</h3>
                        <br>
                        <button class="button" type="button" style="width: 150px; height: 50px;"
                                onclick="requestPay_card()">결제하기
                        </button>
                        <br>
                    </div>
                    <div id="change_trans_button">
                        <br>
                        <h5 style="font-weight:bold">실시간 계좌이체</h5> <h5>최종 결제 금액</h5>
                        <h3 style="font-weight:bold">2,000원</h3>
                        <br>

                        <button class="button" type="button" style="width: 150px; height: 50px;"
                                onclick="requestPay_trans()">결제하기
                        </button>
                        <br>
                    </div>
                    <div id="change_phone_button">
                        <br>
                        <h5 style="font-weight:bold">휴대폰 결제</h5> <h5>최종 결제 금액</h5>
                        <h3 style="font-weight:bold">2,000원</h3>
                        <br>

                        <button class="button" type="button" style="width: 150px; height: 50px;"
                                onclick="requestPay_phone()">결제하기
                        </button>
                        <br>
                    </div>
                    <div id="change_none_bank_button">
                        <br>
                        <h5 style="font-weight:bold">무통장 입금</h5> <h5>최종 결제 금액</h5>
                        <h3 style="font-weight:bold">2,000원</h3>
                        <br>

                        <button class="button" type="button" style="width: 150px; height: 50px;">결제하기</button>
                        <br>
                    </div>
                    <div id="change_vbank_button">
                        <br>
                        <h5 style="font-weight:bold">가상계좌</h5> <h5>최종 결제 금액</h5>
                        <h3 style="font-weight:bold">2,000원</h3>
                        <br>

                        <button class="button" type="button" style="width: 150px; height: 50px;"
                                onclick="requestPay_vbank()">결제하기
                        </button>
                        <br>
                    </div>
                </div>


                <hr style="height: 1px; background: #000000;">
                <h5 style="font-weight:bold">총 적립 예정 금액 - 2,000원</h5>
                <hr style="height: 1px; background: #000000;">
                <h5>상품별 적립금 - 0원 </h5>
                <br>
                <h5>회원 적립금 - 20원</h5>
                <br>
                <h5>쿠폰 적립금 - 0원</h5>
            </div>

        </div>

    </div>

</div>
<div class="category_center_footer"></div>
<div id="footer"></div>


<!-- 입금 방식-->
<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>
<script>
    var IMP = window.IMP; // 생략해도 괜찮습니다.
    IMP.init("imp41398096"); // "imp00000000" 대신 발급받은 "가맹점 식별코드"를 사용합니다.
</script>

<script>


    // 카드결제
    function requestPay_card() {
        // IMP.request_pay(param, callback) 호출

        // 구매 금액
        var buy_amount_comma = $('#buy_amount').val();
        var buy_amount = buy_amount_comma.replace(",", ""); //변경작업
        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();
        // 구매자 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1.concat("-", phone_no_2, "-", phone_no_3);
        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1.concat(" ", buyer_addr2);
        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();

        IMP.request_pay({
            pg: 'html5_inicis',
            pay_method: 'card',
            merchant_uid: 'merchant_' + new Date().getTime(),
            name: '메모리 MA-1 항공점퍼 - Black, L',
            amount: buy_amount,
            buyer_email: buyer_email,
            buyer_name: buyer_name,
            buyer_tel: buyer_phone,
            buyer_addr: buyer_addr,
            buyer_postcode: buyer_postcode
        }, function (rsp) {
            if (rsp.success) {
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;

                post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})

            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
            }

            /*
            var msg9 = '결제가 완료되었습니다.';
            msg9 += '결제금액 : ' + buy_amount;
            msg9 += '이메일 : ' + buyer_email;
            msg9 += '주문인 : ' + buyer_name;
            msg9 += '전화번호 : ' + buyer_phone;
            msg9 += '주소 : ' + buyer_addr;
            msg9 += '우편번호 : ' + buyer_postcode;
            */

            //alert(msg);

            //post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})
            //alert(msg9);



            // 결제에 성공하면 결제완료 페이지로 이동시킨다
            // POST - 주문번호, 주문일자, 결제 금액, 결제수단,
            //      - 상품이름, 상품컬러, 상품사이즈, 상품 수량, 상품가격
            //      - 이름, 우편번호, 주소, 일반전화, 휴대전화, 배송메시지
            // DB에 저장하고 -> 결제완료 페이지에서 띄워주가


        });
    }

    // 실시간 계좌이체
    function requestPay_trans() {
        // IMP.request_pay(param, callback) 호출

        // 구매 금액
        var buy_amount_comma = $('#buy_amount').val();
        var buy_amount = buy_amount_comma.replace(",", ""); //변경작업
        // 구매자 이름
        var trans_buyer_name = $('#trans_buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();
        // 구매자 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1.concat("-", phone_no_2, "-", phone_no_3);
        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1.concat(" ", buyer_addr2);
        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();


        IMP.request_pay({
            pg: 'html5_inicis',
            pay_method: 'trans',
            merchant_uid: 'merchant_' + new Date().getTime(),
            name: '메모리 MA-1 항공점퍼 - Black, L',
            amount: buy_amount,
            buyer_email: buyer_email,
            buyer_name: trans_buyer_name,
            buyer_tel: buyer_phone,
            buyer_addr: buyer_addr,
            buyer_postcode: buyer_postcode
        }, function (rsp) {
            if (rsp.success) {
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;

                post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
            }

            /*
            var msg9 = '결제가 완료되었습니다.';
            msg9 += '결제금액 : ' + buy_amount;
            msg9 += '이메일 : ' + buyer_email;
            msg9 += '주문인 : ' + buyer_name;
            msg9 += '전화번호 : ' + buyer_phone;
            msg9 += '주소 : ' + buyer_addr;
            msg9 += '우편번호 : ' + buyer_postcode;
            */
            alert(msg);
            //alert(msg9);

        });
    }


    // 실시간 핸드폰 소액결제
    function requestPay_phone() {
        // IMP.request_pay(param, callback) 호출


        // 구매 금액
        var buy_amount_comma = $('#buy_amount').val();
        var buy_amount = buy_amount_comma.replace(",", ""); //변경작업
        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();
        // 구매자 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1.concat("-", phone_no_2, "-", phone_no_3);
        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1.concat(" ", buyer_addr2);
        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();



        IMP.request_pay({
            pg: 'html5_inicis',
            pay_method: 'phone',
            merchant_uid: 'merchant_' + new Date().getTime(),
            name: '메모리 MA-1 항공점퍼 - Black, L',
            amount: buy_amount,
            buyer_email: buyer_email,
            buyer_name: buyer_name,
            buyer_tel: buyer_phone,
            buyer_addr: buyer_addr,
            buyer_postcode: buyer_postcode
        }, function (rsp) {
            if (rsp.success) {
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;

                post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
            }
            /*
            var msg9 = '결제가 완료되었습니다.';
            msg9 += '결제금액 : ' + buy_amount;
            msg9 += '이메일 : ' + buyer_email;
            msg9 += '주문인 : ' + buyer_name;
            msg9 += '전화번호 : ' + buyer_phone;
            msg9 += '주소 : ' + buyer_addr;
            msg9 += '우편번호 : ' + buyer_postcode;
            */

            alert(msg);
            //alert(msg9);
        });
    }

    // 가상계좌
    function requestPay_vbank() {
        // IMP.request_pay(param, callback) 호출



        // 구매 금액
        var buy_amount_comma = $('#buy_amount').val();
        var buy_amount = buy_amount_comma.replace(",", ""); //변경작업
        // 구매자 이름
        var buyer_name = $('#buyer_name').val();
        // 구매자 이메일
        var buyer_email = $('#buyer_email').val();
        // 구매자 전화번호
        var phone_no_1 = $('#phone_no_1').val();
        var phone_no_2 = $('#phone_no_2').val();
        var phone_no_3 = $('#phone_no_3').val();
        var buyer_phone = phone_no_1.concat("-", phone_no_2, "-", phone_no_3);
        // 구매자 주소
        var buyer_addr1 = $('#buyer_addr1').val();
        var buyer_addr2 = $('#buyer_addr2').val();
        var buyer_addr = buyer_addr1.concat(" ", buyer_addr2);
        // 구매자 우편번호
        var buyer_postcode = $('#buyer_postcode').val();



        IMP.request_pay({
            pg: 'html5_inicis',
            pay_method: 'vbank',
            merchant_uid: 'merchant_' + new Date().getTime(),
            name: '메모리 MA-1 항공점퍼 - Black, L',
            amount: buy_amount,
            buyer_email: buyer_email,
            buyer_name: buyer_name,
            buyer_tel: buyer_phone,
            buyer_addr: buyer_addr,
            buyer_postcode: buyer_postcode
        }, function (rsp) {
            if (rsp.success) {
                var msg = '결제가 완료되었습니다.';
                msg += '고유ID : ' + rsp.imp_uid;
                msg += '상점 거래ID : ' + rsp.merchant_uid;
                msg += '결제 금액 : ' + rsp.paid_amount;
                msg += '카드 승인번호 : ' + rsp.apply_num;

                post_to_url('http://49.247.136.36/main/cart/order_finish.php', {'name':'jeyeon','age':'23'})
            } else {
                var msg = '결제에 실패하였습니다.';
                msg += '에러내용 : ' + rsp.error_msg;
            }

            /*
            var msg9 = '결제가 완료되었습니다.';
            msg9 += '결제금액 : ' + buy_amount;
            msg9 += '이메일 : ' + buyer_email;
            msg9 += '주문인 : ' + buyer_name;
            msg9 += '전화번호 : ' + buyer_phone;
            msg9 += '주소 : ' + buyer_addr;
            msg9 += '우편번호 : ' + buyer_postcode;

            alert(msg);

             */
            alert(msg9);
        });
    }

    function post_to_url(path, params, method) {
        method = method || "post"; // Set method to post by default, if not specified.
        // The rest of this code assumes you are not using a library.
        // It can be made less wordy if you use one.
        var form = document.createElement("form");
        form.setAttribute("method", method);
        form.setAttribute("action", path);
        for (var key in params) {
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("type", "hidden");
            hiddenField.setAttribute("name", key);
            hiddenField.setAttribute("value", params[key]);
            form.appendChild(hiddenField);
        }
        document.body.appendChild(form);
        form.submit();
    }

</script>


<script>
    $('#footer').load("http://49.247.136.36/main/foot.php");
</script>
</body>
<script>
    //이전페이지에서 GET 방식으로 넘어온 카테고리를 확인한 뒤 페이지 좌측의 선택 카테고리 리스트에서 겹치는것을 확인한다.
    //만일 카테고리 리스트에서 GET 방식으로 넘어온 카테고리가 겹칠 경우 해당하는 카테고리의 상세 카테고리 목록을 펼쳐준다.
    //펼친 카테고리 목록중에서 GET 방식으로 넘어온 상세 카테고리와의 겹침을 추가로 확인한 뒤
    //상세 카테고리도 겹칠 경우에는 해당하는 텍스트의 굵기를 굵게 표기해준다.
    //만일 상세 카테고리 겹치지 않을 경우에는 ALL(전부 보기) 을 선택한다.
    for (var i = 0; i < $('.categories_contents_text').length; i++) {
        if ($('.categories_contents_text').eq(i).text() == "<?php echo $category_1?>") {
            $('.categories_more').eq(i - 1).css("background-image", "url('http://49.247.136.36//web/icon/collapse.png')");
            $('.categories_contents_detail').eq(i - 1).css("display", "block");
            var category2_true = 0;
            for (var detail_c = 0; detail_c < $('.categories_contents_detail').eq(i - 1).children().length; detail_c++) {
                if ("<?php echo $category_2?>" == $('.categories_contents_detail').eq(i - 1).children().eq(detail_c).text()) {
                    $('.categories_contents_detail').eq(i - 1).children().eq(detail_c).css("font-weight", "bold");
                    category2_true = 1;
                }
                if ((detail_c + 1 == $('.categories_contents_detail').eq(i - 1).children().length) && (category2_true == 0)) {
                    console.log(i);
                    $('.categories_contents_detail').eq(i - 1).children().eq(0).css("font-weight", "bold");
                }
            }
            break;
        }
    }

    //페이지 좌측의 카테고리 리스트중 한가지를 클릭했을 떄의 이벤트
    //이전에 펼쳐진 카테고리는 접어주고 클릭한 카테고리의 상세카테고리 목록을 펼쳐준다.
    $('.categories_contents').click(function () {
        $('.categories_contents_detail').css("display", "none");
        var bool = false;
        if ("url(\"http://49.247.136.36/web/icon/collapse.png\")" == $(this).children().eq(1).css("background-image")) {
            bool = false;
        } else {
            bool = true;
        }
        $('.categories_more').css("background-image", "url('http://49.247.136.36/web/icon/expand.png')");
        if (bool) {
            $(this).children().eq(1).css("background-image", "url('http://49.247.136.36/web/icon/collapse.png')");
        }
        var my_category = $(this).children().eq(0).text();
        for (var i = 0; i < $('.categories_contents_text').length; i++) {
            if ($('.categories_contents_text').eq(i).text() == my_category) {
                if ("url(\"http://49.247.136.36/web/icon/expand.png\")" != $(this).children().eq(1).css("background-image")) {
                    $('.categories_contents_detail').eq(i - 1).css("display", "block");
                }
            }
        }
    });
    window.onload = function () {
        $('.loader-default').remove();
    }
</script>


</html>
