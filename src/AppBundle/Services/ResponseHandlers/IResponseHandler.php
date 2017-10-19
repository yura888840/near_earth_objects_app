<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:17
 */

namespace AppBundle\Services\ResponseHandlers;

interface IResponseHandler
{
    public function handleResponse($responseBody);
}