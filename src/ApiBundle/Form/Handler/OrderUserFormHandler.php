<?php

namespace ApiBundle\Form\Handler;

use ApiBundle\Form\Type\UserOrderType;
use AppBundle\Entity\UserOrder;

class OrderUserFormHandler  extends AbstractFormHandler
{
    public function getNewModelInstance()
    {
        return new UserOrder();
    }

    public function getNewTypeInstance(): string
    {
        return UserOrderType::class;
    }
}