<?php

/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 12:34
 */
namespace AppBundle\Services;

use AppBundle\Exceptions\CommunicationErrorWithApiException;
use AppBundle\Exceptions\ErrorWhileRequestingApiException;
use AppBundle\Exceptions\InvalidDataFromApiException;
use \GuzzleHttp\Client;
use AppBundle\Services\ResponseHandlers\IResponseHandler;
use Psr\Http\Message\ResponseInterface;

class ApiClient
{
    CONST FEED = 'feed';
    CONST FEED_TODAY = 'feed_today';
    CONST NEO_BROWSE = 'neo_browse';
    CONST NEO_ASTEROID_ID = 'neo_asteroid_id';
    CONST STATS = 'stats';

    private $apiShortcuts = [
        'feed'              => 'feed',
        'feed_today'        => 'feed/today',
        'neo_browse'        => 'neo/browse',
        'neo_asteroid_id'   => 'neo/{asteroid_id}',
        'stats'             => 'stats',
    ];

    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $apiKey;

    public function __construct(Client $client, $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function doRequest($urlShortcut, $params, IResponseHandler $handler)
    {
        $params['api_key'] = $this->apiKey;
        $query = http_build_query($params);

        if (array_key_exists($urlShortcut, $this->apiShortcuts)) {
            $urlShortcut = sprintf('%s?%s', $this->apiShortcuts[$urlShortcut], $query);
        }

        try {
            /** @var ResponseInterface $result */
            $result = $this->client->request(
                'GET',
                $urlShortcut
            );
        } catch (\Exception $e) {
            throw new CommunicationErrorWithApiException($e->getMessage(), $e->getCode(), $e);
        }

        if (200 !== $result->getStatusCode()) {
            throw new ErrorWhileRequestingApiException();
        }

        $data = json_decode($result->getBody()->getContents(), true);

        if (false === $data) {
            throw new InvalidDataFromApiException();
        }

        return $handler->handleResponse($data);
    }
}
