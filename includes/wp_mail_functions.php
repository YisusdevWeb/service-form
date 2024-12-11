<?php

function fsf_send_email($data, $subject) {
    // Dirección de correo del administrador
    $to = get_option('admin_email');

    // Asunto del correo
    $subject = $subject . ' - ' . $data['email'];

    // Obtener la fecha de creación de la cotización
    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    // Iniciar el buffer de salida para capturar el contenido del correo
    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-admin.php';
    $message = ob_get_contents();
    ob_end_clean();

    // Encabezados del correo
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: Your Company <noreply@yourcompany.com>';

    // Destinatarios del correo (admin y usuario)
    $recipients = array($to, $data['email']);

    // Enviar el correo usando wp_mail
    wp_mail($recipients, $subject, $message, $headers);
}
