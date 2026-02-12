<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\EpreuveRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Entité Epreuve.<br>
 * Représente une épreuve.
 */
#[ORM\Entity(repositoryClass: EpreuveRepository::class)]
#[ORM\Table(name: '`epreuve`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['epreuve:read']],
    denormalizationContext: ['groups' => ['epreuve:write']]
)]
class Epreuve
{
    /**
     * @var int|null Identifiant de l'épreuve.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['epreuve:read', 'competition:read', 'championnat:read'])]
    private ?int $id = null;

    /**
     * @var string|null Nom de l'épreuve.
     */
    #[ORM\Column(length: 255)]
    #[Groups(['epreuve:read', 'epreuve:write', 'competition:read', 'championnat:read'])]
    private ?string $name = null;

    /**
     * @var Competition|null Compétition à laquelle l'épreuve appartient.
     */
    #[ORM\ManyToOne(targetEntity: Competition::class, inversedBy: 'epreuves')]
    #[Groups(['epreuve:read', 'epreuve:write', 'competition:read', 'championnat:read'])]
    private ?Competition $competition = null;

    /**
     * @var Sport|null Sport associé à l'épreuve.
     */
    #[ORM\ManyToOne(targetEntity: Sport::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['epreuve:read', 'epreuve:write', 'competition:read', 'championnat:read'])]
    private ?Sport $sport = null;

    /**
     * Renvoie l'identifiant de l'épreuve.
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom de l'épreuve.
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom de l'épreuve.
     * 
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie le sport de l'épreuve.
     * 
     * @return Sport|null
     */
    public function getSport(): ?Sport
    {
        return $this->sport;
    }

    /**
     * Définit le sport de l'épreuve.
     * 
     * @param Sport|null $sport
     * @return static
     */
    public function setSport(?Sport $sport): static
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Renvoie la compétition à laquelle l'épreuve appartient.
     * 
     * @return Competition|null
     */
    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    /**
     * Définit la compétition à laquelle l'épreuve appartient.
     * 
     * @param Competition|null $competition
     * @return static
     */
    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;
        return $this;
    }
}
