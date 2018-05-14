<?php

add_action( 'init', 'gmi_scripts_init' );

function gmi_scripts_init() {

	add_action( 'wp_enqueue_scripts', 'gmi_scripts' );

	function gmi_scripts() {
		wp_enqueue_script( 'google-merchant-script-render-optin', 'https://apis.google.com/js/platform.js?onload=renderOptIn', null, false, false );
		wp_enqueue_script( 'google-merchant-script-render-badge', 'https://apis.google.com/js/platform.js?onload=renderBadge', null, false, false );
		wp_enqueue_script( 'gmi-script', GMI_URL . 'assets/js/gmi-script.js', array( 'jquery', 'google-merchant-script-render-optin', 'google-merchant-script-render-badge' ), '1.0.3', true );
	}

	add_filter( 'script_loader_tag', 'gmi_add_async_and_defer_attribute', 10, 2 );

	function gmi_add_async_and_defer_attribute( $tag, $handle ) {
	// add script handles to the array below
		$scripts_to_async = array( 'google-merchant-script-render-optin', 'google-merchant-script-render-badge' );

		foreach( $scripts_to_async as $async_script ) :

			if ( $async_script === $handle ) :
				return str_replace( ' src', ' async="async" defer="defer" src', $tag );
			endif;

		endforeach;

		return $tag;
	}

}