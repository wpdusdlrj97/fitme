<?php

$uploade_dir = './write_image';

$name = $_FILES['myfile']['name'];
$ext = array_pop(explode('.',$name));

move_uploaded_file($_FILES['myfile']['tmp_name'],"$uploade_dir/$name");
?>
