<?php
declare(strict_types=1);


namespace App\Tests\Cart\Application\Query;


use App\Cart\Application\Query\GetUserCartQuery;
use App\Cart\Application\Query\GetUserCartQueryHandler;
use App\Cart\Domain\CartRepositoryInterface;
use App\Cart\Domain\UserId;
use PHPUnit\Framework\TestCase;

class GetUserCartQueryHandlerTest extends TestCase
{
    public CONST USER_ID = 1;

    public function test_it_should_get_user_cart()
    {
        $cartRepository = $this->prophesize(CartRepositoryInterface::class);
        $cartRepository->getByUserId(UserId::fromId(self::USER_ID))->shouldBeCalled();
        $queryHandler = new GetUserCartQueryHandler(
            $cartRepository->reveal(),
            self::USER_ID
        );

        $queryHandler(
            new GetUserCartQuery(
                UserId::fromId(self::USER_ID)
            )
        );
    }
}
