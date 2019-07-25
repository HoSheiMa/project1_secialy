<?php

$id = $_SESSION['who'][1]; // id


$name = $_SESSION['who'][0]; // name 


$q = "SELECT `img_wall_usetr`FROM `app_user_main` WHERE `id_user`=". $id;


$img = mysqli_fetch_array(mysqli_query($c, $q))[0];


echo "[ \"$id\", \"$name\" , \"$img\" ]";