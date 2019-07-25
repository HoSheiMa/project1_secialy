<?php
$data = $_POST['val'];
$txt = $data['txt'];
$media = $data['medias'];
echo 'good';
echo $media;
echo 'good';
// txt
$no_txt   = 0;
$no_media = 0;
if ($txt == '' || empty($txt)){
    $txt = null;
    $no_txt = 1;
}
$media_ready = [];
if ($media) {    
    for ($i=0; $i < count($media);$i++) {
        array_push($media_ready, $media[$i][1]);
    }
    $media_ready = json_encode($media_ready);
} else $no_media = 1;

print_r( $media_ready );
echo "$no_txt || $no_media\n\r";
function save_post($user,$id_user,$text_in_post,$date,$new_id_post,$img)
{
	$new_id_post++;
	$c = mysqli_connect('127.0.0.1','root','','db1') or die('error to connection');


	// likes array 
	$ql = "INSERT INTO `likers`(`id_post`, `id_intersted_array`, `date`) VALUES ('$new_id_post','[]','".date("j, n, Y")."')";
	$rl = mysqli_query($c, $ql);


	$q2 = "INSERT INTO `posts`(`name`, `text`, `id`, `name_image`, `date`, `nu_post`) VALUES ('".$user."','".$text_in_post."','".$id_user."','".$img."','".$date."','".$new_id_post."')";
	$r = mysqli_query($c,$q2);


	$q4 = "INSERT INTO `comments`(`id_post`, `comments`) VALUES ({$new_id_post},'[]')";
	$r4 = mysqli_query($c,$q4);


}
if ($no_txt == 0 || $no_media == 0){
            $q1 = "select * from `last_nu_id_inpost` where 1";
            $r1 = mysqli_query($c,$q1);
            $top_numbre =0;
            $top_numbre = mysqli_fetch_array($r1)['numbre'];
            $top_numbre = $top_numbre + 1;
            
            $q3 = "UPDATE `last_nu_id_inpost` SET `numbre`='".$top_numbre."' WHERE 1 ";
            $r3 = mysqli_query($c,$q3);

            
            if ($no_txt == 0 && $no_media == 0){
        	save_post($_SESSION['who'][0],$_SESSION['who'][1],$txt,date("F j, Y, g:i a"),$top_numbre,$media_ready);
            } else if ($no_txt == 0 && $no_media == 1) {
        	save_post($_SESSION['who'][0],$_SESSION['who'][1],$txt,date("F j, Y, g:i a"),$top_numbre,null);
            } else if ($no_txt == 1 && $no_media == 0){
            save_post($_SESSION['who'][0],$_SESSION['who'][1],null,date("F j, Y, g:i a"),$top_numbre,$media_ready);
            }
            echo 'Done!';
} else echo 'error to add new!';