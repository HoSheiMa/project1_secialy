<style type="text/css">
	
	.Get_controller_page_B {
		position: absolute;
		width: 120px;
		height: 200px;
		background-color: #333;
		text-align: center;
		padding: 5px;
		box-sizing: border-box;
		border-radius: 4px;
		box-shadow: 0 3px 5px 1px;
	}
	.Get_controller_page_B:before {
		content: '';
		width: 0;
		height: 0;
		border:5px solid transparent;
		border-bottom: 5px solid #333;
		    margin-top: -15px;
    position: absolute;
    margin-left: 40px;
	}
	.Get_controller_page_B button {
		font-size: 12px;
		background-color: transparent;
		border:none;
		border-bottom: 1px solid #079;
		color :white;
		font-style: italic;
		cursor: pointer;
		transition: .3s;
		margin-top: 15px;
		border-radius: 4px;
		width: 80%;
		height: 30px;
	}
	.Get_controller_page_B button:hover {
		background-color: #079;
	}
	.close_page {
		border-radius: 4px;
		color: red;
		background-color: transparent;
		border:none;
		border-bottom: 1px solid #079;
		width: 20px;
		height: 20px;
		cursor:pointer;
		transition: .3s;
	}
	.close_page:hover{
		background-color: red;
		color: white;
		border-color: red;
	}
</style>
<div class="Get_controller_page_B" onmouseover="GET_cPB_in()" onmouseleave='GET_cPB_out()' style="top: <?php echo $Top."px"; ?>;left: <?php echo $Left."px"; ?>;">
	<button class="show_my_owner_user_wall" onclick='show_my_owner_user_wall()' >My Profile</button>
	<button class="Show_my_POSTS">MY POSTS</button>
	<button>My O-S Objects</button>
	<button>My P_O_S ObjeCTS</button>
</div>

<script type="text/javascript">
	btn_more = "<button id='More_needOwner' onclick=\"GetMoreOwner()\">More</button>"
	$('.Show_my_POSTS').on('click', function () {
		$.ajax({
			url:'ajax.php',
			type:'post',
			data:{req:'Get_own_POSTS'},
			success: function (d) {
					

				$new_el = document.createElement('div')
				$($new_el).css({
					position:'absolute',
					left:'5%',
					top:'10%',
					width:'90%',
					height:'600px',
					backgroundColor:'#333',
					boxShadow:'0 4px 10px 1px',
					borderRadius:'4px',
					textAlign:'center',
					overflowY:'scroll',
					overflowX:'hidden'
				})
				$($new_el).append("<div style='text-align:right;padding:5px;'><button class=close_page>X</button></div>")
				
				$('body').append($new_el)

					see_nu_img = d.split("img")
					if (see_nu_img.length == 5) {
						$($new_el).append(d +"<br>"+ btn_more)
						$($new_el).fadeIn();
					} else {
						$($new_el).html($($new_el).html()+d)
					}
					
				$('.close_page').on('click', function () {
					$(this).parent().parent().remove()
				})
			}
		})
	})

	function GetMoreOwner() {
		$.ajax({
			url:'ajax.php',
			data:{req:'Need_more_POSTSOwner'},
			type:'post',
			success:function (d) {
				console.log(d + "s")
				$("#More_needOwner").remove();
					see_nu_img = d.split("img")
					if (see_nu_img.length == 5) {
						$($new_el).html($($new_el).html()+d +"<br>"+ btn_more)
					} else {
						$($new_el).html($($new_el).html()+d)
					}
				
				$('.close_page').on('click', function () {
					$(this).parent().parent().remove()
				})

			}
		})	}



		function show_my_owner_user_wall() {



			$.ajax({
				url:'php_pages/user_profiles_ajax.php',
				data:{req:'get_my_profile'},
				type:'post',
				success: function  (d) {
					$('body > div').css('display','none')
					$('body').prepend("<div class=profile>"+d+"</div>")

				}
			})


		};
</script>

