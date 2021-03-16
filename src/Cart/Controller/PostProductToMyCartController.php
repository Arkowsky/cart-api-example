<?php
declare(strict_types=1);

namespace App\Cart\Controller;


use FOS\RestBundle\Controller\AbstractFOSRestController;

class PostProductToMyCartController extends AbstractFOSRestController
{
    public function __invoke()
    {
        $data = [
            'id' => 'b5b34004-1ee3-4476-813e-3a213fd2a1bf',
            'products' => [
                '0cf846aa-b521-4b01-8acf-7f46c20e12b6',
                '2095d195-afe1-4752-a531-a183fe62865a'
            ]
        ];

        $view = $this->view($data, 200);

        return $this->handleView($view);
    }
}
