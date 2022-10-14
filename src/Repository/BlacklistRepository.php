<?php

namespace App\Repository;

use App\Entity\Blacklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blacklist|null find($id, $lockMode = null, $lockVersion = null)
 * @method Blacklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blacklist[]    findAll()
 * @method Blacklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlacklistRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager, ManagerRegistry $registry)
    {
        $this->entityManager = $entityManager;
        parent::__construct($registry, Blacklist::class);
    }

    public function findAllCpfsBlacklist()
    {
        return $this->createQueryBuilder('blacklist')
            ->getQuery()
            ->getArrayResult();
    }

    public function findOneBySomeField($cpf): ?Blacklist
    {
        return $this->createQueryBuilder('blacklist')
            ->andWhere('blacklist.cpf = :cpf')
            ->setParameter('cpf', $cpf)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function save(Blacklist $data): ?Blacklist
    {
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return $data;
    }

    public function remove(Blacklist $data): ?Blacklist
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
        return $data;
    }

}