<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ArticleRepository;

class ArticleController extends AbstractController
{
    private ArticleRepository $articleRepository;

    public function __construct(ArticleRepository $articleRepository) 
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/', name: 'app_article_all')]
    public function articleAll(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('article/article_all.html.twig', [
            'articles' => $articles,
        ]);
    }

    #[Route('/article/id/{id}',name:'app_article_id')]
    public function articleById($id) : Response 
    {   
        $article = $this->articleRepository->find($id);

        return $this->render('article/article_detail.html.twig', [
            'article' => $article,
        ]);
    }
}
