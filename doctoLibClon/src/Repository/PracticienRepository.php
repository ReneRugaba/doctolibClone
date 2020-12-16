<?php

namespace App\Repository;

use App\Entity\Practicien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Practicien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Practicien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Practicien[]    findAll()
 * @method Practicien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PracticienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Practicien::class);
    }

    // /**
    //  * @return Practicien[] Returns an array of Practicien objects
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
    public function findOneBySomeField($value): ?Practicien
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
