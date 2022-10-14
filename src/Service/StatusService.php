<?php

namespace App\Service;

use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Uptime\System;

class StatusService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StatusRepository
     */
    private $statusRepository;



    public function __construct(EntityManagerInterface $entityManager, StatusRepository $statusRepository)
    {
        $this->entityManager = $entityManager;
        $this->statusRepository = $statusRepository;
    }

    public function serverRuntime()
    {
        $uptime = @system('uptime');
        $uptime = explode(" ",$uptime);

        return [
            'hour'=> $uptime[0],
            'server_up_time'=> $uptime[3] . ' ' . $uptime[4],
        ];

    }


    public function countConsultQuantityLastRestart(int $typeConsult): int
    {
        $contador = [];

        if($typeConsult === 0){
            array_push($contador, 0);
        }

        return count($contador);
    }


    public function addQuery()
    {
        return $this->statusRepository->save();
    }


    public function countConsult()
    {
        return count($this->statusRepository->findAllConsults());
    }

}