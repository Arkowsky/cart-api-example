<?php
declare(strict_types=1);


namespace App\Catalogue\Controller;


use App\Catalogue\Entity\Product;
use App\Catalogue\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\Uuid;


class PatchProductsController extends AbstractFOSRestController
{
    public function __invoke(string $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find(Uuid::fromString($id)->toBinary());

        if (!$product) {
            throw $this->createNotFoundException('Product not found');
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->submit($data, false);

        if (!$form->isValid()) {
            $view = $this->view(
                $form,
                Response::HTTP_BAD_REQUEST
            );

            return $this->handleView($view);
        }

        $entityManager->flush();

        $view = $this->view(
            $product,
            Response::HTTP_OK
        );

        return $this->handleView($view);
    }
}
