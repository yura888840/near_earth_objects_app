<?php
/**
 * Created by PhpStorm.
 * User: yuri
 * Date: 17.10.17
 * Time: 23:33
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\NearEarthObjectRepository")
 */
class NearEarthObject
{
    /**
     * @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @var string
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\Column(type="string")
     */
    private $reference;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var float
     * @ORM\Column(type="float")
     */
    private $speed;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $isHazardous;

    /**
     * @param \DateTime|string $date
     */
    public function setDate($date)
    {
        if (is_string($date)) {
            $date = new \DateTime($date);
        }
        $this->date = $date;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param float $speed
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    /**
     * @param boolean $isHazardous
     */
    public function setIsHazardous($isHazardous)
    {
        $this->isHazardous = $isHazardous;
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->date->format('Y-m-d');
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * @return boolean
     */
    public function isIsHazardous()
    {
        return $this->isHazardous;
    }
}
