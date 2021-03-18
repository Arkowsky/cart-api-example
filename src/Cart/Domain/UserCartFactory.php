<?php
declare(strict_types=1);


namespace App\Cart\Domain;


class UserCartFactory
{
    public function create(UserId $userId): Cart
    {
        // if found cart by id

        // else
        $cart = Cart::createUserCart($userId);

        return $cart;
    }
}
