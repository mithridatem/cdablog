<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ExerciceController extends AbstractController
{
    #[Route('/exercice/{nom}', name: 'app_exercice')]
    public function afficherNom($nom): Response
    {
        return $this->render('exercice/index.html.twig', [
            'name' => $nom,
        ]);
    }

    #[Route('/exercice/{nbr1}/{nbr2}/{operateur}')]
    public function calculer($nbr1, $nbr2, $operateur) : Response
    {
        return $this->render('exercice/calculatrice.html.twig',[
            'nbr1' => $nbr1,
            'nbr2' => $nbr2,
            'operateur' => $operateur,
        ]);
    }

}
