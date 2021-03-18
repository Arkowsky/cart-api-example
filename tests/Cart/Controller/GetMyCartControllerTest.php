<?php
declare(strict_types=1);


namespace App\Tests\Cart\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class GetMyCartControllerTest extends WebTestCase
{
    public function test_it_should_get_my_cart_with_products()
    {
        $client = static::createClient();
        $client->request('GET', '/api/my_cart');

        $contentDecoded = json_decode($client->getResponse()->getContent(), true);

        $this->assertNotEmpty($contentDecoded['id']);
        $this->assertCount(2, $contentDecoded['cartItems']);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
