<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema POS' ?></title>
    <!-- <title>devCesar</title> -->
   <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.css">
</head>

<body>

    <div class="container">

        <?php require $content; ?>

    </div>

    <script src="/js/app.js"></script>
    <script src="/js/index.js"></script>

</body>

</html>