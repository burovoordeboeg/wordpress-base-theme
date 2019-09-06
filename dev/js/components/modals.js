function openModal(modal) {
    var topScrollPos = $(window).scrollTop();
    $('.modal, .modal .modal__box[data-modal="' + modal + '"]').addClass('is--active');
    $('body').addClass('no-scroll').attr('data-scrollpos', topScrollPos);
}

function closeModal() {
    $('.modal, .modal .modal__box').removeClass('is--active');

    // Revert back to old scrollposition
    $('body').removeClass('no-scroll');
    $(window).scrollTop($('body').attr('data-scrollpos'));
    $('body').attr('data-scrollpos', '');
}

(function ($) {

    $(document).on('click', '.js-open-modal', function (e) {
        e.preventDefault();
        openModal($(this).data('modal'));
    });

    $(document).on('click', '.js-close-modal', function (e) {
        e.preventDefault();
        closeModal();
    });

}(jQuery));