<?php

namespace ApiBundle\Form\Handler;

use ApiBundle\Form\Type\OrderType;
use AppBundle\Entity\Order;

class OrderFormHandler  extends AbstractFormHandler
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