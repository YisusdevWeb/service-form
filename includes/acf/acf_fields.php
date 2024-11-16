<?php

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
                'label' => __('Fases do Serviço', 'Funnel-services-form'),
                'name' => 'fases_do_servico',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'button_label' => __('Adicionar Fase', 'Funnel-services-form'),
                'rows_per_page' => 20,
                'sub_fields' => array(
                    array(
                        'key' => 'field_672e873ee99a4',
                        'label' => __('Título', 'Funnel-services-form'),
                        'name' => 'titulo',
                        'type' => 'text',
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => '',
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                    ),
                    array(
                        'key' => 'field_672e8745e99a5',
                        'label' => __('Descrição', 'Funnel-services-form'),
                        'name' => 'descricao',
                        'type' => 'text',
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => '',
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                    ),
                    array(
                        'key' => 'field_672e8758e99a6',
                        'label' => __('Escrever as Opções', 'Funnel-services-form'),
                        'name' => 'escrever_as_opcoes',
                        'type' => 'repeater',
                        'button_label' => __('Adicionar Opção', 'Funnel-services-form'),
                        'rows_per_page' => 20,
                        'sub_fields' => array(
                            array(
                                'key' => 'field_672e8765e99a7',
                                'label' => __('Título', 'Funnel-services-form'),
                                'name' => 'titulo',
                                'type' => 'text',
                                'default_value' => '',
                                'maxlength' => '',
                                'placeholder' => '',
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                            ),
                            array(
                                'key' => 'field_672e876fe99a8',
                                'label' => __('ID', 'Funnel-services-form'),
                                'name' => 'id_opcion',
                                'type' => 'text',
                                'default_value' => '',
                                'maxlength' => '',
                                'placeholder' => '',
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => 'id_opcion',
                                    'id' => '',
                                ),
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
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'show_in_rest' => 1,
    ));
});
