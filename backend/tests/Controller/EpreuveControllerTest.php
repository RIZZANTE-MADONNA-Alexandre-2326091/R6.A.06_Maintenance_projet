<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du contrôleur EpreuveController.
 */
final class EpreuveControllerTest extends WebTestCase
{
    /**
     * Teste que la page /epreuve répond correctement.
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/epreuve');

        self::assertResponseIsSuccessful();
    }
}
