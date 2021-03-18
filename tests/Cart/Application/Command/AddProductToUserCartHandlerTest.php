<?php
declare(strict_types=1);


namespace App\Tests\Cart\Application\Command;


use App\Cart\Application\Command\AddProductToUserCartCommand;
use App\Cart\Application\Command\AddProductToUserCartHandler;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Cart;
use App\Cart\Domain\ProductId;
use App\Cart\Domain\UserCartFactory;
use App\Cart\Domain\UserId;
use App\Cart\Domain\Event\ProductAddedToCart;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class AddProductToUserCartHandlerTest extends TestCase
{
    private CONST USER_ID = 2;
    private CONST PRODUCT_ID = 'd2b3a83c-87bd-4879-a5c9-98781bd8d02b';

    public function test_it_should_add_product_to_cart()
    {
        $productId = ProductId::fromString(
            self::PRODUCT_ID
        );

        $itemId = Uuid::v4();

        $messageBus = $this->prophesize(MessageBusInterface::class);

        $cart = $this->prophesize(Cart::class);
        $cartRepository = $this->prophesize(CartRepositoryInterface::class);
        $cartRepository->save($cart)->shouldBeCalled();
        $userCartFactory = $this->prophesize(UserCartFactory::class);
        $userCartFactory->create(UserId::fromId(self::USER_ID))->willReturn(
            $cart->reveal()
        );

        $envelope = new Envelope(new \stdClass());
        $messageBus->dispatch(
            new ProductAddedToCart(
                $itemId,
                $productId
        ))->shouldBeCalled()->willReturn($envelope);

        $commandHandler = new AddProductToUserCartHandler(
            $messageBus->reveal(),
            $cartRepository->reveal(),
            $userCartFactory->reveal()
        );

        $commandHandler(new AddProductToUserCartCommand(
            $itemId,
            $productId,
            UserId::fromId(self::USER_ID)
        ));
    }
}
