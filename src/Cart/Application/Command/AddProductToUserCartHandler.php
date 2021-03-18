<?php
declare(strict_types=1);


namespace App\Cart\Application\Command;


use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Event\ProductAddedToCart;
use App\Cart\Domain\UserCartFactory;
use App\Cart\Infrastructure\Messenger\CommandHandlerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class AddProductToUserCartHandler implements CommandHandlerInterface
{
    /**
     * @var MessageBusInterface
     */
    private $eventBus;

    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var UserCartFactory
     */
    private $userCartFactory;

    public function __construct(
        MessageBusInterface $eventBus,
        CartRepositoryInterface $cartRepository,
        UserCartFactory $userCartFactory
    )
    {
        $this->eventBus = $eventBus;
        $this->cartRepository = $cartRepository;
        $this->userCartFactory = $userCartFactory;
    }

    public function __invoke(AddProductToUserCartCommand $command)
    {
        $cart = $this->userCartFactory->create($command->getUserId());
        $cart->addCartItem($command->getProductId(), $command->getQuantity());

        $this->cartRepository->save($cart);

        $this->eventBus->dispatch(
            new ProductAddedToCart($command->getId(), $command->getProductId())
        );
    }
}
