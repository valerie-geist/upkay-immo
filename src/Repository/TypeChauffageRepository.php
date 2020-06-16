<?php

namespace App\Repository;

use App\Entity\TypeChauffage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeChauffage|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeChauffage|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeChauffage[]    findAll()
 * @method TypeChauffage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeChauffageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeChauffage::class);
    }

    // /**
    //  * @return TypeChauffage[] Returns an array of TypeChauffage objects
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
    public function findOneBySomeField($value): ?TypeChauffage
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
