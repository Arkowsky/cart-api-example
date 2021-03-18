<?php
declare(strict_types=1);


namespace App\Cart\Application\Query;


use App\Cart\Domain\UserId;

class GetUserCartQuery
{
    /**
     * @var UserId
     */
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }
}
