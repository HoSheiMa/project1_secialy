function Chating_as(el,id) {


	el.remove()

	$.ajax({
		url: 'ajax.php',
		type: 'post',
		data: {
			req: 'Chating_online',
			id_use: id
		},
		success: function(d) {
		}
	});
}


function msg_allow(id, r, t) {
	if (r) {
		$.ajax({
			url:'ajax.php',
			type:'post',
			data:{
				req:'accept_msg',
				id: id
			},
			success: function (d) {
				el_chat = document.createElement('div');

				$(el_chat).addClass('chat_table').appendTo('body');
			}
		});
	} else {
		if (t) {

		} else {

		}
	}
}