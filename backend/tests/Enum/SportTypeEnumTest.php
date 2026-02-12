<?php

namespace App\Tests\Enum;

use App\Enum\SportTypeEnum;
use PHPUnit\Framework\TestCase;

/**
 * Tests unitaires de l'enum SportTypeEnum.
 */
class SportTypeEnumTest extends TestCase
{
    /**
     * Teste que l'enum possède exactement 3 cas.
     */
    public function testEnumHasThreeCases(): void
    {
        $cases = SportTypeEnum::cases();
        $this->assertCount(3, $cases);
    }

    /**
     * Teste la valeur string du cas 'individuel'.
     */
    public function testIndividuelValue(): void
    {
        $this->assertSame('individuel', SportTypeEnum::individuel->value);
    }

    /**
     * Teste la valeur string du cas 'equipe'.
     */
    public function testEquipeValue(): void
    {
        $this->assertSame('equipe', SportTypeEnum::equipe->value);
    }

    /**
     * Teste la valeur string du cas 'indiEquipe'.
     */
    public function testIndiEquipeValue(): void
    {
        $this->assertSame('indiEquipe', SportTypeEnum::indiEquipe->value);
    }

    /**
     * Teste la construction depuis une valeur string valide.
     */
    public function testFromValidValue(): void
    {
        $this->assertSame(SportTypeEnum::individuel, SportTypeEnum::from('individuel'));
        $this->assertSame(SportTypeEnum::equipe, SportTypeEnum::from('equipe'));
        $this->assertSame(SportTypeEnum::indiEquipe, SportTypeEnum::from('indiEquipe'));
    }

    /**
     * Teste que tryFrom retourne null pour une valeur invalide.
     */
    public function testTryFromInvalidValue(): void
    {
        $this->assertNull(SportTypeEnum::tryFrom('invalide'));
        $this->assertNull(SportTypeEnum::tryFrom(''));
    }
}
