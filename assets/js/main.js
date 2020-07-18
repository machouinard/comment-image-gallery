"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

(function ($) {
  $(function () {
    var count = $('ul.related-list').data('count'); //console.log('count', count);

    if (undefined !== _typeof(count) && 501 > window.screen.width && count > 4) {
      var moreImages = $('ul.related-list').data('more'); //console.log('moreImages', moreImages);

      var plus = document.getElementById('more-count-plus');
      var more = document.getElementById('more-count');
      plus.innerText = '+' + (parseInt(plus.innerText) + 1);
      more.innerText = '' + (parseInt(more.innerText) + 1);
    }

    $('a.main').featherlightGallery();

    $.featherlight.prototype.afterOpen = function () {
      var title = $('<h3 class="related-title">Reader\'s Recipe Photos</h3>');
      var subtitle = $('<p class="fl-subtitle">Click photos to enlarge and read reviews</p>');
      var commentLink = $('<a class="comment-photo" href="#comments">Add a comment and photo</a>');
      $('.featherlight .featherlight-content').prepend(subtitle);
      $('.featherlight .featherlight-content').prepend(title);
      $('.featherlight .featherlight-content').append(commentLink);
      $(commentLink).click(function (e) {
        $.featherlight.close();
      });
    };

    $.featherlightGallery.prototype.afterOpen = function () {
      var link = $('<span class="single-gallery-link"><a class="link" href="#" data-featherlight="#display-gallery">See all readers\' photos</a></span>'); //const addCommentLink = $('<a class="add-comment-link" href="#comments">Add a comment and photo</a>');

      $('.featherlight .featherlight-content').prepend(link); //$( '.featherlight .featherlight-content' ).append( addCommentLink );

      $(link).click(function (e) {
        $.featherlightGallery.close();
      });
      $('p.cig-author a').click(function (e) {
        $.featherlightGallery.close();
      }); //$(addCommentLink).click( e => {
      //	$.featherlightGallery.close();
      //});
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
