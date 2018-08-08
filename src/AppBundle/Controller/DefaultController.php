<?php
declare(strict_types=1);
namespace AppBundle\Controller;

use ApiBundle\Model\ApiModel;
use AppBundle\Entity\Chat;
use AppBundle\Entity\ChatMessages;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Form;
use AppBundle\Form\PostType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use AppBundle\Service\ChatService;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('AccountBundle:Default:index.html.twig');
    }



}