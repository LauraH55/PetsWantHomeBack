<?php

namespace App\Repository;

use App\Entity\Animal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Animal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Animal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Animal[]    findAll()
 * @method Animal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Animal::class);
    }

    // We create a function with custom request to find animal by their status to adopt
    public function findAllByStatusToAdopt()
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Animal a
            WHERE a.status = 1'
        );

        return $query->getResult();
    }

    // We create a function with custom request to find animal by their status adopted
    public function findAllByStatusAdopted()
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Animal a
            WHERE a.status = 2'
        );

        return $query->getResult();
    }

    // [V2] We create a function with custom request to find animal by their status lost
    public function findAllByStatusLost()
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
                FROM App\Entity\Animal a
                WHERE a.status = 3'
        );

        return $query->getResult();
    }

    // [V2] We create a function with custom request to find animal by their status adopted
    public function findAllByStatusFound()
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Animal a
            WHERE a.status = 4'
        );

        return $query->getResult();
    }

    // We create a function to order animal by their status
    public function listOrderByStatus()
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT a
            FROM App\Entity\Animal a
            ORDER BY a.status ASC'
        );

        return $query->getResult();
    }

    public function randomAnimals()
    {

        $entityManager = $this->getEntityManager();

        $query = $entityManager
            ->createQuery("SELECT a FROM App\Entity\Animal a ORDER BY RAND()")
            ->setMaxResults(9);

        return $query->getResult();
    }



    // /**
    //  * @return Animal[] Returns an array of Animal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Animal
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
