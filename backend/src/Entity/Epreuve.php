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
        new Delete(),
    ],
    normalizationContext: ['groups' => ['epreuve:read']],
    denormalizationContext: ['groups' => ['epreuve:write']]
)]
class Epreuve
{
    /**
     * @var int|null identifiant de l'épreuve
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['epreuve:read'])]
    private ?int $id = null;

    /**
     * @var string|null nom de l'épreuve
     */
    #[ORM\Column(length: 255)]
    #[Groups(['epreuve:read', 'epreuve:write'])]
    private ?string $name = null;

    /**
     * @var Competition|null compétition à laquelle l'épreuve appartient
     */
    #[ORM\ManyToOne(targetEntity: Competition::class, inversedBy: 'epreuves')]
    #[Groups(['epreuve:read', 'epreuve:write', 'competition:read', 'championnat:read'])]
    private ?Competition $competition = null;

    #[ORM\ManyToOne(targetEntity: Sport::class, inversedBy: 'epreuves')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['qcm:read', 'qcm:write'])]
    private ?Sport $sport = null;

    /**
     * Renvoie l'identifiant de l'épreuve.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom de l'épreuve.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Modifie le nom de l'épreuve.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie les identifiants des sports de l'épreuve.
     */
    public function getSportId(): ?Sport
    {
        return $this->sport_id;
    }

    /**
     * Modifie les identifiants des sports de l'épreuve.
     */
    public function setSportId(?Sport $sport_id): static
    {
        $this->sport_id = $sport_id;

        return $this;
    }

    public function getCompetition(): ?Competition
    {
        return $this->competition;
    }

    public function setCompetition(?Competition $competition): static
    {
        $this->competition = $competition;

        return $this;
    }
}
