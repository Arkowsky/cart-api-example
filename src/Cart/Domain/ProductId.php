<?php
declare(strict_types=1);


namespace App\Cart\Domain;


use Symfony\Component\Uid\Uuid;

class ProductId
{
    /** @var Uuid */
    private $productId;

    public static function fromString(string $productId)
    {
        return new self(Uuid::fromString($productId));
    }

    protected function __construct(Uuid $productId)
    {
        $this->productId = $productId;
    }

    public function getProductId(): Uuid
    {
        return $this->productId;
    }
}
