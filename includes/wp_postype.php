<?php

add_action('init', function() {
    // Registro del Custom Post Type 'form-servico'
    register_post_type('form-servico', array(
        'labels' => array(
            'name' => __('Serviços', 'funnel-services-form'),
            'singular_name' => __('Serviço', 'funnel-services-form'),
            'menu_name' => __('Serviços', 'funnel-services-form'),
            'all_items' => __('Todos os Serviços', 'funnel-services-form'),
            'edit_item' => __('Editar Serviço', 'funnel-services-form'),
            'view_item' => __('Ver Serviço', 'funnel-services-form'),
            'add_new_item' => __('Adicionar Novo Serviço', 'funnel-services-form'),
            'new_item' => __('Novo Serviço', 'funnel-services-form'),
            'parent_item_colon' => __('Serviço Pai:', 'funnel-services-form'),
            'search_items' => __('Buscar Serviços', 'funnel-services-form'),
            'not_found' => __('Nenhum serviço encontrado', 'funnel-services-form'),
            'not_found_in_trash' => __('Nenhum serviço encontrado na lixeira', 'funnel-services-form'),
            'archives' => __('Arquivos de Serviços', 'funnel-services-form'),
            'attributes' => __('Atributos do Serviço', 'funnel-services-form'),
            'insert_into_item' => __('Inserir no Serviço', 'funnel-services-form'),
            'uploaded_to_this_item' => __('Enviado para este Serviço', 'funnel-services-form'),
            'filter_items_list' => __('Filtrar lista de Serviços', 'funnel-services-form'),
        ),
        'description' => __('Informações de Serviço', 'funnel-services-form'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-filter',
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'delete_with_user' => false,
    ));

    // Registro del Custom Post Type 'user-info'
    register_post_type('user-info', array(
        'labels' => array(
            'name' => __('Informação de Usuário', 'funnel-services-form'),
            'singular_name' => __('Informação de Usuário', 'funnel-services-form'),
            'menu_name' => __('Info Usuário', 'funnel-services-form'),
            'all_items' => __('Toda Informação de Usuário', 'funnel-services-form'),
        ),
        'description' => __('Informações dos Usuários', 'funnel-services-form'),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => false,
        'supports' => array('title', 'custom-fields'),
        'capabilities' => array(
            'create_posts' => false,
            'edit_posts' => false,
            'edit_others_posts' => false,
            'publish_posts' => false,
            'read_private_posts' => true,
            'read' => true,
            'delete_posts' => false,
            'delete_private_posts' => false,
            'delete_published_posts' => false,
            'delete_others_posts' => false,
            'edit_private_posts' => false,
            'edit_published_posts' => false,
        ),
        'map_meta_cap' => true,
    ));
});
