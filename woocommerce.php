<?php

add_action( 'woocommerce_thankyou', 'gmi_integration', 10, 1 );

function gmi_integration( $order_id ) {

	if( !$order_id )
		return;

	$merchant_id = gmi_get_option( 'google_merchant_id' );
	$order = wc_get_order( $order_id );
	$customer_email = $order->get_billing_email();
	$country_code = $order->get_billing_country();
	$default_estimated_delivery = gmi_get_option( 'gmi_default_estimated_delivery' );
	if( empty( $default_estimated_delivery ) )
		$default_estimated_delivery = 0;
	// $current_date = date( 'Y-m-d' );
	// $estimated_delivery_date = date( 'Y-m-d', strtotime( '+2 days', strtotime( $current_date ) ) );
	// gmi_debug( $estimated_delivery_date );
	// MERCHANT_ID
	// ORDER_ID
	// CUSTOMER_EMAIL
	// COUNTRY_CODE
	// ESTIMATED_DELIVERY_DATE
	// OPT_IN_STYLE (optional)
	?>
	<input type="hidden" id="merchant_id" value="<?php echo $merchant_id; ?>">
	<input type="hidden" id="order_id" value="<?php echo $order_id; ?>">
	<input type="hidden" id="customer_email" value="<?php echo $customer_email; ?>">
	<input type="hidden" id="country_code" value="<?php echo $country_code; ?>">
	<input type="hidden" id="default_estimated_delivery" value="<?php echo $default_estimated_delivery; ?>">

	<?php
		$estimated_delivery_date = date( 'Y/m/d', strtotime( '+' . $default_estimated_delivery . ' days' ) );
		// gmi_debug( $estimated_delivery_date );
	?>

	<!-- BEGIN GCR Badge Code -->
	<script src="https://apis.google.com/js/platform.js?onload=renderBadge" async defer>
	</script>

	<script>
		window.renderBadge = function() {
			var ratingBadgeContainer = document.createElement("div");
			document.body.appendChild(ratingBadgeContainer);
			window.gapi.load('ratingbadge', function() {
				window.gapi.ratingbadge.render(
					ratingBadgeContainer, {
						"merchant_id": <?php echo $merchant_id; ?>,
						"position": "BOTTOM_LEFT"
					});
			});
		}
	</script>
	<!-- END GCR Badge Code -->	

	<!-- BEGIN GCR Opt-in Module Code -->
	<script src="https://apis.google.com/js/platform.js?onload=renderOptIn" async defer>
	</script>

	<script>
		console.log('pre renderOptIn');
		window.renderOptIn = function() { 
			console.log('renderOptIn');
			window.gapi.load('surveyoptin', function() {
				console.log('surveyoptin');
				window.gapi.surveyoptin.render(
				{
					"merchant_id": <?php echo $merchant_id; ?>,
					"order_id": "<?php echo $order_id; ?>",
					"email": "<?php echo $customer_email ?>",
					"delivery_country": "<?php echo $country_code ?>",
					"estimated_delivery_date": "<?php echo $estimated_delivery_date ?>",
					"opt_in_style": "CENTER_DIALOG"
				}); 
			});
		}
	</script>
	<!-- END GCR Opt-in Module Code -->

	<!-- BEGIN GCR Language Code -->
	<script>
	  window.___gcfg = {
	    lang: 'pt_BR'
	  };
	</script>
	<!-- END GCR Language Code -->
	<?php
}