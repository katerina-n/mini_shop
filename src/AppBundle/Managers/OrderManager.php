<?php

namespace AppBundle\Managers;
use AppBundle\AppBundle;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class OrderManager.
 */
class OrderManager extends AbstractManager
{
    public function setOrder(Request $request, $event_type)
    {
//        $em = $this->getEntityManager();
//       // $product = $request->request->get('product');
//       $product =  $this->getRepository(Product::class)->find($request->request->get('product'));
//        $event_type->setPrice($product);
//        $event_type->setOrderUser($request->getUser());
//       // dump($event_type); exit;
//        $em->persist($event_type);
//        $em->flush();

    }
}