<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:57
 */

namespace AppBundle\Services\CrawlerResponseHandlers;

class BestmonthHandler implements ICrawlerResponseHandler
{
    public function handleBrowserResponse($result, $data)
    {
        foreach ($result['data'] as $month => $count)
        {
            if (!array_key_exists($month, $data)) {
                $data[$month] = 0;
            }
            $data[$month] += $count;
        }
        unset($data['max_speed']);
        unset($data['neo']);

        return $data;
    }
}
