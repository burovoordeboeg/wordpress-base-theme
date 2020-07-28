(function ($) {

    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
	var initializeBlock = function ($block) {
		if ($('.js-logo-slider').length) {
			$('.js-logo-slider').slick({
				slidesToShow: 5,
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
	}

	// Initialize each block on page load (front end).
	$(document).ready(function () {
		$('.block--logo-slider').each(function () {
			initializeBlock($(this));
		});
	});

	// Initialize dynamic block preview (editor).
	if (window.acf) {
		window.acf.addAction('render_block_preview/type=logo-slider', initializeBlock);
	}

})(jQuery);