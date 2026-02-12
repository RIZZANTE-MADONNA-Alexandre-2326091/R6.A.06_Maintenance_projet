<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du contrôleur ChampionnatController.
 */
final class ChampionnatControllerTest extends WebTestCase
{
    /**
     * Teste que la page /championnat répond correctement.
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/championnat');

        self::assertResponseIsSuccessful();
    }
}
