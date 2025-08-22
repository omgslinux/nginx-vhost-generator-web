<?php

namespace App\Form;

use App\Entity\VhostType as VhostTypeEntity;
use App\Form\Dto\VhostGeneratorDto;
use App\Repository\VhostTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhostGeneratorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('debug', CheckboxType::class, [
                'label' => 'Depuración',
                'required' => false,
            ])
            ->add('name', TextType::class, [
                'label' => 'Nombre de la configuración',
            ])
            ->add('vhostType', EntityType::class, [
                'class' => VhostTypeEntity::class,
                'choice_label' => 'name',
                'placeholder' => 'Selecciona un tipo de Vhost',
                'label' => 'Tipo de Vhost a generar',
                'attr' => [
                    'data-action'=> 'change->live#action',
                    'data-live-action-param'=> 'updateSpecific',
                ]
            ])
            ->add('commonParameters', VhostCommonType::class, [
                'label' => 'Parámetros comunes'
            ])
            /*
            ->add('defaultParameters', DefaultParameterType::class, [
                'label' => 'Parámetros por defecto'
            ])*/
            ;

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            /** @var VhostGeneratorDto $data */
            $data = $event->getData();
            $form = $event->getForm();

            if (!$data || !$data->getVhostType()) {
                return;
            }

            $formFactory = $form->getConfig()->getFormFactory();
            $allParameters = $data->getVhostType()->getParameters();
            $specificParametersData = $data->getSpecificParameters();

            if (count($allParameters) > 0) {
                $specificFormBuilder = $formFactory->createNamedBuilder(
                    'specificParameters',
                    FormType::class,
                    null,
                    [
                        'label' => 'Parámetros específicos',
                        'auto_initialize' => false,
                        'by_reference' => false,
                    ]
                );

                foreach ($allParameters as $parameter) {
                    $formType = ($parameter->getDataType() === 'text') ? TextType::class : CheckboxType::class;

                    $value = $specificParametersData[$parameter->getName()] ?? $parameter->getDefaultValue();

                    $options = [
                        'label' => $parameter->getName(),
                        'required' => false,
                        'attr' => [
                            'placeholder' => $parameter->getDescription(),
                        ],
                    ];

                    if ($parameter->getDataType() === 'text') {
                        $options['empty_data'] = $value;
                    } else {
                        $options['data'] = (bool) $value;
                    }

                    $specificFormBuilder->add($parameter->getName(), $formType, $options);
                }
                $form->add($specificFormBuilder->getForm());
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VhostGeneratorDto::class,
        ]);
    }
}
