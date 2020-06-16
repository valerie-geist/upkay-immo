<?php

namespace App\Controller;

use App\Entity\CommentaireAgence;
use App\Entity\CommentaireArtisan;
use App\Entity\CommentaireLocataire;
use App\Entity\Prestation;
use App\Form\CommentaireAgenceType;
use App\Form\CommentaireArtisanType;
use App\Form\CommentaireLocataireType;
use App\Form\FiltreFormType;
use App\Form\FiltrePrestationFormType;
use App\Form\PrestationType;
use App\Model\BienFiltre;
use App\Model\PrestationFiltre;
use App\Repository\BienRepository;
use App\Repository\PrestationRepository;
use App\Repository\CommentaireAgenceRepository;
use App\Repository\CommentaireArtisanRepository;
use App\Repository\CommentaireLocataireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Faker\Factory;

class PrestationController extends AbstractController
{

    private $prestationRepository;
    private $bienRepository;
    private $faker;
    private $commentaireAgenceRepository;
    private $commentaireArtisanRepository;
    private $commentaireLocataireRepository;

    public function __construct(PrestationRepository $prestationRepository, BienRepository $bienRepository, 
    CommentaireAgenceRepository $commentaireAgenceRepository, CommentaireArtisanRepository $commentaireArtisanRepository, CommentaireLocataireRepository $commentaireLocataireRepository)
    {
        $this->prestationRepository = $prestationRepository;
        $this->bienRepository = $bienRepository;
        $this->faker = new Factory();
        $this->faker = $this->faker->create();
        $this->commentaireAgenceRepository = $commentaireAgenceRepository;
        $this->commentaireArtisanRepository = $commentaireArtisanRepository;
        $this->commentaireLocataireRepository = $commentaireLocataireRepository;

    }

    // Page de choix du bien pour la création d'une prestation
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

