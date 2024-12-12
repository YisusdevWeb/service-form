<?php
function fsf_send_email($data, $subject) {
    // Dirección de correo del administrador
    $to = get_option('admin_email');

    // Asunto del correo
    $subject = $subject . ' - ' . $data['email'];

    // Obtener la fecha de creación de la cotización
    $created_quotation_date = date_i18n(get_option('date_format') . ' ' . get_option('time_format') . ' T');

    // Registrar los datos para depuración
    error_log('Datos recibidos para envío de correo: ' . print_r($data, true));

    // Iniciar el buffer de salida para capturar el contenido del correo
    ob_start();
    include dirname(__FILE__) . '/templates/emails/quotation-notification-admin.php';
    $message = ob_get_contents();
    ob_end_clean();

    // Registrar el mensaje de correo para depuración
    error_log('Mensaje de correo: ' . $message);

    // Verificar si el mensaje está vacío
    if (empty($message)) {
        error_log('El cuerpo del mensaje está vacío.');
        return;
    }

    // Encabezados del correo
    $headers = array();
    $headers[] = 'Content-Type: text/html; charset=UTF-8';
    $headers[] = 'From: dappin <	web@dappin.pt>';

    // Destinatarios del correo (admin y usuario)
    $recipients = array($to, $data['email']);

    // Enviar el correo usando wp_mail
    wp_mail($recipients, $subject, $message, $headers);
}




   // $headers[] = 'From: dappin <	web@dappin.pt>';
