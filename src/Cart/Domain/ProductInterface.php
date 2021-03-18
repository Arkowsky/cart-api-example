<?php
declare(strict_types=1);


namespace App\Cart\Domain;


interface ProductInterface
{
    public function getId(): ProductId;
}
