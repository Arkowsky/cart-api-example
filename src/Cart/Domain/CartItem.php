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

    public static function fromDbRecord(array $record)
    {
        return new self(
            $record['id'] ? Uuid::fromString($record['id']) : null,
            ProductId::fromString($record['productId']),
            $record['quantity']
        );
    }

    protected function __construct(?Uuid $id, ProductId $productId, int $quantity)
    {
        $this->id = null === $id ? Uuid::v4() : $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

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
