(function ($) {

	// Set action to menu button
	$('.js-toggle-nav').on('click', function (e) {
		e.preventDefault();
		$(this).toggleClass('is--active');
		$('.navigation').toggleClass('is--active');

		if ($('.navigation').hasClass('is--active')) {
			var topScrollPos = $(window).scrollTop();
			$('body').addClass('no-scroll').attr('data-scrollpos', topScrollPos);
		} else {
			$('body').removeClass('no-scroll');
			$(window).scrollTop($('body').attr('data-scrollpos'));
			$('body').attr('data-scrollpos', '');
		}
	});

	$('.js-toggle-subnav').on('click', function (e) {
		e.preventDefault();
		$(this).parents('li').toggleClass('is--active');
	});

}(jQuery));