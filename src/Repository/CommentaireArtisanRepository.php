<?php

namespace App\Repository;

use App\Entity\CommentaireArtisan;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentaireArtisan|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireArtisan|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireArtisan[]    findAll()
 * @method CommentaireArtisan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireArtisanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireArtisan::class);
    }

       // Trouve le commentaire artisan en fonction de l'id de la prestation
    public function commentairesArtisan($idPresta)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.prestation = :prestation')
            ->setParameter('prestation', $idPresta)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return CommentaireArtisan[] Returns an array of CommentaireArtisan objects
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
    public function findOneBySomeField($value): ?CommentaireArtisan
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
