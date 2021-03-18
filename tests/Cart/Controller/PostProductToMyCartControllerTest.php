<?php
declare(strict_types=1);


namespace App\Tests\Cart\Controller;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class PostProductToMyCartControllerTest extends WebTestCase
{
    public function test_it_should_add_product_to_cart()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/cart/my_cart',
            [
                'productId' => 'd2b3a83c-87bd-4879-a5c9-98781bd8d02b'
            ]
        );

        $this->assertEmpty($client->getResponse()->getContent());
        $this->assertEquals(Response::HTTP_CREATED, $client->getResponse()->getStatusCode());
    }
}
