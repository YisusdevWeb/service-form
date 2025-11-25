<?php
/**
 * Plugin Name: EWEB - Funnel Services Form
 * Description: Multi-step services form plugin for quotations. Allows creating multi-phase forms with color and style customization.
 * Version: 1.4.3
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
    define( 'FSF_PLUGIN_VERSION', '1.4.3' );
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

// Textos del formulario admin
include FSF_PLUGIN_PATH . 'includes/admin/form-texts-admin.php';

// ACF integration
include FSF_PLUGIN_PATH . 'includes/acf/acf_fields.php';
include FSF_PLUGIN_PATH . 'includes/acf/alert_acf_active.php';

// Include enqueue scripts functions
include FSF_PLUGIN_PATH . 'includes/wp_enqueue_scripts.php';

// Include shortcode functions
include FSF_PLUGIN_PATH . 'includes/wp_shortcode.php';

// Include page templates
include FSF_PLUGIN_PATH . 'includes/wp_page_templates.php';

// Include internationalization for frontend
include FSF_PLUGIN_PATH . 'includes/wp_i18n_frontend.php';

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

/**
 * Debug translation function to check if strings are translating correctly.
 *
 * @since 1.4.3
 * @return void
 */
function fsf_debug_translations() {
    if ( ! current_user_can( 'manage_options' ) ) {
        return;
    }

    global $l10n;
    
    $current_locale = get_locale();
    $textdomain_loaded = is_textdomain_loaded( 'funnel-services-form' ) ? 'Yes' : 'No';
    
    // Check MO file path
    $mofile = WP_LANG_DIR . '/plugins/funnel-services-form-' . $current_locale . '.mo';
    $mofile_plugin = FSF_PLUGIN_PATH . 'languages/funnel-services-form-' . $current_locale . '.mo';
    
    $test_strings = [
        'Privacy Policy Link Settings',
        'Thank You Page Link',
        'Debug / Logs'
    ];

    echo '<div class="notice notice-warning"><p><strong>FSF Translation Debug:</strong></p>';
    echo '<p>Current Locale: ' . esc_html( $current_locale ) . '</p>';
    echo '<p>Textdomain Loaded: ' . esc_html( $textdomain_loaded ) . '</p>';
    echo '<p>MO Global: ' . (file_exists($mofile) ? 'EXISTS ('.filesize($mofile).' bytes)' : 'NOT FOUND') . '</p>';
    echo '<p>MO Plugin: ' . (file_exists($mofile_plugin) ? 'EXISTS ('.filesize($mofile_plugin).' bytes)' : 'NOT FOUND') . '</p>';
    echo '<p>Translation Object: ' . (isset($l10n['funnel-services-form']) ? 'LOADED' : 'NOT LOADED') . '</p>';
    echo '<ul>';
    foreach ( $test_strings as $string ) {
        $translated = __( $string, 'funnel-services-form' );
        echo '<li>' . esc_html( $string ) . ' → ' . esc_html( $translated ) . '</li>';
    }
    echo '</ul></div>';
}
add_action( 'admin_notices', 'fsf_debug_translations' );

