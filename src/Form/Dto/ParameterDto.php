<?php

namespace App\Form\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ParameterDto implements \JsonSerializable
{
    #[Assert\NotBlank]
    private ?string $name = null;

    private ?string $description = null;

    private ?string $dataType = null;

    private mixed $defaultValue = null;

    public function __construct(
        string $name = null,
        string $description = null,
        string $dataType = null,
        mixed $defaultValue = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->dataType = $dataType;
        $this->defaultValue = $defaultValue;
    }

    public function load(array $data = []): void
    {
        $fileData = [];
        if (file_exists(self::FILE_PATH)) {
            $fileContent = file_get_contents(self::FILE_PATH);
            if ($fileContent !== false) {
                $fileData = json_decode($fileContent, true) ?? [];
            }
        }

        $mergedData = array_merge($fileData, $data);

        foreach ($mergedData as $key => $value) {
            $setter = 'set' . ucfirst($key);
            if (method_exists($this, $setter)) {
                $this->$setter($value);
            }
        }
    }

    // 🔹 Conversión automática para Doctrine/JSON
    public function jsonSerialize(): mixed
    {
        return [
            'name'         => $this->name,
            'description'  => $this->description,
            'dataType'     => $this->dataType,
            'defaultValue' => $this->defaultValue,
        ];
    }

    // 🔹 Método opcional para hidratar desde array
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'] ?? null,
            $data['description'] ?? null,
            $data['dataType'] ?? null,
            $data['defaultValue'] ?? null
        );
    }

    public function toFormType(FormBuilderInterface $builder)
    {
        return $builder->add(
            $this->name,
            $this->dataType=='text' ? TextType::class : CheckboxType::class,
            [
                'label' => $this->name,
                'data' => $this->defaultValue,
                'attr' => [
                    'placeholder' => $this->description,
                ]
            ]
        );
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getDataType(): ?string
    {
        return $this->dataType;
    }

    public function setDataType(?string $dataType): void
    {
        $this->dataType = $dataType;
    }

    public function getDefaultValue(): mixed
    {
        return $this->defaultValue;
    }

    public function setDefaultValue(mixed $defaultValue): void
    {
        $this->defaultValue = $defaultValue;
    }
}
