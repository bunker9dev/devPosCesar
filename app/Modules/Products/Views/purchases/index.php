<div class="module-header">
    <a href="<?= BASE_URL ?>/rolls/create" class="btn-primary">Ingresar rollo</a>
</div>

<div class="table-container">
    <table id="tablaPurchases" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Documento</th>
                <th>Proveedor</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($purchases as $purchase): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $purchase['id'] ?></td>
                    <td data-label="Documento"><?= htmlspecialchars($purchase['numero_documento'] ?? '-') ?></td>
                    <td data-label="Proveedor"><?= htmlspecialchars($purchase['proveedor'] ?? '-') ?></td>
                    <td data-label="Total"><?= number_format((float) $purchase['total'], 2) ?></td>
                    <td data-label="Estado"><?= htmlspecialchars(ucfirst($purchase['estado'])) ?></td>
                    <td data-label="Usuario"><?= htmlspecialchars($purchase['usuario']) ?></td>
                    <td data-label="Fecha"><?= htmlspecialchars($purchase['fecha']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
