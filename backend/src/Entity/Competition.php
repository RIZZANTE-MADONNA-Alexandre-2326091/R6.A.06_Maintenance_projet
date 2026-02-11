<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CompetitionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Competition.<br>
 * Représente une compétition.
 */
#[ORM\Entity(repositoryClass: CompetitionRepository::class)]
#[ORM\Table(name: '`competition`')]
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
class Competition
{
    /**
     * @var int|null Identifiant de la compétition.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Epreuve $epreuve_id = null;

    /**
     * Renvoie l'identifiant de la compétition.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEpreuveId(): ?Epreuve
    {
        return $this->epreuve_id;
    }

    public function setEpreuveId(?Epreuve $epreuve_id): static
    {
        $this->epreuve_id = $epreuve_id;

        return $this;
    }
}
