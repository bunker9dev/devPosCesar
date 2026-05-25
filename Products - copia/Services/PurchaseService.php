<?php

namespace App\Modules\Products\Services;

use App\Modules\Products\Repositories\PurchaseRepository;

class PurchaseService
{
    private $purchases;

    public function __construct(PurchaseRepository $purchases)
    {
        $this->purchases = $purchases;
    }

    public function indexData()
    {
        return [
            'purchases' => $this->purchases->all(),
        ];
    }
}
