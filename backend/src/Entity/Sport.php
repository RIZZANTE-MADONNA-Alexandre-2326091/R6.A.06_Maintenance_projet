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
use Doctrine\ORM\Mapping as ORM;

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
        new Delete()
    ],
    normalizationContext: ['groups' => ['qcm:read']],
    denormalizationContext: ['groups' => ['qcm:write']]
)]
class Sport
{
    /**
     * @var int|null Identifiant du sport.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'enum')]
    private ?SportTypeEnum $type = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    /**
     * Renvoie l'identifiant du sport.
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?SportTypeEnum
    {
        return $this->type;
    }

    public function setType(?SportTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
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
}
