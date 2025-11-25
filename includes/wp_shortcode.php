<?php
add_shortcode('Funnel-services-form', 'FSF_frontend');
function FSF_frontend() {
  ob_start(); ?>
    <div id="FSF_frontend-seccion"></div>
  <?php
  return ob_get_clean();
}


 // [Funnel-services-form]
 
