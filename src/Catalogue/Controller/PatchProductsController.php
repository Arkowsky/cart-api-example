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
use Symfony\Component\Uid\Uuid;


class PatchProductsController extends AbstractFOSRestController
{
    public function __invoke(string $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find(Uuid::fromString($id)->toBinary());

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $price = $request->get('price') && $request->get('currency')
            ? new Money($request->get('price'), new Currency($request->get('currency')))
            : null;
        $name = $request->get('name');

        $name ? $product->setName($name) : null;
        $price ? $product->setPrice($price) : null;

        $entityManager->flush();

        $view = $this->view(
            $product,
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }
}
