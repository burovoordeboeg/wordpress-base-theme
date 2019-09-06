var scaleResizeTimer;

(function ($) {

    function scaleImages(target) {
        clearTimeout(scaleResizeTimer);
        $(target).imageScale({
            rescaleOnResize: true
        });
    }

    // Scale the images
    $(document).ready(function () {
        scaleResizeTimer = setTimeout(scaleImages('.js-image-scale'), 300);
        $(window).on('resize', function () {
            scaleResizeTimer = setTimeout(scaleImages('.js-image-scale'), 300);
        });
    });

}(jQuery))