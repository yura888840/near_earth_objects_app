<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 11:01
 */

namespace AppBundle\Services;

use AppBundle\Services\CrawlerResponseHandlers\ICrawlerResponseHandler;
use AppBundle\Services\ResponseHandlers\IResponseHandler;

class ApiBrowser
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * ApiCrawler constructor.
     * @param ApiClient $apiClient
     */
    public function __construct(ApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * @param IResponseHandler $responseHandler
     * @param ICrawlerResponseHandler $crawlerResponseHandler
     * @return array
     */
    public function browse(
        IResponseHandler $responseHandler,
        ICrawlerResponseHandler $crawlerResponseHandler
    )
    {
        $url    = ApiClient::NEO_BROWSE;
        $data   = [
            'max_speed' => 0,
            'neo'       => [],
        ];

        while (!empty($url)) {
            $result = $this->apiClient->doRequest($url, [], $responseHandler);
            $data = $crawlerResponseHandler->handleBrowserResponse($result, $data);

            $url = $result['next'];
        }

        return $data;
    }
}
