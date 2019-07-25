
<?php 
			$q2  = 'SELECT * FROM `likers` WHERE `id_post`='.$x['nu_post'].' AND `id_intersted`='.$_SESSION['who'][1].'';
			$r2 = mysqli_query($c,$q2);
			if (mysqli_fetch_array($r2)[2] == $_SESSION['who'][0]) $INTEREST_ORNOT = "class=interested"; else $INTEREST_ORNOT="";
			$q3 = "SELECT * FROM `likers` WHERE `id_post`='".$x['nu_post']."'";
			$r3 = mysqli_query($c,$q3);
			$nu_interest_post = 0;
			while ($L=mysqli_fetch_array($r3)) {
				++$nu_interest_post;
			}
			if ($nu_interest_post == 0) $nu_interest_post= ""; else $nu_interest_post = $nu_interest_post . " | ";
			if ($x['name'] == $_SESSION['who'][0]) $sttingExist = "<button id=stting_post>...</button>"; else $sttingExist = "";
			if ($x['name_image'] == '') $dispaly = "style=\"display:none\""; else $dispaly = "style=\"display:auto\"";
$post = "<div class=post_css>$sttingExist".
 	 "<span class='UserName_IN_POST'>{$x['name']}<br><span class='DATE_IN_POST'>{$x['date']}</span></span>".
	 "<span class='TEXT_IN_POST'>{$x['text']}</span>".
	 "<img src=data:image;base64,{$x['name_image']} {$dispaly} width=100% height=300>".
	 "<button onclick=interest('{$x["nu_post"]}',this) {$INTEREST_ORNOT} id=btn_interest>{$nu_interest_post}interest</button>".
	 "<textarea type=text id=comment_push{$x['nu_post']}></textarea>".
	 "<script>$('#comment_push{$x['nu_post']}').on('keypress',function(e){". 
	 "if (e.key == 'Enter')comment_it_now('{$x['nu_post']}',$(this).val())".
	 "})</script>".
	 "</div>";



	 ?>