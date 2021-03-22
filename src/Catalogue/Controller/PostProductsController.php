<?php
declare(strict_types=1);


namespace App\Catalogue\Controller;


use App\Catalogue\Entity\Product;
use App\Catalogue\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class PostProductsController extends AbstractFOSRestController
{
    public function __invoke(Request $request, EntityManagerInterface $entityManager)
    {
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(ProductType::class, new Product());
        $form->submit($data);

        if (!$form->isValid()) {
            $view = $this->view(
                $form,
                Response::HTTP_BAD_REQUEST
            );

            return $this->handleView($view);
        }
        /** @var Product $product */
        $product = $form->getData();

        $entityManager->persist($product);
        $entityManager->flush();

        $view = $this->view(
            $product,
            Response::HTTP_CREATED
        );

        return $this->handleView($view);
    }
}
