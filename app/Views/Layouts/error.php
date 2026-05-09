<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Error <?= http_response_code() ?></title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.css">
</head>
<body class="error_body" >

    <div class="error_div">
        <?= $content ?>
    </div>

</body>
</html>