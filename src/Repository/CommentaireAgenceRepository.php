<?php

namespace App\Repository;

use App\Entity\CommentaireAgence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentaireAgence|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireAgence|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireAgence[]    findAll()
 * @method CommentaireAgence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireAgenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireAgence::class);
    }

   // Trouve le commentaire agence en fonction de l'id de la prestation
    public function commentairesAgence($idPresta)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.prestation = :prestation')
            ->setParameter('prestation', $idPresta)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return CommentaireAgence[] Returns an array of CommentaireAgence objects
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
    public function findOneBySomeField($value): ?CommentaireAgence
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
