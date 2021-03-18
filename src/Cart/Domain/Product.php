<?php
declare(strict_types=1);


namespace App\Cart\Domain;


class Product implements ProductInterface
{
    /**
     * @var ProductId
     */
    private $productId;

    public static function fromDBFields(array $dbFields)
    {
        $productId = ProductId::fromString($dbFields['productId']);

        return new self($productId);
    }

    protected function __construct(ProductId $productId)
    {
        $this->productId = $productId;
    }

    public function getId(): ProductId
    {
        return $this->productId;
    }
}
