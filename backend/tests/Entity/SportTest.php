<?php

namespace App\Tests\Entity;

use App\Entity\Epreuve;
use App\Entity\Sport;
use App\Enum\SportTypeEnum;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'entité Sport.
 */
class SportTest extends TestCase
{
    /**
     * Teste que l'id est null par défaut (auto-généré par Doctrine).
     */
    public function testIdIsNullByDefault(): void
    {
        $sport = new Sport();
        $this->assertNull($sport->getId());
    }

    /**
     * Teste le getter et setter du nom.
     */
    public function testGetSetName(): void
    {
        $sport = new Sport();
        $result = $sport->setName('Football');

        $this->assertSame('Football', $sport->getName());
        $this->assertSame($sport, $result, 'setName doit retourner $this pour le chaînage');
    }

    /**
     * Teste le getter et setter du type avec l'enum.
     */
    public function testGetSetType(): void
    {
        $sport = new Sport();
        $result = $sport->setType(SportTypeEnum::equipe);

        $this->assertSame(SportTypeEnum::equipe, $sport->getType());
        $this->assertSame($sport, $result, 'setType doit retourner $this pour le chaînage');
    }

    /**
     * Teste que le type peut être null.
     */
    public function testTypeCanBeNull(): void
    {
        $sport = new Sport();
        $sport->setType(null);

        $this->assertNull($sport->getType());
    }

    /**
     * Teste tous les types de sport possibles.
     */
    public function testAllSportTypes(): void
    {
        $sport = new Sport();

        $sport->setType(SportTypeEnum::individuel);
        $this->assertSame(SportTypeEnum::individuel, $sport->getType());

        $sport->setType(SportTypeEnum::equipe);
        $this->assertSame(SportTypeEnum::equipe, $sport->getType());

        $sport->setType(SportTypeEnum::indiEquipe);
        $this->assertSame(SportTypeEnum::indiEquipe, $sport->getType());
    }

    /**
     * Teste que la collection d'épreuves est initialisée dans le constructeur.
     */
    public function testEpreuvesInitializedAsEmptyCollection(): void
    {
        $sport = new Sport();

        $this->assertNotNull($sport->getEpreuves());
        $this->assertCount(0, $sport->getEpreuves());
    }

    /**
     * Teste le setter des épreuves.
     */
    public function testGetSetEpreuves(): void
    {
        $sport = new Sport();
        $epreuves = new ArrayCollection([new Epreuve(), new Epreuve()]);

        $result = $sport->setEpreuves($epreuves);

        $this->assertSame($epreuves, $sport->getEpreuves());
        $this->assertCount(2, $sport->getEpreuves());
        $this->assertSame($sport, $result, 'setEpreuves doit retourner $this pour le chaînage');
    }
}
