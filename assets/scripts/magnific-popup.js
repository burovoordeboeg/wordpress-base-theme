// Initialize popup
$(document).ready(function () {
  $(".gallery").each(function () {
    // the containers for all your galleries
    var gallery = $(this);
    gallery.magnificPopup({
      delegate: "a", // the selector for gallery item
      type: "image",
      gallery: {
        enabled: true,
      },
    });
  });
});
