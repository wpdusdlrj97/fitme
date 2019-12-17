<!DOCTYPE html>
<html>
<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>



<h1>The onclick Event</h1>

<p>The onclick event is used to trigger a function when an element is clicked on.</p>

<p>Click the button to trigger a function that will output "Hello World" in a p element with id="demo".</p>

<button onclick="post_to_url('http://49.247.136.36/javascript_getpost.php', {'name':'jeyeon','age':'23'})">자바스크립트 POST 전송</button>
<button onclick="ajax_post()">ajax POST 전송</button>

<p id="demo"></p>

<script>
    /*
 * path : 전송 URL
 * params : 전송 데이터 {'q':'a','s':'b','c':'d'...}으로 묶어서 배열 입력
 * method : 전송 방식(생략가능)
 */
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

    function ajax_post() {

        $.ajax({
            type: "POST"
            , url: "http://49.247.136.36/javascript_getpost.php"
            , data: {name: "jeyeon", age: '23'}
            , dataType : "text"
            , success: function (string) {
                if(string=="success"){
                    alert("성공");
                }else{
                    alert("실패");
                }

            }
            , error: function (error) {
                alert(error);
            }
        });
    }

</script>


</body>
</html>

