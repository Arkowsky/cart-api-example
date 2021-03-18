<?php
declare(strict_types=1);


namespace App\Cart\Application\Command;


use App\Cart\Domain\ProductId;
use App\Cart\Domain\UserId;
use Symfony\Component\Uid\Uuid;

class AddProductToUserCartCommand
{
    /** @var Uuid */
    private $id;

    /** @var ProductId */
    private $productId;

    /** @var UserId $userId */
    private $userId;

    /** @var int */
    private $quantity;

    public function __construct(
        Uuid $id,
        ProductId $productId,
        UserId $userId,
        int $quantity = 1
    )
    {
        $this->productId = $productId;
        $this->userId = $userId;
        $this->quantity = $quantity;
        $this->id = $id;
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
