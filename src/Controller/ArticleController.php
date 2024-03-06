<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\UtilsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;
    private EntityManagerInterface $em;

    public function __construct(ArticleRepository $articleRepository,
        EntityManagerInterface $em) 
    {
        $this->articleRepository = $articleRepository;

        $this->em = $em;
    }

    #[Route('/', name: 'app_article_all')]
    public function articleAll(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('article/article_all.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/id/{id}',name:'app_article_id', methods:'GET')]
    public function articleById($id) : Response 
    {   
        $article = $this->articleRepository->find($id);

        return $this->render('article/article_detail.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/article/add', name:'app_article_add')]
    public function addArticle(Request $request) :Response 
    {
        $msg = "";
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()) {
            /* dd($form->getData()->getDateCreation()->format('d-m-Y')); */
            //nettoyer les entrées
            $article->setTitre(UtilsService::cleanInput($article->getTitre()));
            $article->setContenu(UtilsService::cleanInput($article->getContenu()));
            $article->setUrlImg(UtilsService::cleanInput($article->getUrlImg()));
            $article->setDateCreation( new \DateTimeImmutable(UtilsService::cleanInput
            ($form->getData()->getDateCreation()->format('d-m-Y'))));
            //récupération de l'article
            $recup = $this->articleRepository->findOneBy(["titre"=>$article->getTitre(), 
            "contenu"=> $article->getContenu()]);
            //test si l'article existe 
            if(!$recup) {
                $this->em->persist($article);
                $this->em->flush();
                $msg = "L'article : " . $article->getTitre() . " a été ajouté en BDD";
            }
            else{
                $msg = "L'article existe déja en BDD";
            }
        }
        return $this->render('article/index.html.twig', [
            'form' => $form->createView(),
            'message' => $msg,
        ]);
    }

    #[Route('/article/update/{id}', name:'app_update_article')]
    public function updateArticle(Request $request, $id) : Response 
    {

        $msg = ""    ;
        $article = $this->articleRepository->find($id);
        //test si l'article n'existe pas
        if(!$article) {
            //redirection vers la page d'accueil
            return $this->redirectToRoute('app_article_all');
        }
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        //tester si il est submit
        if($form->isSubmitted() and $form->isValid()) {
            /* dd($form->getData()->getDateCreation()->format('d-m-Y')); */
            //nettoyer les entrées
            $article->setTitre(UtilsService::cleanInput($article->getTitre()));
            $article->setContenu(UtilsService::cleanInput($article->getContenu()));
            $article->setUrlImg(UtilsService::cleanInput($article->getUrlImg()));
            $article->setDateCreation( new \DateTimeImmutable(UtilsService::cleanInput
            ($form->getData()->getDateCreation()->format('d-m-Y'))));
            //récupération de l'article
            $recup = $this->articleRepository->findOneBy(["titre"=>$article->getTitre(), 
            "contenu"=> $article->getContenu()]);
            //test si l'article existe 
            if(!$recup) {
                $this->em->persist($article);
                $this->em->flush();
                $msg = "L'article : " . $article->getTitre() . " a été modifié en BDD";
            }
            else{
                $msg = "L'article existe déja en BDD";
            }
        }
        return $this->render('article/update.html.twig', [
            'form' => $form->createView(),
            'message' => $msg,
        ]);
    }
}
