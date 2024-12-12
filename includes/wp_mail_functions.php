<?php

function fsf_send_email_to_admin($data, $subject) {
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

    // Verificar si el mensaje está vacío
    if (empty($message)) {
        error_log('El cuerpo del mensaje está vacío.');
        return;
    }

    // Encabezados del correo para el administrador
    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <web@dappin.pt>';

    // Enviar el correo al administrador usando wp_mail
    wp_mail($to, $subject, $message, $headers);
}

function fsf_send_email_to_user($data, $subject) {
    // Dirección de correo del usuario
    $to = $data['email'];

    // Asunto del correo
    $subject = 'Tu Cotización - ' . $subject;

    // Obtener la fecha de creación de la cotización
    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    // Iniciar el buffer de salida para capturar el contenido del correo
    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-user.php'; // Asegúrate de tener una plantilla separada para el usuario
    $message = ob_get_contents();
    ob_end_clean();

    // Verificar si el mensaje está vacío
    if (empty($message)) {
        error_log('El cuerpo del mensaje para el usuario está vacío.');
        return;
    }

    // Encabezados del correo para el usuario
    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <web@dappin.pt>';

    // Enviar el correo al usuario usando wp_mail
    wp_mail($to, $subject, $message, $headers);
}




   // $headers[] = 'From: dappin <	web@dappin.pt>';
