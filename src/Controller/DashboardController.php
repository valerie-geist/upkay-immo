<?php

namespace App\Controller;

use App\Repository\AgenceRepository;
use App\Repository\BienRepository;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;


class DashboardController extends AbstractController
{
    private $agenceRepository;
    private $bienRepository;
    private $prestationRepository;

    public function __construct(AgenceRepository $agenceRepository, BienRepository $bienRepository, PrestationRepository $prestationRepository){
        $this->agenceRepository = $agenceRepository;
        $this->bienRepository = $bienRepository;
        $this->prestationRepository = $prestationRepository;
    }

    public function index(Security $security)
    {
        // Permet de trouver l'agence 
        $agence = $this->agenceRepository->findOneBy(['email' => $security->getUser()->getEmail()]);

        // Cherche tous les biens (pas de filtre par agence, jugé non nécessaire pour la démo)
        $biens = $this->bienRepository->findAll();

        // Trouve les 5 dernières prestations créées
        $dernieresPrestations = $this->prestationRepository->dernieresPrestations();

        // Trouve toutes les prestations (pas de filtre par agence) afin d'afficher leur nombre
        $prestations = $this->prestationRepository->findAll();

        // Trouve les prestations dont le statut est "en attente"
        $devisEnAttente = $this->prestationRepository->devisEnAttente();

        // Trouve les prestations qui sont encore ouvertes ("en attente" et "en cours")
        $prestationsOuvertes = $this->prestationRepository->prestationsOuvertes();

        // Trouve le montant des factures à payer
        $montantFacture = $this->prestationRepository->montantFacture();

        // Trouve le montant des factures à payer
        $prestationsCloturees = "Clôturé";

        return $this->render('pages/dashboard.html.twig', [
            "agence" => $agence,
            "biens" => $biens,
            "dernieres_prestations" => $dernieresPrestations,
            "devis_en_attente" => $devisEnAttente,
            "prestations_ouvertes" => $prestationsOuvertes,
            "montant_facture" => $montantFacture,
            "prestations" => $prestations,
            "prestations_cloturees" => $prestationsCloturees,
        ]);
    }

}
