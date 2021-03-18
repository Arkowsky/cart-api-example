<?php
declare(strict_types=1);


namespace App\Catalogue\Controller;


use App\Catalogue\Entity\Product;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;

class GetProductsController extends AbstractFOSRestController
{
    public function __invoke()
    {
        $products = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAll();

        $view = $this->view(
            [
                'products' => $products
            ],
            Response::HTTP_OK
        );

        // @TODO: add KnpPaginatorBundle to paginate

        return $this->handleView($view);
    }
}
