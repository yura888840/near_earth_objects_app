<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:17
 */

namespace AppBundle\Services\CrawlerResponseHandlers;

interface ICrawlerResponseHandler
{
    public function handleBrowserResponse($result, $data);
}