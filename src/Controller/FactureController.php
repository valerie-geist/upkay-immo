<?php

namespace App\Controller;

use App\Repository\BienRepository;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    private $prestationRepository;

    public function __construct(PrestationRepository $prestationRepository){
        $this->prestationRepository = $prestationRepository;
    }


    public function index()
    {
        // Trouve le montant des factures à payer
        $montantFacture = $this->prestationRepository->montantFacture();

        // Trouve les prestations dont le statut est "en attente"
        $paiementsEnAttente = $this->prestationRepository->devisEnAttente();

        return $this->render('pages/factures.html.twig', [
            "montant_facture" => $montantFacture,
            "paiements_en_attente" => $paiementsEnAttente,
        ]);
    }
}
