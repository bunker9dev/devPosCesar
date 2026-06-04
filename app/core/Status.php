<?php

namespace App\Core;

class Status
{
    const ELIMINADO = 0;
    const ACTIVO = 1;
    const INACTIVO = 2;

    public static function label($estado)
    {
        return match ($estado) {
            self::ACTIVO => 'Activo',
            self::INACTIVO => 'Inactivo',
            self::ELIMINADO => 'Eliminado',
            default => 'Desconocido'
        };
    }

    public static function class($estado)
    {
        return match ($estado) {
            self::ACTIVO => 'active',
            self::INACTIVO => 'inactive',
            self::ELIMINADO => 'deleted',
            default => ''
        };
    }
}