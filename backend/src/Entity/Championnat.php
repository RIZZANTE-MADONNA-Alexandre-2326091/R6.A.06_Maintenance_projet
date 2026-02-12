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
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
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
        new Delete()
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
     * @var int|null Identifiant du championnat.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['championnat:read'])]
    private ?int $id = null;

    /**
     * @var string|null Nom du championnat.
     */
    #[ORM\Column(length: 255)]
    #[Groups(['championnat:read', 'championnat:write'])]
    private ?string $name = null;

    /**
     * @var Collection|null Liste des compétitions associées à ce championnat.
     */
    #[ORM\OneToMany(targetEntity: Competition::class, mappedBy: 'championnat', cascade: ['persist', 'remove'])]
    #[Groups(['championnat:read'])]
    private ?Collection $competitions = null;

    /**
     * Renvoie l'identifiant du championnat.
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom du championnat.
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du championnat.
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
     * Renvoie la collection des compétitions du championnat.
     * 
     * @return Collection|null
     */
    public function getCompetitions(): ?Collection
    {
        return $this->competitions;
    }

    /**
     * Définit la collection des compétitions du championnat.
     * 
     * @param Collection|null $competitions
     * @return static
     */
    public function setCompetitions(?Collection $competitions): static
    {
        $this->competitions = $competitions;

        return $this;
    }
}
