<?php

namespace AdamwjtkClientBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProductForm extends AbstractType implements IFormFields
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(self::ITEM_TABLE_FIELD_NAME)
            ->add(self::ITEM_TABLE_AMOUNT_NAME,IntegerType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'adamwjtk_client_bundle_product';
    }
}
