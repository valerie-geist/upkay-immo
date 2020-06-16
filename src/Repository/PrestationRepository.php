<?php

namespace App\Repository;

use App\Entity\Prestation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Prestation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prestation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prestation[]    findAll()
 * @method Prestation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PrestationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prestation::class);
    }


    // Trouve les 5 dernières prestations créées
    public function dernieresPrestations(){
        return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    // Trouve les prestations dont le statut est "en attente"
    public function devisEnAttente(){
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->where('p.statut = :statut')
            ->setParameter('statut', 'En attente')
            ->getQuery()
            ->getResult();
    }

    // Trouve les prestations ouvertes ("en attente" et "en cours")
    public function prestationsOuvertes(){
        return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
            ->where('p.statut IN (:statuts)')
            ->setParameter('statuts', ['En cours', 'En attente'] )
            ->getQuery()
            ->getResult();
    }

    // Trouve les prestations clôturées
    public function prestationsCloturees(){
        return $this->createQueryBuilder('p')
        ->orderBy('p.id', 'DESC')
            ->where('p.statut = :statut')
            ->setParameter('statut', 'Clôturé' )
            ->getQuery()
            ->getResult();
    }

    // Trouve le montant des prestation à payer
    public function montantFacture(){
        return $this->createQueryBuilder('p')
            ->select('SUM(p.tarif) AS somme')
            ->where('p.statut = :statut')
            ->setParameter('statut', 'En attente')
        ->getQuery()
        ->getResult();

        $somme = $qb->getOneOrNullResult();
        }

    // /**
    //  * @return Prestation[] Returns an array of Prestation objects
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
    public function findOneBySomeField($value): ?Prestation
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
