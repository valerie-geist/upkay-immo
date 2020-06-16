<?php

namespace App\Repository;

use App\Entity\CommentaireLocataire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CommentaireLocataire|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentaireLocataire|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentaireLocataire[]    findAll()
 * @method CommentaireLocataire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireLocataireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentaireLocataire::class);
    }

    // Trouve le commentaire locataire en fonction de l'id de la prestation
    public function commentairesLocataire($idPresta)
    {
        return $this->createQueryBuilder('c')
            ->Where('c.prestation = :prestation')
            ->setParameter('prestation', $idPresta)
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return CommentaireLocataire[] Returns an array of CommentaireLocataire objects
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
    public function findOneBySomeField($value): ?CommentaireLocataire
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
