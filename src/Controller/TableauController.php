<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Article;
use App\Entity\Utilisateur;
use App\Entity\Categorie;
class TableauController extends AbstractController
{
    #[Route('/tableau', name: 'app_tableau')]
    public function index(EntityManagerInterface $manager): Response
    {
        for ($i=0; $i < 30; $i++) { 
            $user = new Utilisateur();
            
            //$manager->persist($categorie);
        }
        dd($user);
/*         for ($i=0; $i < 50 ; $i++) { 
            $user = new Utilisateur();
            $user->setNom("Mithridate")
            ->setPrenom("Mathieu")
            ->setEmail("test@test.com")
            ->setPassword(md5("1234"));
            //persister l'utilisateur
            $manager->persist($user);
        }
        for ($i=0; $i <200 ; $i++) { 
            //créer un objet article
            $article = new Article();
            $article->setTitre("Nouveau article")
            ->setContenu("contenu de l'article")
            ->setDateCreation(new \DateTimeImmutable("2024-02-28"))
            ->setUtilisateur($user)
            ->addCategory($categorie);
            //persister l'article
            $manager->persist($article);
        }
        //enregistrer en BDD
        $manager->flush(); */
    }
}
