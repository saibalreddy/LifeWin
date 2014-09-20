$(document).ready(function(){
	
	
		
});


$(window).scroll(function() {
	$('.device .col-sm-6.col-md-5.col-md-offset-1').each(function(){
	var imagePos = $(this).offset().top;

	var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+400) {
			$(this).addClass("slideRight");
		}
	});
});

$(window).scroll(function() {
	$('.device .col-sm-6.col-md-5').each(function(){
	var imagePos = $(this).offset().top;

	var topOfWindow = $(window).scrollTop();
		if (imagePos < topOfWindow+400) {
			$(this).addClass("slideLeft");
		}
	});
});








