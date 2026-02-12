<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Enum\SportTypeEnum;
use App\Repository\SportRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Entité Sport.<br>
 * Représente un sport.
 */
#[ORM\Entity(repositoryClass: SportRepository::class)]
#[ORM\Table(name: '`sport`')]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Patch(),
        new Delete(),
    ],
    normalizationContext: ['groups' => ['sport:read']],
    denormalizationContext: ['groups' => ['sport:write']]
)]
class Sport
{
    /**
     * @var int|null identifiant du sport
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sport:read'])]
    private ?int $id = null;

    /**
     * @var SportTypeEnum|null type du sport
     */
    #[ORM\Column(type: 'enum', enumType: SportTypeEnum::class)]
    #[Groups(['sport:read', 'sport:write'])]
    private ?SportTypeEnum $type = null;

    /**
     * @var string|null nom du sport
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['sport:read', 'sport:write'])]
    private ?string $name = null;

    /**
     * Constructeur de l'entité.
     */
    public function __construct()
    {
        $this->epreuves = new ArrayCollection();
    }

    /**
     * @var Collection|null Epreuves liées au sport
     */
    #[ORM\OneToMany(targetEntity: Epreuve::class, mappedBy: 'sport')]
    private ?Collection $epreuves;

    /**
     * Renvoie l'identifiant du sport.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le type du sport.
     */
    public function getType(): ?SportTypeEnum
    {
        return $this->type;
    }

    /**
     * Modifie le type du sport.
     */
    public function setType(?SportTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Renvoie le nom du sport.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Modifie le nom du sport.
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Renvoie les épreuves liées au sport.
     */
    public function getEpreuves(): ?Collection
    {
        return $this->epreuves;
    }

    /**
     * Modifie les épreuves liées au sport.
     */
    public function setEpreuves(Collection $epreuves): static
    {
        $this->epreuves = $epreuves;

        return $this;
    }
}
