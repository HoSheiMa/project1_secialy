<!--  2018/6/23 copyriht  -->
<!DOCTYPE html>
<?php session_start();
$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');
if (!isset($_SESSION['log']))  {
	$_SESSION['log'] = false;
	$_SESSION['who'] = []; 
}


if (isset($_POST['log_out'])) {
		$_SESSION['log'] = false;
		$_SESSION['who'] = []; //?//
	}

				?>
<html>
<head>
	<title>imger</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">




    <!-- Compiled and minified JavaScript -->


	<link rel="stylesheet" type="text/css" href="stylesheet/scripts.css">
	<link rel="stylesheet" type="text/css" href="stylesheet/ico.css">

	<link rel="stylesheet" type="text/css" href="stylesheet/index.css">

	     <link rel="stylesheet" type="text/css" href="stylesheet/media.css">
	     <link rel="stylesheet" type="text/css" href="lib/animate.min.css">
</head>
<body onunload="javascript:alert('heekko')">
<div class="toolbar">
	<div class="logo">imger</div>
</div>


	<div class="page1 container" style="display: none;">

		<div class="pages" >
					<div class="main_user_set">
				<br>
					<div class="txt_main" style="display: inline-block;">
						<h1>THE BIGEST ARABICE SOCIAL WEBSITE</h1>
						<h2>online social media and social networking service</h2>

					</div>


					<div class="logen_set " style="display: inline-block;">
						<form accept="" method="POST" id="login_web">


							<input 
							type="txt" 
							name="user" 
							placeholder="username" 
							required 
							autocomplete="false" 
							onautocomplete="return false">
							<div class=type_txt_input_ico></div>
							<input 
							type="password" 
							name="pass" 
							placeholder="password" 
							required 
							autocomplete="false" 
							onautocomplete="return false">
							<div class=type_password_input_ico></div>
							<input 
							type="submit" 
							name="log"  
							value="Log In" 
							id="">
							<div class="SingUp">
							<span>
								Sing Up
							</span>
</div>

							

<?php
		// log in system
				if (isset($_POST['log'])) {
					$user = $_POST['user'];
					$pass = $_POST['pass'];

					$q =" SELECT `name`, `user`, `pass`, `id_user` FROM `users` WHERE 1";
					$r=  mysqli_query($c,$q);
						

					while ($x = mysqli_fetch_array($r)) {
						if ($user == $x['user'] && $pass == $x['pass']) {
							$_SESSION['log'] = true;
							$_SESSION['who'] = [$x['name'],$x['id_user']];
							break;
						} else {
							$_SESSION['log'] = false;
							$_SESSION['who'] = [];
							
						}
					}
					if (!$_SESSION['log']) {
						echo "<script type=\"text/javascript\" src=\"jquery.min.js\"></script><script  src=\"lib_alert.js\"> </script>";
						echo '<script  >


						throw_alert({ 

							border_error : {
								text : \'\',
								class: \'border border_error\'
								} ,
							img_error : {
								type :"img",
								attr : {
									"src" : "svg/error-flat.png"
								},
								class : "img_error"
							}
							,el_sys_error : {
							text: "Wrong UserName Or PassWord",
							class: "wrong_logen" 
							},
							btn_close : {
								text : \'try again\',
								class: \'btn_error\',
								type : \'button\',
								events: {
									onclick : function () {
										console.log($(this).parent().parent().slideUp(\'fast\', function() { $(this).remove() }))
									}
								}
							} 
						})


						</script>';
					}
					

				}/* else {
					$_SESSION['log'] = false;
					$_SESSION['who'] = [];
				}

				why removed it ; becoase this will log out at all time he hasn't sumbit log
				*/


				?>

						</form>
					</div>
					<br>

			</div>
		</div>



</div>
<script type="text/javascript" src="lib/es5-sham.min-fix-ie-probles.js"></script>
<script type="text/javascript" src="jquery.min.js"></script>
<script type="text/javascript" src="lib_alert.js"></script>
<script type="text/javascript" src="lib/package/jquery.nicescroll.js"></script>
<script type="text/javascript" src="script_2.js"></script>
<?php
if ($_SESSION['log'] == true)
{
?>
<script type="text/javascript" src="user_line.js"></script>
<script type="text/javascript" src="socket.io.js"></script>
<script type="text/javascript" src="Chating_online.js"></script>
<script type="text/javascript" src="interesting_post.js"></script>
<script type="text/javascript" src="scrolling_post.js"></script>


<link rel="stylesheet" type="text/css" href="lib/emoji/emojionearea.min.css">
<script type="text/javascript" src="lib/emoji/emojionearea.min.js"></script>


<link rel="stylesheet" type="text/css" href="stylesheet/editor_post.css">
<script type="text/javascript" src="post_editor.js"></script>

<?php
}
?>
<script type="text/javascript" src="index.js"></script>




<?php

 // socket for io
	function hash_macker($hash)
	{	
	echo "	<script>
				$(function () {
					try {

				    window.socket = io('http://localhost:8080/');
				    socket.on('".$hash."', function(msg){
				    	$('body').append('<div class=\"msg_to_allow\"><h3>'+msg[0]+'</h3><button onclick=msg_allow('+msg[1]+',true)>Yes</button><button onclick=msg_allow('+msg[1]+',false)>No</button><button msg_allow('+msg[1]+',false, 1)>No, And Block</button></div>')
				      
			    });
				    	} catch (e) {
				    		console.log(e)
				    	}
			    socket.on('add_".$hash."', function(msg){
				     	console.log(msg)
				    });

			  });</script>";
	}

	if ($_SESSION['log'] == true) {
		$id = $_SESSION['who'][1];
		$try_id = 1;
		$try_id_2 = 0;
		$q = "SELECT * From `socket_hashing` WHERE `id`=" . $id;
		$r = mysqli_fetch_array( mysqli_query($c, $q) )[1];
		if ($r) {
			hash_macker($r);
		} else {
			$hash = 'd' . $id * rand(10000, 99999999) . base64_encode($id);
			$q = "INSERT INTO `socket_hashing`(`id`, `hash`) VALUES (".$id.",'".$hash."')";
			$r = mysqli_query($c, $q);
			hash_macker($hash);
		}




		}




		
	



?>
</body>
</html>