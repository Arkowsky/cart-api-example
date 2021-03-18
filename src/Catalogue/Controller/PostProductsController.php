<?php
declare(strict_types=1);


namespace App\Catalogue\Controller;


use App\Catalogue\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PostProductsController extends AbstractFOSRestController
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager): Response
    {
        $price = new Money($request->get('price'), new Currency($request->get('currency')));
        $name = $request->get('name');

        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        $entityManager->persist($product);
        $entityManager->flush();

        $view = $this->view(
            $product,
            Response::HTTP_CREATED
        );

        return $this->handleView($view);
    }
}
