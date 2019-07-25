var media_arr_to_uploadd = [];
var nu = 0;

function show_sure(event) {
	_id = event.data.id;
	throw_alert({
		w: {
			html: 'report_problem',
			class: 'material-icons',
			type: 'span',
			attr: {
				style: 'float: left;display: inline-block;padding: 14px;color: red;'
			}

		},
		txt_w: {
			html: 'Are You Sure To Remove This Media?',
			type: 'span',
			attr: {
				style: 'font-size: 18px;font-family: sans-serif;display: inline-block;margin-bottom: 25px;'
			}
		},
		btn_y: {
			html: 'Yes, I\'m Sure!',
			type: 'button',
			attr: {
				style: 'cursor:pointer;padding: 8px;color: #fff;background: #0f0;border: none;border-radius: 5px;font-size: 16px;font-family: sans-serif;font-weight: bold;'
			},
			events: {
				onclick: function() {
					$('.' + _id).parent().remove();
					for (i in media_arr_to_uploadd) {
						if (media_arr_to_uploadd[i][0] == _id) {
							media_arr_to_uploadd.splice(i, 1);
							break;
						}
					}
					$(this).parent().parent().addClass('animated slideOutUp ').delay(600).queue(function(next) {
						$(this).remove();
						next();
					});
				}
			}
		},
		btn_n: {
			html: 'No',
			type: 'button',
			attr: {
				style: 'cursor:pointer;padding: 8px;color: #fff;margin-left: 8px;background: #f00;border: none;border-radius: 5px;font-size: 16px;font-family: sans-serif;font-weight: bold;'
			},
			events: {
				onclick: function() {
					$(this).parent().parent().addClass('animated slideOutUp ').delay(600).queue(function(next) {
						$(this).remove();
						next();
					});
				}
			}
		}
	}, undefined, undefined, {
		class: 'alert_Tab animated bounce'
	}, {
		class: 'alert '
	});

}

function midea_ready(arr_nf) {
	id_media = 'media_iploaded' + (++nu);
	f = new FileReader();
	f.readAsDataURL(arr_nf.file[0]);
	f.onloadend = function() {
		media_arr_to_uploadd.push([id_media, this.result]);

	}

	$(arr_nf.e).prev().hide().remove();

	$(arr_nf.e).fadeIn('fast').addClass(id_media)
	$(arr_nf.e).next().on('click', {
		id: id_media
	}, show_sure);
}

function update(e) {

	$('.class_el6').niceScroll({
		cursorcolor: "#c5c5c5",
		cursorwidth: "3px",
	});

	if ((e.files[0].type).split('/')[0] == "image") {
		div = document.createElement('div');
		div.className = 'div_media_upload';
		img_l = document.createElement('img');
		img_s = document.createElement('img');
		img_l.src = '/bg/l.gif';
		img_l.className = 'media_upload';
		close_btn = document.createElement('div');
		$(close_btn).css({
			position: 'relative',
			color: '#fff',
			fontStyle: 'normal',
			marginLeft: '-26px',
			borderRadius: '0 0 5px 0',
			padding: '1px',
			display: 'inline-block',
			background: 'rgba(0, 0, 0, 0.2)',
			cursor: 'pointer'
		})
		clsoe_btn_i = document.createElement('i');
		$(clsoe_btn_i).css('font-style', 'normal')
			.addClass('material-icons')
			.html('close')
		close_btn.appendChild(clsoe_btn_i);

		img_s.style = "display : 'none'"
		img_s.className = 'media_upload';
		img_s.src = URL.createObjectURL(e.files[0]);
		img_s.onload = function() {
			midea_ready({
				e: this,
				file: e.files
			});
		};

		div.appendChild(img_l);

		div.appendChild(img_s);

		div.appendChild(close_btn);

		$(e).parent().parent().parent().append(div);
	} else if ((e.files[0].type).split('/')[0] == "video") {
		div = document.createElement('div');
		div.className = 'div_media_upload';
		img_l = document.createElement('img');
		img_l.src = '/bg/l.gif';
		img_l.className = 'media_upload';
		close_btn = document.createElement('div');
		$(close_btn).css({
			position: 'relative',
			color: '#fff',
			fontStyle: 'normal',
			marginLeft: '-26px',
			borderRadius: '0 0 5px 0',
			padding: '1px',
			display: 'inline-block',
			background: 'rgba(0, 0, 0, 0.2)',
			cursor: 'pointer'
		})
		clsoe_btn_i = document.createElement('i');
		$(clsoe_btn_i).css('font-style', 'normal')
			.addClass('material-icons')
			.html('close')
		close_btn.appendChild(clsoe_btn_i);
		v = document.createElement('video');
		v.style = 'display:none';
		v.className = 'media_upload';
		v.onloadeddata = function() {
			midea_ready({
				e: this,
				file: e.files
			});
			console.log('ready')
		};
		type = ['video/mp4', 'video/wmv', 'video/ogg', 'video/avi', 'video/webm'];
		for (i in type) {
			n_type = type[i];
			new_S = document.createElement('source');
			new_S.src = URL.createObjectURL(e.files[0]);
			new_S.type = n_type;
			v.appendChild(new_S);
		}
		div.appendChild(img_l);
		div.appendChild(v);
		div.appendChild(close_btn);
		$(e).parent().parent().parent().append(div);
	}

}



