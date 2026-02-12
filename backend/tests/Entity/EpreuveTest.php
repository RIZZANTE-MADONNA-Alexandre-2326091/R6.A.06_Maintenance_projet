<?php

namespace App\Tests\Entity;

use App\Entity\Competition;
use App\Entity\Epreuve;
use App\Entity\Sport;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'entité Epreuve.
 */
class EpreuveTest extends TestCase
{
    /**
     * Teste que l'id est null par défaut.
     */
    public function testIdIsNullByDefault(): void
    {
        $epreuve = new Epreuve();
        $this->assertNull($epreuve->getId());
    }

    /**
     * Teste le getter et setter du nom.
     */
    public function testGetSetName(): void
    {
        $epreuve = new Epreuve();
        $result = $epreuve->setName('100m Sprint');

        $this->assertSame('100m Sprint', $epreuve->getName());
        $this->assertSame($epreuve, $result, 'setName doit retourner $this pour le chaînage');
    }

    /**
     * Teste que le nom est null par défaut.
     */
    public function testNameIsNullByDefault(): void
    {
        $epreuve = new Epreuve();
        $this->assertNull($epreuve->getName());
    }

    /**
     * Teste le getter et setter de la compétition.
     */
    public function testGetSetCompetition(): void
    {
        $epreuve = new Epreuve();
        $competition = new Competition();
        $competition->setName('Athlétisme Cross');

        $result = $epreuve->setCompetition($competition);

        $this->assertSame($competition, $epreuve->getCompetition());
        $this->assertSame($epreuve, $result, 'setCompetition doit retourner $this pour le chaînage');
    }

    /**
     * Teste que la compétition peut être null.
     */
    public function testCompetitionCanBeNull(): void
    {
        $epreuve = new Epreuve();
        $epreuve->setCompetition(null);

        $this->assertNull($epreuve->getCompetition());
    }

    /**
     * Teste la relation complète épreuve → compétition.
     */
    public function testEpreuveCompetitionRelation(): void
    {
        $competition = new Competition();
        $competition->setName('Football Bretagne');

        $epreuve = new Epreuve();
        $epreuve->setName('Football Minimes Garçons');
        $epreuve->setCompetition($competition);

        $this->assertSame('Football Minimes Garçons', $epreuve->getName());
        $this->assertSame($competition, $epreuve->getCompetition());
        $this->assertSame('Football Bretagne', $epreuve->getCompetition()->getName());
    }
}
