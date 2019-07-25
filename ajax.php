<?php

session_start();

$c = mysqli_connect('127.0.0.1', 'root', '', 'db1') or die('error to connection');
$req = $_POST['req'];

$last_post_auto_key = 0;
if ($req == "sure_log") {
	if (isset($_SESSION['log'])) {
		if ($_SESSION['log'] == true) {
			$query_last_post = "SELECT `last_id_post` FROM `last_nu_id_inpost` WHERE 1";
			$res_last_post = mysqli_fetch_array(mysqli_query($c, $query_last_post))[0];


			$_SESSION['backcallpost_max'] = $res_last_post; // this important for req = (show post , need more posts) 

			echo "yes";
		} else {
			echo "no";
		}
	} else {
		echo "no";
	}
} elseif ($req == "show_POST") {
	$last_post_auto_key = $_SESSION['backcallpost_max'];

	$q_get_psot = "SELECT * FROM `posts` WHERE `auto_key_time_view` <= '$last_post_auto_key' ORDER BY `auto_key_time_view` DESC LIMIT 4 ";
	$r = mysqli_query($c, $q_get_psot);

	require 'php_pages/post_disegn.php';

	post_design($r);

		//array_pop($arr_posts);
		//print_r(array_keys( $arr_posts));		 

} elseif ($req == "Need_more_POSTS") {

	$last_post_auto_key = $_SESSION['backcallpost_max'];

	$q_get_psot = "SELECT * FROM `posts` WHERE `auto_key_time_view` < '$last_post_auto_key' ORDER BY `auto_key_time_view` DESC LIMIT 4 ";
	$r = mysqli_query($c, $q_get_psot);

	require 'php_pages/post_disegn.php';

	post_design($r);

} elseif ($req == "Get_controller_page_A") {
	$name_user = $_SESSION['who'][0];

	$el = "<div class=user_sys>" .
		"<span onmouseover=Get_controller_page_B(this) onmouseleave=Get_controller_page_B_remove()>" .
		$name_user .
		"</span>" .
		"<form method=post>" .
		"<input name=log_out type=submit value='Log Out'>" .
		"</form>" .
		"</input>" .
		"</div>";
	echo "{$el}";
} elseif ($req == "Get_controller_page_B") {
	$P = $_POST['P'];
	$Top = $P[0] + 45;
	$Left = $P[1] - 25;
	$page = include 'php_pages/Get_controller_page_B.php';
} elseif ($req == "Get_own_POSTS") {
	$id_user = $_SESSION['who'][1];

	$q = "SELECT * FROM `posts` WHERE `id`=$id_user";

	$r = mysqli_query($c, $q);

	$GroupsPOSTS2 = [];


	while ($x = mysqli_fetch_array($r)) {

		$post = "<div >" .
			"name: {$x['name']}" .
			"<br>" .
			"text: {$x['text']}" .
			"<br>" .
			"date : {$x['date']}" .
			"<br>" .
			"<img src={$x['name_image']} width=300 height=300>" .
			"</div>";

		array_push($GroupsPOSTS2, $post);

	}
	$GroupsPOSTS2 = array_reverse($GroupsPOSTS2);

	foreach ($GroupsPOSTS2 as $key => $value) {
		if ($key > 3) {
			array_shift($GroupsPOSTS2);
			array_shift($GroupsPOSTS2);
			array_shift($GroupsPOSTS2);
			array_shift($GroupsPOSTS2);
			$_SESSION['othersPOSTS2'] = $GroupsPOSTS2;
			break;
		} else {
			echo $GroupsPOSTS2[$key];
		}



	}
} elseif ($req == "Need_more_POSTSOwner") {
	foreach ($_SESSION['othersPOSTS2'] as $key1 => $value1) {
		if ($key1 > 3) {
			array_shift($_SESSION['othersPOSTS2']);
			array_shift($_SESSION['othersPOSTS2']);
			array_shift($_SESSION['othersPOSTS2']);
			array_shift($_SESSION['othersPOSTS2']);

			break;
		} else {
			echo $_SESSION['othersPOSTS2'][$key1];

		}



	}
} else if ($req == "change_username") {
	$new_name = $_POST['new_name'];
	if (strlen($new_name) < 18) {


		$qry1 = 'SELECT `name` FROM `users`';
		$r1 = mysqli_query($c, $qry1);
		$yesno = 1;
		while ($sure = mysqli_fetch_array($r1)) {
			if ($sure[0] == $new_name) {
				echo "this name is already exists";
				$yesno = 0;


			}
		}
		if ($yesno == 1) {
			$qry = 'UPDATE `users` SET `name`="' . $new_name . '" WHERE `name`="' . $_SESSION["who"][0] . '"';
			$r = mysqli_query($c, $qry);

			$_SESSION['log'] = false;
			echo "Done Change Your Name ! re";

		}


	}
} else if ($req == "rem_post") {
	$id_post = $_POST['id_post'];
	$qry = "DELETE FROM `posts` WHERE `nu_post`={$id_post}";
	$r = mysqli_query($c, $qry);
	echo "
	Done!";

	$q = "SELECT `del_post_num` FROM `last_nu_id_inpost` WHERE 1";
	$r = mysqli_query($c, $q);

	$num = (int)mysqli_fetch_array($r)[0];
	$num++;

	$q = "UPDATE `last_nu_id_inpost` SET `del_post_num`={$num} WHERE 1";
	$r = mysqli_query($c, $q);





} else if ($req == "Get_comment_and_comments_tools") {
	$id_post = $_POST['comment_post_id'];

	include 'php_pages/comments.php';
} else if ($req == "add_comment") {
	$txt = $_POST['txt'];
	echo $txt;
	$id = $_POST['id_post'];
	$id_pusher = $_SESSION['who'][1];
	$q = "SELECT `comments` FROM `comments` WHERE `id_post`=" . $id;


	$r = mysqli_query($c, $q);


	$comments = mysqli_fetch_array($r)[0];

	$comments = (array)json_decode($comments);
	
	//$code = (array) json_decode("[[\"id:$id_pusher\",\"$txt\"],[]]");
	$code = [["id:" . $id_pusher, $txt], []];
	array_push($comments, $code);
	print_r($code);
	$code = json_encode($comments, JSON_UNESCAPED_UNICODE);
	print_r($code);
	print_r($code[2][1]);
	$q = "UPDATE `comments` SET `comments`='$code' WHERE `id_post`=" . $id;

	$r = mysqli_query($c, $q);

} else if ($req == "put_comment_r") {
	$id_post = $_POST['id_post'];
	$id_comment = $_POST['id_comment'];
	$txt_r = $_POST['$txt_r'];
	if (strlen($txt_r) > 0) {
		$q = "SELECT `comments` FROM `comments` WHERE `id_post`=" . $id_post;

		$r = mysqli_query($c, $q);

		$comments = (array)json_decode(mysqli_fetch_array($r)[0]);

		array_push($comments[$id_comment][1], ["id:" . $_SESSION['who'][1], $txt_r]);

		$n_comments = json_encode($comments, JSON_UNESCAPED_UNICODE);

		$q = "UPDATE `comments` SET `comments`='$n_comments' WHERE `id_post`=" . $id_post;
		$r = mysqli_query($c, $q);
		echo "Cool all work : $q";
	} else echo "not found reply text.";

}

