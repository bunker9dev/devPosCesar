<section class="inventory-scan">
    <input id="globalRollScanner" autocomplete="off" autofocus placeholder="Escanear rollo para movimiento">
    <div id="scannerResult" class="scan-result">Escanea un rollo para cargarlo en el movimiento</div>
</section>

<form id="movementForm" class="form-users inventory-form movement-form">
    <input type="hidden" name="roll_id" id="movementRollId">

    <div class="form-grid">
        <div class="form-group">
            <label>Tipo</label>
            <select name="tipo" required>
                <option value="salida">Salida</option>
                <option value="devolucion">Devolución</option>
                <option value="ajuste">Ajuste</option>
                <option value="traslado">Traslado</option>
            </select>
        </div>

        <div class="form-group">
            <label>Metros</label>
            <input type="number" step="0.01" min="0.01" name="metros" required>
        </div>

        <div class="form-group">
            <label>Precio</label>
            <input type="number" step="0.01" min="0" name="precio">
        </div>

        <div class="form-group">
            <label>Bodega destino</label>
            <select name="warehouse_destination_id">
                <option value="">Solo traslado/devolución</option>
                <?php foreach ($warehouses as $warehouse): ?>
                    <option value="<?= $warehouse['id'] ?>"><?= htmlspecialchars($warehouse['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label>Nota</label>
        <input name="nota" placeholder="Motivo o referencia">
    </div>

    <div class="form-actions">
        <button class="btn-primary">Registrar movimiento</button>
    </div>
</form>

<div class="table-container">
    <table id="tablaMovements" class="table-main display">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Rollo</th>
                <th>Tipo</th>
                <th>Metros</th>
                <th>Origen</th>
                <th>Destino</th>
                <th>Usuario</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($movements as $movement): ?>
                <tr>
                    <th></th>
                    <td data-label="ID"><?= $movement['id'] ?></td>
                    <td data-label="Rollo"><?= htmlspecialchars($movement['codigo_barra'] . ' / ' . $movement['codigo_visible']) ?></td>
                    <td data-label="Tipo"><?= htmlspecialchars(ucfirst($movement['tipo'])) ?></td>
                    <td data-label="Metros"><?= number_format((float) $movement['metros'], 2) ?></td>
                    <td data-label="Origen"><?= htmlspecialchars($movement['bodega_origen'] ?? '-') ?></td>
                    <td data-label="Destino"><?= htmlspecialchars($movement['bodega_destino'] ?? '-') ?></td>
                    <td data-label="Usuario"><?= htmlspecialchars($movement['usuario']) ?></td>
                    <td data-label="Fecha"><?= htmlspecialchars($movement['created_at']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
