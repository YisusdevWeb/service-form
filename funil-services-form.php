<?php
/*
*Plugin Name: Funnel-services-form
*Description: Plugin for services form with steps.
*Version: 1.0.2
*Author: Yisus_Dev
 * Author URI: https://enlaweb.co/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: Funnel-services-form
*/



if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !defined('FSF_PLUGIN_URL') ) {
  define( 'FSF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if( !defined('FSF_NS') ) {
  define( 'FSF_NS', 'Funnel-services-form' );
}

// Include settings page and fields
include 'includes/wp_postype.php';
// Include REST API routes 
include 'includes/wp_rest_api.php'; 
// Include admin menu 
include 'includes/wp_admin_menu.php';


include 'includes/acf/acf_fields.php';
include 'includes/acf/alert_acf_active.php';


// Include enqueue scripts functions
include 'includes/wp_enqueue_scripts.php';

// Include shortcode functions
include 'includes/wp_shortcode.php';


// Cargar las traducciones del plugin
function ffs_load_textdomain() {
  load_plugin_textdomain('Funnel-services-form', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'ffs_load_textdomain');