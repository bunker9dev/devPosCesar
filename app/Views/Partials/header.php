

<div class="header">

</div>

<div class="header2">
    <div class="header-left">
        <h1><?= $title ?? 'Inicio' ?></h1>
    </div>

    <div class="header-right">
        <ol class="breadcrumb">
            <li><a href="<?= BASE_URL ?>/dashboard">Inicio</a></li>
            <li class="active"><?= $title ?? 'Inicio' ?></li>
        </ol>
    </div>
</div>