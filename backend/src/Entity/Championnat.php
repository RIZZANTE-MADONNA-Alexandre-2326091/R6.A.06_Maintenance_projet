<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ChampionnatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Championnat.<br>
 * Représente un championnat.
 */
#[ORM\Entity(repositoryClass: ChampionnatRepository::class)]
#[ORM\Table(name: '`championnat`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['qcm:read']],
    denormalizationContext: ['groups' => ['qcm:write']]
)]
class Championnat
{
    /**
     * @var int|null Identifiant du championnat.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Competition $competition_id = null;

    /**
     * Renvoie l'identifiant du championnat.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom du championnat
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Change le nom du championnat
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCompetitionId(): ?Competition
    {
        return $this->competition_id;
    }


    public function setCompetitionId(?Competition $competition_id): static
    {
        $this->competition_id = $competition_id;

        return $this;
    }
}
