<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Gère les pages et actions relatives à l'entité Sport.
 *
 * @extends AbstractController
 */
final class SportController extends AbstractController
{
    /**
     * Affiche la page Twig des sports.
     *
     * @return Response Réponse de la création de la page
     */
    #[Route('/sport', name: 'app_sport')]
    public function index(): Response
    {
        return $this->render('sport/index.html.twig', [
            'controller_name' => 'SportController',
        ]);
    }
}
