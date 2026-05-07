<!-- CARDS -->
<div class="cards">
    <div class="card">
        <h3>Stock Total</h3>
        <h1><?= $stock ?></h1>
    </div>

    <div class="card">
        <h3>Productos Activos</h3>
        <h1><?= $activos ?></h1>
    </div>

    <div class="card">
        <h3 style="color:red;">Stock Bajo</h3>
        <h1><?= $lowStock ?></h1>
    </div>

    <div class="card">
        <h3>Movimientos Hoy</h3>
        <h1><?= $movimientos ?></h1>
    </div>
</div>

<!-- GRID -->
<div class="grid">

    <div class="panel">
        <h3>Nivel de Inventario</h3>
        <canvas id="chart" height="150"></canvas>
    </div>

    <div class="panel">
        <h3>Alertas Críticas</h3>
        <div id="alerts"></div>
    </div>

</div>

<!-- TABLE -->
<div class="panel table">
    <h3>Movimientos recientes</h3>
    <div><span>Producto A</span><span style="color:red">-25</span></div>
    <div><span>Producto B</span><span style="color:lime">+50</span></div>
    <div><span>Producto C</span><span style="color:red">-10</span></div>
</div>