<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TableauController extends AbstractController
{
    #[Route('/tableau', name: 'app_tableau')]
    public function index(): Response
    {
        return $this->render('tableau/index.html.twig', [
            'tab' => [10,50,22,36,42,88,50],
            'users' => [
                ["nom" => "Mithridate", "prenom" => "Mathieu", "age" => 45],
                ["nom" => "Dupond", "prenom" => "Marie", "age" => 36],
                ["nom" => "Albert", "prenom" => "Anne", "age" => 28],
                ["nom" => "Durand", "prenom" => "Marc", "age" => 21],
            ]
        ]);
    }
}
