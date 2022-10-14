<?php

namespace App\Service;

use App\Entity\Blacklist;
use App\Repository\BlacklistRepository;
use Doctrine\ORM\EntityManagerInterface;

class BlacklistService
{
    /**
     * @var BlacklistRepository
     */
    private $blacklistRespository;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var StatusService
     */
    private $statusService;


    public function __construct(EntityManagerInterface $entityManager, BlacklistRepository $blacklistRespository, StatusService $statusService)
    {
        $this->blacklistRespository = $blacklistRespository;
        $this->entityManager = $entityManager;
        $this->statusService = $statusService;
    }

    public function checksCpfBlacklist(string $cpf): ?Blacklist
    {
        $typeConsults = 0;
        $this->statusService->countConsultQuantityLastRestart($typeConsults);

        return $this->blacklistRespository->findOneBySomeField($cpf);
    }


    public function getAllCpfsBlacklist(): ?array
    {
        return $this->blacklistRespository->findAllCpfsBlacklist();
    }

    public function includeCpfBlacklist($cpf)
    {
        $data = json_decode($cpf);

        $cpfAlreadyExists = $this->blacklistRespository->findOneBySomeField($data->cpf);

        if(is_null($cpfAlreadyExists)){
            $list = new Blacklist();
            $list->setCpf($data->cpf);

            $this->blacklistRespository->save($list);

            return [
                "id" => $list->getId(),
                "cpf" => $list->getCpf(),
                "date" => $list->getCreateAt()
            ];
        }

        return null;
    }

    public function removeCpf(string $id): ?array
    {
        $cpfAlreadyExist = $this->blacklistRespository->find($id);

        if(!is_null($cpfAlreadyExist)){
            $this->blacklistRespository->remove($cpfAlreadyExist);
            return [ "message" => 'CPF successfully removed!'];
        }

        return null;
    }


    public function countQuantityCpfBlacklist(): int
    {
        return count($this->blacklistRespository->findAllCpfsBlacklist());
    }
    
}