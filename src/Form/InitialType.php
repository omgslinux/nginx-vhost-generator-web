<?php

namespace App\Form;

use App\Entity\Initial;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitialType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sslMode', ChoiceType::class, [
                'choices' => [
                    'Let\'s Encrypt' => 'letsencrypt',
                    'Custom certificate' => 'custom',
                ],
                //'expanded' => true,
                //'multiple' => false,
                //'label_attr' => ['class' => 'd-block mb-3'],
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'checkSslMode',
                ]
            ])
            ->add('httpPort', null, [
                'required' => true,
            ])
            ->add('httpsPort', null, [
            ])
            ->add('domainSuffix', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Ej: domain.org'],
            ])
            ->add('logDirFormat', ChoiceType::class, [
                'choices' => [
                    'name.suffix' => 'server.suffix',
                    'suffix/name' => 'suffix/server',
                ],
            ])
            ->add('sslCertificate', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Ej: /etc/nginx/ssl/cert.pem'],
            ])
            ->add('sslCertificateKey', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Ej: /etc/nginx/ssl/key.pem'],
            ])
            ->add('wellKnownDir', TextType::class, [
                'required' => false,
                'attr' => ['placeholder' => 'Ej: /var/www/_letsencrypt/.well-known'],
            ])
            ->add('clientMaxBodySize', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 512M'],
            ])
            ->add('clientBodyTimeout', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 300s'],
            ])
            ->add('fastcgiBuffers', TextType::class, [
                'required' => true,
                'attr' => ['placeholder' => 'Ej: 64 4K'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Initial::class,
        ]);
    }
}
