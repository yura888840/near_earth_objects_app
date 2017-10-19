<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:58
 */

namespace AppBundle\Services\ResponseHandlers;

class BestmonthHandler implements IResponseHandler
{
    private $isHazardous = false;

    /**
     * @param boolean $isHazardous
     */
    public function setIsHazardous($isHazardous)
    {
        $this->isHazardous = $isHazardous;
    }

    public function handleResponse($responseBody)
    {
        $neos = $responseBody['near_earth_objects'];
        $data = [];

        foreach($neos as $k => $neo) {
            if ($neo['is_potentially_hazardous_asteroid'] != $this->isHazardous) {
                continue;
            }
            //This can be the issue. Cause in some cases we have empty close_approach_data
            foreach ($neo['close_approach_data'] as $neoData) {
                //get date & extract month
                $date = $neoData['close_approach_date'];
                $month = substr($date, 5 , 2);

                if (!array_key_exists($month, $data)) {
                    $data[$month] = 0;
                }
                $data[$month]++;
            }
        }

        $next = array_key_exists('next', $responseBody['links']) ? $responseBody['links']['next'] : '';

        return [
            'next' => $next,
            'data' => $data,
        ];
    }
}
