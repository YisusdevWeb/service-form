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

// Registrar campos personalizados para el CPT 'form-servico'
add_action( 'add_meta_boxes', function() {
    add_meta_box(
        'informacoes_servico',
        __( 'Informações do Serviço', 'funnel-services-form' ),
        'mostrar_campos_servico',
        'form-servico', 
        'normal', 
        'high'
    );
});

// Función para mostrar los campos personalizados
function mostrar_campos_servico( $post ) {
    // Recuperar el valor actual de los campos
    $fase = get_post_meta( $post->ID, '_fase_servico', true );
    $descricao = get_post_meta( $post->ID, '_descricao_servico', true );
    
    // Mostrar los campos en el formulario
    echo '<label for="fase_servico">' . __( 'Fase do Serviço:', 'funnel-services-form' ) . '</label>';
    echo '<input type="text" id="fase_servico" name="fase_servico" value="' . esc_attr( $fase ) . '" class="widefat" />';
    
    echo '<label for="descricao_servico">' . __( 'Descrição:', 'funnel-services-form' ) . '</label>';
    echo '<input type="text" id="descricao_servico" name="descricao_servico" value="' . esc_attr( $descricao ) . '" class="widefat" />';
}

// Guardar los campos personalizados
add_action( 'save_post', function( $post_id ) {
    // Verificar si el post es del tipo 'form-servico' y no está siendo guardado automáticamente
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    
    // Guardar los valores de los campos personalizados
    if ( isset( $_POST['fase_servico'] ) ) {
        update_post_meta( $post_id, '_fase_servico', sanitize_text_field( $_POST['fase_servico'] ) );
    }
    
    if ( isset( $_POST['descricao_servico'] ) ) {
        update_post_meta( $post_id, '_descricao_servico', sanitize_text_field( $_POST['descricao_servico'] ) );
    }
} );

// Configuración avanzada de campos

function my_add_ids_to_options( $response, $post ) {
    if ( ! function_exists( 'get_fields' ) ) return $response;

    $acf_fields = get_fields( $post->ID );

    if ( isset( $acf_fields['fases_do_servico'] ) ) {
        foreach ( $acf_fields['fases_do_servico'] as $faseIndex => &$fase ) {
            $fase['id'] = 'fase_' . ($faseIndex + 1);

            if ( isset( $fase['opcoes_de_fase'] ) && is_array( $fase['opcoes_de_fase'] ) ) {
                foreach ( $fase['opcoes_de_fase'] as $opcaoIndex => &$opcao ) {
                    $opcao['id'] = 'opcao_' . ($faseIndex + 1) . '_' . ($opcaoIndex + 1);
                }
            }
        }
    }

    $response->data['acf'] = $acf_fields;
    return $response;
}
add_filter( 'rest_prepare_form-servico', 'my_add_ids_to_options', 10, 3 );

// Establecer un valor único para el campo 'id_opcion' si está vacío
function establecer_valor_id_opcion($value,  $field) {
    if ($field['key'] === 'field_672e876fe99a8' && empty($value)) {
        $value = uniqid();
    }
    return $value;
}
add_filter('acf/update_value', 'establecer_valor_id_opcion', 10, 3);

// Incluir 'id_opcion' en la respuesta JSON del API REST
function incluir_id_opcion_en_json($data, $post, $context) {
    $id_opcion = get_field('id_opcion', $post->ID);
    if ($id_opcion) {
        $data['acf']['fases_do_servico'][0]['titulo_da_fase']['escrever_as_opcoes'][0]['id_opcion'] = $id_opcion;
    }
    return $data;
}
add_filter('acf/rest_api/post/get_fields', 'incluir_id_opcion_en_json', 10, 3);

// Agregar JavaScript para llenar automáticamente el campo de entrada con 'id_opcion'
function agregar_js_para_llenar_input() {
    ?>
    <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
            const idOpcion = <?php echo json_encode(get_field('id_opcion')); ?>;
            if (idOpcion !== null && idOpcion !== '') {
                const inputField = document.getElementById('acf-field_672e3382181e3-row-0-field_672e872be99a3-field_672e8758e99a6-row-0-field_672e876fe99a8');
                if (inputField) {
                    inputField.value = idOpcion;
                    inputField.style.display = 'none'; // Ocultar el campo
                }
            }
        });
    </script>
    <?php
}
add_action('wp_footer', 'agregar_js_para_llenar_input');
