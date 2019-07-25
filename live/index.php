<?php 
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="style/index.css">
</head>
<body>

	<script type="text/javascript" src="../jquery.min.js"></script>
	<script type="text/javascript" src="../lib_alert.js"></script>
	<script type="text/javascript" src="../socket.io.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/peerjs/0.3.16/peer.min.js"></script>

<?php 
if (!isset($_SESSION['log']))  { header('Location: http://localhost/') ;} 
if (!isset($_GET['live']) && isset($_GET['room']))
{?>
<video id=c autoplay></video>


<script type="text/javascript" src="script/has_live.js"></script>


 <?php } else if(isset($_GET['live'] ) && $_GET['live'] == 1) { ?>

 <h1 class=title>live</h1>

<video id=c autoplay></video>

<button id=live_now>Live Now!</button>
<script type="text/javascript" src="script/index.js"></script>





<?php }else { ?>

	<h1>lives now</h1>

	<div class=room_show style = "margin : 3px;"></div>
	<script type="text/javascript" src="script/home.js"></script>
<?php } ?>
</body>
</html>