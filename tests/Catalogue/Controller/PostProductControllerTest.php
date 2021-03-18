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
            [
                'name' => 'My product',
                'price' => 100,
                'currency' => 'USD'
            ]
        );

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($contentDecoded);
        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
