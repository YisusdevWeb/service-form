<?php
/**
 * Templates de colores predefinidos
 * 
 * @package Funnel_Services_Form
 */

if (!defined('ABSPATH')) exit;

/**
 * Obtener todos los templates de colores disponibles
 */
function fsf_get_color_templates() {
    return [
        'dark' => [
            'name' => __('🌙 Dark (Default)', 'funnel-services-form'),
            'colors' => fsf_get_default_colors()
        ],
        'light' => [
            'name' => __('☀️ Light', 'funnel-services-form'),
            'colors' => [
                'bg_primary' => '#f8fafc',
                'bg_secondary' => '#e2e8f0',
                'text_primary' => '#1e293b',
                'text_secondary' => '#64748b',
                'title_color' => '#0f172a',
                'label_color' => '#334155',
                'input_bg' => 'rgba(0, 0, 0, 0.02)',
                'input_text' => '#1e293b',
                'input_border' => '#cbd5e1',
                'button_bg' => '#3b82f6',
                'button_text' => '#ffffff',
                'button_hover_bg' => '#2563eb',
                'theme_color_light' => '#60a5fa',
                'glass_bg_opacity' => 0.6,
                'glass_blur' => 10,
            ]
        ],
        'blue_corporate' => [
            'name' => __('🔵 Corporate Blue', 'funnel-services-form'),
            'colors' => [
                'bg_primary' => '#0c4a6e',
                'bg_secondary' => '#0369a1',
                'text_primary' => '#ffffff',
                'text_secondary' => '#bae6fd',
                'title_color' => '#ffffff',
                'label_color' => '#e0f2fe',
                'input_bg' => 'rgba(255, 255, 255, 0.05)',
                'input_text' => '#ffffff',
                'input_border' => '#7dd3fc',
                'button_bg' => '#0ea5e9',
                'button_text' => '#ffffff',
                'button_hover_bg' => '#38bdf8',
                'theme_color_light' => '#7dd3fc',
                'glass_bg_opacity' => 0.15,
                'glass_blur' => 12,
            ]
        ],
        'green_nature' => [
            'name' => __('🟢 Natural Green', 'funnel-services-form'),
            'colors' => [
                'bg_primary' => '#14532d',
                'bg_secondary' => '#166534',
                'text_primary' => '#ffffff',
                'text_secondary' => '#bbf7d0',
                'title_color' => '#ffffff',
                'label_color' => '#dcfce7',
                'input_bg' => 'rgba(255, 255, 255, 0.05)',
                'input_text' => '#ffffff',
                'input_border' => '#86efac',
                'button_bg' => '#22c55e',
                'button_text' => '#ffffff',
                'button_hover_bg' => '#4ade80',
                'theme_color_light' => '#86efac',
                'glass_bg_opacity' => 0.15,
                'glass_blur' => 10,
            ]
        ],
        'purple_elegant' => [
            'name' => __('🟣 Elegant Purple', 'funnel-services-form'),
            'colors' => [
                'bg_primary' => '#3b0764',
                'bg_secondary' => '#6b21a8',
                'text_primary' => '#ffffff',
                'text_secondary' => '#e9d5ff',
                'title_color' => '#ffffff',
                'label_color' => '#f3e8ff',
                'input_bg' => 'rgba(255, 255, 255, 0.05)',
                'input_text' => '#ffffff',
                'input_border' => '#c084fc',
                'button_bg' => '#a855f7',
                'button_text' => '#ffffff',
                'button_hover_bg' => '#c084fc',
                'theme_color_light' => '#d8b4fe',
                'glass_bg_opacity' => 0.15,
                'glass_blur' => 12,
            ]
        ],
        'orange_warm' => [
            'name' => __('🟠 Warm Orange', 'funnel-services-form'),
            'colors' => [
                'bg_primary' => '#7c2d12',
                'bg_secondary' => '#c2410c',
                'text_primary' => '#ffffff',
                'text_secondary' => '#fed7aa',
                'title_color' => '#ffffff',
                'label_color' => '#ffedd5',
                'input_bg' => 'rgba(255, 255, 255, 0.05)',
                'input_text' => '#ffffff',
                'input_border' => '#fdba74',
                'button_bg' => '#f97316',
                'button_text' => '#ffffff',
                'button_hover_bg' => '#fb923c',
                'theme_color_light' => '#fdba74',
                'glass_bg_opacity' => 0.15,
                'glass_blur' => 10,
            ]
        ],
    ];
}

/**
 * Obtener colores por defecto
 */
function fsf_get_default_colors() {
    return [
        'bg_primary' => '#090a15',
        'bg_secondary' => '#01579b',
        'text_primary' => '#ffffff',
        'text_secondary' => '#e5e7eb',
        'title_color' => '#ffffff',
        'label_color' => '#ffffff',
        'input_bg' => 'rgba(255, 255, 255, 0.02)',
        'input_text' => '#ffffff',
        'input_border' => '#ffffff',
        'button_bg' => '#122d42',
        'button_text' => '#ffffff',
        'button_hover_bg' => '#3974ad',
        'theme_color_light' => '#7ba8cc',
        'glass_bg_opacity' => 0.15,
        'glass_blur' => 10,
    ];
}

/**
 * Obtener colores actuales (guardados + defaults)
 */
function fsf_get_current_colors() {
    $defaults = fsf_get_default_colors();
    $saved = get_option('fsf_custom_colors', []);
    $colors = array_merge($defaults, (array) $saved);
    
    // Asegurar que ningún valor esté vacío
    foreach ($defaults as $key => $default_value) {
        if (empty($colors[$key])) {
            $colors[$key] = $default_value;
        }
    }
    
    return $colors;
}
