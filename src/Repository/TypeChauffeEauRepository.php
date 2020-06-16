<?php

namespace App\Repository;

use App\Entity\TypeChauffeEau;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeChauffeEau|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeChauffeEau|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeChauffeEau[]    findAll()
 * @method TypeChauffeEau[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeChauffeEauRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeChauffeEau::class);
    }

    // /**
    //  * @return TypeChauffeEau[] Returns an array of TypeChauffeEau objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeChauffeEau
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
