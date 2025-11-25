<?php
// ACF field group definition
add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_672e3381d5343',
        'title' => __('Service Information', 'Funnel-services-form'),
        'fields' => array(
            array(
                'key' => 'field_672e3382181e3',
                'label' => __('Service Phases', 'Funnel-services-form'),
                'name' => 'fases_do_servico',
                'type' => 'repeater',
                'button_label' => __('Add Phase', 'Funnel-services-form'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_672e873ee99a4',
                        'label' => __('Title', 'Funnel-services-form'),
                        'name' => 'titulo',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_672e8745e99a5',
                        'label' => __('Description', 'Funnel-services-form'),
                        'name' => 'descricao',
                        'type' => 'wysiwyg',  // Cambié 'text' por 'wysiwyg'
                        'toolbar' => 'full',  // Puedes definir una barra de herramientas personalizada si lo deseas
                        'media_upload' => 0, // Permite subir imágenes
                    ),
                    array(
                        'key' => 'field_672e8758e99a6',
                        'label' => __('Selection Type', 'Funnel-services-form'),
                        'name' => 'tipo_selecao',
                        'type' => 'select',
                        'choices' => array(
                            'multipla' => 'Multiple Selection',
                            'unica' => 'Single Selection',
                        ),
                        'default_value' => 'multipla',
                        'instructions' => __('Select the selection type for this phase.'),
                    ),
                    array(
                        'key' => 'field_672e8758e99a7',
                        'label' => __('Write Options', 'Funnel-services-form'),
                        'name' => 'escrever_as_opcoes',
                        'type' => 'repeater',
                        'button_label' => __('Add Option', 'Funnel-services-form'),
                        'sub_fields' => array(
                            array(
                                'key' => 'field_672e8765e99a7',
                                'label' => __('Title', 'Funnel-services-form'),
                                'name' => 'titulo',
                                'type' => 'text',
                            ),
                            array(
                                'key' => 'field_672e876fe99a8',
                                'label' => __('ID', 'Funnel-services-form'),
                                'name' => 'id_opcion',
                                'type' => 'text',
                                'instructions' => __('Unique ID generated automatically.'),
                                'readonly' => 1,
                                'wrapper' => array(
                                    'class' => '', // Clases adicionales, si las hay
                                   // 'style' => 'display: none;', // Oculta el campo
                                ), // Marcar como solo lectura
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'form-servico',
                ),
            ),
        ),
        'show_in_rest' => true,
    ));
});

// Generate unique ID automatically if field is empty
add_filter('acf/update_value/name=id_opcion', function($value, $post_id, $field) {
    // Si el valor está vacío, generar un ID único
    if (empty($value)) {
        $value = uniqid(); // Generate unique value
    }
    return $value;
}, 10, 3);

// Remove 'id_opcion' field from DOM

add_filter('acf/prepare_field/key=field_672e876fe99a8', function($field) {
    return false; // Elimina completamente el campo del DOM
});

// se usa este filtro para agregar un ID único a cada fase y opción dentro de cada fase
add_filter('acf/load_value/name=fases_do_servico', function($value, $post_id, $field) {
    if (empty($value)) {
        return $value; // Si no hay valores, no hacer nada
    }

    foreach ($value as $faseIndex => &$fase) {
        // Add unique ID to each phase in the repeater
        $fase['id_fase'] = 'f_' . ($faseIndex + 1);

        if (isset($fase['escrever_as_opcoes']) && is_array($fase['escrever_as_opcoes'])) {
            foreach ($fase['escrever_as_opcoes'] as $opcaoIndex => &$opcao) {
                // Add unique ID to each option within each phase
                $opcao['id_opcion'] = 'opcao_' . ($faseIndex + 1) . '_' . ($opcaoIndex + 1);
            }
        }
    }

    return $value;
}, 10, 3);
