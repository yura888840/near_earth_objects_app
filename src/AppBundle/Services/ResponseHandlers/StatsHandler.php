<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 22:58
 */

namespace AppBundle\Services\ResponseHandlers;


class StatsHandler implements IResponseHandler
{
    public function handleResponse($responseBody)
    {
        return $responseBody['near_earth_object_count'];
    }
}