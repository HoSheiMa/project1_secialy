var template = document.createElement('div');
template.constructor.prototype.create = function(id_post, el) {

template.id =  "post_"+id_post;
template.className = "template_post_feel";
	html_template =



		"<img src=imgs_feels_post/1.png width=40 class=feel_on_post onclick='interest("+id_post+", $(this).parent().prev(), 2)'>" +


		"<img src=imgs_feels_post/2.png width=40 class=feel_on_post onclick='interest("+id_post+", $(this).parent().prev(), 3)'>" +


		"<img src=imgs_feels_post/3.png width=40 class=feel_on_post onclick='interest("+id_post+", $(this).parent().prev(), 4)'>" +


		"<img src=imgs_feels_post/4.png width=40 class=feel_on_post onclick='interest("+id_post+", $(this).parent().prev(), 5)'>" +


		"<img src=imgs_feels_post/5.png width=40 class=feel_on_post onclick='interest("+id_post+", $(this).parent().prev(), 6)'>";

	template.innerHTML = html_template;


	$(el).after(template);


	$(template).hover( 

		function (e) {
		console.log('work' + e.pageX);
	},

		function (e) {
		$(this).slideUp('fast', function () {
			$(this).html(' ');
		});
		}


	);


};



function hover_more_interest(id_post, el) {



	template.create(id_post, el);


	$(template).delay(100).fadeIn();


}



function interest(nu_post, event, type) {
	if (event.className == "interested") {
			console.log(event.className)

		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'remove_interest',
				id_post: nu_post
			},
			success: function(d) {
				$(event).removeClass('interested').css('border', 'none');
				$($(event).children()[0]).removeClass('interested_img');

			}
		});
	} else {
		$.ajax({
			url: 'ajax.php',
			type: 'post',
			data: {
				req: 'add_interest',
				id_post: nu_post,
				type: type
			},
			success: function(d) {

					$(event).addClass('interested');
					$($(event).children()[0]).addClass('interested_img');
					if (type != 1) {
						type = type - 1;
						$($(event).children()[0]).attr('src' , 'imgs_feels_post/' + type +".png")
					}
					console.log(d)
			}
		});
	}
}