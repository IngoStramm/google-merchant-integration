<?php
/*
Plugin Name:  Google Merchant Integration
Plugin URI:   https://convertefacil.com.br
Description:  Plugin integrante da plataforma ConverteFácil. Não pode ser comercializado separadamente.
Version:      1.0.1
Author:       Ingo Stramm
Author URI:   https://convertefacil.com.br
Text Domain:  gmi
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

define( 'GMI_DIR', plugin_dir_path( __FILE__ ) );
define( 'GMI_URL', plugin_dir_url( __FILE__ ) );

// Verifica se os plugins necessários estão instalados
require_once 'tgmpa/tgmpa.php';
require_once 'general.php';
// require_once 'scripts.php';
require_once 'admin-settings.php';
require_once 'woocommerce.php';