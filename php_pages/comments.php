

<?php


$q = "SELECT `comments` FROM `comments` WHERE `id_post`=" .$id_post;


$r = mysqli_query($c,$q);


$comments = mysqli_fetch_array($r)[0];

$comments = (array) json_decode($comments);

	$style = "  display: inline-block;
    width: 5%;
    height: 5%;
    border-radius: 50%;
    border: 1px solid #111;
    padding: 8px;
    text-align: center;
    transform: translateY(-9px);";
	$txt_comment_push = "<div><textarea placeholder='put comment here!' class=txt_push_comment onkeydown='check_txt(($(this).val()).length, this, event)'></textarea><button onclick='send_comment(this, $id_post)' style='$style' class=btn_send_comment><img src='svg/arrow-right.png' width=100% height=100%></button></div>";
	echo $txt_comment_push;
for ($i = 0; $i < count($comments); $i++){
	$a1 	   = $comments[$i][0]; // $comments [0] -> id , [1] -> comment
	$a1_cmnt   = $a1[1]; // comment
	$a1_nm     = $a1[0]; // id
	$id_user_ = explode(':', $a1_nm);
	$q = "SELECT `img_wall_usetr` FROM `app_user_main` WHERE `id_user`=".$id_user_[1];
	$r = mysqli_query($c, $q);
	$img = mysqli_fetch_array($r)[0];
	$q  = "SELECT `name` FROM `users` WHERE `id_user`=".$id_user_[1];
	$r = mysqli_query($c, $q);

	$user_name_use = mysqli_fetch_array($r)[0];
	$s1 = "
    width: 25px;
    border-radius: 50%;
";
	$s2 = "    position: absolute;
    margin-top: -6px;
    margin-left: 6px;
    color: #ccc;
    border-top: 1px solid #5600ff;";
	$txt_comment = "<div class=comment_display id=Cmnt$i>". 
					"<div class=comnt>".
					"<span class=name_comnent_put>".
						"<img style='$s1' src=\"data:image;base64,$img\" />".
						"<span style='$s2'>$user_name_use</span>".
					"</span>".
					"<span class=commet_put style='margin-left:6px;'>".
						$a1_cmnt.
					"</span>".
					"</div>";
	$a2 	   = $comments[$i][1]; // $replays  -> arrays[0->id,1->replays]
	//var_dump($a2); --> array(1) { [0]=> array(2) { [0]=> string(3) "id2" [1]=> string(11) "Thanks pro." } } 
	//echo count($a2);  --> 1
 	for($ii = 0; $ii < count($a2); $ii++){

 		$end_exits= 1;
	$a2_id     = $a2[$ii][0]; // id
	$a2_replay = $a2[$ii][1]; // replays
	


	$id_user_ = explode(':', $a2_id);
	$q = "SELECT `img_wall_usetr` FROM `app_user_main` WHERE `id_user`=".$id_user_[1];
	$r = mysqli_query($c, $q);
	$img = mysqli_fetch_array($r)[0];
	$q  = "SELECT `name` FROM `users` WHERE `id_user`=".$id_user_[1];
	$r = mysqli_query($c, $q);

	$user_name_use = mysqli_fetch_array($r)[0];



	$txt_comment  .=
					"<div class=replays_comment>".
					
					"<img style='$s1' src=\"data:image;base64,$img\" />".
					"<span style='$s2'> $user_name_use </span>".
					"<span style='margin-left:2px;    word-wrap: break-word;'> $a2_replay </span>".
					"</div>";
	}
	$txt_comment .= "</div><div style='margin-left:48px'>".
	"<textarea placeholder='put comment Reply here!' class=txt_push_comment onkeydown='check_txt(($(this).val()).length, this, event)'></textarea>".
		"<button onclick='send_comment_r(this, $id_post, $i)' style='$style' class=btn_send_comment><img src='svg/arrow-right.png' width=100% height=100%>".
		"</button>".
		"</div>";



echo $txt_comment;

}