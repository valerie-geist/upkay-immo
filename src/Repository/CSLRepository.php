<?php

namespace App\Repository;

use App\Entity\CSL;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CSL|null find($id, $lockMode = null, $lockVersion = null)
 * @method CSL|null findOneBy(array $criteria, array $orderBy = null)
 * @method CSL[]    findAll()
 * @method CSL[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CSLRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CSL::class);
    }

    // /**
    //  * @return CSL[] Returns an array of CSL objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CSL
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
