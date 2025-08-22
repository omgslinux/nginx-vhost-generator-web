<?php
// src/Service/VhostConfigGenerator.php

namespace App\Service;

use App\Form\Dto\VhostGeneratorDto;
use Twig\Environment;

class VhostConfigGenerator
{
    public function __construct(private Environment $twig)
    {
    }

    public function generateConfig(VhostGeneratorDto $dto): ?string
    {
        $vhostType = $dto->getVhostType();

        if (null === $vhostType) {
            return null;
        }
        //dump($dto); //Para ver si vienen los parametros especificos

        return $this->twig->render('master_template.twig', [
            'dto' => $dto,
            'common' => $dto->getCommonParameters()->jsonSerialize()
        ]);
    }
}
