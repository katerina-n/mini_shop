<?php
namespace ApiBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as API;

/**
 * Class DefaultController
 *
 * @Rest\Prefix("/info")
 * @Rest\NamePrefix("_info_")
 **/
class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/{id}")
     *
     *
     * @SWG\Get(
     *     summary="Get order_info by Id.",
     *     tags={"Product_Info"},
     *     @SWG\Parameter(name="id", in="path", description="product_id", type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Return product info"),
     *     @SWG\Response(response="404", description="not found"),
     * )
     *
     * @Rest\View(statusCode=200)
     *
     * @return
     *
     * @throws \Exception
     */
    public function getAction()
    { dump(1); exit;
        return $this->getViewHandler();
    }
}