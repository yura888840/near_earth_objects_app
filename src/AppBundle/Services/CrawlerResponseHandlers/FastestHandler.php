<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 19.10.17
 * Time: 11:11
 */

namespace AppBundle\Services\CrawlerResponseHandlers;

class FastestHandler implements ICrawlerResponseHandler
{
    public function handleBrowserResponse($result, $data)
    {
        if ($result['max_speed'] >= $data['max_speed']) {
            $data['max_speed']  = $result['max_speed'];
            $data['neo']        = $result['neo'];
        }
        return $data;
    }
}
