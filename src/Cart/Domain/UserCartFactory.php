<?php
declare(strict_types=1);


namespace App\Cart\Domain;


class UserCartFactory
{
    private $cartRepository;

    public function __construct(CartRepositoryInterface $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function create(UserId $userId): Cart
    {
        $cart = $this->cartRepository->getByUserId($userId);

        if (!$cart) {
            $cart = Cart::createUserCart($userId);
        }

        return $cart;
    }
}
