<?php 
if ($req == "sure_log") {
	if (isset($_SESSION['log'])) {
		if ($_SESSION['log'] == true) {
			$_SESSION['backcallpost_max'] = 0; // this important for req = (show post , need more posts) 
			$_SESSION['backcallpost_min'] = 3;
			echo "yes";
		} else {
			echo "no";
		}
	} else {
		echo "no";
	}
} elseif ($req == "show_POST" || $req =="Need_more_POSTS") {


	
	$arr_posts = [];

	$q0 = "SELECT `numbre` FROM `last_nu_id_inpost` WHERE 1";
	$r0 = mysqli_query($c,$q0);
	$max_numbre  = mysqli_fetch_array($r0)[0] + 1;
	$q0 = "SELECT `del_post_num` FROM `last_nu_id_inpost` WHERE 1";
	$r0 = mysqli_query($c,$q0);
	$max_del = mysqli_fetch_array($r0)[0];
	$mix_numbre_real  = $max_numbre - $_SESSION['backcallpost_max'];
	$min_numbre_real  = $max_numbre - $_SESSION['backcallpost_min'];
	$q =" SELECT * FROM `posts` WHERE `nu_post`>=$min_numbre_real AND `nu_post`<={$mix_numbre_real}";
	$r=  mysqli_query($c,$q);

	$rows = $r->num_rows;
	while (true) {
		if ($rows < 4) {
			$need_rows = 4;

			$rows_exist = $rows;


			$need_to_show = $need_rows - $rows_exist;
			
			if ($min_numbre_real > 0) {
				$min_numbre_real = $min_numbre_real - $need_to_show;
			} else {
				break;
			}
			$q =" SELECT * FROM `posts` WHERE `nu_post`>=$min_numbre_real AND `nu_post`<=$mix_numbre_real";
			$r=  mysqli_query($c,$q);
			//echo "$q<br>";
			$rows = $r->num_rows;
			$_SESSION['backcallpost_max']  = $max_numbre - $mix_numbre_real + $max_del;
			//echo "Done!";

		} else {
			break;	
		} 
		






	}

	$nu_of_imgs = 0;
 function img_filter_($img )
			{
				$nu_of_imgs = 0;
				$img = explode('media_iploaded,', $img);
				

				$l = sizeof($img);
				$index_imgs = '';
				for ( $i= 0; $i < $l; $i++) {

					$len =  (+strlen($img[$i]) - 1);
					if ($len == -1) continue;
					if ($img[$i][$len] == ",") {
						$img[$i] = substr($img[$i], 0, -1);
					}
					$t = "<img src=$img[$i] width=100% height=500 >";
					$index_imgs .= $t;
					$nu_of_imgs++;
				}
				return $index_imgs;
				
			}	

	while ($x = mysqli_fetch_array($r)) {
			$Q4 = "SELECT `name` FROM `users` WHERE `id_user`='".$x['id']."'";
			$r4 = mysqli_query($c, $Q4);
			$name_use = mysqli_fetch_array($r4);
			$name_use = $name_use[0]; // to get name
			

			//$q2  = 'SELECT * FROM `likers` WHERE `id_post`='.$x['nu_post'].' AND `id_intersted`='.$_SESSION['who'][1].'';
			//$r2 = mysqli_query($c,$q2);


			//$ifnot = mysqli_fetch_array($r2);

			//$name_intersted_inpost = $ifnot[2];



			//if ($name_intersted_inpost)$INTEREST_ORNOT = "class=interested style='color:#3367d6'"; else $INTEREST_ORNOT="";

			//if ($name_use == $_SESSION['who'][0]) $INTEREST_ORNOT = "class=interested style='color:#079'"; else $INTEREST_ORNOT="";



			//if ($nu_interest_post == 0) $nu_interest_post= ""; else $nu_interest_post = $nu_interest_post . " | ";
			if ($name_use == $_SESSION['who'][0]) 
				$sttingExist = "<button id=stting_post class=stting_post onclick=open_opt('{$x["nu_post"]}',$(this).parent(),this)>...</button>"; else $sttingExist = ""; // know if he is haver this post or
			if ($x['name_image'] == '%this.null%') $dispaly = "class=\"display_none\""; else $dispaly = "class=\"display_show\""; // if post not have img
			
			

			$x['name_image'] = img_filter_($x['name_image']);
			
			if ($x['text'] == "%this.null%") $d_text = "Text_disapper"; else $d_text = "";
			

			$qry_GEETPicture = "SELECT * FROM `app_user_main` WHERE `id_user`='{$x['id']}'";
			$r_GEETPicture = mysqli_query($c,$qry_GEETPicture);



$ql = "SELECT `id_intersted_array` FROM `likers` WHERE `id_post`=". $x['nu_post'];

	$rl = mysqli_query($c, $ql);

	$array_likes = mysqli_fetch_array($rl)[0];

	$array_likes = (array) json_decode($array_likes);


	$found = 0;
	$type__ = ""; // default
	$interest_C = ""; // default
	$img_n = "imgs_feels_post/1.png"; // default
	$style_css_is_interest = "style='border-raduis:50%;'"; //default
	for ($i = 0; $i < count($array_likes); $i++) {
		$n_array = $array_likes[$i];
		// 0 id
		// 1 type

		if ($n_array[0] == $_SESSION['who'][1]) {
			$found = 1;
			$type__ = $n_array[1] - 1;
				
		}
	}	

	if ($found == 1){

		$img_n = "imgs_feels_post/". $type__ . ".png";

		$interest_C = "class='interested'";

		$style_css_is_interest = "class = 'interested_img'";


	}

$nu_feels = 0; 
$html_feels = "";
$arr_icon_used  = [];
$ql2 = "SELECT `id_intersted_array` FROM `likers` WHERE `id_post`=". $x['nu_post'];

	$rl2 = mysqli_query($c, $ql);

	$array_likes = mysqli_fetch_array($rl2)[0];

	$array_likes = (array) json_decode($array_likes);

foreach ($array_likes as $value) {
	$nu_feels++;
	$nu_name = $value[1] - 1;
	if (!in_array($nu_name, $arr_icon_used)) {
		$arr_icon_used[] = $nu_name;
		$img_n = "imgs_feels_post/". ($nu_name) . ".png";
	$html_feels .= "<img src=". $img_n." width=20 style='border-radius:50%;'>";
	}
}
$div_scroll = '';
$end_div_scroll = '';	
if ($nu_of_imgs != 1) {
	$div_scroll = "<div $dispaly>".
		"	<button onmouseover ='Up($(this).next())'>^</button>".
		
		'<div class=post_imgs>';
	$end_div_scroll = '</div>'.
	 	"<button onmouseover ='Down($(this).prev())'>More</button>".
	 	'</div>';
}
if ($nu_feels != 0) {
	
$html_feels .= "<span style='color:white;'>$nu_feels</span>";

}
$x['text'] = base64_decode($x['text']); // this for decode this text from base64 to normal text!



			$img_own_post = mysqli_fetch_array($r_GEETPicture)[2]; // post owner photo
$post = "<div class=post_css>$sttingExist".

			$div_scroll .
			 $x['name_image']. // imgs
	 		 $end_div_scroll.
 	 "<div>".
 	 "<img class=display_show_profile_owner_post src=data:image;base64,{$img_own_post}>  ".
 	 "<span class='UserName_IN_POST'>{$name_use}<br><span class='DATE_IN_POST'>{$x['date']}</span></span>".
 	 "</div>".

 	 	 	 "<div class='TEXT_IN_POST ".$d_text."'>".$x['text']."</div>".
	 	"<div style='text-align:left'> {$html_feels} </div>".

	 "<div style='text-align:left;'><button {$interest_C} onmouseover='hover_more_interest(\"{$x["nu_post"]}\",this)' onclick=interest('{$x["nu_post"]}',this,2) id=btn_interest>


	 <img {$style_css_is_interest} src='".$img_n."' width=40 class='feel_on_post feel_on_post_2'> 

	 </button></div>".
	 

	 " <button onclick='comment_push({$x['nu_post']}, this)'	 id=POST{$x['nu_post']}><img src=\"imgs_feels_post/7.png\" class='feel_on_post feel_on_post_2'> </button> ".
	 

	 "</div>";


			 array_push($arr_posts, $post);

	}
		for ($i=4; $i >= 0; $i--) { 
			if (isset($arr_posts[$i])) {
				echo $arr_posts[$i];
				array_pop($arr_posts);
				//if ($i != 0) {
					++$_SESSION['backcallpost_max'];
					++$_SESSION['backcallpost_min'];
				//}


			}	

		}

		//array_pop($arr_posts);
		//print_r(array_keys( $arr_posts));		 

} 

?>