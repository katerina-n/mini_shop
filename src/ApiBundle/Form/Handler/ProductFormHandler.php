<?php

namespace ApiBundle\Form\Handler;

use ApiBundle\Form\Type\ProductType;
use AppBundle\Entity\Product;

class ProductFormHandler  extends AbstractFormHandler
{
    public function getNewModelInstance()
    {
        return new Product();
    }

    public function getNewTypeInstance(): string
    {
        return ProductType::class;
    }

}