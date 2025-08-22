<?php

namespace App\Repository;

use App\Entity\Initial;
use App\Entity\Vhost;
use App\Entity\VhostType;
use App\Form\Dto\VhostGeneratorDto;
use App\Form\Dto\VhostCommonDto;
use App\Form\Dto\DefaultParameterDto;
use App\Form\Dto\ParameterDto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class VhostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vhost::class);
    }

    public function createDtoFromVhost(?Vhost $vhost, int $vhostTypeId = null, Initial $initial = null): VhostGeneratorDto
    {
        //list( $vhost, $vhostTypeId, $initial) = $data;
        //$vhostTypeId = $formValues['vhostType'] ?? null;
        $vhostType = null;
        if (null!=$vhostTypeId) {
            $vhostType = $this->getEntityManager()->getRepository(VhostType::class)->find($vhostTypeId);
        }
        $dto = new VhostGeneratorDto();
        // Actualizamos el vhostType del dto
        $dto->setVhostType($vhostType);
        if (null == $vhost->getId()) {
            // Inicializar con valores por defecto
            //$defaultParameters = new DefaultParameterDto();
            //$defaultParameters->load($initial);
            //$dto->setDefaultParameters($defaultParameters);
            $commonDto = new VhostCommonDto();
            $commonDto->loadDefaults($initial);
            $dto->setCommonParameters($commonDto);

            // 💡 Lógica añadida: Inicializar los parámetros específicos si se ha seleccionado un VhostType
            if (null !== $vhostType) {
                $specificParams = [];
                foreach ($vhostType->getParameters() as $param) {
                    $specificParams[$param->getName()] = $param->getDefaultValue();
                }
                $dto->setSpecificParameters($specificParams);
            }
        } else {
            $dto->setId($vhost->getId());
            $dto->setName($vhost->getName());
            $dto->setVhostType($vhost->getVhostType());

            $parameters = $vhost->getParameters();
            $dto->setCommonParameters(new VhostCommonDto($parameters['common'] ?? []));
            //$dto->setDefaultParameters(new DefaultParameterDto($parameters['default'] ?? []));
            // Mapeo de parámetros específicos
            $specificParameters = $parameters['specific'] ?? [];
            $dto->setSpecificParameters($specificParameters);
        }

        return $dto;
    }

    public function submitForm(VhostGeneratorDto $dto, ?Vhost $vhost = null): void
    {
        if (null === $vhost) {
            $vhost = new Vhost();
        }

        $vhost->setName($dto->getName());
        $vhost->setVhostType($dto->getVhostType());

        $parameters = [
            'common' => $dto->getCommonParameters()->jsonSerialize(),
            //'default' => $dto->getDefaultParameters()->jsonSerialize(),
            'specific' => $dto->getSpecificParameters(),
        ];

        $vhost->setParameters($parameters);

        $this->getEntityManager()->persist($vhost);
        $this->getEntityManager()->flush();
    }
}
