<?php
declare(strict_types=1);


namespace App\Cart\Domain\Exception;


use App\Cart\Domain\ProductId;

class ProductNotFoundException extends \InvalidArgumentException
{
    public static function fromProductId(ProductId $productId)
    {
        return new self(sprintf("Product with id = %s not found", $productId->getProductId()));
    }
}
