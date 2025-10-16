<?php
// Definición del grupo de campos ACF
add_action('acf/include_fields', function() {
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }

    acf_add_local_field_group(array(
        'key' => 'group_672e3381d5343',
        'title' => __('Informações de Serviço', 'Funnel-services-form'),
        'fields' => array(
            array(
                'key' => 'field_672e3382181e3',
                'label' => __('Fases dos Serviço', 'Funnel-services-form'),
                'name' => 'fases_do_servico',
                'type' => 'repeater',
                'button_label' => __('Adicionar Fase', 'Funnel-services-form'),
                'sub_fields' => array(
                    array(
                        'key' => 'field_672e873ee99a4',
                        'label' => __('Título', 'Funnel-services-form'),
                        'name' => 'titulo',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_672e8745e99a5',
                        'label' => __('Descripción', 'Funnel-services-form'),
                        'name' => 'descricao',
                        'type' => 'wysiwyg',  // Cambié 'text' por 'wysiwyg'
                        'toolbar' => 'full',  // Puedes definir una barra de herramientas personalizada si lo deseas
                        'media_upload' => 0, // Permite subir imágenes
                    ),
                    array(
                        'key' => 'field_672e8758e99a6',
                        'label' => __('Tipo de Seleção', 'Funnel-services-form'),
                        'name' => 'tipo_selecao',
                        'type' => 'select',
                        'choices' => array(
                            'multipla' => 'Selección Múltiple',
                            'unica' => 'Selección Única',
                        ),
                        'default_value' => 'multipla',
                        'instructions' => __('Seleccione el tipo de selección para esta fase.'),
                    ),
                    array(
                        'key' => 'field_672e8758e99a7',
                        'label' => __('Escrever as Opções', 'Funnel-services-form'),
                        'name' => 'escrever_as_opcoes',
                        'type' => 'repeater',
                        'button_label' => __('Adicionar Opção', 'Funnel-services-form'),
                        'sub_fields' => array(
                            array(
                                'key' => 'field_672e8765e99a7',
                                'label' => __('Título', 'Funnel-services-form'),
                                'name' => 'titulo',
                                'type' => 'text',
                            ),
                            array(
                                'key' => 'field_672e876fe99a8',
                                'label' => __('ID', 'Funnel-services-form'),
                                'name' => 'id_opcion',
                                'type' => 'text',
                                'instructions' => __('ID único gerado automaticamente.'),
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

// Generar un ID único automáticamente si el campo está vacío
add_filter('acf/update_value/name=id_opcion', function($value, $post_id, $field) {
    // Si el valor está vacío, generar un ID único
    if (empty($value)) {
        $value = uniqid(); // Generar un valor único
    }
    return $value;
}, 10, 3);

// Eliminar el campo 'id_opcion' del DOM

add_filter('acf/prepare_field/key=field_672e876fe99a8', function($field) {
    return false; // Elimina completamente el campo del DOM
});

// se usa este filtro para agregar un ID único a cada fase y opción dentro de cada fase
add_filter('acf/load_value/name=fases_do_servico', function($value, $post_id, $field) {
    if (empty($value)) {
        return $value; // Si no hay valores, no hacer nada
    }

    foreach ($value as $faseIndex => &$fase) {
        // Agregar un ID único a cada fase en la repetición
        $fase['id_fase'] = 'f_' . ($faseIndex + 1);

        if (isset($fase['escrever_as_opcoes']) && is_array($fase['escrever_as_opcoes'])) {
            foreach ($fase['escrever_as_opcoes'] as $opcaoIndex => &$opcao) {
                // Agregar un ID único a cada opción dentro de cada fase
                $opcao['id_opcion'] = 'opcao_' . ($faseIndex + 1) . '_' . ($opcaoIndex + 1);
            }
        }
    }

    return $value;
}, 10, 3);
