<?php

namespace App\Form;

use App\Form\Dto\DefaultParameterDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DefaultParameterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('wellKnownDir', TextType::class, [
                'label' => 'Directorio .well-known',
                'required' => false,
                'attr' => ['placeholder' => 'Ej: /var/www/_letsencrypt/.well-known'],
            ])
            ->add('clientMaxBodySize', TextType::class, [
                'label' => 'Tamaño máximo del cuerpo de la petición',
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 512M'],
            ])
            ->add('clientBodyTimeout', TextType::class, [
                'label' => 'Tiempo de espera del cuerpo de la petición',
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 300s'],
            ])
            ->add('fastcgiBuffers', TextType::class, [
                'label' => 'Buffers de FastCGI',
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 64 4K'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => DefaultParameterDto::class,
        ]);
    }
}
