<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A Sua Cotação</title>
</head>
<body>
    <div>
        <h1>Obrigado pela sua Cotação!</h1>
        <p>Nome: <?php echo esc_html($data['nombre']); ?></p>
        <p>Email: <?php echo esc_html($data['email']); ?></p>
        <p>WhatsApp: <?php echo esc_html($data['whatsapp']); ?></p>
        <p>Data de criação: <?php echo esc_html($created_quotation_date); ?></p>
        <h3>Serviços Selecionados</h3>
        <?php
        if (!empty($data['selections'])) {
            foreach ($data['selections'] as $serviceId => $serviceData) {
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
            echo '<p>Não foram selecionados serviços.</p>';
        }
        ?>

<h3>Entraremos em contacto consigo em breve para informar sobre a sua cotação.</h3>
    </div>
</body>
</html>
