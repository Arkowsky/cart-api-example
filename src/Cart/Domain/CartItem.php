<?php
declare(strict_types=1);


namespace App\Cart\Domain;


use Symfony\Component\Uid\Uuid;
use Webmozart\Assert\Assert;

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

    public static function fromProductId(ProductId $productId, int $quantity)
    {
        return new self(
            null,
            $productId,
            $quantity
        );
    }

    protected function __construct(?Uuid $id, ProductId $productId, int $quantity)
    {
        Assert::greaterThan($quantity,0);

        $this->id = null === $id ? Uuid::v4() : $id;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(int $quantity)
    {
        $this->quantity = $this->quantity + $quantity;
    }
}
