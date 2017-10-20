<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:57
 */

namespace AppBundle\Services\CrawlerResponseHandlers;

class BestyearHandler implements ICrawlerResponseHandler
{
    public function handleBrowserResponse($result, $data)
    {
        foreach ($result['data'] as $year => $count)
        {
            if (!array_key_exists($year, $data)) {
                $data[$year] = 0;
            }
            $data[$year] += $count;
        }
        unset($data['max_speed']);
        unset($data['neo']);

        return $data;
    }
}
