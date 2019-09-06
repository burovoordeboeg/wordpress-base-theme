(function ($) {

    // Truncate strings
    setTimeout(function () {
        $('.js-truncate').dotdotdot({
            wrap: 'word',
            watch: window,
            after: '.js-readmore-handle'
        });
    }, 200);

})(jQuery);