<?php
declare(strict_types=1);


namespace App\Cart\Infrastructure\Persistence;


use App\Cart\Domain\Cart;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\UserId;

class CartRepository implements CartRepositoryInterface
{
    public function getByUserId(UserId $userId)
    {
        // @TODO: add database

        $record = [
            'id' => 'b5b34004-1ee3-4476-813e-3a213fd2a1bf',
            'userId' => 2,
            'products' => [
                [
                    'id' => '0cf846aa-b521-4b01-8acf-7f46c20e12b6',
                    'productId' => '0cf846aa-b521-4b01-8acf-7f46c20e12b6',
                    'quantity' => 1
                ],
                [
                    'id' => '2095d195-afe1-4752-a531-a183fe62865a',
                    'productId' => 'd2b3a83c-87bd-4879-a5c9-98781bd8d02b',
                    'quantity' => 2
                ]
            ]
        ];

        return Cart::fromDbRecord($record);
    }

    public function save(Cart $cart)
    {
        // TODO: Implement save() method.
    }
}