//[[id, txt],[]]

else if ($req == 'offline' || $req == "online" || $req == "get_onlines" || $req == "get_info_about_id") {
	include 'php_pages/line.php';
} else if ($req == "Chating_online") {
	$id = $_POST['id_use'];

	$q = "SELECT * FROM `socket_hashing` WHERE `id`=" . $id;
	$id = mysqli_fetch_array(mysqli_query($c, $q))[1];



	file_get_contents('http://localhost:8888/req?user=admin&pass=123555&req=Add_me_in_chat&to=' . $id . '&from=' . $_SESSION['who'][0] . "&id=" . $_SESSION['who'][1]);
} else if ($req == "check_have_chat") {
	$id = $_POST['id'];

	$q = "SELECT * FROM `chating` WHERE `from`=" . $id . ' AND `to`=' . $_SESSION['who'][1] . ' OR `from`=' . $_SESSION['who'][1] . ' AND`to`= ' . $id;
	$r = mysqli_query($c, $q);
	$r = mysqli_fetch_array($r);
	if ($r) {
		echo "0";
	} else echo "1";



} else if ($req == "accept_msg") {

	$id = $_POST['id'];

	$q = "SELECT * FROM `socket_hashing` WHERE `id`=" . $id;

	$hash = mysqli_fetch_array(mysqli_query($c, $q))[1]; // hash
	$q = "INSERT INTO `chating`(`from`, `to`, `chat`, `block`) VALUES (" . $id . "," . $_SESSION['who'][1] . ",'[]',0)";
	$r = mysqli_query($c, $q);
	file_get_contents('http://localhost:8888/req?user=admin&pass=123555&req=accept_chating&from=' . $_SESSION['who'][0] . "&to=" . $hash);
} else if ($req == "add_interest" || $req == "remove_interest") {
	include 'php_pages/interesting_post.php';
} else if ($req == "follow_it") {


	function update($arr_f, $id, $nu_f)
	{

		$c = mysqli_connect('127.0.0.1', 'root', '', 'db1') or die('error to connection');


		$arr_f[] = $_SESSION['who'][1];

		$arr_f = json_encode($arr_f);

		$q = "UPDATE`app_user_main` SET `nu_follows`='$nu_f',`arr_followers`='$arr_f' WHERE  `id_user`=" . $id;

		$r = mysqli_query($c, $q);

		if ($r) echo 'Done!';
	}

	$id = $_POST['id'];



	$q = "SELECT `nu_follows`, `arr_followers` FROM `app_user_main` WHERE `id_user`=" . $id;


	$r = mysqli_query($c, $q);

	$r = mysqli_fetch_array($r);

	$nu_f = +$r[0] + 1;

	$arr_f = (array)json_decode($r[1]);



	if (empty($arr_f)) {
		$q_ = "UPDATE `app_user_main` SET `arr_followers`='[]' WHERE `id_user`=" . $id;
		mysqli_query($c, $q_);
		update($arr_f, $id, $nu_f);
	} else {
		$try_up = 1;
		foreach ($arr_f as $v) {
			if ($v == $_SESSION['who'][1]) $try_up = 0;

		}



		if ($try_up == 1) {
			update($arr_f, $id, $nu_f);
		}




	}



} else if ($req == "check_have_profile_at_used") {
	include 'php_pages/user_profiles_ajax.php';
} else if ($req == "need_info") {
	include 'php_pages/need_info.php';
} else if ($req == "test_") {
	$data = $_POST['data'];
	echo $data;
} else if ($req == "set_new_post") {
	include 'php_pages/set_post.php';
} else if ($req == "set_new_hash_code_for_uploading_file") {

	$new_s = "new_hash_hash" . rand(50000, 999999);

	$id = $_SESSION['who'][1];
	$name = $_SESSION['who'][0];
	$x = file_get_contents(
		'http://localhost:8080/req?user=admin&pass=123555&req=set_hash&id=' . $id . "&name=" . $name . '&hash=' . $new_s
	);
	echo $new_s;
} else if ($req == "live_rooms") {
	include 'php_pages/live_rooms.php';
}