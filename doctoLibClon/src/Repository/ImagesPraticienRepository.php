<?php

namespace App\Repository;

use App\Entity\ImagesPraticien;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImagesPraticien|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImagesPraticien|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImagesPraticien[]    findAll()
 * @method ImagesPraticien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImagesPraticienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImagesPraticien::class);
    }

    // /**
    //  * @return ImagesPraticien[] Returns an array of ImagesPraticien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImagesPraticien
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
