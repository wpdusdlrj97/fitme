<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script type="text/javascript">

    $(document).ready(function(){

        // 입력란에 입력을 하면 입력내용에 내용이 출력

        // 1. #data 공간에서 keyup이라는 이벤트가 발생했을 때

        $("#data").keyup(function(){

            // 2. #out 공간에 #data의 내용이 출력된다.

            $("#out").text($("#data").val());

            // #out의 위치에 text로 데이터를 받는다.(setter)

            // 들어가는 데이터는 #data의 값(.val())이다. (getter)

            // 메서드 괄호 안에 아무것도 없으면 getter, 파라미터가 있으면 setter이다.

        });

    });

</script>





<!-- 바디 부분 -->

<body>



<form>

    키보드로 입력한 내용이 아래에 출력(입력값을 가져와서 입력내용에 전달한다.)<br/>

    입력 : <input id="data"><br/>

    입력 내용:<div id="out">출력되는 곳</div>

</form>



</body>