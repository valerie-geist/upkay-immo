<?php

namespace App\Controller;

use App\Form\FiltreFormType;
use App\Model\BienFiltre;
use App\Repository\BienRepository;
use App\Repository\PrestationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CSLController extends AbstractController
{

    private $bienRepository;
    private $prestationRepository;

    public function __construct(BienRepository $bienRepository, PrestationRepository $prestationRepository){
        $this->bienRepository = $bienRepository;
        $this->prestationRepository = $prestationRepository;
    }


    // Page choix carnet de santé en fonction du logement
    public function index(Request $request)
    {
        // Cherche tous les biens (pas de filtre par agence, jugé non nécessaire pour la démo)
        $biens = $this->bienRepository->findAll();

        // Création d'un formulaire pour filtrer les logements par ville
        $filtre = new BienFiltre();
        $filtreForm = $this->createForm(FiltreFormType::class, $filtre);
        $filtreForm->handleRequest($request);

        if($filtreForm->isSubmitted()) {
            $filtre = $filtreForm->getData();
            $biens = $this->bienRepository->filtreBiens($filtre);
        }

        return $this->render('pages/csl_choix.html.twig', [
            'filtre' => $filtre,
            'biens' => $biens,
            'filtreForm' => $filtreForm->createView()
        ]);
    }

    // Dashboard du carnet de santé du logement
    public function dashboardAction($id)
    {
        // Affiche le bien que l'on a sélectionné
        $bien = $this->bienRepository->find($id);

        // On trouve les prestations liées au bien
        $prestations = $this->prestationRepository->findBy(["bien" => $bien]);

        // On défini une variable pour renvoyer l'utilisateur sur la bonne page si la prestation est clôturée (voir csl_dashboard.html.twig ligne 171)
        $prestationCloturee = 'Clôturé';

        return $this->render('csl/pages/csl_dashboard.html.twig', [
            'bien' => $bien,
            'prestations' => $prestations,
            'prestationCloturee' => $prestationCloturee,
        ]);
    }

    // Page carnet de santé du logement
    public function cslAction($id)
    {
        // Récupération des données concernant le CSL
        $bien = $this->bienRepository->find($id);

        return $this->render('csl/pages/csl.html.twig', [
            "bien" => $bien,
        ]);
    }

    // Page calendrier du carnet de santé du logement (non fonctionnelle)
    public function calendrierAction($id)
    {
        // Récupération des données concernant le CSL
        $bien = $this->bienRepository->find($id);

        return $this->render('csl/pages/calendrier.html.twig', [
            "bien" => $bien
        ]);
    }

    // Page stockage du carnet de santé du logement (non fonctionnelle)
    public function stockageAction($id)
    {
        $bien = $this->bienRepository->find($id);

        return $this->render('csl/pages/coffre_fort.html.twig', [
            "bien" => $bien
        ]);
    }


}
