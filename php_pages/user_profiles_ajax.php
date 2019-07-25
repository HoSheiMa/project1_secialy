


<?php
if (!session_start()) session_start();
$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');

$req = $_POST['req'];


function Get_have_own_profile_or_not($id)
{
	
	$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');

	$qry = "SELECT `id_user` FROM `app_user_main` WHERE `id_user`=".$id;

	$r = mysqli_query($c,$qry);


	if (mysqli_fetch_array($r)[0]) {
		return 1;
	} else return 0 ; // for no data ;

}


function Create_own_profile($id,$intersted,$img,$follows) 
{
	$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');


	$qry = "INSERT INTO `app_user_main`(`id_user`, `interest_in`, `img_wall_usetr`, `nu_follows`, `arr_followers`) VALUES ('{$id}','{$intersted}','{$img}','{$follows}', '[]')";

	echo "$img";
	$r = mysqli_query($c,$qry);

	return true;


	
}

function Get_his_profile($id)
{
	$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');

	$qry = "SELECT * FROM `app_user_main` WHERE `id_user`='{$id}'";

	$r = mysqli_query($c,$qry);


	while ($get_r = mysqli_fetch_array($r)) {
		return [
			$get_r['id_user'],
			$get_r['interest_in'],
			$get_r['img_wall_usetr'],
			$get_r['nu_follows']
		];
	}
}

function get_nu_id($id)
{
	$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');

	$qry = "SELECT `name`FROM `users` WHERE `id_user`='{$id}'";

	$r = mysqli_query($c,$qry);
	while ($get_r = mysqli_fetch_array($r)) {
		return $get_r[0];
	}
}
if ($req == "get_my_profile") {



	$id = $_SESSION['who'][1];



	$hav = Get_have_own_profile_or_not($id);



	$img = "user_anon.PNG";

	$img = file_get_contents($img, FILE_USE_INCLUDE_PATH);

	$img = base64_encode($img);


	 if ($hav == 0 ) {
	 	$create = Create_own_profile(
	 		$id,
	 		'#All',
	 		$img,
	 		'0'
	 	);


	 } else $create = true;


	 if ($create) {


	 	$info = Get_his_profile($id);

	 	// 0 id_user
	 	// 1 interest_in
	 	// 2 img_wall
	 	// 3 numbre follors


	 	$name = get_nu_id($info[0]);


	 	$profile = "<div><div class=tag_info_user>User info</div><br>".
	 				"<div>".

	 				"<img src=\"svg/change-user-male.png\" data-img='0'>".
	 				"<img src=data:image;base64,{$info[2]} data-img='1' updating_new_progile_image()>".


					"</div>".

	 				"<br>".
	 				"<div class=user_info>".
	 				"<div><span class=tag_info_for_data>NAME<button class=change_my_profile_name onclick=change_username(1)>Change_NAME</button></span><span class=info_for_data>{$name}</span></div>".
	 				"<div><span class=tag_info_for_data>FOLLOWS </span><span class=info_for_data>{$info[3]}</span></div>".
	 				"</div>".
	 				"<button class=btn_use_for_close onclick=close_info()>Close!</button></div>";
	 	echo $profile;

	 }
} else if($req == "check_have_profile_at_used") {
	$id = $_SESSION['who'][1];



	$hav = Get_have_own_profile_or_not($id);



	$img ="user_anon.PNG";

	$img = file_get_contents($img, FILE_USE_INCLUDE_PATH);

	$img = base64_encode($img);


	 if ($hav == 0 ) {
	 	$create = Create_own_profile(
	 		$id,
	 		'#All',
	 		$img,
	 		'0'
	 	);


	 } else $create = true;
}



?>