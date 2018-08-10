<?php
namespace ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * Class DefaultController
 *
 * @Rest\Prefix("/info")
 * @Rest\NamePrefix("_info_")
 **/
class DefaultController extends FOSRestController
{
    /**
     * @Rest\Get("/")
     *
     * @SWG\Get(
     *     summary="Get all products",
     *     tags={"Order_Info"},
     *     @SWG\Response(
     *         response=200,
     *         description="Return all products"),
     *     @SWG\Response(response="404", description="not found"),
     * )
     *
     * @Rest\View(statusCode=200)
     *
     * @return
     *
     * @throws \Exception
     */
    public function getAllProductsAction()
    {
        return $this->get('app.managers.product_managers')->findAll();
    }
    /**
     * @Rest\Get("/{id}")
     *
     * @SWG\Get(
     *     summary="Get order_info by Id.",
     *     tags={"Order_Info"},
     *     @SWG\Parameter(name="id", in="path", description="order_id", type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Return user_order info"),
     *     @SWG\Response(response="404", description="not found"),
     * )
     *
     * @Rest\View(statusCode=200)
     *
     * @return
     *
     * @throws \Exception
     */
    public function getOrderAction($id)
    {
       // dump($this->get('app.managers.order_managers')->findAll()); exit;
        return $this->get('app.managers.order_managers')->find($id);
    }

    /**
     * @Rest\Post("/")
     *
     * @SWG\Post(
     *     tags={"Order_Info"},
     *    @SWG\Parameter(
     *         name="data",
     *         in="body",
     *         type="json",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="summa", type="integer"),
     *            )
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="Order created",
     *     ),
     *     @SWG\Response(response="404", description="not found"),
     *     @SWG\Response(response="400", description=""),
     *
     * )
     *
     * @return
     *
     * @Rest\View(statusCode=201, serializerGroups={"Default"})
     *
     * @throws \Exception
     */
    public function createOrderAction()
    {
        return $this->get('api.form.order_handler')
            ->setMethod('POST')
            ->handle();
    }

    /**
     * @Rest\Post("/create/product")
     *
     * @param Request $request
     *
     *
     * @SWG\Post(
     *     tags={"Order_Info"},
     *     @SWG\Parameter(
     *         name="data",
     *         in="body",
     *         type="json",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="name", type="string"),
     *              @SWG\Property(property="price", type="integer"),
     *            )
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="product created",
     *     ),
     *     @SWG\Response(response="404", description="not found"),
     *
     * )
     *
     * @return
     *
     * @Rest\View(statusCode=201, serializerGroups={"Default"})
     *
     * @throws \Exception
     */
    public function createProductAction(Request $request)
    {
        return $this->get('api.form.product_handler')
            ->setMethod('POST')
            ->handle();
    }

    /**
     * @Rest\Post("/create/user_order")
     *
     * @param Request $request
     *
     *
     * @SWG\Post(
     *     tags={"Order_Info"},
     *     @SWG\Parameter(
     *         name="data",
     *         in="body",
     *         type="json",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="product", type="integer"),
     *              @SWG\Property(property="count", type="integer"),
     *              @SWG\Property(property="price", type="integer"),
     *              @SWG\Property(property="order", type="integer"),
     *            )
     *     ),
     *     @SWG\Response(
     *          response=201,
     *          description="product created",
     *     ),
     *     @SWG\Response(response="404", description="not found"),
     *
     * )
     *
     * @return
     *
     * @Rest\View(statusCode=201, serializerGroups={"Default"})
     *
     * @throws \Exception
     */
    public function createUserOrderAction(Request $request)
    {
        return $this->get('api.form.user_order_handler')
            ->setMethod('POST')
            ->handle();
    }

    /**
     * @Rest\Get("/get/user/order/{id}")
     *
     * @SWG\Get(
     *     summary="Get order by Id user",
     *     tags={"Order_Info"},
     *     @SWG\Parameter(name="id", in="path", description="order_id", type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Return all products"),
     *     @SWG\Response(response="404", description="not found"),
     * )
     *
     * @Rest\View(statusCode=200)
     *
     * @return
     *
     * @throws \Exception
     */
    public function getOrderByIdAction($id)
    {
        return $this->get('app.managers.user_order')->find($id);
    }
}