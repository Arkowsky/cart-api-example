<?php
declare(strict_types=1);


namespace App\Catalogue\DataFixtures;


use App\Catalogue\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;
use Symfony\Component\Uid\Uuid;

class ProductFixtures extends Fixture
{
    public CONST PRODUCT_WITH_CONST_ID = 'b65c147e-e659-44c7-8e1a-873cb18b0388';

    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++) {
            $product = new Product();
            $product->setName('good product ' . $i);
            $product->setPrice(
                new Money(10 * $i, new Currency('PLN'))
            );
            $manager->persist($product);
        }

        // product with known identifier
        $product = new Product();
        $product->setId(Uuid::fromString(self::PRODUCT_WITH_CONST_ID));
        $product->setName('well known product');
        $product->setPrice(
            new Money(200, new Currency('PLN'))
        );
        $manager->persist($product);

        $manager->flush();
    }
}
