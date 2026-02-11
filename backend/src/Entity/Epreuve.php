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
    normalizationContext: ['groups' => ['qcm:read']],
    denormalizationContext: ['groups' => ['qcm:write']]
)]
class Epreuve
{
    /**
     * @var int|null Identifiant de l'épreuve.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(cascade: ['persist', 'remove'])]
    private ?Sport $sport_id = null;

    /**
     * Renvoie l'identifiant de l'épreuve.
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

    public function getSportId(): ?Sport
    {
        return $this->sport_id;
    }

    public function setSportId(?Sport $sport_id): static
    {
        $this->sport_id = $sport_id;

        return $this;
    }
}
