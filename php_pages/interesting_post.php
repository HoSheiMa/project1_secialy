<?php 





if ($req == "add_interest") {



	$id_post = $_POST['id_post'];
	$type = $_POST['type'];


	$q = "SELECT `id_intersted_array` FROM `likers` WHERE `id_post`=". $id_post;

	$r = mysqli_query($c, $q);

	$array_likes = mysqli_fetch_array($r)[0];

	$array_likes = (array) json_decode($array_likes);


	$found = 1;
	for ($i = 0; $i < count($array_likes); $i++) {
		$n_array = $array_likes[$i];
		// 0 id
		// 1 type

		if ($n_array[0] == $_SESSION['who'][1]) {
			$found = 0;

			// type post for change feel 
			$array_likes[$i][1] = $type;

			$n_arr = json_encode($array_likes);
			
			print_r($n_arr);
			
			$q = "UPDATE `likers` SET `id_intersted_array`='".$n_arr."' WHERE `id_post`=".$id_post;
			
			$r= mysqli_query($c, $q);

			break;

		
	}


	}


	if ($found == 1) {
		$n_arr = array_push($array_likes, [$_SESSION['who'][1], $type]);
		$n_arr = json_encode($array_likes);
			$q = "UPDATE `likers` SET `id_intersted_array`='".$n_arr."' WHERE `id_post`=".$id_post;
			$r = mysqli_query($c, $q);
			var_dump( $n_arr );
	}


} else if($req == "remove_interest"){
	$id_post = $_POST['id_post'];

	$q = "SELECT `id_intersted_array` FROM `likers` WHERE `id_post`=". $id_post;

	$r = mysqli_query($c, $q);

	$array_likes = mysqli_fetch_array($r)[0];

	$array_likes = (array) json_decode($array_likes);

	for ($i = 0; $i < count($array_likes); $i++) {
		$n_array = $array_likes[$i];
		// 0 id
		// 1 type

		if ($n_array[0] == $_SESSION['who'][1]) {

			// type post for remove feel 
			
			unset($array_likes[$i]);
			$n_arr = json_encode($array_likes);
			$q = "UPDATE `likers` SET `id_intersted_array`='".$n_arr."' WHERE `id_post`=".$id_post;
			$r= mysqli_query($c, $q);

		
		}
		var_dump( $n_arr );


	}


}