<?php

namespace App\Repository;

use App\Entity\Bien;
use App\Model\PrestationFiltre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Bien|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bien|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bien[]    findAll()
 * @method Bien[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BienRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bien::class);
    }

    // Affiche les bien du plus récent au plus ancien
    public function ordreBien(){
        return $this->createQueryBuilder('b')
        ->orderBy('b.id', 'DESC')
        ->getQuery()
        ->getResult();
    }

    // Permet de filtrer les bien en fonction de la ville sélectionnée
    public function filtreBiens(\App\Model\BienFiltre $filtre)
    {
        $qb = $this->createQueryBuilder('b');
        if ($filtre->getVille() !== NULL){
            $qb
                ->innerJoin('b.ville', 'v')
                ->where("v.nom LIKE :ville")
                ->setParameter('ville', '%'.$filtre->getVille().'%')
                ->orderBy('b.id', 'DESC');
        }

        if ($filtre->getCp() !== NULL){
            $qb
                ->innerJoin('b.ville', 'v')
                ->where("v.codePostal LIKE :cp")
                ->setParameter('cp', '%'.$filtre->getCp().'%')
                ->orderBy('b.id', 'DESC');
        }
        
        return $qb
            ->getQuery()
            ->getResult();
    }


    // Test filtre par ville et par prestation (non fonctionnel)
    // public function  filtrePrestation(PrestationFiltre $prestationFiltre){
    //     $qb = $this->createQueryBuilder('b');
    //     if ($prestationFiltre->getPrestation()->getId() !== NULL) {
    //         $qb
    //             ->where('b.prestation = :prestation')
    //             ->setParameter(
    //                 "prestation", $prestationFiltre->getPrestation()->getId());
    //     };
    //     return $qb
    //         ->getQuery()
    //         ->getResult();
    // }


    // Test filtre par ville et par prestation (non fonctionnel)
    // public function  filtrePrestations(PrestationFiltre $search){
    //     $qb = $this->createQueryBuilder('b');
    //     if ($search->getPrestation()->getId() !== NULL && $search->getVille()->getId() !== NULL) {
    //         $qb
    //             ->where('b.prestation = :prestation')
    //             ->andWhere('b.ville = :ville')
    //             ->setParameters([
    //                 "prestation" => $search->getPrestation()->getId(),
    //                 "ville" => $search->getVille()->getId()
    //             ]);
    //     };
    //     return $qb
    //         ->getQuery()
    //         ->getResult();
    // }

    // /**
    //  * @return Bien[] Returns an array of Bien objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bien
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
