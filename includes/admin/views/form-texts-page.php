<?php
/**
 * Vista HTML para la página de textos del formulario
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;
?>
<div class="wrap fsf-admin-wrap">
    <!-- Header -->
    <div class="fsf-admin-header">
        <div class="fsf-admin-header-content">
            <h1><span class="dashicons dashicons-edit"></span> <?php _e('Form Texts', 'funnel-services-form'); ?></h1>
            <p class="fsf-admin-subtitle"><?php _e('Customize all texts of the initial form', 'funnel-services-form'); ?></p>
        </div>
        <button type="button" class="button fsf-reset-btn" id="fsf_reset_texts">
            <span class="dashicons dashicons-image-rotate"></span> <?php _e('Restore Default', 'funnel-services-form'); ?>
        </button>
    </div>

    <?php if (!empty($show_success)): ?>
    <div class="fsf-success-message">
        <span class="dashicons dashicons-yes-alt"></span>
        <span><?php _e('Texts updated successfully!', 'funnel-services-form'); ?></span>
        <button type="button" class="fsf-dismiss-notice">&times;</button>
    </div>
    <?php endif; ?>

    <form method="post">
        <?php wp_nonce_field('fsf_form_texts_settings', 'fsf_form_texts_nonce'); ?>

        <div class="fsf-admin-grid">
            <!-- Títulos Card -->
            <div class="fsf-admin-card">
                <div class="fsf-card-header">
                    <h2><span class="dashicons dashicons-heading"></span> <?php _e('Titles', 'funnel-services-form'); ?></h2>
                </div>
                <div class="fsf-card-body">
                    <div class="fsf-form-group">
                        <label for="form_title"><?php _e('Main Title', 'funnel-services-form'); ?></label>
                        <input type="text" name="form_title" id="form_title" value="<?php echo esc_attr($texts['form_title']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['form_title']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="form_subtitle"><?php _e('Subtitle', 'funnel-services-form'); ?></label>
                        <input type="text" name="form_subtitle" id="form_subtitle" value="<?php echo esc_attr($texts['form_subtitle']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['form_subtitle']); ?>" />
                    </div>
                </div>
            </div>

            <!-- Botón Card -->
            <div class="fsf-admin-card">
                <div class="fsf-card-header">
                    <h2><span class="dashicons dashicons-button"></span> <?php _e('Button', 'funnel-services-form'); ?></h2>
                </div>
                <div class="fsf-card-body">
                    <div class="fsf-form-group">
                        <label for="submit_button"><?php _e('Button Text', 'funnel-services-form'); ?></label>
                        <input type="text" name="submit_button" id="submit_button" value="<?php echo esc_attr($texts['submit_button']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['submit_button']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="error_message"><?php _e('Error Message', 'funnel-services-form'); ?></label>
                        <input type="text" name="error_message" id="error_message" value="<?php echo esc_attr($texts['error_message']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['error_message']); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Campo Nome Card -->
        <div class="fsf-admin-card">
            <div class="fsf-card-header">
                <h2><span class="dashicons dashicons-admin-users"></span> <?php _e('Name Field', 'funnel-services-form'); ?></h2>
            </div>
            <div class="fsf-card-body">
                <div class="fsf-form-grid">
                    <div class="fsf-form-group">
                        <label for="name_label"><?php _e('Label', 'funnel-services-form'); ?></label>
                        <input type="text" name="name_label" id="name_label" value="<?php echo esc_attr($texts['name_label']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['name_label']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="name_placeholder"><?php _e('Placeholder', 'funnel-services-form'); ?></label>
                        <input type="text" name="name_placeholder" id="name_placeholder" value="<?php echo esc_attr($texts['name_placeholder']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['name_placeholder']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="name_error_required"><?php _e('Error: Required field', 'funnel-services-form'); ?></label>
                        <input type="text" name="name_error_required" id="name_error_required" value="<?php echo esc_attr($texts['name_error_required']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['name_error_required']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="name_error_min"><?php _e('Error: Minimum characters', 'funnel-services-form'); ?></label>
                        <input type="text" name="name_error_min" id="name_error_min" value="<?php echo esc_attr($texts['name_error_min']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['name_error_min']); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Campo Email Card -->
        <div class="fsf-admin-card">
            <div class="fsf-card-header">
                <h2><span class="dashicons dashicons-email"></span> <?php _e('Email Field', 'funnel-services-form'); ?></h2>
            </div>
            <div class="fsf-card-body">
                <div class="fsf-form-grid">
                    <div class="fsf-form-group">
                        <label for="email_label"><?php _e('Label', 'funnel-services-form'); ?></label>
                        <input type="text" name="email_label" id="email_label" value="<?php echo esc_attr($texts['email_label']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['email_label']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="email_placeholder"><?php _e('Placeholder', 'funnel-services-form'); ?></label>
                        <input type="text" name="email_placeholder" id="email_placeholder" value="<?php echo esc_attr($texts['email_placeholder']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['email_placeholder']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="email_error_required"><?php _e('Error: Required field', 'funnel-services-form'); ?></label>
                        <input type="text" name="email_error_required" id="email_error_required" value="<?php echo esc_attr($texts['email_error_required']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['email_error_required']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="email_error_invalid"><?php _e('Error: Invalid email', 'funnel-services-form'); ?></label>
                        <input type="text" name="email_error_invalid" id="email_error_invalid" value="<?php echo esc_attr($texts['email_error_invalid']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['email_error_invalid']); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Campo WhatsApp Card -->
        <div class="fsf-admin-card">
            <div class="fsf-card-header">
                <h2><span class="dashicons dashicons-phone"></span> <?php _e('WhatsApp Field', 'funnel-services-form'); ?></h2>
            </div>
            <div class="fsf-card-body">
                <div class="fsf-form-grid">
                    <div class="fsf-form-group">
                        <label for="whatsapp_label"><?php _e('Label', 'funnel-services-form'); ?></label>
                        <input type="text" name="whatsapp_label" id="whatsapp_label" value="<?php echo esc_attr($texts['whatsapp_label']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['whatsapp_label']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="whatsapp_placeholder"><?php _e('Placeholder', 'funnel-services-form'); ?></label>
                        <input type="text" name="whatsapp_placeholder" id="whatsapp_placeholder" value="<?php echo esc_attr($texts['whatsapp_placeholder']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['whatsapp_placeholder']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="whatsapp_error_required"><?php _e('Error: Required field', 'funnel-services-form'); ?></label>
                        <input type="text" name="whatsapp_error_required" id="whatsapp_error_required" value="<?php echo esc_attr($texts['whatsapp_error_required']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['whatsapp_error_required']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="whatsapp_error_invalid"><?php _e('Error: Invalid WhatsApp', 'funnel-services-form'); ?></label>
                        <input type="text" name="whatsapp_error_invalid" id="whatsapp_error_invalid" value="<?php echo esc_attr($texts['whatsapp_error_invalid']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['whatsapp_error_invalid']); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Privacidad Card -->
        <div class="fsf-admin-card">
            <div class="fsf-card-header">
                <h2><span class="dashicons dashicons-shield"></span> <?php _e('Privacy Policy', 'funnel-services-form'); ?></h2>
            </div>
            <div class="fsf-card-body">
                <div class="fsf-form-grid">
                    <div class="fsf-form-group">
                        <label for="privacy_text"><?php _e('Text before link', 'funnel-services-form'); ?></label>
                        <input type="text" name="privacy_text" id="privacy_text" value="<?php echo esc_attr($texts['privacy_text']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['privacy_text']); ?>" />
                    </div>
                    <div class="fsf-form-group">
                        <label for="privacy_link_text"><?php _e('Link text', 'funnel-services-form'); ?></label>
                        <input type="text" name="privacy_link_text" id="privacy_link_text" value="<?php echo esc_attr($texts['privacy_link_text']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['privacy_link_text']); ?>" />
                    </div>
                    <div class="fsf-form-group fsf-full-width">
                        <label for="privacy_error"><?php _e('Error: Not accepted', 'funnel-services-form'); ?></label>
                        <input type="text" name="privacy_error" id="privacy_error" value="<?php echo esc_attr($texts['privacy_error']); ?>" class="fsf-input" data-default="<?php echo esc_attr($defaults['privacy_error']); ?>" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="fsf-admin-footer">
            <?php submit_button(__('Save Changes', 'funnel-services-form'), 'primary large', 'submit', false); ?>
        </div>
    </form>
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
.fsf-success-message .dashicons { font-size: 24px; width: 24px; height: 24px; }
.fsf-success-message span:not(.dashicons) { flex: 1; font-weight: 500; font-size: 14px; }
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
.fsf-dismiss-notice:hover { background: rgba(255,255,255,0.3); }
@keyframes fsf-slide-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Header */
.fsf-admin-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #fff;
    padding: 25px 30px;
    border-radius: 16px;
    margin-bottom: 25px;
    box-shadow: 0 10px 40px rgba(245, 158, 11, 0.3);
}
.fsf-admin-header h1 { color: #fff; margin: 0; font-size: 24px; display: flex; align-items: center; gap: 10px; }
.fsf-admin-header h1 .dashicons { font-size: 28px; width: 28px; height: 28px; }
.fsf-admin-subtitle { margin: 5px 0 0; opacity: 0.9; font-size: 14px; }
.fsf-reset-btn {
    background: rgba(255,255,255,0.2) !important;
    border: none !important;
    color: #fff !important;
    padding: 10px 20px !important;
    border-radius: 8px !important;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: background 0.2s ease !important;
}
.fsf-reset-btn:hover { background: rgba(255,255,255,0.3) !important; }
.fsf-reset-btn .dashicons { font-size: 16px; width: 16px; height: 16px; }

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
.fsf-card-header h2 .dashicons { color: #f59e0b; }
.fsf-card-body { padding: 25px; }

/* Grid */
.fsf-admin-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; }
.fsf-form-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; }
.fsf-full-width { grid-column: 1 / -1; }

/* Form Groups */
.fsf-form-group { display: flex; flex-direction: column; gap: 8px; }
.fsf-form-group label {
    font-weight: 600;
    color: #374151;
    font-size: 13px;
}
.fsf-input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.2s ease;
    background: #fff;
}
.fsf-input:focus {
    outline: none;
    border-color: #f59e0b;
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.1);
}
.fsf-input:hover { border-color: #d1d5db; }

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
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    border: none;
    padding: 0 30px;
    height: 44px;
    font-size: 14px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
    transition: all .2s ease;
}
.fsf-admin-footer .button-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.4);
}

/* Responsive */
@media (max-width: 782px) {
    .fsf-admin-header { flex-direction: column; gap: 15px; text-align: center; }
    .fsf-admin-grid { grid-template-columns: 1fr; }
    .fsf-form-grid { grid-template-columns: 1fr; }
}
</style>
