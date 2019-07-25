$.ajax({
	url: 'ajax.php',
	data: {
		req: 'check_have_profile_at_used'
	},
	type: 'post',
	success: function(d) {
		console.log(d)
	}
});
$.ajax({
	url: 'ajax.php',
	data: {
		req: 'sure_log'
	},
	type: 'post',
	success: function(d) {
		btn_more = "<button id='More_need' onclick=\"GetMore()\">More</button>"
		if (d == 'no') {
			$('.page1').fadeIn()
			console.log('no')
		} else {
			$.ajax({
				url: 'ajax.php',
				data: {
					req: 'show_POST'
				},
				type: 'post',
				beforeSend: function() {
					$('.page1').show().html('<br><br><div style="background:transparent;"><img src="svg/loading.gif"></div>')
					console.log('good')
				},
				success: function(d) {
					console.log(d);
					console.log('yes')
					$('.page1').css('padding', '60px 0 0 0')
					see_nu_img = d.split("<img src")
					Maker = "<button onclick='show_post_editor()' class=share_post><span>Share Post</span> <i class=material-icons>control_point</i></button>";

					if (see_nu_img.length >= 5) {
						$('.page1').html(Maker + d + "<br>" + btn_more)
						$('.page1').fadeIn();
					} else {
						$('.page1').html(Maker + d)
						$('.page1').fadeIn();

					}



					$.ajax({
						url: 'ajax.php',
						data: {
							req: 'Get_controller_page_A'
						},
						type: 'post',
						success: function(d) {
							$(".toolbar").prepend(d)
						}
					})

				}
			})
		}
	}
})

function GetMore() {
	$.ajax({
		url: 'ajax.php',
		data: {
			req: 'Need_more_POSTS'
		},
		type: 'post',
		success: function(d) {
			$("#More_need").remove();
			see_nu_img = d.split("<img src")
			if (see_nu_img.length >= 5) {
				$('.page1').html($('.page1').html() + d + "<br>" + btn_more)
			} else {
				$('.page1').html($('.page1').html() + d)
			}

			//window.scrollTo(0,0)

		}
	})
}

try1 = 0;
no_f_GET_cPB = 1;

function Get_controller_page_B(e) {
	if (!try1) {
		el = e;
		Left = el.offsetLeft;
		Top = el.offsetTop;
		$.ajax({
			url: 'ajax.php',
			data: {
				req: 'Get_controller_page_B',
				P: [Top, Left]
			},
			type: 'post',
			success: function(d) {
				$('body').append(d)
				try1 = 1;
			}
		})
	} else {
		$('.Get_controller_page_B').fadeIn()
	}
}

function Get_controller_page_B_remove() {
	setTimeout('(function(){if (no_f_GET_cPB) $(\'.Get_controller_page_B\').fadeOut();no_f_GET_cPB = 1;})()', 3000)

}

function GET_cPB_in() {
	no_f_GET_cPB = 0;
}

function GET_cPB_out() {
	no_f_GET_cPB = 1;
	$('.Get_controller_page_B').fadeOut()
}

function change_username(procces_n) {
	if (procces_n == 1) {

		$el = $('.user_info > div > .tag_info_for_data')[0];

		$($el).html('<input placeholder=\'New Name\' maxlength=18 type=txt id=new_name><button onclick=change_username(2)>change</button>').css('text-align', 'center').css('display', 'inline-block')
		$('#new_name').next().css({
			boxShadow: '0 0 1px 0',
			color: 'white',
			background: 'transparent',
			border: 'none',
			padding: '6px'

		})
	} else {
		$new_name = $('#new_name').val();
		len = $new_name.length;
		if (len < 18) {
			$.ajax({
				url: 'ajax.php',
				data: {
					req: 'change_username',
					new_name: $new_name
				},
				type: 'post',
				success: function(d) {

					if (d.includes('re')) {
						document.location.reload()
					}
					$('#new_name').val('').attr('placeholder', d)
				}
			})
		}
	}
}

function send_comment(el, id) {
	txt = $(el).prev().val();
	$(txt).val('');
	if (txt.length > 0) {
		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'add_comment',
				txt: txt,
				id_post: id
			},
			success: function(d) {
				console.log(d)
				comment_push(id, el, 1);
			}
		})
	}
}



function comment_push(id_post, el, after_not) {
	if (!after_not) {
		if (el) {
			$(el).fadeOut('fast', function() {
				$(this).prev().css('width', '100%')
			})
		}

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'Get_comment_and_comments_tools',
				comment_post_id: id_post
			},
			success: function(d) {
				$(el).prev().after("<div class=class_comment>" + d + "</div>")
			}
		})
	} else {
		$(el).fadeOut('fast', function() {
			$(this).parent().html(' ')
		})

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'Get_comment_and_comments_tools',
				comment_post_id: id_post
			},
			success: function(d) {
				//console.log($(el).parent())
				$(el).parent().parent().after("<div  class='class_comment'>" + d + "</div>").remove()
				//console.log(d)
			}
		})
	}
}


function send_comment_r(el, id_post, id_comment) {
	$txt_r = $(el).prev().val();
	$(el).prev().val(' ');
	if ($txt_r.length > 0) {

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'put_comment_r',
				id_post: id_post,
				id_comment: id_comment,
				$txt_r: $txt_r
			},
			success: function(d) {
				comment_push(id_post, el, 1)
			}
		})


	} else {
		console.log('not found reply text.')
	}



}

function close_info() {
	$('.profile').remove()
	$('.toolbar').fadeIn()
	$('.page1').fadeIn()

}

function rem(nu_post, her) {
	$(her).parent().fadeOut('fast', function() {
		$(this).remove()
	})
	$('.stting_post').each(function(e) {
		$el = $('.stting_post')[e]
		if ($($el).text() == ".") {
			$($el).parent().fadeOut('fast', function() {
				$(this).remove()
			})
		}
	})

	$.ajax({
		url: 'ajax.php',
		type: 'post',
		data: {
			req: 'rem_post',
			id_post: nu_post
		},
		success: function(e) {
			//	console.log(e)
		}
	})
}

function open_opt(nu_post, parent, el_stt) {



	$('.tls_post').each(function(e) {
		$('.tls_post').remove();

	})
	$('.stting_post').each(function(e) {
		$el = $('.stting_post')[e]
		$($el).text('...')
	})
	$(el_stt).text('.')
	X = el_stt.offsetLeft + 27
	Y = el_stt.offsetTop
	el = "<div style='position: absolute;" + "left:" + X + "px;top:" + Y + "px'" + " class=tls_post> <button onclick='rem(" + nu_post + ",this)' class=tls_btn>Remove</button><br><button onclick='New_txt_changing(" + nu_post + ", " + parent + ")' class=tls_btn>Put New Text</button>"
	$('body').append(el)
	$('.tls_post').slideDown()

}


function check_txt(nu, el, event) {
	ineed_incress = 0;
	txt = $(el).val()

	for (i in txt) {
		if (txt[i].charCodeAt() == 10) {
			ineed_incress++;
		}
	}
	len_txt_area = txt.length
	while (len_txt_area > 0) {
		if (!len_txt_area >= 93) break;
		len_txt_area = +len_txt_area - 93;
		ineed_incress++;
	}

	$(el).css('height', ineed_incress * 10 + 70 + "px")
}