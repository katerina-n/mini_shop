<?php

namespace ApiBundle\Form\Handler;

use ApiBundle\Form\Type\OrderType;
use AppBundle\Entity\Order;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class OrderFormHandler // extends AbstractFormHandler
{
    public function getNewModelInstance()
    {
        return new Order();
    }

    public function getNewTypeInstance(): string
    {
        return OrderType::class;
    }

}