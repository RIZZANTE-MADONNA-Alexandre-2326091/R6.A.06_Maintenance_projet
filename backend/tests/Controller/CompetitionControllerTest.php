<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du contrôleur CompetitionController.
 */
final class CompetitionControllerTest extends WebTestCase
{
    /**
     * Teste que la page /competition répond correctement.
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/competition');

        self::assertResponseIsSuccessful();
    }
}
