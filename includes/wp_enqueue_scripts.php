<?php

add_action( 'wp_enqueue_scripts', 'FSF_enequeue_scripts_and_styles', 100 );
function FSF_enequeue_scripts_and_styles() {
  $js_data_passed = array('ajax_url' => admin_url( 'admin-ajax.php' ));

 // wp_enqueue_script( 'FSF-frontend', FSF_PLUGIN_URL . 'react-app/app/page.tsx', array('jquery'), '1.0.0', true );
 wp_enqueue_script( 'FSF-frontend', 'http://localhost:9000/app.js', array('jquery'), '1.0.0', true );
  wp_localize_script( 'FSF-frontend', 'FSF_data', $js_data_passed );



}
add_action( 'admin_enqueue_scripts', 'FSF_enqueue_admin_scripts_and_styles' );
function FSF_enqueue_admin_scripts_and_styles(){
  wp_enqueue_style( 'FSF-settings-style', FSF_PLUGIN_URL . '/assets/css/style.css', array(), '1.0.1' );
}