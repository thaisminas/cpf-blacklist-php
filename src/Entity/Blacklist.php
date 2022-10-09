<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BlacklistRepository")
 */
class Blacklist
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $cpf;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;


    public function __construct()
    {
        $this->createAt = new DateTime();
    }


    public function getId(): int
    {
        return $this->id;
    }


    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }


    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

}