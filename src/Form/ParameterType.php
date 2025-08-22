<?php

// src/Form/ParameterType.php
namespace App\Form;

use App\Form\Dto\ParameterDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => ['placeholder' => 'Nombre del parámetro']
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['placeholder' => 'Descripción (ej. La ruta del documento raíz)']
            ])
            ->add('dataType', ChoiceType::class, [
                'label' => 'Type',
                'choices' => [
                    'Texto' => 'text',
                    'Booleano' => 'boolean',
                ],
                'attr' => ['placeholder' => 'Tipo de dato']
            ])
            ->add('defaultValue', TextType::class, [
                'label' => 'Default value',
                'required' => false,
                'attr' => ['placeholder' => 'Valor predeterminado']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParameterDto::class,
        ]);
    }
}
