( function( $ ) {

	let cigGallery;

	$( function() {
		console.log( 'jquery working' );
	} );

	$('.cig-link').featherlightGallery({
		targetAttr: 'href'
	});

	$('.cig-link').click(() => {
		cigInitGallery();
		cigGallery.close();
	});

	$('a.cig-fl').click(() => {
		$.featherlight.current().close();
		cigInitGallery();
	});

	const cigInitGallery = () => {
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
	};




	//$('a.fl').featherlightGallery({
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

} )( jQuery );
