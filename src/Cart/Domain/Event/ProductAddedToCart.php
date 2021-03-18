<?php
declare(strict_types=1);


namespace App\Cart\Domain\Event;


use App\Cart\Domain\ProductId;
use Symfony\Component\Uid\Uuid;

final class ProductAddedToCart
{
    /** @var Uuid */
    private $id;

    /** @var ProductId */
    private $productId;

    public function __construct(Uuid $id, ProductId $productId)
    {
        $this->id = $id;
        $this->productId = $productId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }
}
