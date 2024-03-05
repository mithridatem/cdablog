<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;


class ApiUtilisateurController extends AbstractController{

    private UtilisateurRepository $utilisateurRepository;
    
    private SerializerInterface $serializer;

    private EntityManagerInterface $manager;

    private UserPasswordHasherInterface $hash;

    public function __construct(
        UtilisateurRepository $utilisateurRepository,
        SerializerInterface $serializer, EntityManagerInterface $manager,
        UserPasswordHasherInterface $hash) 
    {
        $this->utilisateurRepository = $utilisateurRepository;

        $this->serializer = $serializer;

        $this->manager = $manager;

        $this->hash = $hash;

    }

    #[Route('/api/utilisateur/all', name:'app_api_utilisateur_all', methods:'GET')]
    public function getAllUtilisateur() : Response 
    {
        return $this->json($this->utilisateurRepository->findAll(), 200, [
            "Access-Control-Allow-Origin" => "*",
        ], ["groups"=> "api"]);
    }

    #[Route('/api/utilisateur/add', name:'app_api_utilisateur_add', methods:'POST')]
    public function addUtilisateur(Request $request) : Response 
    {
        //réupérer le contenu de la requête
        $data = $request->getContent();
        //si le json est valide
        if($data) {
            //convertir le json => objet Utilisateur
            $utilisateur = $this->serializer->deserialize($data, Utilisateur::class, "json");
            //test si le compte existe déja
            if($this->utilisateurRepository->findOneBy(["email"=>$utilisateur->getEmail()])) {
                $message = ["Erreur"=> "Informations d'inscription incorrectes"];
                $code = 400;
            }
            //test si il n'existe pas
            else{
                //hash du password (récuperation du password)
                $password = $utilisateur->getPassword();
                //hash du password
                $hash = md5($utilisateur->getPassword());
                //setter le hash du mot de passe
                $utilisateur->setPassword($hash);
                //version en 1 ligne
                //$utilisateur->setPassword($this->hash->hashPassword($utilisateur, $utilisateur->getPassword()));
                //persist
                $this->manager->persist($utilisateur);
                //flush
                $this->manager->flush();
                $message = $utilisateur;
                $code = 200;
            }

        }
        //test le json n'existe pas
        else{
            $message = ["Erreur"=> "Le json est invalide"];
            $code = 400;
        }

        return $this->json($message,$code, ["Access-Control-Allow-Origin" => "*"]);
    }

    #[Route('/api/utilisateur/update', name:'app_api_utilisateur_update', methods:'POST')]
    public function updateUtilisateur(Request $request) : Response 
    {
        //récupération du json
        $json = $request->getContent();
        //tester si le json est valide (si il existe)
        if($json){
            //convertir le json en objet Utilisateur
            $utilisateur = $this->serializer->deserialize($json, Utilisateur::class, "json");
            //récupérer le compte utilisateur
            $userRecup = $this->utilisateurRepository->findOneBy(["email"=>$utilisateur->getEmail()]);
            //test si le compte existe
            if($userRecup){
                //setter les nouvelles valeurs
                $userRecup->setNom($utilisateur->getNom());
                $userRecup->setPrenom($utilisateur->getPrenom());
                $userRecup->setPassword(md5($utilisateur->getPassword()));
                $userRecup->setUrlImg($utilisateur->getUrlImg());
                //persit les données
                $this->manager->persist($userRecup);
                //enregistre en BDD
                $this->manager->flush();
                $msg = $userRecup;
                $code = 200;
            }
            //test le compte n'existe pas
            else{
                $msg = ["Erreur"=> "Les informations sont incorrectes"];
                $code = 400;
            }
        }
        //test si il n'existe pas (vide)
        else {
            $msg = ["Erreur"=>"Le json est invalide"];
            $code = 400;
        }
        return $this->json($msg,$code,["Access-Control-Allow-Origin" => "*",]);
    }
}
