<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:57
 */

namespace AppBundle\Services\ResponseHandlers;

class BestyearHandler implements IResponseHandler
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
            foreach ($neo['close_approach_data'] as $neoData) {
                //get date & extract year
                $date = $neoData['close_approach_date'];
                $year = substr($date, 0 , 4);

                if (!array_key_exists($year, $data)) {
                    $data[$year] = 0;
                }
                $data[$year]++;
            }
        }

        $next = array_key_exists('next', $responseBody['links']) ? $responseBody['links']['next'] : '';

        return [
            'next' => $next,
            'data' => $data,
        ];
    }
}