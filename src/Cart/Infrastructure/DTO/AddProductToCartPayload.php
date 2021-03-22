<?php
declare(strict_types=1);


namespace App\Cart\Infrastructure\DTO;


final class AddProductToCartPayload
{
    /** @var string */
    protected $productId;

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function setProductId(string $productId): void
    {
        $this->productId = $productId;
    }
}
