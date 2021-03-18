<?php
declare(strict_types=1);


namespace App\Cart\Domain;


use Symfony\Component\Uid\Uuid;

class CartItem
{
    /** @var Uuid */
    private $id;

    /** @var ProductId */
    private $productId;

    /** @var int */
    private $quantity;

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return ProductId
     */
    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
