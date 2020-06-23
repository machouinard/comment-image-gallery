"use strict";

(function ($) {
  var cigGallery;
  $(function () {
    console.log('jquery working');
  });
  $('.cig-link').featherlightGallery({
    targetAttr: 'href'
  });
  $('.cig-link').click(function () {
    cigInitGallery();
    cigGallery.close();
  });
  $('a.cig-fl').click(function () {
    $.featherlight.current().close();
    cigInitGallery();
  });

  var cigInitGallery = function cigInitGallery() {
    cigGallery = $('a.cig-fl').featherlightGallery({
      gallery: {
        next: 'next »',
        previous: '« previous',
        fadeIn: 300,
        fadeOut: 300,
        openSpeed: 300,
        closeSpeed: 300
      },
      variant: 'featherlight-gallery2'
    });
  }; //$('a.fl').featherlightGallery({
  //	gallery: {
  //		next: 'next »',
  //		previous: '« previous',
  //		fadeIn: 300,
  //		fadeOut: 300,
  //		openSpeed:    300,
  //		closeSpeed:   300
  //	},
  //	variant: 'featherlight-gallery2'
  //});

})(jQuery);
//# sourceMappingURL=main.js.map
