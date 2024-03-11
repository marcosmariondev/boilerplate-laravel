<?php

declare(strict_types=1);

namespace App\Services\Product\Contracts;

use App\ValueObjects\Uuid;
use App\DTOs\Product\ComboProduct;
use App\DTOs\Product\ComboProductShowOutput;
use App\DTOs\ComboProduct\ComboProductFilterInput;
use App\Collections\ComboProduct\ComboProductListCollection;

interface ComboProductServiceInterface
{
    public function getProduct(ComboProduct $comboProduct): ComboProductShowOutput;
    public function getProductListFromCombo(Uuid $uuid, ComboProductFilterInput $filters): ComboProductListCollection;
}
