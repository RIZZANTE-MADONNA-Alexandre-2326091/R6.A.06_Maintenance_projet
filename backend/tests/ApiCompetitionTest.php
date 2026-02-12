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
        $this->assertJsonContains(['@context' => '/api/contexts/Competition']);
    }

    /**
     * Créer une compétition.
     */
    public function testCreateCompetition(): void
    {
        $response = static::createClient()->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition Nationale'
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'name' => 'Compétition Nationale'
        ]);
        $this->assertMatchesRegularExpression('~^/api/competitions/\d+$~', $response->toArray()['@id']);
    }

    /**
     * Créer une compétition avec une épreuve.
     */
    public function testCreateCompetitionWithEpreuve(): void
    {
        $client = static::createClient();
        
        // Créer d'abord une épreuve
        $epreuveResponse = $client->request('POST', '/api/epreuves', [
            'json' => [
                'name' => 'Épreuve test'
            ]
        ]);
        $epreuveIri = $epreuveResponse->toArray()['@id'];

        // Créer la compétition avec l'épreuve
        $response = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition régionale',
                'epreuve_id' => $epreuveIri
            ]
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'name' => 'Compétition régionale'
        ]);
    }

    /**
     * Récupérer une compétition.
     */
    public function testGetCompetition(): void
    {
        // Créer une compétition pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition départementale'
            ]
        ]);
        $id = $response->toArray()['id'];

        // Récupérer la compétition créée
        $response = $client->request('GET', '/api/competitions/'.$id);

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'id' => $id,
            'name' => 'Compétition Départementale'
        ]);
    }

    /**
     * Mettre à jour une compétition (PUT).
     */
    public function testUpdateCompetition(): void
    {
        // Créer une compétition pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition Junior'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Mettre à jour la compétition
        $client->request('PUT', $iri, [
            'json' => [
                'name' => 'Compétition Senior'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Compétition Senior'
        ]);
    }

    /**
     * Mettre à jour partiellement une compétition (PATCH).
     */
    public function testPatchCompetition(): void
    {
        // Créer une compétition pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition Cadets'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Modifier seulement le nom
        $client->request('PATCH', $iri, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'name' => 'Compétition Minimes'
            ]
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Compétition Minimes'
        ]);
    }

    /**
     * Supprimer une compétition.
     */
    public function testDeleteCompetition(): void
    {
        // Créer une compétition pour le test
        $client = static::createClient();
        $response = $client->request('POST', '/api/competitions', [
            'json' => [
                'name' => 'Compétition à supprimer'
            ]
        ]);
        $iri = $response->toArray()['@id'];

        // Supprimer la compétition
        $client->request('DELETE', $iri);
        $this->assertResponseStatusCodeSame(204);

        // Vérifier qu'elle n'existe plus
        $client->request('GET', $iri);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test de validation : création avec nom vide.
     */
    public function testCreateCompetitionWithEmptyName(): void
    {
        static::createClient()->request('POST', '/api/competitions', [
            'json' => [
                'name' => ''
            ]
        ]);

        $this->assertResponseStatusCodeSame(422);
    }

    /**
     * Test d'erreur 404 : récupérer une compétition inexistante.
     */
    public function testGetNonExistentCompetition(): void
    {
        static::createClient()->request('GET', '/api/competitions/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : mettre à jour une compétition inexistante.
     */
    public function testUpdateNonExistentCompetition(): void
    {
        static::createClient()->request('PUT', '/api/competitions/99999', [
            'json' => [
                'name' => 'Compétition inexistante'
            ]
        ]);
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test d'erreur 404 : supprimer une compétition inexistante.
     */
    public function testDeleteNonExistentCompetition(): void
    {
        static::createClient()->request('DELETE', '/api/competitions/99999');
        $this->assertResponseStatusCodeSame(404);
    }

    /**
     * Test des fixtures : vérifier que les compétitions des fixtures sont présentes.
     */
    public function testFixturesCompetitionsArePresent(): void
    {
        $response = static::createClient()->request('GET', '/api/competitions');
        
        $this->assertResponseStatusCodeSame(200);
        $data = $response->toArray();
        
        // Vérifier qu'il y a au moins 7 compétitions (nos fixtures)
        $this->assertGreaterThanOrEqual(7, $data['hydra:totalItems']);
        
        // Vérifier que certaines compétitions spécifiques existent
        $competitionNames = array_column($data['hydra:member'], 'name');
        $this->assertContains('Football Collèges - Bretagne', $competitionNames);
        $this->assertContains('Championnat de France Football', $competitionNames);
        $this->assertContains('Handball Minimes - 56', $competitionNames);
    }

    /**
     * Test des fixtures : vérifier les épreuves associées aux compétitions.
     */
    public function testFixturesCompetitionsWithEpreuves(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/competitions');
        $data = $response->toArray();
        
        // Trouver la compétition Basketball
        $basketCompetitions = array_filter($data['hydra:member'], 
            fn($c) => str_contains($c['name'], 'Basketball')
        );
        
        if (count($basketCompetitions) > 0) {
            $competition = array_values($basketCompetitions)[0];
            $competitionId = $competition['id'];
            
            // Récupérer la compétition complète avec ses épreuves
            $response = $client->request('GET', '/api/competitions/' . $competitionId);
            $compData = $response->toArray();
            
            $this->assertResponseStatusCodeSame(200);
            $this->assertArrayHasKey('epreuves', $compData);
        }
    }

    /**
     * Test des fixtures : rechercher une compétition spécifique.
     */
    public function testGetSpecificFixtureCompetition(): void
    {
        $client = static::createClient();
        $response = $client->request('GET', '/api/competitions');
        $data = $response->toArray();
        
        // Trouver la compétition de Natation
        $natations = array_filter($data['hydra:member'], 
            fn($c) => str_contains($c['name'], 'Natation')
        );
        
        if (count($natations) > 0) {
            $natation = array_values($natations)[0];
            $natationId = $natation['id'];
            
            // Récupérer la compétition spécifique
            $response = $client->request('GET', '/api/competitions/' . $natationId);
            
            $this->assertResponseStatusCodeSame(200);
            $this->assertJsonContains([
                'id' => $natationId
            ]);
        }
    }
}