function show_post_editor() {
	$.ajax({
		url: 'ajax.php',
		type: 'post',
		data: {
			req: 'need_info'
		},
		success: function(d) {
			data = JSON.parse(d);
			$('.page1').fadeOut();
			throw_alert({

				el1: {
					id: " ",
					class: 'class_el1',
					children: {
						el2: {
							type: 'img',
							attr: {
								src: "data:image;base64," + data[2]
							}
						},
						el3: {
							type: 'span',
							html: data[1]
						},
						el4: {
							type: 'button',
							html: "<i class=material-icons>close</i>",
							events: {
								onclick: function() {
									$(this).parent().parent().parent().addClass('animated bounceOut').delay(1600).queue(function(next) {
										$(this).remove();
										next();
									});
									$('.page1').fadeIn();
								}
							}
						}

					}
				},
				el5: {
					id: ' ',
					class: 'class_el5',
					children: {
						input1: {
							type: 'textarea',
							id: ' ',
							attr: {
								placeholder: 'Start writing'
							},
							events: {
								onclick: function() {
									$(".class_el5 textarea").emojioneArea({
										pickerPosition: "bottom",
										autocomplete: true,
										events: {
											focus: function() {
												$('.class_el5 .emojionearea .emojionearea-editor').niceScroll({
													cursorcolor: "#c5c5c5",
													cursorwidth: "3px",
												});
											}
										}
									});


								}
							}
						}
					}

				},
				el6: {
					id: ' ',
					class: 'class_el6',
					children: {
						input_to_up_some_else: {
							type: 'button',
							html: '<i class=material-icons>control_point</i><form id=media_upload_form style=display:none multipart="" enctype="multipart/form-data"><input name=media[] multiple onchange=update(this) type=file ></form>',
							class: 'upload-btn',
							events: {
								onclick: function() {
									$(this).children()[1][0].click();
								}
							}

						}
					}
				},
				el7: {
					id: ' ',
					class: 'class_el7',
					children: {
						btn: {
							type: 'button',
							html: '<i class=material-icons whte>share</i>',
							events: {
								onclick: function() {
									$txt = $('.class_el5 .emojionearea .emojionearea-editor')
									$text = $('.class_el5 .emojionearea .emojionearea-editor').html();
									$txt_c = $($txt).children();
									try_send = 0;
									if ($txt_c.length > 0) {
										for (i in $txt_c) {
											if ($txt_c[i].tagName == "IMG") {
												if (($txt_c[i].src).split('/')[0] == 'https:') {
													if (($txt_c[i].src).split('/')[2] == "cdn.jsdelivr.net") {
														if (($txt_c[i].src).split('/')[3] == "emojione") {
															try_send = 1;
														} else try_send = 0;
														break;
													} else try_send = 0;
													break;
												} else try_send = 0;
												break;
											} else try_send = 0;
											break;
										}
									} else try_send = 1;
									if ($text == '') text = null;
									if (try_send) {
										$.ajax({
											url: 'ajax.php',
											type: 'post',
											data: {
												req: 'set_new_hash_code_for_uploading_file',
											},
											success: function(d) {
												hash = d;
												console.log(d)
												for (i in media_arr_to_uploadd) {
													media_arr_to_uploadd[i][0] = 'media_iploaded';
												}
												console.log(media_arr_to_uploadd)
												socket.emit('upload_files', {'hash': hash, 'txt': $text, 'files' : media_arr_to_uploadd});
											}
										})
									}
								}
							}
						},
						btn2: {
							type: 'button',
							html: '<i class=material-icons whte>all_inclusive</i>',
							events : {
								onclick : function () {
									window.location.href = window.location.href + 'live?live=1';
								}
							}
						}
					}
				}



			}, undefined, undefined, {
				class: "tab_has"
			}, {
				class: "bounceIn animated alert_tab"
			});



		}
	});


}