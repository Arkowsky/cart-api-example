<?php
declare(strict_types=1);


namespace App\Cart\Application\Query;


use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\UserId;
use App\Cart\Infrastructure\Messenger\QueryHandlerInterface;

class GetUserCartQueryHandler implements QueryHandlerInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;
    /**
     * @var int
     */
    private $userId;

    public function __construct(CartRepositoryInterface $cartRepository, int $userId)
    {
        $this->cartRepository = $cartRepository;
        $this->userId = $userId;
    }

    public function __invoke(GetUserCartQuery $query)
    {
        $cart = $this->cartRepository->getByUserId(UserId::fromId($this->userId));

        return $cart;
    }
}
