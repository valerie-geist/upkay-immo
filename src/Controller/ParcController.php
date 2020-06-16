<?php

namespace App\Controller;

use App\Entity\Bien;
use App\Entity\CSL;
use App\Form\BienType;
use App\Form\FiltreFormType;
use App\Model\BienFiltre;
use App\Repository\AgenceRepository;
use App\Repository\BienRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class ParcController extends AbstractController
{

    private $agenceRepository;
    private $bienRepository;

    public function __construct(AgenceRepository $agenceRepository, BienRepository $bienRepository){
        $this->agenceRepository = $agenceRepository;
        $this->bienRepository = $bienRepository;
    }


    // Page parc locatif
    public function index(Request $request)
    {
        // Cherche tous les biens (pas de filtre par agence, jugé non nécessaire pour la démo)
        $biens = $this->bienRepository->ordreBien();

        // Création d'un formulaire pour filtrer les logements par ville
        $filtre = new BienFiltre();
        $filtreForm = $this->createForm(FiltreFormType::class, $filtre);
        $filtreForm->handleRequest($request);

        if($filtreForm->isSubmitted()) {
            $filtre = $filtreForm->getData();
            $biens = $this->bienRepository->filtreBiens($filtre);
        }

        return $this->render('pages/parc_locatif.html.twig', [
            'filtre' => $filtre,
            'biens' => $biens,
            'filtreForm' => $filtreForm->createView()
        ]);
    }
    
    // Page visualisation bien
    public function bienAction($id){
        // Bien en fonction de l'id
        $bien = $this->bienRepository->find($id);

        return $this->render('pages/bien.html.twig', [
            'bien' => $bien
        ]);
    }


    // Page création de bien
    public function bienFormAction(Request $request, Security $security)
    {
        // Création du formulaire de création de bien
        $bien = new Bien();
        $bienForm = $this->createForm(BienType::class, $bien);
        $bienForm->handleRequest($request);

        // Création du CSL associé au logement
        $csl = new CSL();

        // Vérification de la validité du formulaire
        if ($bienForm->isSubmitted() && $bienForm->isValid()){
            $bien = $bienForm->getData();
            $agence = $this->agenceRepository->findOneBy(['email' => $security->getUser()->getEmail()]);
            $bien->setAgence($agence);

            // Date d'entretien fictives du CSL créées lors de la validation du formulaire
            $csl->setEntretienChaudiere(new \DateTime("+ 1 year"));
            $csl->setEntretienChauffeEau(new \DateTime("+1 year"));
            $bien->setCsl($csl);

            // Upload de la photo
            $photo = $bienForm['photo']->getData();
            if($photo){
                $originalFileName = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                $newUniqueFileName = $originalFileName.'-'.uniqid().'.'.$photo->guessExtension();
                $photo->move($this->getParameter('uploads_directory'), $newUniqueFileName);
                $bien->setPhoto($newUniqueFileName);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();
            return $this->redirectToRoute("parc_locatif");
        }

        return $this->render('formulaires/bien_form.html.twig', [
            'bienForm' => $bienForm->createView(),
        ]);
    }

    public function bienModifFormAction(Request $request, Security $security, $id)
    {
        // Recherche du bien à modifier
        $bien = $this->bienRepository->find($id);

        // Création d'un formulaire de modification
        $bienForm = $this->createForm(BienType::class, $bien);
        $bienForm->handleRequest($request);


        if($bienForm->isSubmitted() && $bienForm->isValid()){
            $bien = $bienForm->getData();
            $agence = $this->agenceRepository->findOneBy(['email' => $security->getUser()->getEmail()]);
            $bien->setAgence($agence);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bien);
            $entityManager->flush();
            return $this->redirectToRoute("parc_locatif");
        }

        return $this->render('formulaires/bien_form_modif.html.twig', [
            'bienForm' => $bienForm->createView(),
        ]);
    }



}
