<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

/**
 * Test de l'API de l'entité Championnat.
 */
class ApiChampionnatTest extends ApiTestCase
{
    /**
     * Récupérer plusieurs championnats.
     */
    public function testGetChampionnats(): void
    {
        $response = static::createClient()->request('GET', '/api/championnats');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }

    /**
     * Récupérer un championnat.
     */
    public function testGetChampionnat(int $id): void
    {
        $response = static::createClient()->request('GET', '/api/championnats/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains(['@id' => '/']);
    }
}
