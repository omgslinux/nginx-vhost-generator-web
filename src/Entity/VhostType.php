<?php

namespace App\Entity;

use App\Form\Dto\ParameterDto;
use App\Repository\VhostTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VhostTypeRepository::class)]
#[ORM\Table(name: 'vhost_types')]
class VhostType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 16)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $template = null;

    /**
     * @var Collection<int, Vhost>
     */
    #[ORM\OneToMany(targetEntity: Vhost::class, mappedBy: 'vhostType')]
    private Collection $vhosts;

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $parameters = null;

    #[ORM\Column(nullable: true)]
    private ?array $copy = null;

    public function __construct()
    {
        $this->vhosts = new ArrayCollection();
    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTemplate(): ?string
    {
        return $this->template;
    }

    public function setTemplate(string $template): static
    {
        $this->template = $template;

        return $this;
    }

    /**
     * @return Collection<int, Vhost>
     */
    public function getVhosts(): Collection
    {
        return $this->vhosts;
    }

    public function addVhost(Vhost $vhost): static
    {
        if (!$this->vhosts->contains($vhost)) {
            $this->vhosts->add($vhost);
            $vhost->setVhostType($this);
        }

        return $this;
    }

    public function removeVhost(Vhost $vhost): static
    {
        if ($this->vhosts->removeElement($vhost)) {
            // set the owning side to null (unless already changed)
            if ($vhost->getVhostType() === $this) {
                $vhost->setVhostType(null);
            }
        }

        return $this;
    }

    public function getParameters(): ?array
    {
        return array_map(
            fn ($item) => $item instanceof ParameterDto ? $item : ParameterDto::fromArray($item),
            $this->parameters ?? []
        );
        //return $this->parameters;
    }

    public function setParameters(?array $parameters): static
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function getCopy(): ?array
    {
        return $this->copy;
    }

    public function setCopy(?array $copy): static
    {
        $this->copy = $copy;

        return $this;
    }
}
