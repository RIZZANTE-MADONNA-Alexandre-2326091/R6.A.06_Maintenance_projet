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
        new Delete()
    ],
    normalizationContext: ['groups' => ['sport:read']],
    denormalizationContext: ['groups' => ['sport:write']]
)]
class Sport
{
    /**
     * @var int|null Identifiant du sport.
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['sport:read'])]
    private ?int $id = null;

    /**
     * @var SportTypeEnum|null Type du sport.
     */
    #[ORM\Column(type: 'enum', enumType: SportTypeEnum::class)]
    #[Groups(['sport:read', 'sport:write', 'epreuve:read', 'competition:read', 'championnat:read'])]
    private ?SportTypeEnum $type = null;

    /**
     * @var string|null Nom du sport.
     */
    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['sport:read', 'sport:write', 'epreuve:read', 'competition:read', 'championnat:read'])]
    private ?string $name = null;

    /**
     * Renvoie l'identifiant du sport.
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Renvoie le type du sport.
     * 
     * @return SportTypeEnum|null
     */
    public function getType(): ?SportTypeEnum
    {
        return $this->type;
    }

    /**
     * Définit le type du sport.
     * 
     * @param SportTypeEnum|null $type
     * @return static
     */
    public function setType(?SportTypeEnum $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Renvoie le nom du sport.
     * 
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Définit le nom du sport.
     * 
     * @param string $name
     * @return static
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
