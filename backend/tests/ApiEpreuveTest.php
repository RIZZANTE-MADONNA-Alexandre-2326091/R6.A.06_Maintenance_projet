<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

/**
 * Test de l'API de l'entité Epreuve.
 */
class ApiEpreuveTest extends ApiTestCase
{
    /**
     * Récupérer plusieurs épreuves.
     */
    public function testGetEpreuves(): void
    {
        $response = static::createClient()->request('GET', '/api/epreuves');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

    /**
     * Récupérer une épreuve.
     */
    public function testGetEpreuve(int $id): void
    {
        $response = static::createClient()->request('GET', '/api/epreuves/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
