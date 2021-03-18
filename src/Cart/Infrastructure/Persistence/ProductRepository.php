<?php
declare(strict_types=1);


namespace App\Cart\Infrastructure\Persistence;


use App\Cart\Domain\Product;
use App\Cart\Domain\ProductId;
use App\Cart\Domain\ProductInterface;
use App\Cart\Domain\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function findById(ProductId $productId): ProductInterface
    {
        // @TODO: add database, and get records with different fields than we have in catalogue - THIS IS MOCK
        return Product::fromDBFields(
            [
                'productId' => $productId->getProductId()->toBase32()
            ]
        );
    }
}
