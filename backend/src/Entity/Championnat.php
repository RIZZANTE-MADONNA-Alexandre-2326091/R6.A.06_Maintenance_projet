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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
        new Delete(),
    ],
    normalizationContext: ['groups' => ['championnat:read']],
    denormalizationContext: ['groups' => ['championnat:write']]
)]
class Championnat
{
    /**
     * Constructeur de la classe Championnat.
     */
    public function __construct()
    {
        $this->competitions = new ArrayCollection();
    }

    /**
     * @var int|null identifiant du championnat
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['championnat:read'])]
    private ?int $id = null;

    /**
     * @var string|null nom du championnat
     */
    #[ORM\Column(length: 255)]
    #[Groups(['championnat:read', 'championnat:write'])]
    private ?string $name = null;

    /**
     * @var Collection|null competitions du championnat
     */
    #[ORM\OneToMany(targetEntity: Competition::class, mappedBy: 'championnat', cascade: ['persist', 'remove'])]
    #[Groups(['championnat:read'])]
    private ?Collection $competitions = null;

    /**
     * Renvoie l'identifiant du championnat.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom du championnat.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Change le nom du championnat.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie les compétitions du championnat.
     */
    public function getCompetitions(): ?Collection
    {
        return $this->competitions;
    }

    /**
     * Modifie les compétitions du championnat.
     */
    public function setCompetitions(?Collection $competitions): static
    {
        $this->competitions = $competitions;

        return $this;
    }
}
