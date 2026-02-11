<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Gère les pages et actions relatives à l'entité Competition.
 * @extends AbstractController
 */
final class CompetitionController extends AbstractController
{
    /**
     * Affiche la page Twig des compétitions.
     * @return Response Réponse de la création de la page
     */
    #[Route('/competition', name: 'app_competition')]
    public function index(): Response
    {
        return $this->render('competition/index.html.twig', [
            'controller_name' => 'CompetitionController',
        ]);
    }
}
