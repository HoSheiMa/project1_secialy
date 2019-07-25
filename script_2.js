
	$('html').niceScroll({
		cursorcolor:"#f6f6f6",
		cursorwidth:"4px",
	});

	function niceScroll_resize(){
         

         $('html, .el_online').getNiceScroll().resize();
      		

		$('.class_el5 textarea').getNiceScroll().resize();

		$('.class_el6').getNiceScroll().resize();
		
         setTimeout(niceScroll_resize, 600);
      }

niceScroll_resize()