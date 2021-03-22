<?php
declare(strict_types=1);


namespace App\Catalogue\Entity;


use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity()
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     *
     * @var Uuid
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=24)
     *
     * @var string
     */
    private $priceValue;

    /**
     * @ORM\Column(type="string", length=10)
     *
     * @var string
     */
    private $priceCurrency;

    public function __construct()
    {
        if (!$this->id) {
            $this->id = Uuid::v4();
        }
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function setId(Uuid $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getPriceValue(): string
    {
        return $this->priceValue;
    }

    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    public function setPriceValue(string $priceValue): void
    {
        $this->priceValue = $priceValue;
    }

    public function setPriceCurrency(string $priceCurrency): void
    {
        $this->priceCurrency = $priceCurrency;
    }

    public function getPrice(): ?Money
    {
        return $this->priceValue && $this->priceCurrency
            ? new Money($this->priceValue, new Currency($this->priceCurrency))
            : null;
    }

    public function setPriceFromMoney(Money $price): void
    {
        $this->priceValue = $price->getAmount();
        $this->priceCurrency = $price->getCurrency()->getCode();
    }
}
