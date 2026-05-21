<?php
function normalizarProveedor($data)
{
    $data['nombre'] = normalizarNombre($data['nombre'] ?? '');
    $data['ciudad'] = normalizarCiudad($data['ciudad'] ?? '');
    $data['nit']    = normalizarNit($data['nit'] ?? '');

    return $data;
}