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
     * @Rest\Get("/")
     *
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
    {dump($this->get('app.managers.product')->findAll()); exit;
        return $this->get('app.managers.product')->findAll();
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
     * @SWG\Post(
     *     summary="Create profile info",
     *     tags={"Order_Info"},
     *     @SWG\Parameter(
     *         name="data",
     *         in="body",
     *         type="json",
     *         @SWG\Schema(
     *              type="object",
     *              @SWG\Property(property="name", type="string"),
     *              @SWG\Property(property="nationality", type="integer"),
     *              @SWG\Property(property="languages",
     *                            type="array",
     *                            @SWG\Items(type="integer")
     *                              ),
     *              @SWG\Property(property="age", type="integer"),
     *              @SWG\Property(property="height", type="integer"),
     *              @SWG\Property(property="weight", type="integer"),
     *              @SWG\Property(property="breast", type="integer"),
     *              @SWG\Property(property="bustNatural", type="integer"),
     *              @SWG\Property(property="dress", type="integer"),
     *              @SWG\Property(property="gender", type="string", example="female"),
     *              @SWG\Property(property="orientation", type="string", example="hetero"),
     *              @SWG\Property(property="smoker", type="string", example="no"),
     *              @SWG\Property(property="tattoo", type="integer", example="no"),
     *              @SWG\Property(property="willingToSee",
     *                            type="array",
     *                            @SWG\Items(type="integer")
     *                              ),
     *             @SWG\Property(property="labels",
     *                           type="array",
     *                           @SWG\Items(type="integer")
     *                             )
     *                          )
     *                        ),
     *     @SWG\Response(
     *          response=201,
     *          description="Profile info created",
     *     ),
     *     @SWG\Response(response="404", description="not found"),
     *     @SWG\Response(response="400", description="Duplicate entry for key, please choose another name"),
     *
     * )
     *
     * @return Response
     *
     * @Rest\View(statusCode=201, serializerGroups={"ApiProfile"})
     *
     * @throws \Exception
     */
    public function createAction()
    {
        return $this->get('diva_rest.form_handler.profile_info_form_handler')
            ->setMethod('POST')
            ->handle();
    }
}