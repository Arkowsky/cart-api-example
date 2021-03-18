<?php
declare(strict_types=1);


namespace App\Cart\Domain;


use App\Cart\Domain\Exception\MaxCartItemsCountExceededException;
use Symfony\Component\Uid\Uuid;

class Cart
{
    /** @var Uuid */
    private $id;

    /** @var UserId */
    private $userId;

    /** @var null|CartItem[] */
    private $cartItems;

    public CONST MAX_CART_ITEMS = 3;

    public static function createUserCart(UserId $userId, ?array $cartItems = null)
    {
        $cart = new self(null, $userId);
        $cart->cartItems = $cartItems;

        return $cart;
    }

    public static function fromDbRecord(array $record)
    {
        $cart = new self(Uuid::fromString($record['id']), UserId::fromId($record['userId']));
        $cart->cartItems = array_map(function ($product) {
            return CartItem::fromDbRecord($product);
        }, $record['products']);

        return $cart;
    }

    protected function __construct(?Uuid $id, UserId $userId)
    {
        $this->id = null === $id ? Uuid::v4() : $id;
        $this->userId = $userId;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getCartItems(): ?array
    {
        return $this->cartItems;
    }

    public function addCartItem(ProductId $productId, int $quantity)
    {
        $processedCartItem = null;

        $cartItems = $this->getCartItems();

        foreach ($cartItems as $cartItem) {
            if ($cartItem->getProductId() == $productId) {
                $cartItem->increaseQuantity($quantity);
                return;
            }
        }

        if (count($cartItems) + 1 >= self::MAX_CART_ITEMS) {
            throw new MaxCartItemsCountExceededException(count($cartItems));
        }

        $newCartItem = CartItem::fromProductId($productId, $quantity);

        array_push($this->cartItems, $newCartItem);
    }
}
