<?php
declare(strict_types=1);


namespace App\Tests\Catalogue\Controller;

use App\Catalogue\DataFixtures\ProductFixtures;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PatchProductControllerTest extends WebTestCase
{
    public function testPatchProductName()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/catalogue/products/' . ProductFixtures::PRODUCT_WITH_CONST_ID,
            [
                'name' => 'Awesome product XXY'
            ]
        );

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($contentDecoded);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testPatchProductPrice()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/catalogue/products/' . ProductFixtures::PRODUCT_WITH_CONST_ID,
            [
                'price' => 500,
                'currency' => 'EUR'
            ]
        );

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($contentDecoded);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testProductNotFoundError()
    {
        $client = static::createClient();
        $client->request(
            'PATCH',
            '/api/catalogue/products/cba3907e-81d1-4fbc-b3f7-51837c8b31f5',
            [
                'price' => 500,
                'currency' => 'EUR'
            ]
        );

        $this->assertEquals(Response::HTTP_NOT_FOUND, $client->getResponse()->getStatusCode());
    }
}
