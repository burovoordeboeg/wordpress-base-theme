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
		$('.js-toggle-tabs').on('click', function (e) {
			e.preventDefault();
			var id = $(this).data('id');
			$('.js-toggle-tabs.is--active').removeClass('is--active');
			$(this).addClass('is--active');


			// Show content
			$('.tab-content__content.is--active').removeClass('is--active');
			$('.tab-content__content[data-id="' + id + '"]').addClass('is--active');

		});
	}

	// Initialize each block on page load (front end).
	$(document).ready(function () {
		$('.block--content-tabs').each(function () {
			initializeBlock($(this));
		});
	});

	// Initialize dynamic block preview (editor).
	if (window.acf) {
		window.acf.addAction('render_block_preview/type=content-tabs', initializeBlock);
	}


})(jQuery);