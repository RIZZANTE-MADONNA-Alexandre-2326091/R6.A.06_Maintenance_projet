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
        $this->assertJsonContains(['@context' => '/api/contexts/Championnat']);
    }

    /**
     * Créer un championnat.
     */
    public function testCreateChampionnat(): void
    {
        $response = static::createClient()->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat de France'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => 'Championnat de France'
        ]);
        $this->assertMatchesRegularExpression('~^/api/championnats/\d+$~', $response->toArray()['@id']);
    }

    /**
     * Créer un championnat avec une compétition.
     */
    public function testCreateChampionnatWithCompetition(): void
    {
        $client = static::createClient();
        
        // Créer d'abord une compétition
        $competitionResponse = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition Test'
            ]
        ]);
        $competitionIri = $competitionResponse->toArray()['@id'];

        // Créer le championnat avec la compétition
        $response = $client->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat Régional',
                'competition_id' => $competitionIri
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'name' => 'Championnat Régional'
        ]);
    }

    /**
     * Récupérer un championnat.
     */
    public function testGetChampionnat(): void
    {
        // Créer un championnat pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat National'
            ]
        ]);
        $id = $response->toArray()['id'];

        // Récupérer le championnat créé
        $response = $client->request('GET', '/api/championnats/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $id,
            'name' => 'Championnat National'
        ]);
    }

    /**
     * Mettre à jour un championnat (PUT).
     */
    public function testUpdateChampionnat(): void
    {
        // Créer un championnat pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat Junior'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Mettre à jour le championnat
        $client->request('PUT', $iri, [
            'json' => [
                'name' => 'Championnat Senior'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Championnat Senior'
        ]);
    }

    /**
     * Mettre à jour partiellement un championnat (PATCH).
     */
    public function testPatchChampionnat(): void
    {
        // Créer un championnat pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat Vétéran'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Modifier seulement le nom
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Championnat Vétérans'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Championnat Vétérans'
        ]);
    }

    /**
     * Supprimer un championnat.
     */
    public function testDeleteChampionnat(): void
    {
        // Créer un championnat pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/championnats', [
            'json' => [
                'name' => 'Championnat à supprimer'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Supprimer le championnat
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Vérifier qu'il n'existe plus
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test de validation : création avec nom vide.
     */
    public function testCreateChampionnatWithEmptyName(): void
    {
        static::createClient()->request('POST', '/api/championnats', [
            'json' => [
                'name' => ''
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * Test d'erreur 404 : récupérer un championnat inexistant.
     */
    public function testGetNonExistentChampionnat(): void
    {
        static::createClient()->request('GET', '/api/championnats/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : mettre à jour un championnat inexistant.
     */
    public function testUpdateNonExistentChampionnat(): void
    {
        static::createClient()->request('PUT', '/api/championnats/99999', [
            'json' => [
                'name' => 'Championnat inexistant'
            ]
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : supprimer un championnat inexistant.
     */
    public function testDeleteNonExistentChampionnat(): void
    {
        static::createClient()->request('DELETE', '/api/championnats/99999');
        $this->assertResponseStatusCodeSame(404);
    }
}
