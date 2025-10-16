<?php


add_action('admin_menu', 'fsf_add_settings_menu');

function fsf_add_settings_menu()
{
    add_submenu_page(
        'fsf-informacion-de-usuario',
        __('Configuração de correio', 'funnel-services-form'),
        __('Configuração de correio', 'funnel-services-form'),
        'manage_options',
        'fsf-settings',
        'fsf_display_settings_page'
    );
}

function fsf_display_settings_page()
{
    if (isset($_POST['fsf_save_settings'])) {
        check_admin_referer('fsf_save_settings_verify');
        update_option('fsf_email_subject', sanitize_text_field($_POST['fsf_email_subject']));
        update_option('fsf_email_recipient', sanitize_email($_POST['fsf_email_recipient']));
        update_option('fsf_email_from', sanitize_email($_POST['fsf_email_from']));
        update_option('fsf_email_body', wp_kses_post($_POST['fsf_email_body']));
        echo '<div class="notice notice-success"><p>' . __('Configuração guardada.', 'funnel-services-form') . '</p></div>';
    }

    $email_subject = get_option('fsf_email_subject', __('Cotización de Serviços', 'funnel-services-form'));
    $email_recipient = get_option('fsf_email_recipient', get_option('admin_email'));
    $email_from = get_option('fsf_email_from', 'web@dappin.pt');
    $email_body = get_option('fsf_email_body', __('', 'funnel-services-form'));
?>
    <div class="wrap">
        <h1><?php _e('Configuração de correio', 'funnel-services-form'); ?></h1>
        <form method="post" action=""> <?php wp_nonce_field('fsf_save_settings_verify'); ?> <table class="form-table">
                <tr>
                    <th scope="row"><?php _e('Cabeçalho de correio', 'funnel-services-form'); ?></th>
                    <td><input type="text" name="fsf_email_subject" value="<?php echo esc_attr($email_subject); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Destino do correio', 'funnel-services-form'); ?></th>
                    <td><input type="email" name="fsf_email_recipient" value="<?php echo esc_attr($email_recipient); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Remetente do correio', 'funnel-services-form'); ?></th>
                    <td><input type="email" name="fsf_email_from" value="<?php echo esc_attr($email_from); ?>" class="regular-text" /></td>
                </tr>
                <tr>
                    <th scope="row"><?php _e('Corpo do correio', 'funnel-services-form'); ?></th>
                    <td><?php wp_editor($email_body, 'fsf_email_body', array('textarea_name' => 'fsf_email_body', 'media_buttons' => true, 'textarea_rows' => 10, 'teeny' => false, 'tinymce' => array('plugins' => 'wordpress, wplink, textcolor, wptextpattern, wpautoresize', 'toolbar1' => 'formatselect bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link', 'toolbar2' => 'forecolor backcolor | removeformat'))); ?></td>
                </tr>
            </table>
            <p class="submit"><button type="submit" name="fsf_save_settings" class="button button-primary"><?php _e('Guardar a configuração', 'funnel-services-form'); ?></button></p>
        </form>
    </div>
<?php
}