        return $this->render('pages/choix_bien_prestations.html.twig', [
            'filtre' => $filtre,
            'biens' => $biens,
            'filtreForm' => $filtreForm->createView()
        ]);
    }

    // Page formulaire création prestation
    public function prestationAction(Request $request, $id)
    {
        // Trouve le bien par l'id
        $bien = $this->bienRepository->find($id);

        // Création du formulaire de création de prestation
        $prestation = new Prestation();
        $form = $this->createForm(PrestationType::class, $prestation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $prestation = $form->getData();

            // Remplissage des différentes cases du formulaire avec des données en partie fictives
            $prestation->setStatut('En attente')
                ->setValidationArtisan('Non')
                ->setArtisan($this->faker->name)
                ->setTarif($this->faker->numberBetween($min = 100, $max = 600))
                ->setDateDemande(new \DateTime())
                ->setDateIntervention(new \DateTime("+ 3 days"))
                ->setBien($bien);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($prestation);
            $entityManager->flush();
            return $this->redirectToRoute("prestations_ouvertes");
        }

        return $this->render('formulaires/demande_prestation.html.twig', [
            "form" => $form->createView(),
            "bien" => $bien,
        ]);
    }

    // Page liste des prestations ouvertes ("en attente" et "en cours")
    public function prestaOuvertesAction(Request $request)
    {
        // Cherche tous les biens (pas de filtre par agence, jugé non nécessaire pour la démo)
        $biens = $this->bienRepository->findAll();

        // Trouve toutes les prestations ouvertes
        $prestations = $this->prestationRepository->prestationsOuvertes();

        // Création d'un formulaire pour filtrer les logements par ville
        $filtre = new BienFiltre();
        $filtreForm = $this->createForm(FiltreFormType::class, $filtre);
        $filtreForm->handleRequest($request);
        if($filtreForm->isSubmitted()) {
            $filtre = $filtreForm->getData();
            $biens = $this->bienRepository->filtreBiens($filtre);
        }

        return $this->render('pages/prestations_ouvertes.html.twig', [
            'prestations' => $prestations,
            'biens' => $biens,
            'filtre' => $filtre,
            'filtreForm' => $filtreForm->createView(),
        ]);
    }

    // Page récapitulative de la prestation en cours sélectionnée
    public function prestaAction(Request $request, $id)
    {
        // Trouve la prestation via son id
        $prestation = $this->prestationRepository->find($id);

        // Permet d'utiliser une condition pour le statut en cours dans le template
        $statutEnCours = 'En cours';

        // Trouve les commentaires agence liés à la prestation
        $commentairesAgence = $this->commentaireAgenceRepository->commentairesAgence($id);

        // Trouve les commentaires artisan liés à la prestation
        $commentairesArtisan = $this->commentaireArtisanRepository->commentairesArtisan($id);

        // Trouve les commentaires locataire liés à la prestation
        $commentairesLocataire = $this->commentaireLocataireRepository->commentairesLocataire($id);

        // Création du formulaire de création de commentaire agence
        $commentaireAgence = new CommentaireAgence();
        $commentaireAgenceForm = $this->createForm(CommentaireAgenceType::class, $commentaireAgence);
        $commentaireAgenceForm->handleRequest($request);

        if ($commentaireAgenceForm->isSubmitted() && $commentaireAgenceForm->isValid()){
            $commentaireAgence = $commentaireAgenceForm->getData();
            $commentaireAgence->setPrestation($prestation)
                ->setDate(new \DateTime());
            $photo = $commentaireAgenceForm['photo']->getData();
            if($photo){
                $originalFileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName.'-'.uniqid().'.'.$photo->guessExtension();
                $photo->move($this->getParameter('uploads_directory'), $newUniqueFileName);
                $commentaireAgence->setPhoto($newUniqueFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaireAgence);
            $entityManager->flush();
            return $this->redirectToRoute("prestation", ['id' => $id]);
        }

        return $this->render('pages/prestation.html.twig', [
            'prestation' => $prestation,
            'statut_en_cours' => $statutEnCours,
            'commentaires_agence' => $commentairesAgence,
            'commentaires_artisan' => $commentairesArtisan,
            'commentaires_locataire' => $commentairesLocataire,
            'commentaire_agence_form' => $commentaireAgenceForm->createView(),
        ]);
    }

    // Page récapitulative de la prestation clôturée sélectionnée
    public function prestaClotureeAction($id)
    {
        // Trouve la prestation via son id
        $prestation = $this->prestationRepository->find($id);

        // Trouve les commentaires agence liés à la prestation
        $commentairesAgence = $this->commentaireAgenceRepository->commentairesAgence($id);

        // Trouve les commentaires artisan liés à la prestation
        $commentairesArtisan = $this->commentaireArtisanRepository->commentairesArtisan($id);

        // Trouve les commentaires locataire liés à la prestation
        $commentairesLocataire = $this->commentaireLocataireRepository->commentairesLocataire($id);

        return $this->render('pages/prestation_cloturee.html.twig', [
            'prestation' => $prestation,
            'commentaires_agence' => $commentairesAgence,
            'commentaires_locataire' => $commentairesLocataire,
            'commentaires_artisan' => $commentairesArtisan,
        ]);
    }

    // Page liste des prestations clôturées
    public function prestaClotureesAction(Request $request)
    {
        // Cherche tous les biens (pas de filtre par agence, jugé non nécessaire pour la démo)
        $biens = $this->bienRepository->findAll();

        // Trouve toutes les prestations clôturées
        $prestations = $this->prestationRepository->prestationsCloturees();

        // Création d'un formulaire pour filtrer les logements par ville
        $filtre = new BienFiltre();
        $filtreForm = $this->createForm(FiltreFormType::class, $filtre);
        $filtreForm->handleRequest($request);
        if($filtreForm->isSubmitted()) {
            $filtre = $filtreForm->getData();
            $biens = $this->bienRepository->filtreBiens($filtre);
        }

        return $this->render('pages/prestations_cloturees.html.twig', [
            'prestations' => $prestations,
            'filtre' => $filtre,
            'biens' => $biens,
            'filtreForm' => $filtreForm->createView()
        ]);
    }

}
