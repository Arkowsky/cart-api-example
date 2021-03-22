<?php
declare(strict_types=1);


namespace App\Tests\Catalogue\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostProductControllerTest extends WebTestCase
{
    public function testPostProducts()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/catalogue/products',
            [],
            [],
            [],
            json_encode([
                'name' => 'My product',
                'priceValue' => 100,
                'priceCurrency' => 'USD'
            ])
        );

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('id', $contentDecoded);
        $this->assertArrayHasKey('name', $contentDecoded);
        $this->assertArrayHasKey('price', $contentDecoded);
        $this->assertNotEmpty($contentDecoded);
        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }

    public function testPostProductsWithInvalidData()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/catalogue/products',
            [],
            [],
            [],
            json_encode([
                'name' => 'My product',
                'priceValue' => 100,
            ])
        );

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertArrayHasKey('code', $contentDecoded);
        $this->assertArrayHasKey('message', $contentDecoded);
        $this->assertArrayHasKey('errors', $contentDecoded);
        $this->assertNotEmpty($contentDecoded);
        $this->assertEquals(Response::HTTP_BAD_REQUEST, $client->getResponse()->getStatusCode());
    }
}
