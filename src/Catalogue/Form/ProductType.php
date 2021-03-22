<?php
declare(strict_types=1);


namespace App\Catalogue\Form;


use App\Catalogue\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('priceValue')
            ->add('priceCurrency');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => Product::class,
                'allow_extra_fields' => true,
                'csrf_protection' => false,
            ]
        );
    }
}
