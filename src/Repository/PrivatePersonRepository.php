<?php

namespace App\Repository;

use App\Entity\PrivatePerson;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PrivatePerson|null find($id, $lockMode = null, $lockVersion = null)
 * @method PrivatePerson|null findOneBy(array $criteria, array $orderBy = null)
 * @method PrivatePerson[]    findAll()
 * @method PrivatePerson[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrivatePersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PrivatePerson::class);
    }

    // /**
    //  * @return PrivatePerson[] Returns an array of PrivatePerson objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PrivatePerson
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
