<?php
/**
 * Plugin Name: EWEB - Funnel Services Form
 * Description: Plugin de formulário de serviços com etapas (steps) para cotações. Permite criar formulários de múltiplas fases com personalização de cores e estilos.
 * Version: 1.4.0
 * Author: Yisus Develop
 * Author URI: https://github.com/Yisus-Develop
 * Plugin URI: https://enlaweb.co/
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: funnel-services-form
 * Domain Path: /languages/
 * Requires at least: 6.0
 * Requires PHP: 8.1
 * Tested up to: 6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Plugin constants
if ( ! defined( 'FSF_PLUGIN_URL' ) ) {
    define( 'FSF_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'FSF_PLUGIN_PATH' ) ) {
    define( 'FSF_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'FSF_PLUGIN_VERSION' ) ) {
    define( 'FSF_PLUGIN_VERSION', '1.4.0' );
}

if ( ! defined( 'FSF_TEXT_DOMAIN' ) ) {
    define( 'FSF_TEXT_DOMAIN', 'funnel-services-form' );
}

// Legacy constant for backward compatibility
if ( ! defined( 'FSF_NS' ) ) {
    define( 'FSF_NS', 'funnel-services-form' );
}

// Include settings page and fields
include FSF_PLUGIN_PATH . 'includes/wp_postype.php';
// Include REST API routes 
include FSF_PLUGIN_PATH . 'includes/wp_rest_api.php'; 
// Include admin menu 
include FSF_PLUGIN_PATH . 'includes/wp_admin_menu.php';
include FSF_PLUGIN_PATH . 'includes/wp_admin_config_mail.php';

// Estilos admin (refactorizado)
include FSF_PLUGIN_PATH . 'includes/admin/styles-admin.php';

// ACF integration
include FSF_PLUGIN_PATH . 'includes/acf/acf_fields.php';
include FSF_PLUGIN_PATH . 'includes/acf/alert_acf_active.php';

// Include enqueue scripts functions
include FSF_PLUGIN_PATH . 'includes/wp_enqueue_scripts.php';

// Include shortcode functions
include FSF_PLUGIN_PATH . 'includes/wp_shortcode.php';

// Include page templates
include FSF_PLUGIN_PATH . 'includes/wp_page_templates.php';

/**
 * Load plugin textdomain for translations.
 *
 * @since 1.3.7
 * @return void
 */
function fsf_load_textdomain() {
    load_plugin_textdomain(
        'funnel-services-form',
        false,
        dirname( plugin_basename( __FILE__ ) ) . '/languages'
    );
}
add_action( 'plugins_loaded', 'fsf_load_textdomain' );

