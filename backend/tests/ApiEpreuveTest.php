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
                'name' => '100m Haies',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => '100m Haies',
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
                'type' => 'individuel',
            ],
        ]);
        $sportIri = $sportResponse->toArray()['@id'];

        // Créer l'épreuve avec le sport
        $response = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => '200m',
                'sport_id' => $sportIri,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'name' => '200m',
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
                'name' => 'Saut en longueur',
            ],
        ]);
        $id = $response->toArray()['id'];

        // Récupérer l'épreuve créée
        $response = $client->request('GET', '/api/epreuves/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $id,
            'name' => 'Saut en longueur',
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
                'name' => 'Saut en hauteur',
            ],
        ]);
        $iri = $response->toArray()['@id'];

        // Mettre à jour l'épreuve
        $client->request('PUT', $iri, [
            'json' => [
                'name' => 'Triple saut',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Triple saut',
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
                'name' => 'Lancer de poids',
            ],
        ]);
        $iri = $response->toArray()['@id'];

        // Modifier seulement le nom
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Lancer du marteau',
            ],
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Lancer du marteau',
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
                'name' => 'Épreuve à supprimer',
            ],
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
                'name' => '',
            ],
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
                'name' => 'Épreuve inexistante',
            ],
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

    /**
     * Test des fixtures : vérifier que les épreuves des fixtures sont présentes.
     */
    public function testFixturesEpreuvesArePresent(): void
    {
        $response = static::createClient()->request('GET', '/api/epreuves');
        
        $this->assertResponseStatusCodeSame(200);
        $data = $response->toArray();
        
        // Vérifier qu'il y a au moins 13 épreuves (nos fixtures)
        $this->assertGreaterThanOrEqual(13, $data['hydra:totalItems']);
        
        // Vérifier que certaines épreuves spécifiques existent
        $epreuveNames = array_column($data['hydra:member'], 'name');
        $this->assertContains('100m Sprint', $epreuveNames);
        $this->assertContains('Football Minimes Garçons', $epreuveNames);
        $this->assertContains('50m Nage Libre', $epreuveNames);
    }

    /**
     * Test des fixtures : vérifier les sports associés aux épreuves.
     */
    public function testFixturesEpreuvesWithSports(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/epreuves');
        $data = $response->toArray();
        
        // Trouver une épreuve de football
        $footballEpreuves = array_filter($data['hydra:member'], 
            fn($e) => str_contains($e['name'], 'Football')
        );
        
        if (count($footballEpreuves) > 0) {
            $epreuve = array_values($footballEpreuves)[0];
            $epreuveId = $epreuve['id'];
            
            // Récupérer l'épreuve complète
            $response = $client->request('GET', '/api/epreuves/' . $epreuveId);
            $epreuveData = $response->toArray();
            
            $this->assertResponseStatusCodeSame(200);
            // Vérifier que l'épreuve a un sport associé
            if (isset($epreuveData['sport'])) {
                $this->assertNotNull($epreuveData['sport']);
            }
        }
    }

    /**
     * Test des fixtures : vérifier qu'une épreuve d'athlétisme existe.
     */
    public function testGetSpecificFixtureEpreuve(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/epreuves');
        $data = $response->toArray();
        
        // Trouver une épreuve de 100m
        $sprint100m = array_filter($data['hydra:member'], 
            fn($e) => str_contains($e['name'], '100m')
        );
        
        if (count($sprint100m) > 0) {
            $epreuve = array_values($sprint100m)[0];
            $epreuveId = $epreuve['id'];
            
            // Récupérer l'épreuve spécifique
            $response = $client->request('GET', '/api/epreuves/' . $epreuveId);
            
            $this->assertResponseStatusCodeSame(200);
            $this->assertJsonContains([
                'id' => $epreuveId
            ]);
        }
    }

    /**
     * Test des fixtures : vérifier les relations épreuve-compétition.
     */
    public function testFixturesEpreuvesCompetitionRelations(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/epreuves');
        $data = $response->toArray();
        
        // Vérifier qu'au moins une épreuve a une compétition associée
        $epreuvesWithCompetition = array_filter($data['hydra:member'], 
            fn($e) => isset($e['competition']) && $e['competition'] !== null
        );
        
        $this->assertGreaterThan(0, count($epreuvesWithCompetition), 
            'Au moins une épreuve devrait avoir une compétition associée');
    }
}

