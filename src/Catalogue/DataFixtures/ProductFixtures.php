<?php
declare(strict_types=1);


namespace App\Catalogue\DataFixtures;


use App\Catalogue\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Money\Currency;
use Money\Money;

class ProductFixtures extends Fixture
{

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
        $manager->flush();
    }
}
