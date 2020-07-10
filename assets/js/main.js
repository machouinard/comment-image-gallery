"use strict";

(function ($) {
  $(function () {
    $('a.main').featherlightGallery();

    $.featherlight.prototype.afterOpen = function () {
      var title = $('<p>Click photos to enlarge and read reviews</p>');
      var commentLink = $('<a href="#comments">Add a comment and photo</a>');
      $('.featherlight .featherlight-content').prepend(title);
      $('.featherlight .featherlight-content').append(commentLink);
      $(commentLink).click(function (e) {
        $.featherlight.close();
      });
    };

    $.featherlightGallery.prototype.afterOpen = function () {
      var link = $('<span class="single-gallery-link"><a class="link" href="#" data-featherlight="#display-gallery">View Gallery</a></span>');
      $('.featherlight .featherlight-content').prepend(link);
      $(link).click(function (e) {
        $.featherlightGallery.close();
      });
      $('p.cig-author a').click(function (e) {
        $.featherlightGallery.close();
      });
    };

    $('a.intro').click(function (e) {
      e.preventDefault();
      $.featherlight.close(); // get ID from data attribute of thumbnail

      var id = $(this).data('link'); // Get same thumb in gallery and trigger a click

      var thumb = document.getElementById(id);
      $(thumb).click();
    });
  });
})(jQuery);
//# sourceMappingURL=main.js.map
