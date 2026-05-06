<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema POS' ?></title>
    <!-- <title>devCesar</title> -->
   <link rel="stylesheet" href="<?= BASE_URL ?>/css/app.css">
</head>

<body>

    <div class="container">

        <?php require __DIR__ . '/../partials/sidebar.php'; ?>

        <div class="main">

            <?php require __DIR__ . '/../partials/header.php'; ?>

            <?php require $content; ?>

        </div>

    </div>

    <script src="/js/app.js"></script>
    <script src="/js/index.js"></script>

</body>

</html>