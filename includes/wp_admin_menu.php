<?php

add_action('admin_menu', 'fsf_add_admin_menu');

function fsf_add_admin_menu() {
    add_menu_page(
        __('Informações do utilizador', 'funnel-services-form'),
        __('Informações do utilizador', 'funnel-services-form'),
        'manage_options',
        'fsf-informacion-de-usuario',
        'fsf_display_user_info_page',
        'dashicons-admin-users',
        9
    );
    add_submenu_page(
        null,
        __('Detalles de Usuario', 'funnel-services-form'),
        __('Detalles de Usuario', 'funnel-services-form'),
        'manage_options',
        'fsf-detalles-usuario',
        'fsf_display_user_details_page'
    );
}

function fsf_display_user_info_page() {
    ?>
    <div class="wrap">
        <h1><?php _e('Informações do utilizador', 'funnel-services-form'); ?></h1>
        <?php
        $args = array(
            'post_type' => 'user-info',
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);
        ?>
        <form method="post" action="<?php echo admin_url('admin-post.php?action=fsf_bulk_delete_user'); ?>">
            <?php wp_nonce_field('fsf_bulk_delete_user', 'fsf_bulk_delete_user_nonce'); ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th style="width: 40px;"><input type="checkbox" id="select-all"></th>
                        <th><?php _e('Nome', 'funnel-services-form'); ?></th>
                        <th><?php _e('Email', 'funnel-services-form'); ?></th>
                        <th><?php _e('Telefone', 'funnel-services-form'); ?></th>
                        <th><?php _e('Acções', 'funnel-services-form'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($posts as $post) : ?>
                        <tr>
                            <td><input type="checkbox" name="post_ids[]" value="<?php echo $post->ID; ?>"></td>
                            <td><?php echo esc_html(get_post_meta($post->ID, 'nombre', true)); ?></td>
                            <td><?php echo esc_html(get_post_meta($post->ID, 'email', true)); ?></td>
                            <td><?php echo esc_html(get_post_meta($post->ID, 'Telefone', true)); ?></td>
                            <td>
                                <a href="<?php echo admin_url('admin.php?page=fsf-detalles-usuario&post_id=' . $post->ID); ?>"><?php _e('Ver', 'funnel-services-form'); ?></a>
                                | 
                                <a href="<?php echo wp_nonce_url(admin_url('admin-post.php?action=fsf_delete_user&post_id=' . $post->ID), 'fsf_delete_user_' . $post->ID); ?>" onclick="return confirm('<?php _e('Tem a certeza de que pretende apagar este utilizador?', 'funnel-services-form'); ?>');"><?php _e('Apagar', 'funnel-services-form'); ?></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div style="margin-top: 10px;">
                <button type="submit" class="button button-primary" onclick="return confirm('<?php _e('Tem a certeza de que pretende eliminar os utilizadores selecionados?', 'funnel-services-form'); ?>');" style="margin-right: 10px;"><?php _e('Remover selecionados', 'funnel-services-form'); ?></button>
                <button type="button" class="button button-secondary" id="export-selected" style="margin-left: 10px;"><?php _e('Exportação selecionada', 'funnel-services-form'); ?></button>
            </div>
        </form>

        <form method="post" action="<?php echo admin_url('admin-post.php?action=fsf_export_user_info'); ?>" target="_blank">
            <?php wp_nonce_field('fsf_export_user_info', 'fsf_export_user_info_nonce'); ?>
            <input type="hidden" name="post_ids" id="export_post_ids">
        </form>
    </div>
    <script>
        document.getElementById('select-all').addEventListener('click', function(event) {
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="post_ids[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });

        document.getElementById('export-selected').addEventListener('click', function(event) {
            var selected = [];
            var checkboxes = document.querySelectorAll('input[type="checkbox"][name="post_ids[]"]:checked');
            for (var checkbox of checkboxes) {
                selected.push(checkbox.value);
            }
            document.getElementById('export_post_ids').value = selected.join(',');
            document.querySelector('form[action*="fsf_export_user_info"]').submit();
        });
    </script>
    <?php
}


function fsf_display_user_details_page() {
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    if (!$post_id) {
        echo '<div class="notice notice-error"><p>' . __('ID de publicação inválido', 'funnel-services-form') . '</p></div>';
        return;
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'user-info') {
        echo '<div class="notice notice-error"><p>' . __('Publicação não encontrada', 'funnel-services-form') . '</p></div>';
        return;
    }

    $nombre = get_post_meta($post->ID, 'nombre', true);
    $email = get_post_meta($post->ID, 'email', true);
    $whatsapp = get_post_meta($post->ID, 'Telefone', true);
    $services = maybe_unserialize(get_post_meta($post->ID, 'services', true));
    
    ?>
    <div class="wrap">
        <h1><?php _e('Dados do utilizador', 'funnel-services-form'); ?></h1>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Nome', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($nombre); ?></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Email', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($email); ?></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Telefone', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($whatsapp); ?></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Serviços selecionados', 'funnel-services-form'); ?></th>
                <td>
                    <?php
                    if (is_array($services)) {
                        foreach ($services as $serviceId => $serviceData) {
                            echo '<h4>' . esc_html($serviceData['serviceTitle']) . '</h4>';
                            foreach ($serviceData as $phaseId => $phaseData) {
                                if ($phaseId !== 'serviceTitle') {
                                    echo '<strong>' . esc_html($phaseData['phaseTitle']) . ':</strong><br>';
                                    echo '<ul>';
                                    foreach ($phaseData as $option => $selected) {
                                        if ($selected && $option !== 'phaseTitle') {
                                            echo '<li>' . esc_html($option) . '</li>';
                                        }
                                    }
                                    echo '</ul>';
                                }
                            }
                        }
                    } else {
                        _e('Não foi selecionado nenhum serviço.', 'funnel-services-form');
                    }
                    ?>
                </td>
            </tr>
        </table>
        <a href="<?php echo admin_url('admin.php?page=fsf-informacion-de-usuario'); ?>" class="button"><?php _e('Volver', 'funnel-services-form'); ?></a>
    </div>
    <?php
}
add_action('admin_post_fsf_delete_user', 'fsf_delete_user');
function fsf_delete_user() {
    if (!isset($_GET['post_id']) || !isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'fsf_delete_user_' . $_GET['post_id'])) {
        wp_die(__('Autorizações insuficientes para realizar esta ação.', 'funnel-services-form'));
    }

    $post_id = intval($_GET['post_id']);
    if ($post_id && get_post($post_id) && 'user-info' === get_post_type($post_id)) {
        wp_delete_post($post_id, true);
        wp_redirect(admin_url('admin.php?page=fsf-informacion-de-usuario&deleted=true'));
        exit;
    } else {
        wp_die(__('Post inválido.', 'funnel-services-form'));
    }
}

add_action('admin_post_fsf_bulk_delete_user', 'fsf_bulk_delete_user');
function fsf_bulk_delete_user() {
    if (!isset($_POST['fsf_bulk_delete_user_nonce']) || !wp_verify_nonce($_POST['fsf_bulk_delete_user_nonce'], 'fsf_bulk_delete_user')) {
        wp_die(__('Autorizações insuficientes para realizar esta ação.', 'funnel-services-form'));
    }

    if (isset($_POST['post_ids']) && is_array($_POST['post_ids'])) {
        foreach ($_POST['post_ids'] as $post_id) {
            if (get_post($post_id) && 'user-info' === get_post_type($post_id)) {
                wp_delete_post($post_id, true);
            }
        }
    }
    wp_redirect(admin_url('admin.php?page=fsf-informacion-de-usuario&bulk_deleted=true'));
    exit;
}
function fsf_export_user_info() {
    if (!isset($_POST['fsf_export_user_info_nonce']) || !wp_verify_nonce($_POST['fsf_export_user_info_nonce'], 'fsf_export_user_info')) {
        wp_die(__('Autorizações insuficientes para realizar esta ação.', 'funnel-services-form'));
    }

    if (isset($_POST['post_ids'])) {
        $post_ids = explode(',', $_POST['post_ids']);
        if (is_array($post_ids)) {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename=usuarios.csv');
            $output = fopen('php://output', 'w');
            fputcsv($output, array('nome', 'Email', 'Telefone', 'Serviços Selecionados'));

            foreach ($post_ids as $post_id) {
                if ($post = get_post($post_id)) {
                    $nombre = get_post_meta($post->ID, 'nombre', true);
                    $email = get_post_meta($post->ID, 'email', true);
                    $whatsapp = get_post_meta($post->ID, 'Telefone', true);
                    $services = maybe_unserialize(get_post_meta($post->ID, 'services', true));

                    // Convertir la selección de servicios a un formato legible (por ejemplo, separado por comas)
                    $services_list = '';
                    if (is_array($services)) {
                        $services_array = array();
                        foreach ($services as $serviceId => $serviceData) {
                            $service_details = $serviceData['serviceTitle'] . ': ';
                            $phases = array();
                            foreach ($serviceData as $phaseId => $phaseData) {
                                if ($phaseId !== 'serviceTitle') {
                                    $phase_details = $phaseData['phaseTitle'] . ' (';
                                    $options = array();
                                    foreach ($phaseData as $option => $selected) {
                                        if ($selected && $option !== 'phaseTitle') {
                                            $options[] = $option;
                                        }
                                    }
                                    $phase_details .= implode(', ', $options) . ')';
                                    $phases[] = $phase_details;
                                }
                            }
                            $service_details .= implode(' | ', $phases);
                            $services_array[] = $service_details;
                        }
                        $services_list = implode('; ', $services_array);
                    }

                    fputcsv($output, array($nombre, $email, $whatsapp, $services_list));
                }
            }
            fclose($output);
            exit;
        }
    }
    wp_redirect(admin_url('admin.php?page=fsf-informacion-de-usuario&export_failed=true'));
    exit;
}

add_action('admin_post_fsf_export_user_info', 'fsf_export_user_info');
