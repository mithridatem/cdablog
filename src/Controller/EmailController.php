<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(): Response
    {
        $subject = "Veuillez activer votre compte";
        $body = "Veuillez trouver ci-dessous le lien pour activer votre compte";
        return $this->render('email/index.html.twig', [
            'subject' => $subject,
            'body' => $body,
        ]);
    }
}
