(function ($) {

	$('.js-toggle-tabs').on('click', function (e) {
		e.preventDefault();
		var id = $(this).data('id');
		$('.js-toggle-tabs.is--active').removeClass('is--active');
		$(this).addClass('is--active');


		// Show content
		$('.tab-content__content.is--active').removeClass('is--active');
		$('.tab-content__content[data-id="' + id + '"]').addClass('is--active');

	});

})(jQuery);