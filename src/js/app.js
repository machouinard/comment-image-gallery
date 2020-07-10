( function( $ ) {

	$(function() {
		$( 'a.main' ).featherlightGallery();

		$.featherlightGallery.prototype.afterOpen = function() {
			const link = $( '<span class="single-gallery-link"><a class="link" href="#" data-featherlight="#display-gallery">View Gallery</a></span>' );
			$( '.featherlight .featherlight-content' ).prepend( link );
			$( link ).click( e => {
				$.featherlightGallery.close();
			} );
			$('p.cig-author a').click( e => {
				$.featherlightGallery.close();
			})
		};

		$( 'a.intro' ).click( function( e ) {
			e.preventDefault();
			$.featherlight.close();
			// get ID from data attribute of thumbnail
			let id = $( this ).data( 'link' );
			// Get same thumb in gallery and trigger a click
			let thumb = document.getElementById( id );
			$( thumb ).click();
		} );
	})

} )( jQuery );
