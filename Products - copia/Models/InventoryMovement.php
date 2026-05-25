<?php

namespace App\Modules\Products\Models;

class InventoryMovement
{
    public const ENTRADA = 'entrada';
    public const SALIDA = 'salida';
    public const DEVOLUCION = 'devolucion';
    public const AJUSTE = 'ajuste';
    public const TRASLADO = 'traslado';

    public const TYPES = [
        self::ENTRADA,
        self::SALIDA,
        self::DEVOLUCION,
        self::AJUSTE,
        self::TRASLADO,
    ];
}
