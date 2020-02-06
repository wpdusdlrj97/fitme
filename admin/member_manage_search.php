<?php


/*
 *  url 흐름 - member_manage.php -> member_manage_search.php -> member_manage.php로 리다이렉트
 *
 * 이 페이지는 회원 정보 조회를 하는 페이지이다
 * 받은 값들을 토대로 query를 완성해 그 해당 쿼리를 세션에 저장하고
 * member_manage.php에서 해당 쿼리를 불러온다
 *
 */


session_start(); //세션을 유지한다.

$con = mysqli_connect('localhost','FunIdeaDBUser','*TeamNova2019*','FitMe'); //DB에 연결한다.
mysqli_set_charset($con,'utf8'); //문자셋을 지정한다.

// FitMe 관리자 이메일
$email = $_SESSION['email']; //현재 유지되고 있는 세션 변수에서 이메일을 가지고 온다.

$member_id =  $_POST['member_id'];
$member_level = $_POST['member_level'];
$member_sex = $_POST['member_sex'];
$member_age1 = $_POST['member_age1'];
$member_age2 = $_POST['member_age2'];
$member_phone = $_POST['member_phone'];
$member_advertise = $_POST['member_advertise'];

if($member_id!=''){ //아이디로 조회했을 경우 값은 하나

    $query = "SELECT * FROM user_information where email='$member_id'";

    //해당 쿼리를 세션쿼리로 저장한다
    $_SESSION['query'] = $query;
    //그 다음에 member_manage.php로 이동시킨다
    echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


}else{ //아이디로 조회하지 않았을 경우 핸드폰 번호로 조회했는지 확인

    if($member_phone!=''){ //핸드폰번호로 조회했을 경우에도 값은 하나

        $query = "SELECT * FROM user_information where phone='$member_phone'";
        //해당 쿼리를 세션쿼리로 저장한다
        $_SESSION['query'] = $query;
        //그 다음에 member_manage.php로 이동시킨다
        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

    }else{ //아이디와 폰번호로 조회하지 않았을 경우 경우의 수는 늘어난다

        // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)

        if($member_level=='0'){ // 일반회원으로 검색했을 경우


            // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
            // 2. 성별 - 남자(man), 여자(woman)

            if($member_sex=='man'){ // 일반회원이고 성별 남자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 일반회원이고 성별이 남자이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }




                }else{ // 일반회원이고 성별이 남자이고 나이를 입력하지 않았을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }




                }



            }elseif($member_sex=='woman'){ // 일반회원이고 성별 여자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 일반회원이고 성별이 여자이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }




                }else{ // 일반회원이고 성별이 여자이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }

            }else{// 일반 회원이고 성별 전체검색 시

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 일반회원이고 성별이 전체검색이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }





                }else{ // 일반회원이고 성별이 전체검색이고 나이를 입력하지 않았을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 일반회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 일반회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 일반회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }

            }



        }elseif($member_level=='1'){ // 쇼핑몰로 검색했을 경우


            // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
            // 2. 성별 - 남자(man), 여자(woman)

            if($member_sex=='man'){ // 쇼핑몰회원이고 성별 남자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }else{ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰회원이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }

            }elseif($member_sex=='woman'){ // 쇼핑몰회원이고 성별 여자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }else{ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰회원이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }


            }else{// 쇼핑몰 회원이고 성별 전체검색 시

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }else{ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 쇼핑몰 회원이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }


                }

            }



        }elseif($member_level=='2'){ // FitMe 관리자로 검색했을 경우


            // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
            // 2. 성별 - 남자(man), 여자(woman)

            if($member_sex=='man'){ // FitMe 관리자이고 성별 남자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // FitMe 관리자이고 성별이 남자이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 남자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 남자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 남자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }else{ // FitMe 관리자이고 성별이 남자이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }




                }

            }elseif($member_sex=='woman'){ // FitMe 관리자이고 성별 여자일때

                if($member_age1!="" and $member_age2!=""){ // FitMe 관리자이고 성별이 여자이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 여자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 여자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 여자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }

                }else{ // FitMe 관리자이고 성별이 여자이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }

            }else{// FitMe 관리자이고 성별 전체검색 시

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력했을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }


                }else{ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // FitMe 관리자이고 성별이 전체검색이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where level='$member_level'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }

            }


        }else{ // 회원 등급을 전체로 검색했을 경우 성별로 넘어간다

            // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
            // 2. 성별 - 남자(man), 여자(woman)

            if($member_sex=='man'){ // 회원등급이 전체이고 성별 남자일때


                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 회원등급이 전체이고 성별이 남자이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별이 남자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별이 남자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 회원등급이 전체이고 성별이 남자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }



                }else{ // 회원등급이 전체이고 성별이 남자이고 나이를 입력하지 않았을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 회원등급이 전체이고 성별이 남자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }



                }



            }elseif($member_sex=='woman'){ // 회원등급이 전체이고 성별 여자일때

                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 회원등급이 전체이고 성별 여자이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별이 여자이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별이 여자이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 회원등급이 전체이고 성별이 여자이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }




                }else{ // 회원등급이 전체이고 성별 여자이고 나이를 입력하지 않았을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 회원등급이 전체이고 성별이 여자이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where sex='$member_sex'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }

            }else{// 회원등급이 전체이고 성별 전체검색 시


                // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                // 2. 성별 - 남자(man), 여자(woman)
                // 3. 나이

                if($member_age1!="" and $member_age2!=""){ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력했을 경우


                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력했고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where age >='$member_age1' and age<='$member_age2' and push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력했고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where age >='$member_age1' and age<='$member_age2' and push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }else{ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력했고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information where age >='$member_age1' and age<='$member_age2'";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }



                }else{ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력하지 않았을 경우

                    // 1. 회원등급 - 일반(0), 쇼핑몰(1), FitMe 관리자(2)
                    // 2. 성별 - 남자(man), 여자(woman)
                    // 3. 나이
                    // 4. 광고 수신 여부 - 예(yes), 아니요(no)

                    if($member_advertise=="yes"){ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력하지 않았고 광고 수신여부 동의했을 경우

                        $query = "SELECT * FROM user_information where push_consent=1";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }elseif($member_advertise=="no"){ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력하지 않았고 광고 수신여부 거부했을 경우

                        $query = "SELECT * FROM user_information where push_consent=0";
                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';


                    }else{ // 회원등급이 전체이고 성별 전체검색이고 나이를 입력하지 않았고 광고 수신여부 전체 검색했을 경우

                        $query = "SELECT * FROM user_information";

                        //해당 쿼리를 세션쿼리로 저장한다
                        $_SESSION['query'] = $query;
                        //그 다음에 member_manage.php로 이동시킨다
                        echo '<script>location.href=\'http://49.247.136.36/admin/member_manage.php\'</script>';

                    }
                }



            }

        }



    }

}








?>