<?php
namespace ApiBundle\Controller;


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
class DefaultController
{
    /**
     * @Rest\Get("/{id}")
     *
     *
     * @SWG\Get(
     *     summary="Get profile_info by Id.",
     *     tags={"Profile_Info"},
     *     @SWG\Parameter(name="id", in="path", description="profile_id", type="integer"),
     *     @SWG\Response(
     *         response=200,
     *         description="Return profile info",
     *         @Model(type=\Diva\ProfileBundle\Entity\Profile::class, groups={"ApiProfile"})
     *         ),
     *     @SWG\Response(response="404", description="not found"),
     * )
     *
     * @Rest\View(statusCode=200, serializerGroups={"ApiProfile"})
     *
     * @return
     *
     * @throws \Exception
     */
    public function getAction()
    {
        return 1;
    }
}