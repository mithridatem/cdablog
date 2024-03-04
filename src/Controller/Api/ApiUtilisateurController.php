<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Symfony\Component\Serializer\SerializerInterface;

class ApiUtilisateurController extends AbstractController{

    private UtilisateurRepository $utilisateurRepository;
 

    public function __construct(UtilisateurRepository $utilisateurRepository, SerializerInterface $serializer) 
    {
        $this->utilisateurRepository = $utilisateurRepository;

    }

    #[Route('/api/utilisateur/all', name:'app_api_utilisateur_all', methods:'GET')]
    public function getAllUtilisateur() : Response 
    {
        return $this->json($this->utilisateurRepository->findAll(), 200, [
            "Access-Control-Allow-Origin" => "*",
        ], ["groups"=> "api"]);
    }
}