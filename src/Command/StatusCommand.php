<?php

namespace App\Command;

use App\Repository\StatusRepository;
use App\Service\BlacklistService;
use App\Service\StatusService;
use Doctrine\ORM\EntityManagerInterface;

class StatusCommand
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StatusService
     */
    private $statusService;


    /**
     * @var BlacklistService
     */
    private $blacklistService;



    public function __construct(EntityManagerInterface $entityManager, StatusService $statusService, BlacklistService $blacklistService)
    {
        $this->entityManager = $entityManager;
        $this->statusService = $statusService;
        $this->blacklistService = $blacklistService;
    }


    public function status()
    {
        $quantityCpf = $this->blacklistService->countQuantityCpfBlacklist();
        $timeServer = $this->statusService->serverRuntime();
        $typeConsult = 1;
        $consult = $this->statusService->countConsultQuantityLastRestart($typeConsult);

        return [
            'uptime' => $timeServer,
            'quantity_consults' => $consult,
            'quantity_cpf' => $quantityCpf
        ];
    }
}