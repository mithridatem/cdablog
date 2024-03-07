<?php

namespace App\Service;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;

class UtilisateurService
{
    private UtilisateurRepository $utilisateurRepository;

    private EntityManagerInterface $em;

    public function __construct(UtilisateurRepository $utilisateurRepository, 
    EntityManagerInterface $em) 
    {
        $this->utilisateurRepository = $utilisateurRepository;

        $this->em = $em;
    }
    
    public function create(?Utilisateur $utilisateur) : bool 
    {
        //test si l'objet ne vaut pas null
        if($utilisateur) {
            //tester si le compte n'existe pas déja
            if(!$this->utilisateurRepository->findOneBy(["email" => $utilisateur->getEmail()])) {
                $this->em->persist($utilisateur);
                $this->em->flush();
                return true;
            }
            return false;
        }
        return false;
    }
}