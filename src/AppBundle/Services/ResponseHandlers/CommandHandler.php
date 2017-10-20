<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 18.10.17
 * Time: 13:54
 */

namespace AppBundle\Services\ResponseHandlers;

use AppBundle\Entity\NearEarthObject;
use AppBundle\Exceptions\DatabaseErrorException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMInvalidArgumentException;

class CommandHandler implements IResponseHandler
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CommandHandler constructor.
     * @param EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->em = $manager;
    }

    public function handleResponse($responseBody)
    {
        $data = $responseBody;
        $elementCount = $data['element_count'];

        if ($elementCount > 0) {
            foreach ($data['near_earth_objects'] as $date => $neoDataByDay) {
                foreach ($neoDataByDay as $neoData) {
                    $neoObject = new NearEarthObject();
                    $neoObject->setReference($neoData['neo_reference_id']);
                    $neoObject->setDate($date);
                    $neoObject->setIsHazardous($neoData['is_potentially_hazardous_asteroid']);
                    $neoObject->setName($neoData['name']);
                    $neoObject->setSpeed($neoData['close_approach_data'][0]['relative_velocity']['kilometers_per_second']);

                    try {
                        $this->em->merge($neoObject);
                    } catch (ORMInvalidArgumentException $e) {
                        throw new DatabaseErrorException($e->getMessage(), $e->getCode(), $e);
                    }
                }
            }

            try {
                $this->em->flush();
            } catch (\Exception $e) {
                throw new DatabaseErrorException($e->getMessage(), $e->getCode(), $e);
            }
        }

        return $elementCount;
    }
}