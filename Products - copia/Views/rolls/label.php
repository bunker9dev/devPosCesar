<section class="label-toolbar">
    <a href="<?= BASE_URL ?>/rolls" class="btn-secondary">Volver</a>
    <button class="btn-primary" onclick="window.print()">Imprimir etiqueta</button>
</section>

<section class="roll-label">
    <svg id="barcodeSvg" data-code="<?= htmlspecialchars($roll['codigo_barra']) ?>"></svg>
    <strong><?= htmlspecialchars($roll['codigo_visible']) ?></strong>
    <div><?= htmlspecialchars($roll['tipo_tela']) ?> / <?= htmlspecialchars($roll['color']) ?></div>
    <div><?= number_format((float) $roll['metros'], 2) ?> m</div>
    <small><?= htmlspecialchars($roll['codigo_barra']) ?></small>
</section>

<script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.6/dist/JsBarcode.all.min.js"></script>
<script>
    const barcode = document.getElementById('barcodeSvg');
    JsBarcode(barcode, barcode.dataset.code, {
        format: 'CODE128',
        width: 2,
        height: 56,
        displayValue: false,
        margin: 0
    });
</script>
