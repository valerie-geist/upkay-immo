<?php

namespace App\Repository;

use App\Entity\ChauffeEau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method ChauffeEau|null find($id, $lockMode = null, $lockVersion = null)
 * @method ChauffeEau|null findOneBy(array $criteria, array $orderBy = null)
 * @method ChauffeEau[]    findAll()
 * @method ChauffeEau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ChauffeEauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ChauffeEau::class);
    }

    // /**
    //  * @return ChauffeEau[] Returns an array of ChauffeEau objects
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
    public function findOneBySomeField($value): ?ChauffeEau
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
