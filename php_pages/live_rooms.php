
<?php

$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');

$q = "SELECT * FROM `room_live` WHERE 1";


$r = mysqli_query($c, $q); 
$arr = [];
while ($r1 = mysqli_fetch_array($r)) {
    	
    	$id_room = $r1[0];
    	
    	$id = $r1[1];

    	$txt = $r1[2];

    	$img_l = $r1[3];

    	
    	$q1 = "SELECT `name` FROM `users` WHERE `id_user`=". $id;
    	$name = mysqli_fetch_array(mysqli_query($c, $q1))[0];
    	
    	$q2 =  "SELECT  `img_wall_usetr` FROM `app_user_main` WHERE `id_user`=". $id;
    	$img = mysqli_fetch_array(mysqli_query($c, $q2))[0];
    	array_push($arr, ["$name","$id_room","$img", "$txt", "$img_l"]);


}
print_r(json_encode($arr));
