<?php

add_action('admin_menu', 'fsf_add_admin_menu');

function fsf_add_admin_menu() {
    add_menu_page(
        __('Información de Usuario', 'funnel-services-form'),
        __('Información de Usuario', 'funnel-services-form'),
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
        <h1><?php _e('Información de Usuario', 'funnel-services-form'); ?></h1>
        <?php
        $args = array(
            'post_type' => 'user-info',
            'posts_per_page' => -1,
        );
        $posts = get_posts($args);
        ?>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th><?php _e('Nombre', 'funnel-services-form'); ?></th>
                    <th><?php _e('Email', 'funnel-services-form'); ?></th>
                    <th><?php _e('WhatsApp', 'funnel-services-form'); ?></th>
                    <th><?php _e('Acciones', 'funnel-services-form'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) : ?>
                    <tr>
                        <td><?php echo esc_html(get_post_meta($post->ID, 'nombre', true)); ?></td>
                        <td><?php echo esc_html(get_post_meta($post->ID, 'email', true)); ?></td>
                        <td><?php echo esc_html(get_post_meta($post->ID, 'whatsapp', true)); ?></td>
                        <td><a href="<?php echo admin_url('admin.php?page=fsf-detalles-usuario&post_id=' . $post->ID); ?>"><?php _e('Ver', 'funnel-services-form'); ?></a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php
}

function fsf_display_user_details_page() {
    $post_id = isset($_GET['post_id']) ? intval($_GET['post_id']) : 0;
    if (!$post_id) {
        echo '<div class="notice notice-error"><p>' . __('ID de post inválido', 'funnel-services-form') . '</p></div>';
        return;
    }

    $post = get_post($post_id);
    if (!$post || $post->post_type !== 'user-info') {
        echo '<div class="notice notice-error"><p>' . __('Post no encontrado', 'funnel-services-form') . '</p></div>';
        return;
    }

    $nombre = get_post_meta($post->ID, 'nombre', true);
    $email = get_post_meta($post->ID, 'email', true);
    $whatsapp = get_post_meta($post->ID, 'whatsapp', true);
    
    // Aquí se pueden añadir más campos según sea necesario

    ?>
    <div class="wrap">
        <h1><?php _e('Detalles del Usuario', 'funnel-services-form'); ?></h1>
        <table class="form-table">
            <tr>
                <th scope="row"><?php _e('Nombre', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($nombre); ?></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('Email', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($email); ?></td>
            </tr>
            <tr>
                <th scope="row"><?php _e('WhatsApp', 'funnel-services-form'); ?></th>
                <td><?php echo esc_html($whatsapp); ?></td>
            </tr>
            <!-- Añadir más filas para otros campos -->
        </table>
        <a href="<?php echo admin_url('admin.php?page=fsf-informacion-de-usuario'); ?>" class="button"><?php _e('Volver', 'funnel-services-form'); ?></a>
    </div>
    <?php
}
