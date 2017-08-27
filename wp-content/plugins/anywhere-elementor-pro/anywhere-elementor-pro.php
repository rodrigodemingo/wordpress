<?php
/**
 * Plugin Name: AnyWhere Elementor Pro
 * Description: Global layouts to use with shortcodes, global post layouts for single and archive pages. Supports CPT and ACF
 * Plugin URI: http://www.elementoraddons.com/anywhere-elementor-pro/
 * Author: WebTechStreet
 * Version: 2.2.1
 * Author URI: https://www.webtechstreet.com/shop
 * License:      GNU General Public License v2 or later
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: ae-pro
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'AE_PRO_URL', plugins_url( '/', __FILE__ ) );
define( 'AE_PRO_PATH', plugin_dir_path( __FILE__ ) );

add_action( 'plugins_loaded', 'ae_pro_load_plugin_textdomain' );

global $ae_template;
$ae_template = get_option( 'template' );

require( AE_PRO_PATH . 'includes/bootstrap.php' );

function ae_pro_load_plugin_textdomain(){
    load_plugin_textdomain( 'ae-pro' );
}