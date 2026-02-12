<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Gère les pages et actions relatives à l'entité Championnat.
 *
 * @extends AbstractController
 */
final class ChampionnatController extends AbstractController
{
    /**
     * Affiche la page Twig des championnats.
     *
     * @return Response Réponse de la création de la page
     */
    #[Route('/championnat', name: 'app_championnat')]
    public function index(): Response
    {
        return $this->render('championnat/index.html.twig', [
            'controller_name' => 'ChampionnatController',
        ]);
    }
}
