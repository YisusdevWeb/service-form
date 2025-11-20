<?php
/**
 * Panel de administración para personalizar estilos del formulario
 */

add_action('admin_menu', 'fsf_add_styles_menu');

function fsf_add_styles_menu() {
    add_submenu_page(
        'fsf-informacion-de-usuario',
        __('Personalização de Estilos e Logo', 'funnel-services-form'),
        __('Estilos e Logo', 'funnel-services-form'),
        'manage_options',
        'fsf-styles-settings',
        'fsf_display_styles_settings_page'
    );
}

function fsf_display_styles_settings_page() {
    // Valores por defecto
    $defaults = [
        'bg_primary' => '#0a1929',
        'bg_secondary' => '#1e5a8e',
        'text_primary' => '#ffffff',
        'text_secondary' => '#e5e7eb',
        'title_color' => '#ffffff',
        'label_color' => '#ffffff',
        'input_bg' => '#ffffff',
        'input_text' => '#1f2937',
        'input_border' => '#3a7bc8',
        'button_bg' => '#1e5a8e',
        'button_text' => '#ffffff',
        'button_hover_bg' => '#2563eb',
        'glass_bg_opacity' => 0.08,
        'glass_blur' => 20,
    ];
    
    // Procesar guardado
    if (isset($_POST['fsf_styles_nonce']) && wp_verify_nonce($_POST['fsf_styles_nonce'], 'fsf_styles_settings')) {
        // Logo
        if (isset($_POST['logo_url'])) {
            update_option('fsf_logo_url', esc_url_raw($_POST['logo_url']));
        }
        
        // Colores - usar default si está vacío
        $color_options = [
            'bg_primary' => !empty($_POST['bg_primary']) ? sanitize_hex_color($_POST['bg_primary']) : $defaults['bg_primary'],
            'bg_secondary' => !empty($_POST['bg_secondary']) ? sanitize_hex_color($_POST['bg_secondary']) : $defaults['bg_secondary'],
            'text_primary' => !empty($_POST['text_primary']) ? sanitize_hex_color($_POST['text_primary']) : $defaults['text_primary'],
            'text_secondary' => !empty($_POST['text_secondary']) ? sanitize_hex_color($_POST['text_secondary']) : $defaults['text_secondary'],
            'title_color' => !empty($_POST['title_color']) ? sanitize_hex_color($_POST['title_color']) : $defaults['title_color'],
            'label_color' => !empty($_POST['label_color']) ? sanitize_hex_color($_POST['label_color']) : $defaults['label_color'],
            'input_bg' => !empty($_POST['input_bg']) ? sanitize_hex_color($_POST['input_bg']) : $defaults['input_bg'],
            'input_text' => !empty($_POST['input_text']) ? sanitize_hex_color($_POST['input_text']) : $defaults['input_text'],
            'input_border' => !empty($_POST['input_border']) ? sanitize_hex_color($_POST['input_border']) : $defaults['input_border'],
            'button_bg' => !empty($_POST['button_bg']) ? sanitize_hex_color($_POST['button_bg']) : $defaults['button_bg'],
            'button_text' => !empty($_POST['button_text']) ? sanitize_hex_color($_POST['button_text']) : $defaults['button_text'],
            'button_hover_bg' => !empty($_POST['button_hover_bg']) ? sanitize_hex_color($_POST['button_hover_bg']) : $defaults['button_hover_bg'],
            'glass_bg_opacity' => !empty($_POST['glass_bg_opacity']) ? floatval($_POST['glass_bg_opacity']) : $defaults['glass_bg_opacity'],
            'glass_blur' => !empty($_POST['glass_blur']) ? intval($_POST['glass_blur']) : $defaults['glass_blur'],
        ];
        
        update_option('fsf_custom_colors', $color_options);
        
        echo '<div class="notice notice-success is-dismissible"><p>' . __('Estilos atualizados com sucesso!', 'funnel-services-form') . '</p></div>';
    }
    
    // Valores por defecto (DEFAULT THEME)
    $default_colors = [
        'bg_primary' => '#0a1929',
        'bg_secondary' => '#1e5a8e',
        'text_primary' => '#ffffff',
        'text_secondary' => '#e5e7eb',
        'title_color' => '#ffffff',
        'label_color' => '#ffffff',
        'input_bg' => '#ffffff',
        'input_text' => '#1f2937',
        'input_border' => '#3a7bc8',
        'button_bg' => '#1e5a8e',
        'button_text' => '#ffffff',
        'button_hover_bg' => '#2563eb',
        'glass_bg_opacity' => 0.08,
        'glass_blur' => 20,
    ];
    
    // Obtener valores actuales
    $logo_url = get_option('fsf_logo_url', '');
    $colors = get_option('fsf_custom_colors', $default_colors);
    
    ?>
    <div class="wrap">
        <h1><?php _e('Personalização de Estilos e Logo', 'funnel-services-form'); ?></h1>
        <p><?php _e('Configure o logo e as cores do seu formulário. Use códigos hexadecimais para as cores.', 'funnel-services-form'); ?></p>
        
        <div style="margin: 20px 0; padding: 15px; background: #fff; border-left: 4px solid #2271b1;">
            <p><strong><?php _e('Dica:', 'funnel-services-form'); ?></strong> <?php _e('Deixe um campo vazio para usar o valor padrão do tema.', 'funnel-services-form'); ?></p>
            <button type="button" class="button button-secondary" id="fsf_reset_defaults" style="margin-top: 10px;">
                <span class="dashicons dashicons-image-rotate" style="margin-top: 3px;"></span>
                <?php _e('Restaurar Cores Padrão', 'funnel-services-form'); ?>
            </button>
        </div>
        
        <form method="post" action="">
            <?php wp_nonce_field('fsf_styles_settings', 'fsf_styles_nonce'); ?>
            
            <h2><?php _e('Logo do Formulário', 'funnel-services-form'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label><?php _e('Logo Atual', 'funnel-services-form'); ?></label></th>
                    <td>
                        <div class="fsf-logo-preview" style="margin-bottom: 10px;">
                            <?php if ($logo_url): ?>
                                <img src="<?php echo esc_url($logo_url); ?>" style="max-width: 200px; height: auto; display: block; margin-bottom: 10px;" id="fsf-logo-preview" />
                            <?php else: ?>
                                <img src="" style="max-width: 200px; height: auto; display: none; margin-bottom: 10px;" id="fsf-logo-preview" />
                                <p id="fsf-no-logo"><?php _e('Nenhum logo carregado', 'funnel-services-form'); ?></p>
                            <?php endif; ?>
                        </div>
                        <input type="hidden" name="logo_url" id="fsf_logo_url" value="<?php echo esc_attr($logo_url); ?>" />
                        <button type="button" class="button" id="fsf_upload_logo_button"><?php _e('Selecionar Logo da Biblioteca', 'funnel-services-form'); ?></button>
                        <?php if ($logo_url): ?>
                            <button type="button" class="button" id="fsf_remove_logo_button" style="margin-left: 10px;"><?php _e('Remover Logo', 'funnel-services-form'); ?></button>
                        <?php endif; ?>
                        <p class="description"><?php _e('Formatos aceitos: PNG, JPG, SVG. Tamanho recomendado: 300x80px', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Cores do Tema', 'funnel-services-form'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="bg_primary"><?php _e('Cor de Fundo Principal', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="bg_primary" id="bg_primary" value="<?php echo esc_attr($colors['bg_primary']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor de fundo do formulário (gradient início)', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="bg_secondary"><?php _e('Cor de Fundo Secundária', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="bg_secondary" id="bg_secondary" value="<?php echo esc_attr($colors['bg_secondary']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor de fundo (gradient fim)', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="title_color"><?php _e('Cor dos Títulos', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="title_color" id="title_color" value="<?php echo esc_attr($colors['title_color']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor dos títulos principais (h1, h2, h3)', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="text_primary"><?php _e('Cor do Texto Principal', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="text_primary" id="text_primary" value="<?php echo esc_attr($colors['text_primary']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor do texto principal do formulário', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="text_secondary"><?php _e('Cor do Texto Secundário', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="text_secondary" id="text_secondary" value="<?php echo esc_attr($colors['text_secondary']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor do texto secundário (descrições, ajudas)', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="label_color"><?php _e('Cor dos Labels (Campos)', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="label_color" id="label_color" value="<?php echo esc_attr($colors['label_color']); ?>" class="fsf-color-picker" />
                        <p class="description"><?php _e('Cor dos labels dos campos de formulário', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Campos de Input', 'funnel-services-form'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="input_bg"><?php _e('Cor de Fundo dos Inputs', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="input_bg" id="input_bg" value="<?php echo esc_attr($colors['input_bg']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="input_text"><?php _e('Cor do Texto dos Inputs', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="input_text" id="input_text" value="<?php echo esc_attr($colors['input_text']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="input_border"><?php _e('Cor da Borda dos Inputs', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="input_border" id="input_border" value="<?php echo esc_attr($colors['input_border']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Botões', 'funnel-services-form'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="button_bg"><?php _e('Cor de Fundo do Botão', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="button_bg" id="button_bg" value="<?php echo esc_attr($colors['button_bg']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="button_text"><?php _e('Cor do Texto do Botão', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="button_text" id="button_text" value="<?php echo esc_attr($colors['button_text']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="button_hover_bg"><?php _e('Cor do Botão (Hover)', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="text" name="button_hover_bg" id="button_hover_bg" value="<?php echo esc_attr($colors['button_hover_bg']); ?>" class="fsf-color-picker" />
                    </td>
                </tr>
            </table>
            
            <h2><?php _e('Efeito Glassmorphism', 'funnel-services-form'); ?></h2>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="glass_bg_opacity"><?php _e('Opacidade do Fundo Glass', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="number" name="glass_bg_opacity" id="glass_bg_opacity" value="<?php echo esc_attr($colors['glass_bg_opacity']); ?>" step="0.01" min="0" max="1" />
                        <p class="description"><?php _e('Valor entre 0 e 1 (ex: 0.05)', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="glass_blur"><?php _e('Intensidade do Blur (px)', 'funnel-services-form'); ?></label></th>
                    <td>
                        <input type="number" name="glass_blur" id="glass_blur" value="<?php echo esc_attr($colors['glass_blur']); ?>" min="0" max="50" />
                        <p class="description"><?php _e('Valor entre 0 e 50 pixels', 'funnel-services-form'); ?></p>
                    </td>
                </tr>
            </table>
            
            <?php submit_button(__('Guardar Configurações', 'funnel-services-form')); ?>
        </form>
    </div>
    
    <style>
        .fsf-color-picker {
            width: 100px;
        }
    </style>
    <?php
}

// Enqueue WordPress color picker and media uploader
add_action('admin_enqueue_scripts', 'fsf_enqueue_color_picker');
function fsf_enqueue_color_picker($hook_suffix) {
    if ($hook_suffix === 'informações-do-utilizador_page_fsf-styles-settings') {
        // Color picker
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_script('wp-color-picker');
        
        // Media uploader
        wp_enqueue_media();
        
        // Custom script para el selector de medios y reset
        wp_add_inline_script('wp-color-picker', "
            jQuery(document).ready(function($) {
                // Valores por defecto
                var defaultColors = {
                    'bg_primary': '#0a1929',
                    'bg_secondary': '#1e5a8e',
                    'text_primary': '#ffffff',
                    'text_secondary': '#e5e7eb',
                    'title_color': '#ffffff',
                    'label_color': '#ffffff',
                    'input_bg': '#ffffff',
                    'input_text': '#1f2937',
                    'input_border': '#3a7bc8',
                    'button_bg': '#1e5a8e',
                    'button_text': '#ffffff',
                    'button_hover_bg': '#2563eb',
                    'glass_bg_opacity': '0.08',
                    'glass_blur': '20'
                };
                
                // Inicializar color pickers
                $('.fsf-color-picker').wpColorPicker();
                
                // Botón de reset a valores por defecto
                $('#fsf_reset_defaults').on('click', function(e) {
                    e.preventDefault();
                    
                    if (confirm('¿Estás seguro de restaurar todos los colores a los valores por defecto?')) {
                        // Actualizar cada campo con el valor por defecto
                        $.each(defaultColors, function(key, value) {
                            var field = $('#' + key);
                            if (field.hasClass('fsf-color-picker')) {
                                field.wpColorPicker('color', value);
                            } else {
                                field.val(value);
                            }
                        });
                        
                        alert('Colores restaurados. Haz clic en \"Guardar Cambios\" para aplicar.');
                    }
                });
                
                // Media uploader para logo
                var mediaUploader;
                
                $('#fsf_upload_logo_button').on('click', function(e) {
                    e.preventDefault();
                    
                    if (mediaUploader) {
                        mediaUploader.open();
                        return;
                    }
                    
                    mediaUploader = wp.media({
                        title: 'Selecionar Logo',
                        button: {
                            text: 'Usar esta imagem'
                        },
                        multiple: false,
                        library: {
                            type: 'image'
                        }
                    });
                    
                    mediaUploader.on('select', function() {
                        var attachment = mediaUploader.state().get('selection').first().toJSON();
                        $('#fsf_logo_url').val(attachment.url);
                        $('#fsf-logo-preview').attr('src', attachment.url).show();
                        $('#fsf-no-logo').hide();
                        
                        // Mostrar botón de remover si no existe
                        if ($('#fsf_remove_logo_button').length === 0) {
                            $('#fsf_upload_logo_button').after('<button type=\"button\" class=\"button\" id=\"fsf_remove_logo_button\" style=\"margin-left: 10px;\">Remover Logo</button>');
                        }
                    });
                    
                    mediaUploader.open();
                });
                
                // Remover logo
                $(document).on('click', '#fsf_remove_logo_button', function(e) {
                    e.preventDefault();
                    $('#fsf_logo_url').val('');
                    $('#fsf-logo-preview').attr('src', '').hide();
                    $('#fsf-no-logo').show();
                    $(this).remove();
                });
            });
        ");
    }
}

// Generar CSS personalizado dinámicamente
add_action('wp_head', 'fsf_inject_custom_styles', 100);
function fsf_inject_custom_styles() {
    // Defaults
    $defaults = [
        'bg_primary' => '#0a1929',
        'bg_secondary' => '#1e5a8e',
        'text_primary' => '#ffffff',
        'text_secondary' => '#e5e7eb',
        'title_color' => '#ffffff',
        'label_color' => '#ffffff',
        'input_bg' => '#ffffff',
        'input_text' => '#1f2937',
        'input_border' => '#3a7bc8',
        'button_bg' => '#1e5a8e',
        'button_text' => '#ffffff',
        'button_hover_bg' => '#2563eb',
        'glass_bg_opacity' => 0.08,
        'glass_blur' => 20,
    ];
    
    $colors = get_option('fsf_custom_colors', $defaults);
    $logo_url = get_option('fsf_logo_url', '');
    
    // Convertir hex a rgba para glassmorphism
    $glass_opacity = $colors['glass_bg_opacity'];
    
    ?>
    <style id="fsf-custom-styles">
        :root {
            --bg-color: <?php echo esc_attr($colors['bg_primary']); ?>;
            --bg-gradient: linear-gradient(135deg, <?php echo esc_attr($colors['bg_primary']); ?> 0%, <?php echo esc_attr($colors['bg_secondary']); ?> 100%);
            --assistant-color: rgba(255, 255, 255, <?php echo esc_attr($glass_opacity); ?>);
            --heading-color: <?php echo esc_attr($colors['title_color']); ?>;
            --font-color: <?php echo esc_attr($colors['text_primary']); ?>;
            --font-color-secondary: <?php echo esc_attr($colors['text_secondary']); ?>;
            --label-color: <?php echo esc_attr($colors['label_color']); ?>;
            --theme-color: <?php echo esc_attr($colors['button_bg']); ?>;
            --theme-color-darken: <?php echo esc_attr($colors['button_hover_bg']); ?>;
            --theme-color-light: <?php echo esc_attr($colors['input_border']); ?>;
            --border-color: rgba(255, 255, 255, 0.1);
            --glass-bg: rgba(255, 255, 255, <?php echo esc_attr($glass_opacity); ?>);
            --glass-border: rgba(255, 255, 255, 0.15);
            --shadow-color: rgba(0, 0, 0, 0.3);
            --input-bg: <?php echo esc_attr($colors['input_bg']); ?>;
            --input-text: <?php echo esc_attr($colors['input_text']); ?>;
            --input-border: <?php echo esc_attr($colors['input_border']); ?>;
            --button-text: <?php echo esc_attr($colors['button_text']); ?>;
        }
        
        .form-paper,
        .tab-panel {
            backdrop-filter: blur(<?php echo esc_attr($colors['glass_blur']); ?>px) saturate(180%);
            -webkit-backdrop-filter: blur(<?php echo esc_attr($colors['glass_blur']); ?>px) saturate(180%);
        }
        
        /* Estilos para inputs */
        .MuiInputBase-root input,
        .MuiInputBase-root textarea {
            background-color: var(--input-bg) !important;
            color: var(--input-text) !important;
        }
        
        .MuiOutlinedInput-root {
            background-color: var(--input-bg) !important;
        }
        
        .MuiOutlinedInput-notchedOutline {
            border-color: var(--input-border) !important;
        }
        
        /* Logo personalizado */
        <?php if ($logo_url): ?>
        .logo-container img {
            content: url('<?php echo esc_url($logo_url); ?>');
        }
        <?php endif; ?>
    </style>
    <?php
}
