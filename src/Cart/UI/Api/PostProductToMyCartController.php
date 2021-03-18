<?php
declare(strict_types=1);

namespace App\Cart\UI\Api;


use App\Cart\Application\Command\AddProductToUserCartCommand;
use App\Cart\Domain\ProductId;
use App\Cart\Domain\UserId;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Uid\Uuid;

class PostProductToMyCartController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    public function __construct(MessageBusInterface $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request, $userId)
    {
        $productId = $request->get('productId');
        $userId = UserId::fromId($userId);
        $cartItemNewId = Uuid::v4();

        // @TODO: check if product exists - exception

        $this->commandBus->dispatch(new AddProductToUserCartCommand(
            $cartItemNewId,
            ProductId::fromString($productId),
            $userId
        ));

        $view = $this->view(null, Response::HTTP_CREATED);

        return $this->handleView($view);
    }
}
