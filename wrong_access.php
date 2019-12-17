<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=euc-kr" />
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <title>FITME</title>
</head>
<body>
</body>
<script>
    swal({
        title: "잘못된 접근",
        text: "접근할 수 없는 페이지 입니다.",
        icon: "warning",
        button: "뒤로가기",
        dangerMode: true,
    })
        .then((willDelete) => {
        location.href="http://49.247.136.36/main/main.php";
    });
</script>