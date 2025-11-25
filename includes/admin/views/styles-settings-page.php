<?php
/**
 * Vista HTML para la página de estilos
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;
?>
<div class="wrap">
    <h1><?php _e('Personalização de Estilos e Logo', 'funnel-services-form'); ?></h1>
    
    <!-- Templates de colores -->
    <h2><?php _e('🎨 Templates de Cores', 'funnel-services-form'); ?></h2>
    <div class="fsf-templates-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; margin: 20px 0;">
        <?php foreach ($color_templates as $template_id => $template): ?>
            <div class="fsf-template-card <?php echo $active_template === $template_id ? 'active' : ''; ?>" 
                 data-template="<?php echo esc_attr($template_id); ?>"
                 data-colors='<?php echo esc_attr(json_encode($template['colors'])); ?>'
                 style="cursor: pointer; border: 2px solid <?php echo $active_template === $template_id ? '#2271b1' : '#ddd'; ?>; border-radius: 12px; padding: 15px; text-align: center; background: linear-gradient(135deg, <?php echo esc_attr($template['colors']['bg_primary']); ?> 0%, <?php echo esc_attr($template['colors']['bg_secondary']); ?> 100%);">
                <div style="color: <?php echo esc_attr($template['colors']['text_primary']); ?>; font-weight: 600;">
                    <?php echo esc_html($template['name']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <button type="button" class="button" id="fsf_reset_defaults"><?php _e('Restaurar Padrão', 'funnel-services-form'); ?></button>
    
    <hr style="margin: 30px 0;">
    
    <form method="post">
        <?php wp_nonce_field('fsf_styles_settings', 'fsf_styles_nonce'); ?>
        <input type="hidden" name="active_template" id="active_template" value="<?php echo esc_attr($active_template); ?>" />
        
        <!-- Logo -->
        <h2><?php _e('Logo', 'funnel-services-form'); ?></h2>
        <table class="form-table">
            <tr>
                <th><?php _e('Logo Atual', 'funnel-services-form'); ?></th>
                <td>
                    <img src="<?php echo esc_url($logo_url); ?>" id="fsf-logo-preview" style="max-width: 200px; <?php echo $logo_url ? '' : 'display:none;'; ?>" />
                    <p id="fsf-no-logo" <?php echo $logo_url ? 'style="display:none;"' : ''; ?>><?php _e('Sem logo', 'funnel-services-form'); ?></p>
                    <input type="hidden" name="logo_url" id="fsf_logo_url" value="<?php echo esc_attr($logo_url); ?>" />
                    <button type="button" class="button" id="fsf_upload_logo_button"><?php _e('Selecionar', 'funnel-services-form'); ?></button>
                    <button type="button" class="button" id="fsf_remove_logo_button"><?php _e('Remover', 'funnel-services-form'); ?></button>
                </td>
            </tr>
            <tr>
                <th><?php _e('Tamanho Máximo', 'funnel-services-form'); ?></th>
                <td>
                    <input type="number" name="logo_max_width" value="<?php echo esc_attr(get_option('fsf_logo_max_width', 200)); ?>" min="50" max="500" style="width:80px;" /> x
                    <input type="number" name="logo_max_height" value="<?php echo esc_attr(get_option('fsf_logo_max_height', 80)); ?>" min="30" max="200" style="width:80px;" /> px
                </td>
            </tr>
        </table>
        
        <!-- Colores -->
        <h2><?php _e('Cores', 'funnel-services-form'); ?></h2>
        <table class="form-table">
            <?php
            $color_fields = [
                'bg_primary' => __('Fundo Principal', 'funnel-services-form'),
                'bg_secondary' => __('Fundo Secundário', 'funnel-services-form'),
                'title_color' => __('Títulos', 'funnel-services-form'),
                'text_primary' => __('Texto Principal', 'funnel-services-form'),
                'text_secondary' => __('Texto Secundário', 'funnel-services-form'),
                'label_color' => __('Labels', 'funnel-services-form'),
                'theme_color_light' => __('Cor Tema', 'funnel-services-form'),
                'input_text' => __('Texto Input', 'funnel-services-form'),
                'input_border' => __('Borda Input', 'funnel-services-form'),
                'button_bg' => __('Botão', 'funnel-services-form'),
                'button_text' => __('Texto Botão', 'funnel-services-form'),
                'button_hover_bg' => __('Botão Hover', 'funnel-services-form'),
            ];
            foreach ($color_fields as $field => $label): ?>
            <tr>
                <th><label for="<?php echo $field; ?>"><?php echo $label; ?></label></th>
                <td><input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo esc_attr($colors[$field]); ?>" class="fsf-color-picker" /></td>
            </tr>
            <?php endforeach; ?>
        </table>
        
        <!-- Glassmorphism -->
        <h2><?php _e('Glassmorphism', 'funnel-services-form'); ?></h2>
        <table class="form-table">
            <tr>
                <th><?php _e('Opacidade', 'funnel-services-form'); ?></th>
                <td><input type="number" name="glass_bg_opacity" value="<?php echo esc_attr($colors['glass_bg_opacity']); ?>" step="0.01" min="0" max="1" style="width:80px;" /></td>
            </tr>
            <tr>
                <th><?php _e('Blur (px)', 'funnel-services-form'); ?></th>
                <td><input type="number" name="glass_blur" value="<?php echo esc_attr($colors['glass_blur']); ?>" min="0" max="50" style="width:80px;" /></td>
            </tr>
        </table>
        
        <?php submit_button(__('Guardar', 'funnel-services-form')); ?>
    </form>
</div>

<style>
.fsf-template-card:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
.fsf-template-card.active { box-shadow: 0 0 0 3px rgba(34, 113, 177, 0.3); }
</style>

<script>
jQuery(document).ready(function($) {
    $('.fsf-template-card').on('click', function() {
        var colors = $(this).data('colors');
        var templateId = $(this).data('template');
        
        $('.fsf-template-card').removeClass('active').css('border-color', '#ddd');
        $(this).addClass('active').css('border-color', '#2271b1');
        $('#active_template').val(templateId);
        
        $.each(colors, function(key, value) {
            var field = $('#' + key);
            if (field.hasClass('fsf-color-picker')) {
                field.wpColorPicker('color', value);
            } else {
                field.val(value);
            }
        });
    });
});
</script>
