<?php
/**
 * Vista HTML para la página de estilos
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;
?>
<div class="wrap fsf-admin-wrap">
    <!-- Header -->
    <div class="fsf-admin-header">
        <div class="fsf-admin-header-content">
            <h1><span class="dashicons dashicons-art"></span> <?php _e('Personalização de Estilos e Logo', 'funnel-services-form'); ?></h1>
            <p class="fsf-admin-subtitle"><?php _e('Personalize a aparência do formulário de serviços', 'funnel-services-form'); ?></p>
        </div>
        <?php
        $fsf_active_name = isset($color_templates[$active_template]) && !empty($color_templates[$active_template]['name']) ? $color_templates[$active_template]['name'] : $active_template;
        ?>
        <div class="fsf-admin-badge">
            <span class="fsf-badge-label"><?php _e('Plantilla activa', 'funnel-services-form'); ?></span>
            <span class="fsf-badge-value"><?php echo esc_html($fsf_active_name); ?></span>
        </div>
    </div>

    <?php if (!empty($show_success)): ?>
    <div class="fsf-success-message">
        <span class="dashicons dashicons-yes-alt"></span>
        <span><?php _e('Estilos atualizados com sucesso!', 'funnel-services-form'); ?></span>
        <button type="button" class="fsf-dismiss-notice">&times;</button>
    </div>
    <?php endif; ?>

    <div class="fsf-admin-content">
        <!-- Templates de colores -->
        <div class="fsf-admin-card">
            <div class="fsf-card-header">
                <h2><span class="dashicons dashicons-admin-customizer"></span> <?php _e('Templates de Cores', 'funnel-services-form'); ?></h2>
                <button type="button" class="button button-secondary" id="fsf_reset_defaults">
                    <span class="dashicons dashicons-image-rotate"></span> <?php _e('Restaurar Padrão', 'funnel-services-form'); ?>
                </button>
            </div>
            <div class="fsf-templates-grid">
                <?php foreach ($color_templates as $template_id => $template): ?>
                    <div class="fsf-template-card <?php echo $active_template === $template_id ? 'active' : ''; ?>" 
                         data-template="<?php echo esc_attr($template_id); ?>"
                         data-colors='<?php echo esc_attr(json_encode($template['colors'])); ?>'
                         data-bg-primary="<?php echo esc_attr($template['colors']['bg_primary']); ?>"
                         data-bg-secondary="<?php echo esc_attr($template['colors']['bg_secondary']); ?>"
                         data-text-primary="<?php echo esc_attr($template['colors']['text_primary']); ?>">
                        <div class="fsf-template-name">
                            <?php echo esc_html($template['name']); ?>
                        </div>
                        <div class="fsf-template-check"><span class="dashicons dashicons-yes-alt"></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <form method="post">
            <?php wp_nonce_field('fsf_styles_settings', 'fsf_styles_nonce'); ?>
            <input type="hidden" name="active_template" id="active_template" value="<?php echo esc_attr($active_template); ?>" />

            <div class="fsf-admin-grid">
                <!-- Logo Card -->
                <div class="fsf-admin-card">
                    <div class="fsf-card-header">
                        <h2><span class="dashicons dashicons-format-image"></span> <?php _e('Logo', 'funnel-services-form'); ?></h2>
                    </div>
                    <div class="fsf-card-body">
                        <div class="fsf-logo-preview-container">
                            <img src="<?php echo esc_url($logo_url); ?>" id="fsf-logo-preview" class="fsf-logo-preview <?php echo $logo_url ? '' : 'hidden'; ?>" />
                            <div id="fsf-no-logo" class="fsf-no-logo <?php echo $logo_url ? 'hidden' : ''; ?>">
                                <span class="dashicons dashicons-format-image"></span>
                                <p><?php _e('Sem logo', 'funnel-services-form'); ?></p>
                            </div>
                        </div>
                        <input type="hidden" name="logo_url" id="fsf_logo_url" value="<?php echo esc_attr($logo_url); ?>" />
                        <div class="fsf-logo-actions">
                            <button type="button" class="button button-primary" id="fsf_upload_logo_button">
                                <span class="dashicons dashicons-upload"></span> <?php _e('Selecionar', 'funnel-services-form'); ?>
                            </button>
                            <button type="button" class="button button-secondary" id="fsf_remove_logo_button">
                                <span class="dashicons dashicons-trash"></span> <?php _e('Remover', 'funnel-services-form'); ?>
                            </button>
                        </div>
                        <div class="fsf-logo-size">
                            <label><?php _e('Tamanho Máximo', 'funnel-services-form'); ?></label>
                            <div class="fsf-size-inputs">
                                <input type="number" name="logo_max_width" value="<?php echo esc_attr(get_option('fsf_logo_max_width', 200)); ?>" min="50" max="500" /> 
                                <span>×</span>
                                <input type="number" name="logo_max_height" value="<?php echo esc_attr(get_option('fsf_logo_max_height', 80)); ?>" min="30" max="200" />
                                <span>px</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Glassmorphism Card -->
                <div class="fsf-admin-card">
                    <div class="fsf-card-header">
                        <h2><span class="dashicons dashicons-visibility"></span> <?php _e('Glassmorphism', 'funnel-services-form'); ?></h2>
                    </div>
                    <div class="fsf-card-body">
                        <div class="fsf-glass-preview" id="fsf-glass-preview"
                             data-opacity="<?php echo esc_attr($colors['glass_bg_opacity']); ?>"
                             data-blur="<?php echo esc_attr($colors['glass_blur']); ?>">
                            <div class="fsf-glass-bg" id="fsf-glass-bg"></div>
                            <div class="fsf-glass-content">
                                <span class="dashicons dashicons-admin-appearance"></span>
                                <p><?php _e('Vista previa', 'funnel-services-form'); ?></p>
                            </div>
                        </div>
                        <div class="fsf-glass-controls">
                            <div class="fsf-control-group">
                                <label for="glass_bg_opacity"><?php _e('Opacidade', 'funnel-services-form'); ?></label>
                                <input type="range" id="glass_bg_opacity_range" min="0" max="1" step="0.01" value="<?php echo esc_attr($colors['glass_bg_opacity']); ?>" />
                                <input type="number" name="glass_bg_opacity" id="glass_bg_opacity" value="<?php echo esc_attr($colors['glass_bg_opacity']); ?>" step="0.01" min="0" max="1" />
                            </div>
                            <div class="fsf-control-group">
                                <label for="glass_blur"><?php _e('Blur (px)', 'funnel-services-form'); ?></label>
                                <input type="range" id="glass_blur_range" min="0" max="50" step="1" value="<?php echo esc_attr($colors['glass_blur']); ?>" />
                                <input type="number" name="glass_blur" id="glass_blur" value="<?php echo esc_attr($colors['glass_blur']); ?>" min="0" max="50" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colores Card -->
            <div class="fsf-admin-card fsf-colors-card">
                <div class="fsf-card-header">
                    <h2><span class="dashicons dashicons-admin-appearance"></span> <?php _e('Cores', 'funnel-services-form'); ?></h2>
                </div>
                <div class="fsf-card-body">
                    <div class="fsf-colors-grid">
                        <?php
                        $color_fields = [
                            'bg_primary' => ['label' => __('Fundo Principal', 'funnel-services-form'), 'icon' => 'format-image'],
                            'bg_secondary' => ['label' => __('Fundo Secundário', 'funnel-services-form'), 'icon' => 'format-image'],
                            'title_color' => ['label' => __('Títulos', 'funnel-services-form'), 'icon' => 'heading'],
                            'text_primary' => ['label' => __('Texto Principal', 'funnel-services-form'), 'icon' => 'editor-textcolor'],
                            'text_secondary' => ['label' => __('Texto Secundário', 'funnel-services-form'), 'icon' => 'editor-textcolor'],
                            'label_color' => ['label' => __('Labels', 'funnel-services-form'), 'icon' => 'tag'],
                            'theme_color_light' => ['label' => __('Cor Tema', 'funnel-services-form'), 'icon' => 'art'],
                            'input_text' => ['label' => __('Texto Input', 'funnel-services-form'), 'icon' => 'edit'],
                            'input_border' => ['label' => __('Borda Input', 'funnel-services-form'), 'icon' => 'forms'],
                            'button_bg' => ['label' => __('Botão', 'funnel-services-form'), 'icon' => 'button'],
                            'button_text' => ['label' => __('Texto Botão', 'funnel-services-form'), 'icon' => 'editor-textcolor'],
                            'button_hover_bg' => ['label' => __('Botão Hover', 'funnel-services-form'), 'icon' => 'button'],
                        ];
                        foreach ($color_fields as $field => $config): ?>
                        <div class="fsf-color-field">
                            <label for="<?php echo $field; ?>">
                                <span class="dashicons dashicons-<?php echo $config['icon']; ?>"></span>
                                <?php echo $config['label']; ?>
                            </label>
                            <input type="text" name="<?php echo $field; ?>" id="<?php echo $field; ?>" value="<?php echo esc_attr($colors[$field]); ?>" class="fsf-color-picker" />
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="fsf-admin-footer">
                <?php submit_button(__('Guardar Alterações', 'funnel-services-form'), 'primary large', 'submit', false); ?>
            </div>
        </form>
    </div>
</div>

<style>
/* Admin Wrapper */
.fsf-admin-wrap { max-width: 1400px; margin: 0 auto; }

