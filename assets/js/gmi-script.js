jQuery( function( $ ) {
	$( document ).ready( function() {

		var merchant_id = $( '#merchant_id' ).val();

		if( !merchant_id )
			return;

		var order_id = $( '#order_id' ).val();
		var email = $( '#customer_email' ).val();
		var delivery_country = $( '#country_code' ).val();
		var default_estimated_delivery = $( '#default_estimated_delivery' ).val();

		// Calcula a data de entrega
		var frete = $( '.shipped_via' ).text();
		// frete = 'Retirar no local';
		var dias = frete.match( 'em (.*) dia' );

		if( typeof dias === 'undefined' || dias == null ) {
			dias = default_estimated_delivery;
		} else if( $.isArray( dias ) && dias.length < 2 ) {
			dias = default_estimated_delivery;
		} else {
			dias = dias[1];
		}

		dias = parseInt( dias );

		var full_date = new Date();


		if( dias > 0 ) {
			full_date.setDate( full_date.getDate() + dias );
		}
		var day = ( full_date.getDate() > 9 ) ? full_date.getDate() : '0' + ( full_date.getDate() );
		var month = ( ( full_date.getMonth().length + 1 ) === 1 ) ? ( full_date.getMonth() + 1 ) : '0' + ( full_date.getMonth() + 1 );
		var year = full_date.getFullYear();
		var estimated_delivery_date = year + '/' + month + '/' + day;
		console.log('estimated_delivery_date 1: ' + estimated_delivery_date);

		window.renderOptIn = function() { 
			console.log( 'renderOptIn' );
			window.gapi.load( 'surveyoptin', function() {
				console.log( 'load' );
				window.gapi.surveyoptin.render(
				{
					// REQUIRED
					'merchant_id': merchant_id,
					'order_id': order_id,
					'email': email,
					'delivery_country': delivery_country,
					'estimated_delivery_date': estimated_delivery_date,

					// OPTIONALx
					'opt_in_style': 'BOTTOM_TRAY'
				}); 
			});
		}

		window.renderBadge = function() {
			console.log('renderBadge');
			var ratingBadgeContainer = document.createElement("div");
			document.body.appendChild(ratingBadgeContainer);
			window.gapi.load('ratingbadge', function() {
				console.log('ratingbadge');
				window.gapi.ratingbadge.render(
					ratingBadgeContainer, {
						// REQUIRED
						"merchant_id": merchant_id,
						// OPTIONAL
						"position": "BOTTOM_LEFT"
					}
				);           
			});
		}

		window.___gcfg = {
			lang: 'pt_BR'
		};

	}); // $(document).ready
});