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
        $this->assertJsonContains(['@context' => '/api/contexts/Epreuve']);
    }

    /**
     * Créer une épreuve.
     */
    public function testCreateEpreuve(): void
    {
        $response = static::createClient()->request('POST', '/api/epreuves', [
            'json' => [
                'name' => '100m Haies'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => '100m Haies'
        ]);
        $this->assertMatchesRegularExpression('~^/api/epreuves/\d+$~', $response->toArray()['@id']);
    }

    /**
     * Créer une épreuve avec un sport.
     */
    public function testCreateEpreuveWithSport(): void
    {
        $client = static::createClient();
        
        // Créer d'abord un sport
        $sportResponse = $client->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Athlétisme',
                'type' => 'individuel'
            ]
        ]);
        $sportIri = $sportResponse->toArray()['@id'];

        // Créer l'épreuve avec le sport
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => '200m',
                'sport_id' => $sportIri
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'name' => '200m'
        ]);
    }

    /**
     * Récupérer une épreuve.
     */
    public function testGetEpreuve(): void
    {
        // Créer une épreuve pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => 'Saut en longueur'
            ]
        ]);
        $id = $response->toArray()['id'];

        // Récupérer l'épreuve créée
        $response = $client->request('GET', '/api/epreuves/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $id,
            'name' => 'Saut en longueur'
        ]);
    }

    /**
     * Mettre à jour une épreuve (PUT).
     */
    public function testUpdateEpreuve(): void
    {
        // Créer une épreuve pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => 'Saut en hauteur'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Mettre à jour l'épreuve
        $client->request('PUT', $iri, [
            'json' => [
                'name' => 'Triple saut'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Triple saut'
        ]);
    }

    /**
     * Mettre à jour partiellement une épreuve (PATCH).
     */
    public function testPatchEpreuve(): void
    {
        // Créer une épreuve pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => 'Lancer de poids'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Modifier seulement le nom
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Lancer du marteau'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Lancer du marteau'
        ]);
    }

    /**
     * Supprimer une épreuve.
     */
    public function testDeleteEpreuve(): void
    {
        // Créer une épreuve pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => 'Épreuve à supprimer'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Supprimer l'épreuve
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Vérifier qu'elle n'existe plus
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test de validation : création avec nom vide.
     */
    public function testCreateEpreuveWithEmptyName(): void
    {
        static::createClient()->request('POST', '/api/epreuves', [
            'json' => [
                'name' => ''
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * Test d'erreur 404 : récupérer une épreuve inexistante.
     */
    public function testGetNonExistentEpreuve(): void
    {
        static::createClient()->request('GET', '/api/epreuves/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : mettre à jour une épreuve inexistante.
     */
    public function testUpdateNonExistentEpreuve(): void
    {
        static::createClient()->request('PUT', '/api/epreuves/99999', [
            'json' => [
                'name' => 'Épreuve inexistante'
            ]
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : supprimer une épreuve inexistante.
     */
    public function testDeleteNonExistentEpreuve(): void
    {
        static::createClient()->request('DELETE', '/api/epreuves/99999');
        $this->assertResponseStatusCodeSame(404);
    }
}
