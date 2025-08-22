<?php

namespace App\Entity;

use App\Repository\VhostRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VhostRepository::class)]
#[ORM\Table(name: 'vhosts')]
class Vhost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 32)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'vhosts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?VhostType $vhostType = null;

    #[ORM\Column]
    private array $parameters = [];


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getVhostType(): ?VhostType
    {
        return $this->vhostType;
    }

    public function setVhostType(?VhostType $vhostType): static
    {
        $this->vhostType = $vhostType;

        return $this;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }
}
