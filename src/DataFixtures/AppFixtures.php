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
        $faker = Faker\Factory::create('fr_FR');
        //créer un tableau pour stocker les catégories
        $categories = [];

        //boucle pour créer 30 catégories
        for ($i=0; $i < 30; $i++) { 
            $cat = new Categorie();
            $cat->setNom($faker->jobTitle());
            //persister la catégorie
            $manager->persist($cat);
            //ajouter la catégorie au tableau categories
            $categories[] = $cat;
        }
    }
}
