<?php

namespace App\Tests\Entity;

use App\Entity\Championnat;
use App\Entity\Competition;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'entité Championnat.
 */
class ChampionnatTest extends TestCase
{
    /**
     * Teste que l'id est null par défaut.
     */
    public function testIdIsNullByDefault(): void
    {
        $championnat = new Championnat();
        $this->assertNull($championnat->getId());
    }

    /**
     * Teste le getter et setter du nom.
     */
    public function testGetSetName(): void
    {
        $championnat = new Championnat();
        $result = $championnat->setName('UGSEL Bretagne 2025-2026');

        $this->assertSame('UGSEL Bretagne 2025-2026', $championnat->getName());
        $this->assertSame($championnat, $result, 'setName doit retourner $this pour le chaînage');
    }

    /**
     * Teste que le nom est null par défaut.
     */
    public function testNameIsNullByDefault(): void
    {
        $championnat = new Championnat();
        $this->assertNull($championnat->getName());
    }

    /**
     * Teste que la collection de compétitions est initialisée dans le constructeur.
     */
    public function testCompetitionsInitializedAsEmptyCollection(): void
    {
        $championnat = new Championnat();

        $this->assertNotNull($championnat->getCompetitions());
        $this->assertCount(0, $championnat->getCompetitions());
    }

    /**
     * Teste le setter des compétitions.
     */
    public function testGetSetCompetitions(): void
    {
        $championnat = new Championnat();
        $competitions = new ArrayCollection([new Competition(), new Competition()]);

        $result = $championnat->setCompetitions($competitions);

        $this->assertSame($competitions, $championnat->getCompetitions());
        $this->assertCount(2, $championnat->getCompetitions());
        $this->assertSame($championnat, $result, 'setCompetitions doit retourner $this pour le chaînage');
    }

    /**
     * Teste que setCompetitions accepte null.
     */
    public function testSetCompetitionsNull(): void
    {
        $championnat = new Championnat();
        $championnat->setCompetitions(null);

        $this->assertNull($championnat->getCompetitions());
    }
}