/* Success Message */
.fsf-success-message {
    display: flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: #fff;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    animation: fsf-slide-in 0.3s ease-out;
}
.fsf-success-message .dashicons {
    font-size: 24px;
    width: 24px;
    height: 24px;
}
.fsf-success-message span:not(.dashicons) {
    flex: 1;
    font-weight: 500;
    font-size: 14px;
}
.fsf-dismiss-notice {
    background: rgba(255,255,255,0.2);
    border: none;
    color: #fff;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 18px;
    line-height: 1;
    transition: background 0.2s ease;
}
.fsf-dismiss-notice:hover {
    background: rgba(255,255,255,0.3);
}
@keyframes fsf-slide-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header */
.fsf-admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 25px 30px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
}
.fsf-admin-header h1 { color: #fff; margin: 0; font-size: 24px; display: flex; align-items: center; gap: 10px; }
.fsf-admin-header h1 .dashicons { font-size: 28px; width: 28px; height: 28px; }
.fsf-admin-subtitle { margin: 5px 0 0; opacity: 0.9; font-size: 14px; }
.fsf-admin-badge {
    background: rgba(255,255,255,0.2);
    backdrop-filter: blur(10px);
    padding: 12px 20px;
    border-radius: 12px;
    text-align: center;
}
.fsf-badge-label { display: block; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; }
.fsf-badge-value { display: block; font-size: 16px; font-weight: 700; margin-top: 4px; }

/* Cards */
.fsf-admin-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    margin-bottom: 25px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
}
.fsf-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #f0f0f0;
    background: #fafbfc;
}
.fsf-card-header h2 { margin: 0; font-size: 16px; display: flex; align-items: center; gap: 8px; color: #1e1e1e; }
.fsf-card-header h2 .dashicons { color: #667eea; }
.fsf-card-body { padding: 25px; }

/* Grid */
.fsf-admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }

/* Templates Grid */
.fsf-templates-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 15px;
    padding: 20px 25px 25px;
}
.fsf-template-card {
    cursor: pointer;
    border-radius: 14px;
    padding: 20px 15px;
    text-align: center;
    border: 3px solid transparent;
    transition: all .2s ease;
    position: relative;
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.fsf-template-card:hover { transform: translateY(-4px); box-shadow: 0 12px 30px rgba(0,0,0,0.15); }
.fsf-template-card.active { border-color: #667eea; box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.2); }
.fsf-template-name { font-weight: 600; font-size: 14px; text-shadow: 0 1px 2px rgba(0,0,0,0.1); }
.fsf-template-check {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #667eea;
    color: #fff;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: none;
    align-items: center;
    justify-content: center;
}
.fsf-template-check .dashicons { font-size: 16px; width: 16px; height: 16px; }
.fsf-template-card.active .fsf-template-check { display: flex; }

/* Logo */
.fsf-logo-preview-container {
    background: linear-gradient(45deg, #f0f0f0 25%, transparent 25%), linear-gradient(-45deg, #f0f0f0 25%, transparent 25%), linear-gradient(45deg, transparent 75%, #f0f0f0 75%), linear-gradient(-45deg, transparent 75%, #f0f0f0 75%);
    background-size: 20px 20px;
    background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    min-height: 120px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    border: 2px dashed #ddd;
}
.fsf-logo-preview { max-width: 200px; max-height: 100px; }
.fsf-no-logo { text-align: center; color: #999; }
.fsf-no-logo .dashicons { font-size: 48px; width: 48px; height: 48px; opacity: 0.3; }
.fsf-no-logo p { margin: 10px 0 0; }
.hidden { display: none !important; }
.fsf-logo-actions { display: flex; gap: 10px; margin-bottom: 20px; }
.fsf-logo-actions .button { display: flex; align-items: center; gap: 5px; }
.fsf-logo-actions .dashicons { font-size: 16px; width: 16px; height: 16px; }
.fsf-logo-size label { display: block; font-weight: 600; margin-bottom: 8px; color: #555; }
.fsf-size-inputs { display: flex; align-items: center; gap: 8px; }
.fsf-size-inputs input { width: 80px; }
.fsf-size-inputs span { color: #999; }

/* Glassmorphism */
.fsf-glass-preview {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 12px;
    padding: 40px;
    position: relative;
    overflow: hidden;
    margin-bottom: 20px;
}
.fsf-glass-bg {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    height: 80%;
    background: rgba(255,255,255, 0.1);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.2);
}
.fsf-glass-content {
    position: relative;
    z-index: 1;
    text-align: center;
    color: #fff;
}
.fsf-glass-content .dashicons { font-size: 32px; width: 32px; height: 32px; opacity: 0.8; }
.fsf-glass-content p { margin: 8px 0 0; font-size: 13px; opacity: 0.9; }
.fsf-glass-controls { display: flex; flex-direction: column; gap: 15px; }
.fsf-control-group { display: flex; align-items: center; gap: 12px; }
.fsf-control-group label { min-width: 100px; font-weight: 500; color: #555; }
.fsf-control-group input[type="range"] { flex: 1; }
.fsf-control-group input[type="number"] { width: 70px; }

/* Colors Grid */
.fsf-colors-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}
.fsf-color-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.fsf-color-field label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
    color: #444;
    font-size: 13px;
}
.fsf-color-field label .dashicons { font-size: 16px; width: 16px; height: 16px; color: #667eea; }

/* Footer */
.fsf-admin-footer {
    background: #fff;
    border-radius: 16px;
    padding: 20px 25px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
}
.fsf-admin-footer .button-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    padding: 0 30px;
    height: 44px;
    font-size: 14px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    transition: all .2s ease;
}
.fsf-admin-footer .button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
}

/* Responsive */
@media (max-width: 782px) {
    .fsf-admin-header { flex-direction: column; gap: 15px; text-align: center; }
    .fsf-admin-grid { grid-template-columns: 1fr; }
    .fsf-colors-grid { grid-template-columns: 1fr; }
}
</style>
