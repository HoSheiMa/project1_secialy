<?php


if ($req == 'offline') {
 	$q = 'SELECT * FROM `line` WHERE 1';
 	$r = mysqli_query($c, $q);
 	while ($id= mysqli_fetch_array($r)) {
 		$own_id = (int) $_SESSION['who'][1];
 		if ($id[0] == $own_id) {
 			$q = "DELETE FROM `line` WHERE `online_id`= {$own_id}";
 			$r = mysqli_query($c, $q);
 			echo "you now offline";
 			break;
 		} else continue;
 	}

 	 }

 else if ($req=="online") {
 	$is_exist = 0;
	$q = 'SELECT * FROM `line` WHERE 1';
	 	$r = mysqli_query($c, $q);
	 	while ($id= mysqli_fetch_array($r)) {
	 		$own_id = (int) $_SESSION['who'][1];
	 		if ($id[0] == $own_id) {
	 			$is_exist = 1;
	 			break;
	 		} else $is_exist = 0;

	 	}
	 	if (!$is_exist) {
	 		$own_id = (int) $_SESSION['who'][1];
	 		$q = "INSERT INTO `line`(`online_id`) VALUES (".$own_id.")";
	 		mysqli_query($c, $q);
	 	}
	 }
else if ($req == "get_onlines") {
		$own_id = (int) $_SESSION['who'][1];
		$q = "SELECT * FROM `line` WHERE 1";
		$r = mysqli_query($c, $q);
		$arr_online = "";
		while ($id = mysqli_fetch_array($r)) {
			$id = $id[0];
			if ($id != $own_id) $arr_online .= ",$id";
		}
		echo $arr_online;
 	  }
else if ($req == "get_info_about_id") {
	$q = "SELECT * FROM `users` WHERE `id_user`=".$_POST['id_u'];
	$r = mysqli_query($c, $q);
	$d_arr = "";
	while ($data = mysqli_fetch_array($r)) {
		$d_arr .= $data[0] . ",";

	}
	$q = "SELECT * FROM `app_user_main` WHERE `id_user`=".$_POST['id_u'];
	$r =mysqli_query($c, $q);
	$data = mysqli_fetch_array($r);
	$d_arr .= $data[2];
	$d_arr .= "," . $_POST['id_u'];
	$d_arr .= "," . $data[3];
	


	echo $d_arr;
}