<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\CategorieType;
use App\Entity\Categorie;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
class CategorieController extends AbstractController
{
    #[Route('/categorie/add', name: 'app_categorie_add')]
    public function addCategorie(Request $request ,EntityManagerInterface $em): Response
    {
        $msg = "";
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);
        if($form->isSubmitted())
        {  
            $em->persist($categorie);
            $em->flush();
            $msg = "La categorie à été ajouté en BDD";
        }
        return $this->render('categorie/index.html.twig', [
            'form'=> $form->createView(),
            'msg' => $msg
        ]);
    }
}
