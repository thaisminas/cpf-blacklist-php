<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StatusRepository")
 */
class Status
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $consult;


    public function getId(): int
    {
        return $this->id;
    }


    public function getConsult(): \DateTime
    {
        return $this->consult;
    }


    public function setConsult(\DateTime $consult): void
    {
        $this->consult = $consult;
    }

}