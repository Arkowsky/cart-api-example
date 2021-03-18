<?php
declare(strict_types=1);


namespace App\Cart\Domain;


class UserId
{
    private $userId;

    public static function fromId(int $userId)
    {
        return new self($userId);
    }
    protected function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
