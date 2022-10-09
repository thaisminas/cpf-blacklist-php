<?php

namespace App\Repository;

use App\Entity\Blacklist;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Blacklist|null find($cpf, $lockMode = null, $lockVersion = null)
 * @method Blacklist|null findOneBy(array $criteria, array $orderBy = null)
 * @method Blacklist[]    findAll()
 * @method Blacklist[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlacklistRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Blacklist::class);
    }

    // /**
    //  * @return Blacklist[] Returns an array of Blacklist objects
    //  */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('blacklist')
            ->andWhere('blacklist.cpf = :val')
            ->setParameter('val', $value)
            ->orderBy('blacklist.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


    /**
     * @throws NonUniqueResultException
     */
    public function findOneBySomeField($cpf): ?Blacklist
    {
        return $this->createQueryBuilder('blacklist')
            ->andWhere('blacklist.cpf = :cpf')
            ->setParameter('cpf', $cpf)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

}