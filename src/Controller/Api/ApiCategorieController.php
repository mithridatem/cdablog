<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiCategorieController extends AbstractController{

    private CategorieRepository $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository) 
    {
        $this->categorieRepository = $categorieRepository;
    }

    #[Route('/api/categorie/all', name:'app_api_categorie_all', methods:'GET')]
    public function getAllCategorie() : Response
    {
        return $this->json($this->categorieRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",
        ], ["groups"=>"api"]);
    }
}