<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Test du contrôleur SportController.
 */
final class SportControllerTest extends WebTestCase
{
    /**
     * Teste que la page /sport répond correctement.
     */
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/sport');

        self::assertResponseIsSuccessful();
    }
}
