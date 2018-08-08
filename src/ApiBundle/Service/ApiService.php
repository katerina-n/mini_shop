<?php
declare(strict_types=1);
namespace ApiBundle\Service;

use ApiBundle\Model\ApiModel;
use GuzzleHttp\Client;
use AppBundle\Model\Form;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class ApiService
 * @package ApiBundle\Service
 */
class ApiService
{

//    public function add

    /**
     * @param Form $dateTime
     * @param string $url
     * @param array $params
     * @return array
     */
    public function requestSend(Form $dateTime, string $url, array $params = []):array
    {
        $client = new Client();
        $request = $client->request('GET', $url, [
            'form_params' => $params

        ]);

        if (200 !== $request->getStatusCode()) {
            return new Exception('Bad request');
        } else {
            if (!empty($request->getBody())) {
                $content = $request->getBody()->getContents();
               // dump($content); exit;
                $content = json_decode($content, true);
               // dump($content); exit;
                $res = [];

                foreach ($content['data'] as $row) {
                  //  dump($content); exit;
                    $row = json_decode($row, true);

                    if ((new \DateTime($row['date']) >= new \DateTime($dateTime->getDateFirst()->format('Y-m-d'))) && (new \DateTime($row['date']) <= new \DateTime($dateTime->getDateLast()->format('Y-m-d')))) {
                        $res[] = (new ApiModel())
                            ->setObj($row['obj'])
                            ->setSubj($row['subj'])
                            ->setDate(new \DateTime($row['date']))
                            ->setChat($row['chat']);

                    }
                }

//
                return $res;
                }

            return new Exception('Bag request') ;
        }

    }


}