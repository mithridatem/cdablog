<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;
use Faker;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        /*-Créer 30 catégories,
        -Créer 50 Utilisateurs,
        -Créer 200 articles,
        */
        //création de 30 articles
        for ($i=0; $i < 30; $i++) { 
           $cat = new Categorie();
           $cat->setNom("News");
           $manager->persist($cat);
        }

        //création de 50 Utilisateurs
        for ($i=0; $i < 50 ; $i++) { 
            $user = new Utilisateur();
            $user->setNom("Test")
                ->setPrenom("Test")
                ->setEmail("test@test.com")
                ->setPassword(md5("1234"));
            $manager->persist($user);
        }

        //création de 200 articles
        for ($i=0; $i < 200; $i++) { 
            $article = new Article();
            $article->setTitre("Titre")
                ->setContenu("Contenu de l'article")
                ->setDateCreation(new \DateTime("2024-02-28"))
                ->addCategory($cat)
                ->setUtilisateur($user);
            $manager->persist($article);
        }
        $manager->flush();
    }
}
