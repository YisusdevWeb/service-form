<?php

// Registro del Custom Post Type 'form-servico'
add_action( 'init', function() {
    // Registro del Custom Post Type
    register_post_type( 'form-servico', array(
        'labels' => array(
            'name' => __( 'Serviços', 'funnel-services-form' ),
            'singular_name' => __( 'Serviço', 'funnel-services-form' ),
            'menu_name' => __( 'Serviços', 'funnel-services-form' ),
            'all_items' => __( 'Todos os Serviços', 'funnel-services-form' ),
            'edit_item' => __( 'Editar Serviço', 'funnel-services-form' ),
            'view_item' => __( 'Ver Serviço', 'funnel-services-form' ),
            'add_new_item' => __( 'Adicionar Novo Serviço', 'funnel-services-form' ),
            'new_item' => __( 'Novo Serviço', 'funnel-services-form' ),
            'parent_item_colon' => __( 'Serviço Pai:', 'funnel-services-form' ),
            'search_items' => __( 'Buscar Serviços', 'funnel-services-form' ),
            'not_found' => __( 'Nenhum serviço encontrado', 'funnel-services-form' ),
            'not_found_in_trash' => __( 'Nenhum serviço encontrado na lixeira', 'funnel-services-form' ),
            'archives' => __( 'Arquivos de Serviços', 'funnel-services-form' ),
            'attributes' => __( 'Atributos do Serviço', 'funnel-services-form' ),
            'insert_into_item' => __( 'Inserir no Serviço', 'funnel-services-form' ),
            'uploaded_to_this_item' => __( 'Enviado para este Serviço', 'funnel-services-form' ),
            'filter_items_list' => __( 'Filtrar lista de Serviços', 'funnel-services-form' ),
        ),
        'description' => __( 'Informações de Serviço', 'funnel-services-form' ),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,  // Habilita el uso de la API REST
        'menu_position' => 8,
        'menu_icon' => 'dashicons-filter',
        'supports' => array(
            'title',      // Título
            'thumbnail',  // Imagen destacada
            'custom-fields', // Campos personalizados (meta)
        ),
        'delete_with_user' => false,
    ));
} );



