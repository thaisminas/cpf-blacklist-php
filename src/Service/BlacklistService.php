<?php

namespace App\Service;

use App\Entity\Blacklist;
use App\Repository\BlacklistRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;

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


    public function __construct(EntityManagerInterface $entityManager, BlacklistRepository $blacklistRespository)
    {
        $this->blacklistRespository = $blacklistRespository;
        $this->entityManager = $entityManager;
    }

    /**
     * @throws NonUniqueResultException
     */
    public function checksCpfBlacklist(string $cpf): ?\App\Entity\Blacklist
    {
        return $this->blacklistRespository->findOneBySomeField($cpf);

    }

    public function includeCpfBlacklist($cpf)
    {
        $data = json_decode($cpf);

        $cpfAlreadyExists = $this->blacklistRespository->findOneBySomeField($data->cpf);

        if(is_null($cpfAlreadyExists)){
            $list = new Blacklist();

            $list->setCpf($data->cpf);

            $this->entityManager->persist($list);
            $this->entityManager->flush();

            return [
                "id" => $list->getId(),
                "cpf" => $list->getCpf(),
                "date" => $list->getCreateAt()
            ];
        }

        return null;
    }
}