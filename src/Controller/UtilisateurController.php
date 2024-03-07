<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use App\Service\UtilsService;
use App\Service\UtilisateurService;


class UtilisateurController extends AbstractController
{
    #[Route('/utilisateur/add', name: 'app_utilisateur_add')]
    public function addUtilisateur(Request $request, UtilisateurService $userService) : Response
    {
        $msg = "";
        $utilisateur = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $utilisateur);
        $form->handleRequest($request);
        //tester si le formulaire est submit
        if($form->isSubmitted() and $form->isValid()) {
           /* dd($request->request->all('utilisateur')); */
            //nettoyer les entrées
            $utilisateur->setNom(UtilsService::cleanInput($utilisateur->getNom()));
            $utilisateur->setPrenom(UtilsService::cleanInput($utilisateur->getPrenom()));
            $utilisateur->setEmail(UtilsService::cleanInput($utilisateur->getEmail()));
            $utilisateur->setPassword(UtilsService::cleanInput($utilisateur->getPassword()));
            //tester si le champ est complété
            if($utilisateur->getUrlImg()) {
                $utilisateur->setUrlImg(UtilsService::cleanInput($utilisateur->getUrlImg()));
            }
            //test si le compte n'existe pas
            if($userService->create($utilisateur)) {
                $msg = "Le compte " . $utilisateur->getNom() . " a été ajouté en BDD";
            }
            else{
                $msg = "Les informations sont incorrectes";
            }
        }    
        return $this->render('utilisateur/index.html.twig', [
            'form' => $form->createView(),
            'message' => $msg,
        ]);
    }
}
