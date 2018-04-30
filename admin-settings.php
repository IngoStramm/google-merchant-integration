<?php
/**
 * This snippet has been updated to reflect the official supporting of options pages by CMB2
 * in version 2.2.5.
 *
 * If you are using the old version of the options-page registration,
 * it is recommended you swtich to this method.
 */
add_action( 'cmb2_admin_init', 'cgmi_admin_settings' );
/**
 * Hook in and register a metabox to handle a theme options page and adds a menu item.
 */
function cgmi_admin_settings() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box( array(
		'id'           => 'gmi_option_metabox',
		'title'        => esc_html__( 'Google Merchant Integration', 'gmi' ),
		'object_types' => array( 'options-page' ),

		/*
		 * The following parameters are specific to the options-page box
		 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
		 */

		'option_key'      => 'gmi_options', // The option key and admin menu page slug.
		// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
		// 'menu_title'      => esc_html__( 'Options', 'gmi' ), // Falls back to 'title' (above).
		// 'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
		'capability'      => 'manage_options', // Cap required to view options-page.
		// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
		// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
		// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
		// 'save_button'     => esc_html__( 'Save Theme Options', 'gmi' ), // The text for the options-page save button. Defaults to 'Save'.
	) );

	/*
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

	$cmb_options->add_field( array(
		'name' => __( 'Código da sua loja no Google Merchant Center', 'gmi' ),
		'desc' => __( 'Insira seu <code>merchant_id</code> no campo acima. Acesse a sua conta no <a href="https://merchants.google.com" target="_blank">Google Merchant Center</a> para descobrir o código da sua loja.', 'gmi' ),
		'id'   => 'google_merchant_id',
		'type' => 'text',
	) );

	$cmb_options->add_field( array(
		'name' => __( 'Número de dias padrão para estimativa de entrega do pedido', 'gmi' ),
		'desc' => __( 'O Google Merchant Center precisa de uma estimativa de dias para entrega do pedido. Selecione um número de dias para uma estimativa padrão (será usada quando não for possível encontrar a estimativa de dias do método de entrega escolhido pelo cliente).', 'gmi' ),
		'id'   => 'gmi_default_estimated_delivery',
		'type' => 'text',
		'attributes' => array(
			'type' => 'number',
			'pattern' => '\d*',
		),
		'sanitization_cb' => 'absint',
    	'escape_cb'       => 'absint',
	) );

}

/**
 * Wrapper function around cmb2_get_option
 * @since  0.1.0
 * @param  string $key     Options array key
 * @param  mixed  $default Optional default value
 * @return mixed           Option value
 */
function gmi_get_option( $key = '', $default = false ) {
	if ( function_exists( 'cmb2_get_option' ) ) {
		// Use cmb2_get_option as it passes through some key filters.
		return cmb2_get_option( 'gmi_options', $key, $default );
	}

	// Fallback to get_option if CMB2 is not loaded yet.
	$opts = get_option( 'gmi_options', $default );

	$val = $default;

	if ( 'all' == $key ) {
		$val = $opts;
	} elseif ( is_array( $opts ) && array_key_exists( $key, $opts ) && false !== $opts[ $key ] ) {
		$val = $opts[ $key ];
	}

	return $val;
}