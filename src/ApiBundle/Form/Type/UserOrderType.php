<?php

namespace ApiBundle\Form\Type;

use AppBundle\Entity\UserOrder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('user');
        $builder->add('count');
        $builder->add('order');
        $builder->add('product');
        $builder->add('price');
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['csrf_protection' => false, 'data_class' => UserOrder::class]);
    }

    public function getBlockPrefix()
    {
        return null;
    }
}