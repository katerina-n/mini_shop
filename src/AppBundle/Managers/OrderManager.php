<?php

namespace AppBundle\Managers;
use AccountBundle\Entity\User;
use AppBundle\AppBundle;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use AppBundle\Entity\UserOrder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrderManager.
 */
class OrderManager extends AbstractManager
{

}