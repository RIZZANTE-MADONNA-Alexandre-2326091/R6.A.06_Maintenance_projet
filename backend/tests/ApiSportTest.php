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
        $this->assertJsonContains(['@context' => '/api/contexts/Sport']);
    }

    /**
     * Créer un sport.
     */
    public function testCreateSport(): void
    {
        $response = static::createClient()->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Football',
                'type' => 'equipe',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => 'Football',
            'type' => 'equipe',
        ]);
        $this->assertMatchesRegularExpression('~^/api/sports/\d+$~', $response->toArray()['@id']);
    }

    /**
     * Récupérer un sport.
     */
    public function testGetSport(): void
    {
        // Créer un sport pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Basketball',
                'type' => 'equipe',
            ],
        ]);
        $id = $response->toArray()['id'];

        // Récupérer le sport créé
        $response = $client->request('GET', '/api/sports/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $id,
            'name' => 'Basketball',
            'type' => 'equipe',
        ]);
    }

    /**
     * Mettre à jour un sport (PUT).
     */
    public function testUpdateSport(): void
    {
        // Créer un sport pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Tennis',
                'type' => 'individuel',
            ],
        ]);
        $iri = $response->toArray()['@id'];

        // Mettre à jour le sport
        $client->request('PUT', $iri, [
            'json' => [
                'name' => 'Tennis de Table',
                'type' => 'individuel',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Tennis de Table',
            'type' => 'individuel',
        ]);
    }

    /**
     * Mettre à jour partiellement un sport (PATCH).
     */
    public function testPatchSport(): void
    {
        // Créer un sport pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Volley',
                'type' => 'equipe',
            ],
        ]);
        $iri = $response->toArray()['@id'];

        // Modifier seulement le nom
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Volley-ball',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Volley-ball',
            'type' => 'equipe',
        ]);
    }

    /**
     * Supprimer un sport.
     */
    public function testDeleteSport(): void
    {
        // Créer un sport pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/sports', [
            'json' => [
                'name' => 'Rugby',
                'type' => 'equipe',
            ],
        ]);
        $iri = $response->toArray()['@id'];

        // Supprimer le sport
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Vérifier qu'il n'existe plus
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test de validation : création avec données invalides.
     */
    public function testCreateSportWithInvalidData(): void
    {
        static::createClient()->request('POST', '/api/sports', [
            'json' => [
                'name' => '', // nom vide
                'type' => 'invalide', // type invalide
            ],
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * Test d'erreur 404 : récupérer un sport inexistant.
     */
    public function testGetNonExistentSport(): void
    {
        static::createClient()->request('GET', '/api/sports/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : mettre à jour un sport inexistant.
     */
    public function testUpdateNonExistentSport(): void
    {
        static::createClient()->request('PUT', '/api/sports/99999', [
            'json' => [
                'name' => 'Sport inexistant',
                'type' => 'individuel',
            ],
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : supprimer un sport inexistant.
     */
    public function testDeleteNonExistentSport(): void
    {
        static::createClient()->request('DELETE', '/api/sports/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test des fixtures : vérifier que les sports des fixtures sont présents.
     */
    public function testFixturesSportsArePresent(): void
    {
        $response = static::createClient()->request('GET', '/api/sports');
        
        $this->assertResponseStatusCodeSame(200);
        $data = $response->toArray();
        
        // Vérifier qu'il y a au moins 12 sports (nos fixtures)
        $this->assertGreaterThanOrEqual(12, $data['hydra:totalItems']);
        
        // Vérifier que certains sports spécifiques existent
        $sportNames = array_column($data['hydra:member'], 'name');
        $this->assertContains('Football', $sportNames);
        $this->assertContains('Basketball', $sportNames);
        $this->assertContains('Athlétisme', $sportNames);
        $this->assertContains('Natation', $sportNames);
        $this->assertContains('Judo', $sportNames);
    }

    /**
     * Test des fixtures : vérifier les types de sports.
     */
    public function testFixturesSportsTypes(): void
    {
        $response = static::createClient()->request('GET', '/api/sports');
        $data = $response->toArray();
        
        $sports = $data['hydra:member'];
        
        // Trouver le Football et vérifier son type
        $football = array_filter($sports, fn($s) => $s['name'] === 'Football');
        if (count($football) > 0) {
            $this->assertEquals('equipe', array_values($football)[0]['type']);
        }
        
        // Trouver l'Athlétisme et vérifier son type
        $athletisme = array_filter($sports, fn($s) => $s['name'] === 'Athlétisme');
        if (count($athletisme) > 0) {
            $this->assertEquals('individuel', array_values($athletisme)[0]['type']);
        }
        
        // Trouver le Tennis en double et vérifier son type
        $tennisDouble = array_filter($sports, fn($s) => $s['name'] === 'Tennis en double');
        if (count($tennisDouble) > 0) {
            $this->assertEquals('indiEquipe', array_values($tennisDouble)[0]['type']);
        }
    }

    /**
     * Test des fixtures : rechercher un sport spécifique par nom.
     */
    public function testGetSpecificFixtureSportByName(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/sports');
        $data = $response->toArray();
        
        // Trouver le Basketball dans les fixtures
        $basketballs = array_filter($data['hydra:member'], fn($s) => $s['name'] === 'Basketball');
        
        if (count($basketballs) > 0) {
            $basketball = array_values($basketballs)[0];
            $basketballId = $basketball['id'];
            
            // Récupérer le sport spécifique
            $response = $client->request('GET', '/api/sports/' . $basketballId);
            
            $this->assertResponseStatusCodeSame(200);
            $this->assertJsonContains([
                'id' => $basketballId,
                'name' => 'Basketball',
                'type' => 'equipe'
            ]);
        }
    }
}

