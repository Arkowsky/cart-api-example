<?php


namespace App\Cart\Domain;


interface ProductRepositoryInterface
{
    public function findById(ProductId $productId): ProductInterface;
}
