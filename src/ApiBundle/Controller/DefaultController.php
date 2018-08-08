<?php
declare(strict_types=1);
namespace ApiBundle\Controller;

use ApiBundle\Model\ApiModel;
use ApiBundle\Service\ApiService;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Model\Form;
use AppBundle\Form\PostType;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class DefaultController
 *
 * @Route("/api")
 */
class DefaultController extends Controller
{
    /**
     * @var array
     */
    private static $mockData = [
        ['obj' => 'user1', 'subj' => 'user2', 'date' => '2018-05-06', 'chat'=>'chat1'],
        ['obj' => 'user2', 'subj' => 'user3', 'date' => '2018-06-08', 'chat'=>'chat2'],
        ['obj' => 'user3', 'subj' => 'user1', 'date' => '2018-03-15', 'chat'=>'chat3'],
        ['obj' => 'user2', 'subj' => 'user4', 'date' => '2017-08-05', 'chat'=>'chat4'],
        ['obj' => 'user3', 'subj' => 'user4', 'date' => '2017-06-05', 'chat'=>'chat5'],
        ['obj' => 'user1', 'subj' => 'user2', 'date' => '2018-07-06', 'chat'=>'chat6'],
        ['obj' => 'user2', 'subj' => 'user4', 'date' => '2017-06-06', 'chat'=>'chat7'],
        ['obj' => 'user3', 'subj' => 'user11', 'date' => '2017-05-10', 'chat'=>'chat8'],
        ['obj' => 'user12', 'subj' => 'user4', 'date' => '2018-10-05','chat'=>'chat9'],
        ['obj' => 'user3', 'subj' => 'user4', 'date' => '2017-06-01', 'chat'=>'chat10'],
    ];

    /**
     * @Route("/chat", name="app_default_api_chat")
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiChatAction(Request $request): JsonResponse
    {

        $serializer = $this->container->get('jms_serializer');
        $data = [];
        foreach (self::$mockData as $el) {
            $model = (new ApiModel())
                ->setObj($el['obj'])
                ->setSubj($el['subj'])
                ->setDate(new \DateTime($el['date']))
                ->setChat($el['chat']);
            $data[] = $serializer->serialize($model, 'json', SerializationContext::create()->setGroups(array('chat')));
        }

        return new JsonResponse(['data' => $data], 200);
    }
}
