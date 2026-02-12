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
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
    normalizationContext: ['groups' => ['competition:read']],
    denormalizationContext: ['groups' => ['competition:write']]
)]
class Competition
{
    /**
     * @var int|null Identifiant de la compétition.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['competition:read', 'championnat:read'])]
    private ?int $id = null;

    /**
     * @var string|null Nom de la compétition.
     */
    #[ORM\Column(length: 255)]
    #[Groups(['competition:read', 'competition:write', 'championnat:read'])]
    private ?string $name = null;

    /**
     * @var Championnat|null Championnat dont la compétition appartient.
     */
    #[ORM\ManyToOne(targetEntity: Championnat::class, inversedBy: 'competitions')]
    private ?Championnat $championnat = null;

    /**
     * @var Collection|null Epreuves du championnat.
     */
    #[ORM\OneToMany(targetEntity: Epreuve::class, mappedBy: 'competition', cascade: ['persist', 'remove'])]
    #[Groups(['competition:read', 'championnat:read'])]
    private ?Collection $epreuves;

    /**
     * Renvoie l'identifiant de la compétition.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le nom de la compétition.
     * @return int|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Modifie le nom de la competition
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie les épreuves de la compétition
     * @return Collection|null
     */
    public function getEpreuves(): ?Collection
    {
        return $this->epreuves;
    }

    /**
     * Modifie les épreuves de la compétition
     * @return static
     */
    public function setEpreuves(?Collection $epreuves): static
    {
        $this->epreuves = $epreuves;

        return $this;
    }

    /**
     * @return Championnat|null
     */
    public function getChampionnat(): ?Championnat
    {
        return $this->championnat;
    }

    /**
     * @param Championnat|null $championnat
     */
    public function setChampionnat(?Championnat $championnat): static
    {
        $this->championnat = $championnat;
        return $this;
    }
}
