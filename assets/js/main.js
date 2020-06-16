"use strict";

(function ($) {
  $(function () {
    console.log('jquery working');
  });
  $('a.fl').featherlightGallery({
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
})(jQuery);
//# sourceMappingURL=main.js.map
