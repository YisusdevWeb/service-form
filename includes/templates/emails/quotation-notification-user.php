<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>A Sua Cotação</title>
</head>
<body>
    <div>
    <p><?php echo esc_html($data['nombre']); ?> obrigado por sua cotação</p>
        <?php echo $email_body; ?>
        <p>Data de criação: <?php echo esc_html($created_quotation_date); ?></p>
        <h3><a href="https://dappin.pt/">dappin</a></h3>
    </div>
</body>
</html>
