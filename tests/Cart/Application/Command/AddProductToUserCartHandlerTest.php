<?php
declare(strict_types=1);


namespace App\Tests\Cart\Application\Command;


use App\Cart\Application\Command\AddProductToUserCartCommand;
use App\Cart\Application\Command\AddProductToUserCartHandler;
use App\Cart\Domain\CartItem;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\Cart;
use App\Cart\Domain\Exception\MaxCartItemsCountExceededException;
use App\Cart\Domain\Product;
use App\Cart\Domain\ProductId;
use App\Cart\Domain\ProductRepositoryInterface;
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
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findById($productId)->willReturn(
            Product::fromDBFields(['productId' => $productId->getProductId()->toBase32()])
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
            $userCartFactory->reveal(),
            $productRepository->reveal()
        );

        $commandHandler(new AddProductToUserCartCommand(
            $itemId,
            $productId,
            UserId::fromId(self::USER_ID)
        ));
    }

    public function test_it_should_through_max_cart_items_count_exception()
    {
        $productId = ProductId::fromString(
            self::PRODUCT_ID
        );

        $userId = UserId::fromId(self::USER_ID);

        $messageBus = $this->prophesize(MessageBusInterface::class);

        $cart = $this->getCartWithMaxItemCount($userId);
        $cartRepository = $this->prophesize(CartRepositoryInterface::class);
        $userCartFactory = $this->prophesize(UserCartFactory::class);
        $userCartFactory->create($userId)->willReturn(
            $cart
        );
        $productRepository = $this->prophesize(ProductRepositoryInterface::class);
        $productRepository->findById($productId)->willReturn(
            Product::fromDBFields(['productId' => $productId->getProductId()->toBase32()])
        );

        $commandHandler = new AddProductToUserCartHandler(
            $messageBus->reveal(),
            $cartRepository->reveal(),
            $userCartFactory->reveal(),
            $productRepository->reveal()
        );

        $this->expectException(MaxCartItemsCountExceededException::class);

        $commandHandler(new AddProductToUserCartCommand(
            Uuid::v4(),
            $productId,
            UserId::fromId(self::USER_ID)
        ));
    }

    private function getCartWithMaxItemCount(UserId $userId)
    {
        return Cart::createUserCart(
            $userId,
            [
                CartItem::fromProductId(ProductId::fromString('4d961e02-df90-4f7a-b018-c3523af285ea'), 1),
                CartItem::fromProductId(ProductId::fromString('b4fc2477-168d-47db-82dd-fda06d4c48d3'), 2),
                CartItem::fromProductId(ProductId::fromString('a9166d8b-dee2-4eab-82e1-db0bfd19b3a3'), 1)
            ]
        );
    }
}
