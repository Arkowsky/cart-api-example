<?php
declare(strict_types=1);


namespace App\Tests\Catalogue\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetProductControllerTest extends WebTestCase
{
    public function testGetProducts()
    {
        $client = static::createClient();
        $client->request('GET', '/api/catalogue/products');

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertGreaterThan(0, count($contentDecoded['products']));
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
