( function( $ ) {

	$( function() {
		console.log( 'jquery working' );
	} );

	$('.cig-modal-int').featherlightGallery({
		previousIcon: '&#9664;',     /* Code that is used as previous icon */
		nextIcon: '&#9654;',         /* Code that is used as next icon */
		galleryFadeIn: 100,          /* fadeIn speed when slide is loaded */
		galleryFadeOut: 300          /* fadeOut speed before slide is loaded */
	})

} )( jQuery );
