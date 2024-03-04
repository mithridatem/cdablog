<?php
namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ApiCategorieController extends AbstractController{

    private CategorieRepository $categorieRepository;
    private SerializerInterface $serializer;
    private EntityManagerInterface $manager;

    public function __construct(CategorieRepository $categorieRepository,
     SerializerInterface $serializer,
     EntityManagerInterface $manager) 
    {
        $this->categorieRepository = $categorieRepository;

        $this->serializer = $serializer;

        $this->manager = $manager;
    }

    #[Route('/api/categorie/all', name:'app_api_categorie_all', methods:'GET')]
    public function getAllCategorie() : Response
    {
        return $this->json($this->categorieRepository->findAll(),200,[
            "Access-Control-Allow-Origin" => "*",
        ], ["groups"=>"api"]);
    }

    #[Route('api/categorie/add', name:'app_api_categorie_add', methods:'POST')]
    public function addCategorie(Request $request) : Response 
    {
        //version en utilisant decode (tableau)
        /* 
        //1 récupérer le contenu de la requête
        $data = $request->getContent();

        //2 convertir le contenu de la requête => en tableau
        $categorie = $this->serializer->decode($data, "json");

        //3 créer un objet Categorie
        $cat = new Categorie();

        //4 setter les informations
        $cat->setNom($categorie["nom"]);

        //5 persist les données
        $this->manager->persist($cat);

        //6 flush (enregistrer en BDD)
        $this->manager->flush(); */

        //version avec deserialize
        //1 récupérer le contenu de la requête
        $data = $request->getContent();

        //2 convertir en objet Categorie
        $categorie = $this->serializer->deserialize($request->getContent(),Categorie::class ,"json");
        
        //3 persister la Categorie
        $this->manager->persist($categorie);

        //Flush (enregister en BDD)
        $this->manager->flush();

        dd($categorie);
        return $this->json($categorie, 200,[
            "Access-Control-Allow-Origin" => "*",
        ]);
    }
}