<?php
declare(strict_types=1);

namespace App\Cart\UI\Api;


use App\Cart\Application\Command\AddProductToUserCartCommand;
use App\Cart\Domain\ProductId;
use App\Cart\Domain\UserId;
use App\Cart\Infrastructure\DTO\AddProductToCartPayload;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PostProductToMyCartController extends AbstractFOSRestController
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * @var ValidatorInterface
     */
    protected $validator;
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    public function __construct(
        MessageBusInterface $commandBus,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    )
    {
        $this->commandBus = $commandBus;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function __invoke(Request $request, $userId)
    {
        /** @var AddProductToCartPayload $requestPayload */
        $requestPayload = $this->serializer->deserialize($request->getContent(), AddProductToCartPayload::class, 'json');

        $userId = UserId::fromId($userId);
        $cartItemNewId = Uuid::v4();

        $errors = $this->validator->validate($requestPayload);
        if (count($errors)) {
            $view = $this->view($errors, Response::HTTP_BAD_REQUEST);

            return $this->handleView($view);
        }
        // @TODO: check if product exists - exception

        $this->commandBus->dispatch(new AddProductToUserCartCommand(
            $cartItemNewId,
            ProductId::fromString($requestPayload->getProductId()),
            $userId
        ));

        $view = $this->view(null, Response::HTTP_CREATED);

        return $this->handleView($view);
    }
}
