<?php
declare(strict_types=1);


namespace App\Cart\Domain;


use Symfony\Component\Uid\Uuid;

class Cart
{
    /** @var Uuid */
    private $id;

    /** @var int */
    private $userId;

    /** @var null|CartItem[] */
    private $cartItems;

    public static function createUserCart(UserId $userId, ?array $cartItems = null)
    {
        $cart = new self($userId);
        $cart->cartItems = $cartItems;

        return $cart;
    }

    protected function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return null|CartItem[]
     */
    public function getCartItems(): ?array
    {
        return $this->cartItems;
    }

    public function addCartItem(ProductId $productId, int $quantity)
    {
//        $processedCartItem = null;
//
//        $cartItems = $this->getCartItems();
//
//        foreach ($cartItems as $cartItem) {
//            if ($cartItem->getProductId() === $product->getId()) {
//                $processedCartItem = $cartItem;
//                break;
//            }
//        }
//
//        if (!$processedCartItem instanceof CartItem) {
//            $processedCartItem = (new CartItem())
//                ->setProduct($product)
//                ->setUserId($userId)
//                ->setId($newCartItemId);
//        }
//
//        $processedCartItem->setQuantity($quantity);
//
//        return $processedCartItem;
    }
}
