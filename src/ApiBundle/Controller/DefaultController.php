<?php
namespace ApiBundle\Controller;


use ApiBundle\Form\Type\OrderType;
use AppBundle\Entity\Order;
use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
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
     *
     * @SWG\Get(
     *     summary="Get user_order_info by Id.",
     *     tags={"Order_Info"},
     *     @SWG\Parameter(name="id", in="path", description="user_order_id", type="integer"),
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
    public function getAction()
    {
        return $this->getViewHandler();
    }

    /**
     * @Rest\Post("/")
     *
     * @param Request $request
     *
     *
     * @SWG\Post(
     *     summary="Create order",
     *     tags={"Order_Info"},
     *     consumes={"application/x-www-form-urlencoded"},
     *     @SWG\Parameter(name="product", in="formData", description="product", type="integer"),
     *     @SWG\Parameter(name="count", in="formData", description="count", type="integer"),
     *     @SWG\Response(
     *          response=201,
     *          description="Order created",
     *     ),
     *     @SWG\Response(response="404", description="not found"),
     *     @SWG\Response(response="400", description="Duplicate entry for key, please choose another name"),
     *
     * )
     *
     * @return
     *
     * @Rest\View(statusCode=201)
     *
     * @throws \Exception
     */
    public function createAction(Request $request)
    {
        $event_type = new Order();
        $form = $this->createForm(OrderType::class, $event_type);
        $form->submit($request->request->all());
        $em = $this->get('app.managers.order_managers')->getEntityManager();

        if ($form->isValid()) {
            $product = $this->get('app.managers.product_managers')->find($request->request->get('product'));
            $event_type->setPrice($product);
            $event_type->setOrderUser($this->getUser());
            //dump($event_type); exit;
            $em->persist($event_type);
            $em->flush();
          $this->get('app.managers.order_managers')->setOrder($request, $event_type);
            return View::create($event_type, Response::HTTP_CREATED , []);
        }
        return View::create($form, Response::HTTP_BAD_REQUEST , []);
       // return $this->get('api.form.order_handler')->getNewTypeInstance();
//            ->setMethod('POST')
//            ->handle();
    }
}