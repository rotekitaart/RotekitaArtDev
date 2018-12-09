(function( $ ) {
	'use strict';

	/**
	 * Set cookie for accepting the privacy consent.
	 *
	 * @since    1.0.0
	 */
	function aiovg_set_cookie() {
		
		var data = {
			'action': 'aiovg_set_cookie'
		};
		
		$.post( aiovg.ajax_url, data, function( response ) {
			// console.log( 'Cookie stored!' );
		});
		
	}
	
	/**
	 * Called when the page has loaded.
	 *
	 * @since    1.0.0
	 */
	$(function() {
			   
		$( '.aiovg-privacy-consent-button' ).on( 'click', function() {
			
			aiovg_set_cookie();
			
			var container = $( this ).closest( '.aiovg-player' );
			
			var iframe = container.find( 'iframe' ).clone();
			var src = iframe.data( 'src' );
			iframe.attr( 'src', src );
			
			container.html( iframe );
			
		});
		
	});

})( jQuery );
