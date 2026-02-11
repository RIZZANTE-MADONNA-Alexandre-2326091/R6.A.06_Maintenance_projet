<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

/**
 * Test de l'API de l'entité Sport.
 */
class ApiSportTest extends ApiTestCase
{
    /**
     * Récupérer plusieurs sports.
     */
    public function testGetSports(): void
    {
        $response = static::createClient()->request('GET', '/api/sports');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

    /**
     * Récupérer un sport.
     */
    public function testGetSport(int $id): void
    {
        $response = static::createClient()->request('GET', '/api/sports/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
