( function( $ ) {

	$(function() {
		$( 'a.main' ).featherlightGallery();

		$.featherlight.prototype.afterOpen = function() {
			const title = $('<h3 class="related-title">Reader\'s Recipe Photos</h3>');
			const subtitle = $('<p class="fl-subtitle">Click photos to enlarge and read reviews</p>');
			const commentLink = $('<a class="comment-photo" href="#comments">Add a comment and photo</a>');
			$('.featherlight .featherlight-content' ).prepend(subtitle);
			$('.featherlight .featherlight-content' ).prepend(title);
			$('.featherlight .featherlight-content' ).append(commentLink);
			$(commentLink).click( e => {
				$.featherlight.close();
			})
		};

		$.featherlightGallery.prototype.afterOpen = function() {
			const link = $( '<span class="single-gallery-link"><a class="link" href="#" data-featherlight="#display-gallery">See all readers\' photos</a></span>' );
			//const addCommentLink = $('<a class="add-comment-link" href="#comments">Add a comment and photo</a>');
			$( '.featherlight .featherlight-content' ).prepend( link );
			//$( '.featherlight .featherlight-content' ).append( addCommentLink );
			$( link ).click( e => {
				$.featherlightGallery.close();
			} );
			$('p.cig-author a').click( e => {
				$.featherlightGallery.close();
			});
			//$(addCommentLink).click( e => {
			//	$.featherlightGallery.close();
			//});
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
