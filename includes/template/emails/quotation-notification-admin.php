<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notificación de nueva cotización</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap"
        rel="stylesheet"
    />
    <style>
        body {
            background-color: transparent;
            padding: 0;
            text-align: center;
        }
        #outer_wrapper {
            background-color: #efefef;
            padding: 30px;
        }
        #wrapper {
            background-color: #fff;
            border-radius: 8px;
            margin: 0 auto;
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }
        #mail-title {
            font-family: "Montserrat", sans-serif;
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 20px;
            margin-top: 0;
            text-align: center;
        }
        p.email-description-text {
            font-family: "Montserrat", sans-serif;
            font-size: 14px;
            font-weight: normal;
            margin: 15px 0;
            text-align: center;
        }
        p.email-description-text.powered-text {
            margin-bottom: 0;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table th, .info-table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .info-table th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div id="outer_wrapper">
        <div id="wrapper">
            <h3 id="mail-title">¡Se ha creado una nueva cotización!</h3>
            <p class="email-description-text">
                Se ha creado una cotización en la fecha <?php echo esc_html($created_quotation_date); ?>
            </p>
            <table class="info-table">
                <tr>
                    <th>Nombre completo</th>
                    <td><?php echo esc_html($data['nombre']); ?></td>
                </tr>
                <tr>
                    <th>Correo electrónico</th>
                    <td><?php echo esc_html($data['email']); ?></td>
                </tr>
                <tr>
                    <th>Teléfono</th>
                    <td><?php echo esc_html($data['whatsapp']); ?></td>
                </tr>
                <!-- Añadir más filas según sea necesario -->
            </table>
            <h3>Servicios Seleccionados</h3>
            <?php
            if (!empty($data['selections'])) {
                $selections = maybe_unserialize($data['selections']);
                foreach ($selections as $serviceId => $serviceData) {
                    echo '<h4>' . esc_html($serviceData['serviceTitle']) . '</h4>';
                    foreach ($serviceData as $phaseId => $phaseData) {
                        if ($phaseId !== 'serviceTitle') {
                            echo '<strong>' . esc_html($phaseData['phaseTitle']) . ':</strong><br>';
                            echo '<ul>';
                            foreach ($phaseData as $option => $selected) {
                                if ($selected && $option !== 'phaseTitle') {
                                    echo '<li>' . esc_html($option) . '</li>';
                                }
                            }
                            echo '</ul>';
                        }
                    }
                }
            } else {
                echo '<p>No se seleccionaron servicios.</p>';
            }
            ?>
            <p class="email-description-text powered-text">
                Powered by: Your Company
            </p>
        </div>
    </div>
</body>
</html>
