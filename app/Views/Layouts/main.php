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

    <!-- iconos-->
    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

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
    <script>
        const BASE_URL = "<?= BASE_URL ?>";
    </script>

    <!-- APP -->
    <script type="module" src="<?= BASE_URL ?>/assets/js/core/app.js"></script>



<!-- ================================
   EDIT MODAL
================================  -->

    <div id="modalEditType" class="modal hidden">

        <div class="modal-overlay"></div>

        <div class="modal-content">

            <h2 class="modal-title">Editar tipo de tela</h2>

            <form id="formEditType">

                <input type="hidden" id="editTypeId">

                <div class="form-group">
                    <label>Nombre</label>
                    <input type="text" id="editTypeName" required>
                </div>

                <div class="modal-actions">
                    <button type="button" id="btnCancelEdit" class="btn-secondary">
                        Cancelar
                    </button>

                    <button type="submit" class="btn-primary">
                        Actualizar
                    </button>
                </div>

            </form>

        </div>

    </div>


<!-- ================================
   DELETE MODAL
================================ -->

<div id="modalConfirmDelete" class="modal hidden">

    <div class="modal-overlay"></div>

    <div class="modal-content">

        <h2 class="modal-title">Eliminar tipo de tela</h2>

        <!-- 🔥 reutilizamos estructura -->
        <div class="form-group">
           
            <p id="deleteMessage">
                ¿Seguro que deseas eliminar este registro?
            </p>
        </div>

        <div class="modal-actions">
            <button type="button" id="btnCancelDelete" class="btn-secondary">
                Cancelar
            </button>

            <button type="button" id="btnConfirmDelete" class="btn-danger">
                Eliminar
            </button>
        </div>

    </div>

</div>


</body>

</html>