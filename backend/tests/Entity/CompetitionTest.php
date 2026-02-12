<?php

namespace App\Tests\Entity;

use App\Entity\Championnat;
use App\Entity\Competition;
use App\Entity\Epreuve;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'entité Competition.
 */
class CompetitionTest extends TestCase
{
    /**
     * Teste que l'id est null par défaut.
     */
    public function testIdIsNullByDefault(): void
    {
        $competition = new Competition();
        $this->assertNull($competition->getId());
    }

    /**
     * Teste le getter et setter du nom.
     */
    public function testGetSetName(): void
    {
        $competition = new Competition();
        $result = $competition->setName('Football Collèges - Bretagne');

        $this->assertSame('Football Collèges - Bretagne', $competition->getName());
        $this->assertSame($competition, $result, 'setName doit retourner $this pour le chaînage');
    }

    /**
     * Teste le getter et setter du championnat.
     */
    public function testGetSetChampionnat(): void
    {
        $competition = new Competition();
        $championnat = new Championnat();
        $championnat->setName('UGSEL National');

        $result = $competition->setChampionnat($championnat);

        $this->assertSame($championnat, $competition->getChampionnat());
        $this->assertSame($competition, $result, 'setChampionnat doit retourner $this pour le chaînage');
    }

    /**
     * Teste que le championnat peut être null.
     */
    public function testChampionnatCanBeNull(): void
    {
        $competition = new Competition();
        $competition->setChampionnat(null);

        $this->assertNull($competition->getChampionnat());
    }

    /**
     * Teste le getter et setter des épreuves.
     */
    public function testGetSetEpreuves(): void
    {
        $competition = new Competition();
        $epreuves = new ArrayCollection([new Epreuve(), new Epreuve()]);

        $result = $competition->setEpreuves($epreuves);

        $this->assertSame($epreuves, $competition->getEpreuves());
        $this->assertCount(2, $competition->getEpreuves());
        $this->assertSame($competition, $result, 'setEpreuves doit retourner $this pour le chaînage');
    }

    /**
     * Teste que les épreuves peuvent être null.
     */
    public function testEpreuvesCanBeNull(): void
    {
        $competition = new Competition();
        $competition->setEpreuves(null);

        $this->assertNull($competition->getEpreuves());
    }
}
