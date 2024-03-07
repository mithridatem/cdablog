<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\EmailService;
class EmailController extends AbstractController
{
    #[Route('/email', name: 'app_email')]
    public function index(EmailService $emailService): Response
    {
        $subject = "Veuillez activer votre compte";
        $body = "Veuillez trouver ci-dessous le lien pour activer votre compte";
        $content = $this->render('email/index.html.twig', [
            'subject' => $subject,
            'body' => $body,
        ]);
        /* dd($content->getContent()); */
        $emailService->sendEmail('mathieumithridate@adrar-formation.com',$subject, $content->getContent());
        return new Response('Le mail à bien été envoyé');
    }
}
