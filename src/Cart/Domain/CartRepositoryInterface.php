<?php


namespace App\Cart\Domain;



interface CartRepositoryInterface
{
    public function getByUserId(UserId $userId);

    public function save(Cart $cart);
}
