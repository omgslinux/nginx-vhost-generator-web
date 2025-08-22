<?php

namespace App\Form;

use App\Entity\VhostType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhostTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add(
                'template',
                TextareaType::class,
                [
                    'attr' => [
                        'cols' => 100,
                        'rows' => 30,
                        'resize' => 'both',
                        'class' => 'font-monospace',
                    ]
                ]
            )
            ->add('copy', ChoiceType::class, [
                'label' => 'Ficheros de configuración a copiar',
                'choices' => $options['copy_choices'],
                'multiple' => true,
                'expanded' => true, // Muestra una lista de checkboxes en lugar de un select
                'required' => false, // El campo es opcional
            ])
            // Aquí está el CollectionType que crea los campos dinámicos
            ->add('parameters', CollectionType::class, [
                'entry_type' => ParameterType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'required' => false,
                'allow_delete' => true,
                'by_reference' => false, // Importante para que el setter funcione
                'label' => 'Parámetros específicos para este tipo de Vhost',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VhostType::class,
            'copy_choices' => [],
        ]);
    }
}
