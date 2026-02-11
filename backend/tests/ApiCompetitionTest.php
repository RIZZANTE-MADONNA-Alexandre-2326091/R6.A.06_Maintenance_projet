<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

/**
 * Test de l'API de l'entité Competition.
 */
class ApiCompetitionTest extends ApiTestCase
{
    /**
     * Récupérer plusieurs compétitions.
     */
    public function testGetCompetitions(): void
    {
        $response = static::createClient()->request('GET', '/api/competitions');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

    /**
     * Récupérer une compétition.
     */
    public function testGetCompetition(int $id): void
    {
        $response = static::createClient()->request('GET', '/api/competitions/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
