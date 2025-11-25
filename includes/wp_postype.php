<?php


add_action('init', function() {
    // Register Custom Post Type 'form-servico'
    register_post_type('form-servico', array(
        'labels' => array(
            'name' => __('Services', 'funnel-services-form'),
            'singular_name' => __('Service', 'funnel-services-form'),
            'menu_name' => __('Services', 'funnel-services-form'),
            'all_items' => __('All Services', 'funnel-services-form'),
            'edit_item' => __('Edit Service', 'funnel-services-form'),
            'view_item' => __('View Service', 'funnel-services-form'),
            'add_new_item' => __('Add New Service', 'funnel-services-form'),
            'new_item' => __('New Service', 'funnel-services-form'),
            'parent_item_colon' => __('Parent Service:', 'funnel-services-form'),
            'search_items' => __('Search Services', 'funnel-services-form'),
            'not_found' => __('No services found.', 'funnel-services-form'),
            'not_found_in_trash' => __('No services found in trash.', 'funnel-services-form'),
            'archives' => __('Service Archives', 'funnel-services-form'),
            'attributes' => __('Service Attributes', 'funnel-services-form'),
            'insert_into_item' => __('Insert into Service', 'funnel-services-form'),
            'uploaded_to_this_item' => __('Uploaded to this Service', 'funnel-services-form'),
            'filter_items_list' => __('Filter Services List', 'funnel-services-form'),
        ),
        'description' => __('Services Information', 'funnel-services-form'),
        'public' => true,
        'hierarchical' => true,
        'show_in_rest' => true,
        'menu_position' => 8,
        'menu_icon' => 'dashicons-filter',
        'supports' => array('title', 'thumbnail', 'custom-fields'),
        'delete_with_user' => false,
    ));

    // Register Custom Post Type 'user-info'
    register_post_type('user-info', array(
        'labels' => array(
            'name' => __('User Information', 'funnel-services-form'),
            'singular_name' => __('User Information', 'funnel-services-form'),
            'menu_name' => __('User Info', 'funnel-services-form'),
            'all_items' => __('All User Information', 'funnel-services-form'),
        ),
        'description' => __('User Information', 'funnel-services-form'),
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
