<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SISTEMA POS CESAR</title>
    <!-- <title>devCesar</title> -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/app.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

</head>

<body>

    <div class="container">

        <?php require __DIR__ . '/../partials/sidebar.php'; ?>
        <div class="main">
            <?php require __DIR__ . '/../partials/navbar.php'; ?>
            <?php require __DIR__ . '/../partials/header.php'; ?>
            <?php require $content; ?>
        </div>

    </div>

    <!-- 🔥 TOAST CONTAINER -->
    <div id="toast-container"></div>

    <!-- 🔥 FLASH DESDE PHP -->
    <script>
        window.APP_FLASH = {
            success: <?= json_encode($_SESSION['success'] ?? null) ?>,
            error: <?= json_encode($_SESSION['error'] ?? null) ?>
        };
    </script>

    <?php unset($_SESSION['success'], $_SESSION['error']); ?>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    <!-- Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Responsive -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- 🔥 BASE URL PARA JS -->
    <script> const BASE_URL = "<?= BASE_URL ?>";</script>

    <!-- APP -->
    <script type="module" src="<?= BASE_URL ?>/assets/js/core/app.js"></script>


</body>

</html>