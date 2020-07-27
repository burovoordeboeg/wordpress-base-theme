(function ($) {

	if ($('.js-slider').length) {
		$('.js-slider').slick({
			slidesToShow: 3,
			dots: false,
			arrows: true,
			infinite: true,
			swipeToSlide: true,
			responsive: [
				{
					breakpoint: 769,
					settings: {
						slidesToShow: 3
					}
				},

				{
					breakpoint: 600,
					settings: {
						slidesToShow: 2
					}
				}

			]
		});
	}

})(jQuery);