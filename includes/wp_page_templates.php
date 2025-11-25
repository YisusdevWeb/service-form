<?php
/**
 * Registro de templates de página personalizados del plugin
 * Compatible con Gutenberg, FSE (Full Site Editing) y editor clásico
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Clase para manejar los templates del plugin
 */
class FSF_Page_Templates {

    /**
     * Templates disponibles
     */
    protected $templates = array();

    /**
     * Slug del template
     */
    const TEMPLATE_SLUG = 'fsf-fullscreen-form';

    /**
     * Instancia única
     */
    private static $instance;

    /**
     * Obtener instancia
     */
    public static function get_instance() {
        if ( null === self::$instance ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor
     */
    private function __construct() {
        $this->templates = array(
            self::TEMPLATE_SLUG => __( '🚀 Formulário Full Screen (Plugin)', 'funnel-services-form' ),
        );

        // Filtros para temas clásicos y Gutenberg
        add_filter( 'theme_page_templates', array( $this, 'add_templates' ), 10, 3 );
        add_filter( 'template_include', array( $this, 'load_template' ), 999 );
        
        // Para temas de bloques (FSE) - registrar el template
        add_action( 'init', array( $this, 'register_block_template' ), 20 );
        
        // Asegurar que el meta está disponible en REST API
        add_action( 'init', array( $this, 'register_template_post_meta' ), 10 );
        
        // Limpiar cache al activar/desactivar
        add_action( 'activated_plugin', array( $this, 'clear_template_cache' ) );
        add_action( 'deactivated_plugin', array( $this, 'clear_template_cache' ) );
        add_action( 'switch_theme', array( $this, 'clear_template_cache' ) );
    }

    /**
     * Registrar meta para REST API (Gutenberg)
     */
    public function register_template_post_meta() {
        register_post_meta( 'page', '_wp_page_template', array(
            'show_in_rest'  => true,
            'single'        => true,
            'type'          => 'string',
            'auth_callback' => function() {
                return current_user_can( 'edit_posts' );
            },
        ) );
    }

    /**
     * Registrar template para temas de bloques (FSE)
     */
    public function register_block_template() {
        // Solo si es un tema de bloques
        if ( ! wp_is_block_theme() ) {
            return;
        }

        // Registrar el template como un block template
        $template_content = '<!-- wp:shortcode -->[funil_services_form]<!-- /wp:shortcode -->';

        // Verificar si ya existe
        $existing = get_block_templates( array( 'slug__in' => array( self::TEMPLATE_SLUG ) ), 'wp_template' );
        
        if ( empty( $existing ) ) {
            // No podemos crear templates programáticamente en FSE de la misma forma
            // Pero podemos usar el filtro get_block_templates
            add_filter( 'get_block_templates', array( $this, 'add_block_template' ), 10, 3 );
        }
    }

    /**
     * Agregar template a la lista de block templates
     */
    public function add_block_template( $query_result, $query, $template_type ) {
        if ( 'wp_template' !== $template_type ) {
            return $query_result;
        }

        // Crear un objeto de template
        $template                 = new WP_Block_Template();
        $template->id             = 'funnel-services-form//' . self::TEMPLATE_SLUG;
        $template->theme          = 'funnel-services-form';
        $template->slug           = self::TEMPLATE_SLUG;
        $template->source         = 'plugin';
        $template->type           = 'wp_template';
        $template->title          = __( '🚀 Formulário Full Screen', 'funnel-services-form' );
        $template->description    = __( 'Template de página completa para el formulario de servicios', 'funnel-services-form' );
        $template->status         = 'publish';
        $template->has_theme_file = true;
        $template->is_custom      = true;
        $template->content        = '<!-- wp:shortcode -->[funil_services_form]<!-- /wp:shortcode -->';

        $query_result[] = $template;

        return $query_result;
    }

    /**
     * Agregar templates al dropdown (temas clásicos y Gutenberg)
     */
    public function add_templates( $templates, $theme = null, $post = null ) {
        // Merge con templates existentes
        return array_merge( $templates, $this->templates );
    }

    /**
     * Limpiar cache de templates
     */
    public function clear_template_cache() {
        // Limpiar cache del tema
        $cache_key = 'page_templates-' . md5( get_theme_root() . '/' . get_stylesheet() );
        wp_cache_delete( $cache_key, 'themes' );
        
        // Limpiar transients relacionados
        delete_transient( 'fsf_templates_registered' );
    }

    /**
     * Cargar el template cuando se solicita
     */
    public function load_template( $template ) {
        global $post;

        if ( ! $post || ! is_page() ) {
            return $template;
        }

        $page_template = get_post_meta( $post->ID, '_wp_page_template', true );

        // Verificar si es nuestro template (con o sin extensión)
        $is_our_template = ( 
            $page_template === self::TEMPLATE_SLUG || 
            $page_template === self::TEMPLATE_SLUG . '.php' ||
            strpos( $page_template, self::TEMPLATE_SLUG ) !== false
        );

        if ( ! $is_our_template ) {
            return $template;
        }

        // Buscar el archivo del template
        $plugin_template = FSF_PLUGIN_PATH . 'templates/fsf-fullscreen-form.php';

        if ( file_exists( $plugin_template ) ) {
            return $plugin_template;
        }

        return $template;
    }
}

// Inicializar
add_action( 'plugins_loaded', array( 'FSF_Page_Templates', 'get_instance' ) );

// Añadir clase al body cuando se usa el template fullscreen
add_filter( 'body_class', 'fsf_add_body_class' );
function fsf_add_body_class( $classes ) {
    global $post;
    
    if ( $post && is_page() ) {
        $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
        
        if ( strpos( $page_template, 'fsf-fullscreen-form' ) !== false ) {
            $classes[] = 'fsf-fullscreen-template';
        }
    }
    
    return $classes;
}
