"use strict";

(function ($) {
  $(function () {
    $('a.main').featherlightGallery();

    $.featherlightGallery.prototype.afterOpen = function () {
      var link = $('<span class="single-gallery-link"><a class="link" href="#" data-featherlight="#display-gallery">View Gallery</a></span>');
      $('.featherlight .featherlight-content').prepend(link);
      $(link).click(function (e) {
        $.featherlightGallery.close();
      });
    };

    $('a.intro').click(function (e) {
      e.preventDefault();
      $.featherlight.close(); // get ID from data attribute of thumbnail

      var id = $(this).data('link');
      console.log(id); // Get same thumb in gallery and trigger a click

      var thumb = document.getElementById(id);
      $(thumb).click();
    });
  });
})(jQuery);
//# sourceMappingURL=main.js.map
