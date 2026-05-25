<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Repositories\AuditLogRepository;
use App\Modules\Products\Repositories\CatalogRepository;
use Exception;

class CatalogService
{
    private $catalog;
    private $audit;

    public function __construct(CatalogRepository $catalog, AuditLogRepository $audit)
    {
        $this->catalog = $catalog;
        $this->audit = $audit;
    }

    public function dashboardData()
    {
        return [
            'types' => $this->catalog->fabricTypes(),
            'colors' => $this->catalog->colors(),
            'products' => $this->catalog->products(),
        ];
    }

    public function fabricTypesData()
    {
        return [
            'types' => $this->catalog->fabricTypes(),
        ];
    }

    public function colorsData()
    {
        return [
            'colors' => $this->catalog->colors(),
        ];
    }

    public function createFabricType(array $data)
    {
        $nombre = $this->normalizeName($data['nombre'] ?? '');

        if (!$nombre) {
            throw new Exception("El nombre del tipo de tela es obligatorio");
        }

        $codigo = $this->catalog->nextFabricTypeCode();
        $id = $this->catalog->createFabricType($codigo, $nombre);
        $this->audit->log('CREATE', 'fabric_types', $id, compact('codigo', 'nombre'));

        return $id;
    }

    public function createColor(array $data)
    {
        $nombre = $this->normalizeName($data['nombre'] ?? '');

        if (!$nombre) {
            throw new Exception("El nombre del color es obligatorio");
        }

        $codigo = $this->catalog->nextColorCode();
        $hex = null;
        $id = $this->catalog->createColor($codigo, $nombre, $hex ?: null);
        $this->audit->log('CREATE', 'fabric_colors', $id, compact('codigo', 'nombre', 'hex'));

        return $id;
    }

    private function normalizeName($value)
    {
        $value = trim($value);
        $value = preg_replace('/[^a-zA-Z0-9áéíóúÁÉÍÓÚñÑ\s\.\-&]/u', '', $value);
        $value = preg_replace('/\s+/', ' ', $value);

        if ($value === '') {
            return '';
        }

        $value = mb_strtolower($value, 'UTF-8');

        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
}
