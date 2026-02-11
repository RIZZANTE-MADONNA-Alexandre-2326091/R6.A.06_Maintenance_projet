<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Gère les pages et actions relatives à l'entité Epreuve.
 * @extends AbstractController
 */
final class EpreuveController extends AbstractController
{
    /**
     * Affiche la page Twig des épreuves.
     * @return Response Réponse de la création de la page
     */
    #[Route('/epreuve', name: 'app_epreuve')]
    public function index(): Response
    {
        return $this->render('epreuve/index.html.twig', [
            'controller_name' => 'EpreuveController',
        ]);
    }
}
