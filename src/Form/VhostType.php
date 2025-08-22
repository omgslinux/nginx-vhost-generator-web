<?php

namespace App\Form;

use App\Entity\Vhost;
use App\Entity\VhostType as VType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'label' => 'Nombre descriptivo',
            ])
            ->add('vhostType', EntityType::class, [
                'class' => VType::class,
                'choice_label' => 'name',  // Ajusta según el campo para mostrar
                'placeholder' => 'Choose vhost type',
                'required' => false,
                'label' => 'Type of vhost',
            ])
            /*->add('common', VhostCommonType::class, [
                'data' => $options['common'],
                'mapped' => false,
            ])*/
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Vhost::class,
            'common' => null,
            'defaults' => null,
        ]);
    }
}
