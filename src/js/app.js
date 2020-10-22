( function( $ ) {

	$(function() {
		const count = $('ul.related-list').data('count');
		//console.log('count', count);
		if ( undefined !== typeof count && 501 > window.screen.width && count > 4 ) {

			//const moreImages = $('ul.related-list').data('more');
			//console.log('moreImages', moreImages);

			let plus = document.getElementById('more-count-plus');
			let more = document.getElementById('more-count');
			plus.innerText = '+' + (parseInt( plus.innerText ) + 1);
			more.innerText = '' + (parseInt( more.innerText ) + 1);
		}

		$( 'a.main' ).featherlightGallery();

		$.featherlight.prototype.afterOpen = function() {
			const title = $('<h2 class="related-title">Readers\' Recipe Photos</h2>');
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
	});
	$('i.fas.fa-camera').html( '<span style=\'font-size: 14px;padding-left: 5px;font-family: Arial Hebrew, Arial, sans-serif;\'>ADD PHOTO</span>' );
} )( jQuery );
