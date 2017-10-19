<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 17.10.17
 * Time: 22:56
 */

namespace AppBundle\Controller;

use AppBundle\Services\ApiBrowser;
use AppBundle\Services\ResponseHandlers\FastestHandler;
use AppBundle\Services\CrawlerResponseHandlers\ICrawlerResponseHandler;
use AppBundle\Services\ResponseHandlers\IResponseHandler;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class NeoController extends FOSRestController
{
    /**
     * @Rest\Get("/neo/hazardous")
     *
     * @return JsonResponse
     */
    public function getHazardousAction(SerializerInterface $serializer)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        $data = $em->getRepository('AppBundle:NearEarthObject')->findBy(['isHazardous' => true]);
        $data = $serializer->serialize($data, 'json');

        $response = new JsonResponse();
        $response->setContent($data);

        return $response;
    }

    /**
     * @Rest\Get("/neo/fastest")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getFastestAction(Request $request)
    {
        $hazardous = $request->query->get('hazardous', false);
        $hazardous = ('true' == strtolower($hazardous)) ? true : false;

        /** @var IResponseHandler|FastestHandler $responseHandler */
        $responseHandler = $this->get('AppBundle\Services\ResponseHandlers\FastestHandler');
        $responseHandler->setIsHazardous($hazardous);

        /** @var ICrawlerResponseHandler $crawlerResponseHandler */
        $crawlerResponseHandler = $this->get('AppBundle\Services\CrawlerResponseHandlers\FastestHandler');

        /** @var ApiBrowser $crawler */
        $crawler = $this->get('api.browser');

        $result = $crawler->browse($responseHandler, $crawlerResponseHandler);

        return new JsonResponse($result['neo']);
    }

    /**
     * @Rest\Get("/neo/best-year")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBestYear(Request $request)
    {
        $hazardous = $request->query->get('hazardous', false);
        $hazardous = ('true' == strtolower($hazardous)) ? true : false;

        // Not sure - Should we process all the data - from API ? Implemented processing from API
        /** @var IResponseHandler|FastestHandler $responseHandler */
        $responseHandler = $this->get('AppBundle\Services\ResponseHandlers\BestyearHandler');
        $responseHandler->setIsHazardous($hazardous);

        /** @var ICrawlerResponseHandler $crawlerResponseHandler */
        $crawlerResponseHandler = $this->get('AppBundle\Services\CrawlerResponseHandlers\BestyearHandler');

        /** @var ApiBrowser $crawler */
        $crawler = $this->get('api.browser');

        $result = $crawler->browse($responseHandler, $crawlerResponseHandler);

        sort($result);
        $count = reset($result);
        $year = key($result);

        return new JsonResponse([$year => $count]);
    }

    /**
     * @Rest\Get("/neo/best-month")
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getBestMonth(Request $request)
    {
        $hazardous = $request->query->get('hazardous', false);
        $hazardous = ('true' == strtolower($hazardous)) ? true : false;

        // Not sure - Should we process all the data - from API ? Implemented processing from API
        /** @var IResponseHandler|FastestHandler $responseHandler */
        $responseHandler = $this->get('AppBundle\Services\ResponseHandlers\BestmonthHandler');
        $responseHandler->setIsHazardous($hazardous);

        /** @var ICrawlerResponseHandler $crawlerResponseHandler */
        $crawlerResponseHandler = $this->get('AppBundle\Services\CrawlerResponseHandlers\BestmonthHandler');

        /** @var ApiBrowser $crawler */
        $crawler = $this->get('api.browser');

        $result = $crawler->browse($responseHandler, $crawlerResponseHandler);

        sort($result);
        $count = reset($result);
        $month = key($result);

        return new JsonResponse([$month => $count]);
    }
}
