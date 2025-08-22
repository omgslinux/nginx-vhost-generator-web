<?php

namespace App\Form\Dto;

use App\Entity\VhostType;
use App\Form\Dto\VhostCommonDto;
use App\Form\Dto\DefaultParameterDto;
use Symfony\Component\Validator\Constraints as Assert;

class VhostGeneratorDto implements \JsonSerializable
{
    private ?int $id = null; // 💡 Propiedad para el ID de la entidad

    #[Assert\NotBlank]
    private ?string $name = null;

    #[Assert\NotNull]
    private ?VhostType $vhostType = null;

    public ?VhostCommonDto $commonParameters = null;

    private ?DefaultParameterDto $defaultParameters = null;

    private bool $debug = false;

    // Los parámetros específicos no necesitan ser un DTO.
    // Los manejaremos como un array simple en el controlador.
    private array $specificParameters = [];


    public function jsonSerialize(): mixed
    {
        return [
            'common' => $this->commonParameters,
            'default' => $this->defaultParameters,
            'specific' => $this->specificParameters,
            'type' => $this->vhostType?->getName(),
            'name' => $this->name,
        ];
    }


    // Getters y Setters para cada propiedad
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getVhostType(): ?VhostType
    {
        return $this->vhostType;
    }

    public function setVhostType(?VhostType $vhostType): self
    {
        $this->vhostType = $vhostType;
        return $this;
    }

    public function getCommonParameters(): ?VhostCommonDto
    {
        return $this->commonParameters;
    }

    public function setCommonParameters(?VhostCommonDto $commonParameters): self
    {
        $this->commonParameters = $commonParameters;
        return $this;
    }

    public function getDefaultParameters(): ?DefaultParameterDto
    {
        return $this->defaultParameters;
    }

    public function setDefaultParameters(?DefaultParameterDto $defaultParameters): self
    {
        $this->defaultParameters = $defaultParameters;
        return $this;
    }

    public function getSpecificParameters(): array
    {
        return $this->specificParameters;
    }

    public function setSpecificParameters(array $specificParameters): self
    {
        $this->specificParameters = $specificParameters;
        return $this;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug(bool $debug): self
    {
        $this->debug = $debug;
        return $this;
    }
}
