<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:57
 */

namespace AppBundle\Services\ResponseHandlers;


class FastestHandler implements IResponseHandler
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
        $neos       = $responseBody['near_earth_objects'];
        $maxSpeed   = 0;
        $resultNeo  = reset($neos);

        foreach($neos as $k => $neo) {
            if (!is_array($neo['close_approach_data'])) {
                continue;
            }

            if ($neo['is_potentially_hazardous_asteroid'] != $this->isHazardous) {
                continue;
            }

            foreach ($neo['close_approach_data'] as $neoData) {
                // I guess that we can choose here kilometers_per_second. But I am not sure
                $neoSpeed = doubleval($neoData['relative_velocity']['kilometers_per_second']);

                if ($neoSpeed > $maxSpeed) {
                    $maxSpeed = $neoSpeed;
                    $resultNeo = $neo;
                }
            }
        }

        $next = array_key_exists('next', $responseBody['links']) ? $responseBody['links']['next'] : '';

        return [
            'next' => $next,
            'neo' => $resultNeo,
            'max_speed' => $maxSpeed
        ];
    }
}
