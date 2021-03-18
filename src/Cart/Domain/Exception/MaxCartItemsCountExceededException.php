<?php
declare(strict_types=1);

namespace App\Cart\Domain\Exception;


class MaxCartItemsCountExceededException extends \RuntimeException
{
    public function __construct(int $itemsCount)
    {
        parent::__construct(sprintf("Max count of cart items exceeded. Can not add new item, cart has %s already items.", $itemsCount));
    }
}
