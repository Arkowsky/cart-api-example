<?php
declare(strict_types=1);

namespace App\Cart\UI\Api;


use App\Cart\Application\Query\GetUserCartQuery;
use App\Cart\Domain\UserId;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class GetMyCartController extends AbstractFOSRestController
{
    /**
     * @var MessageBusInterface
     */
    private $queryBus;
    /**
     * @var int
     */
    private $userId;

    public function __construct(MessageBusInterface $queryBus, int $userId)
    {
        $this->queryBus = $queryBus;
        $this->userId = $userId;
    }

    public function __invoke()
    {
        $userId = UserId::fromId($this->userId);
        $envelope = $this->queryBus->dispatch(
            new GetUserCartQuery($userId)
        );
        $handledStamp = $envelope->last(HandledStamp::class);
        $data = $handledStamp->getResult();

        $view = $this->view($data, Response::HTTP_OK);

        return $this->handleView($view);
    }
}
