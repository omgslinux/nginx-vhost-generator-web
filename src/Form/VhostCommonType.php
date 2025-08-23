<?php
// src/Form/VhostCommonType.php
namespace App\Form;

use App\Form\Dto\VhostCommonDto;
use App\Entity\Vhost;
use App\Entity\VhostType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VhostCommonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('documentRoot', TextType::class, [
                'required' => true,
            ])
            ->add('serverName', TextType::class)
            ->add('useHttp', CheckboxType::class, [
                'required' => false,
                'label' => 'Use HTTP',
            ])
            ->add('httpPort', IntegerType::class, [
                'required' => false,
                'label' => 'Port:',
            ])
            ->add('useHttpRedirect', CheckboxType::class, [
                'required' => false,
                'label' => 'HTTPS Redirect',
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'checkHttpRedirect',
                ]
            ])
            ->add('useHttps', CheckboxType::class, [
                'required' => false,
                'label' => 'Use HTTPS',
            ])
            ->add('httpsPort', IntegerType::class, [
                'required' => false,
                'label' => 'Port:',
            ])
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
            ->add('sslVerifyClient', ChoiceType::class, [
                'choices' => [
                    'On' => 'on',
                    'Off' => 'off',
                    'Optional' => 'optional',
                    'Optional no CA' => 'optional_no_ca'
                ],
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'checkVerifyClient',
                ]
            ])
            ->add('sslClientCertificate', TextType::class, [
                'required' => false,
            ])
            ->add('sslClientFastcgi', CheckboxType::class, [
                'required' => false,
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
            ->add('useStaticFiles', CheckboxType::class, [
                'required' => false,
            ])
            ->add('extraBlock', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'cols' => 80,
                    'rows' => 30,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => VhostCommonDto::class,
        ]);
    }
}
