	$(window).on('beforeunload unload pagehide', function() {

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'offline'
			},
			success: function(d) {
				setTimeout(check_is_me_now_off, 1000);
			}
		});

	});


	function check_is_me_now_off() {
		online_active();
		/*
		
		this function made becouse some people cancel page by wrong and
		refuse close this page than those will hide at online this function 
		return it to stute online . this_fix_it
	
		*/
	}


	$try_ = 1;
	__close = 1;

	function create_revc_el() {
		if ($try_) {

			$el_recv = document.createElement('div');
			$el_recv.id = "el_recv_info";
			$el_recv.constructor.prototype.__create_table_info__ = function(info) {
				// typeof info -> array;
				// info[0] => name
				// info[1] => state
				// info[2] => img
				// info[3] => id
				// info[4] => pos -> x,y
				// info[5] => nu_followrs


				

					$.ajax({
						url:'ajax.php',
						type:'post',
						data: {
							req: 'check_have_chat',
							id : info[3]
						},
						success: function (d) {
						console.log(d)
							if (d == 1) {
								$('#el_recv_info').html(

									"<div class=chating_as_div_img>"+
									"<img class=chating_as_img src=data:image;base64,"+ info[2] + ">"+
									"</div>"+
									"<br>"+
									"<span class=chating_as_txt>" + info[0] + "</span>"+
									"<br>"+
									"<button onclick=\"Chating_as(this,"+info[3]+");\" class=chating_as_btn>Chating</button>"+
									"<button class=chating_as_btn onclick=follow_it_("+ info[3] +")>"+
									"<span>" +
									info[5]+ ' | ' + "Follow" +
									"</span>"+
									"</button>"+
									"<button class=chating_as_btn>"+
									"Show Profile!"+
									"</button>"

									);
							} else {
								$('#el_recv_info').html(


									"<span>" + info[0] + "</span>"+
									"<br>"



									);
							}
						}
					});

					

					$(this).css('display', 'block');
					$(this).css('opacity', '1');
					$(this).animate({
						left:'6.5%'
					}, 'fast');
			};
			$el_recv.__proto__.__close__ = function(argument) {
				if (__close) {
					$(this).animate({
						left : '100%',
						opacity : 0
					}, 'fast', function () {
						$(this).css('display', 'none');
					});
				}
			};
			document.body.appendChild($el_recv);


			$try_ = 0;
			Object.freeze($try_); // to not change again !
		}
	}
	$('body').append("<div id=id_get_info ></div>"); // this important for create_html->fun
	__try_c = 1;
	function create_html(arr) {
		create_revc_el();
		arr = arr.split(',');
		var
			name = arr[0],
			img = arr[1],
			id_online = arr[2],
			nu_followers = arr[3]; 
		var el = document.createElement('div');
		$(el).addClass('id' + id_online);
		$(el).html('<img class="image_online' + '" src="data:image;base64,' + img + ' ">');
		$(el).on('mouseover', function(e) {

			var x = e.clientX,
				y = e.clientY;

			pos = [x + 20, y];

			console.log(pos);

			$el_recv = document.querySelector('#el_recv_info');
			$el_recv.__create_table_info__(
				[
					name,
					'online',
					img,
					id_online,
					pos,
					nu_followers
				]

			);

		}).on('mouseleave', function() {
			$el_recv = document.querySelector('#el_recv_info');

			$el_recv.__close__();

		}).on('click' , function  () {
			if (__try_c) {
				$(this).css('background', '#eee');
				__close = 0;
				__try_c = 0;
			} else{
				$(this).css('background', 'transparent');

				__close = 1;
				__try_c = 1;
			}
		});
		try___ = 1;
		exist = 0;
		$('.el_online').children().each(function(e) {
			$is_use_div = $('.el_online').children()[e];
			$id_use_div = $($is_use_div).attr('class').split('d')[1];
			//	console.log(id_online + '===' + $id_use_div);

			if (id_online == $id_use_div) {
				exist = 1;
			}
			try___ = 0;
		});

		if (try___ || !exist) {
			//	console.log(
			//		"==" + id_online
			//	);
			$('.el_online').append(el);
		}
	}
	try__ = 1;

	function create_cover_online() {
		if (try__) {
			el_online = document.createElement('div');

			$(el_online).addClass('el_online');

			$('body').append(el_online);
			$('.el_online').niceScroll({
				cursorcolor: "#111",
				cursorwidth: "6px"
			});
			try__ = 0;
		}
	}

	function offline_remove_html(arr) {

		exist = 1;
		el_to_remove = "";
		try___not___found_any_one = 1;
		$('.el_online').children().each(function(e) {
			for (i in arr) {
				if (arr[i] != "") {


					try___not___found_any_one = 0;
					$is_use_div = $('.el_online').children()[e];
					$id_use_div = $($is_use_div).attr('class').split('d')[1];
					if ($id_use_div == arr[i]) {
						exist = 0; // found in table online
						break;
					} else {
						exist = 1; // not found in table online 
						el_to_remove = '.el_online .id' + $id_use_div;
					}

				}
			}
			if (exist) {
				$(el_to_remove).fadeOut('fast', function() {
					$(this).remove();
				});
			}
			if (try___not___found_any_one) {
				$('.el_online').html('');
			}

		});
	}

	function get_info_arr(arr_id) {
		//	console.log(arr_id)
		offline_remove_html(arr_id);
		for (i in arr_id) {
			if (arr_id[i] != "") {
				$.ajax({
					url: 'ajax.php',
					type: 'post',
					data: {
						req: 'get_info_about_id',
						id_u: arr_id[i]
					},
					success: function(d) {
						create_html(d);
					}
				});
			}
		}
	}

	function Show_online_tools() {
		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'get_onlines'
			},
			success: function(d) {
				d = d.split(',');
				get_info_arr(d);
			}
		});
	}

	function online_active() {
		// body...

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'online'
			},
			success: function(d) {

				create_cover_online();
				Show_online_tools();

			}
		});

	}
	online_active();



	function check_for_online() {

		Show_online_tools();
		setTimeout(check_for_online, 1000);
	}

	setTimeout(check_for_online, 1000);


	//$('.el_online').onclick


function follow_it_ (id) {
	$.ajax({
		url:'ajax.php',
		data: {req : 'follow_it' , id: id},
		type: 'post',
		success : function (d) {
			console.log(d);
		}
	});
}