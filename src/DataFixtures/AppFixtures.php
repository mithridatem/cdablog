<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        //ajout d'une categorie
        $categorie = new Categorie();
        $categorie->setNom("Actualite");
        //persister la catégorie
        $manager->persist($categorie);
        //ajout d'une categorie 2
        $categorie2 = new Categorie();
        $categorie2->setNom("new");
        //persister la catégorie 2
        $manager->persist($categorie2);
        
        //ajout d'un utilisateur
        $user = new Utilisateur();
        $user->setNom("Mithridate")
            ->setPrenom("Mathieu")
            ->setEmail("test@test.com")
            ->setPassword(md5("1234"));
        //persister l'utilisateur
        $manager->persist($user);

        //créer un objet article
        $article = new Article();
        $article->setTitre("Nouveau article")
        ->setContenu("contenu de l'article")
        ->setDateCreation(new \DateTimeImmutable("2024-02-28"))
        ->setUtilisateur($user)
        ->addCategory($categorie)
        ->addCategory($categorie2);
        //persister l'article
        $manager->persist($article);
        //enregistrer en BDD
        $manager->flush();
    }
}
