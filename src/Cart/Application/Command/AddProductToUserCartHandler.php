<?php
declare(strict_types=1);


namespace App\Cart\Application\Command;


use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Event\ProductAddedToCart;
use App\Cart\Domain\Exception\ProductNotFoundException;
use App\Cart\Domain\ProductRepositoryInterface;
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
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        MessageBusInterface $eventBus,
        CartRepositoryInterface $cartRepository,
        UserCartFactory $userCartFactory,
        ProductRepositoryInterface $productRepository
    )
    {
        $this->eventBus = $eventBus;
        $this->cartRepository = $cartRepository;
        $this->userCartFactory = $userCartFactory;
        $this->productRepository = $productRepository;
    }

    public function __invoke(AddProductToUserCartCommand $command)
    {
        if (!$this->productRepository->findById($command->getProductId())) {
            return ProductNotFoundException::fromProductId($command->getProductId());
        }

        $cart = $this->userCartFactory->create($command->getUserId());
        $cart->addCartItem($command->getProductId(), $command->getQuantity());

        $this->cartRepository->save($cart);

        $this->eventBus->dispatch(
            new ProductAddedToCart($command->getId(), $command->getProductId())
        );
    }
}
