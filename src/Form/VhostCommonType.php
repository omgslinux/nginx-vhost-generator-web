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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('documentRoot', TextType::class, [
                'required' => true,
                'label' => 'Document Root',
            ])
            ->add('serverName', TextType::class)
            ->add('useHttp', CheckboxType::class, [
                'required' => false,
                'label' => 'Usar HTTP',
            ])
            ->add('httpPort', IntegerType::class, [
                'required' => false,
                'label' => 'Puerto:',
            ])
            ->add('useHttpRedirect', CheckboxType::class, [
                'required' => false,
                'label' => 'Redirigir a HTTPS',
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'checkHttpRedirect',
                ]
            ])
            ->add('useHttps', CheckboxType::class, [
                'required' => false,
                'label' => 'Usar HTTPS',
            ])
            ->add('httpsPort', IntegerType::class, [
                'required' => false,
                'label' => 'Puerto:',
            ])
            ->add('sslMode', ChoiceType::class, [
                'label' => 'Modo SSL',
                'choices' => [
                    'Let\'s Encrypt' => 'letsencrypt',
                    'Certificado personalizado' => 'custom',
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
                'label' => 'Sufijo de dominio del Vhost',
                'required' => false,
                'attr' => ['placeholder' => 'Ej: domain.org'],
            ])
            ->add('logDirFormat', ChoiceType::class, [
                'label' => 'Formato de la ruta de logs',
                'choices' => [
                    'name.suffix' => 'server.suffix',
                    'suffix/name' => 'suffix/server',
                ],
            ])
            ->add('sslCertificate', TextType::class, [
                'label' => 'Ruta al certificado SSL',
                'required' => false,
                'attr' => ['placeholder' => 'Ej: /etc/nginx/ssl/cert.pem'],
            ])
            ->add('sslCertificateKey', TextType::class, [
                'label' => 'Ruta a la clave del certificado SSL',
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
                'label' => 'Verificar ssl cliente',
                'attr' => [
                    'data-action' => 'live#action',
                    'data-live-action-param' => 'checkVerifyClient',
                ]
            ])
            ->add('sslClientCertificate', TextType::class, [
                'required' => false,
                'label' => 'Ruta al certificado CA',
            ])
            ->add('sslClientFastcgi', CheckboxType::class, [
                'required' => false,
                'label' => 'Usar fastcgi',
            ])
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
            ->add('useStaticFiles', CheckboxType::class, [
                'required' => false,
                'label' => 'Use static files',
            ])
            ->add('extraBlock', TextareaType::class, [
                'label' => 'Extra block',
                'required' => false,
                'attr' => [
                    'cols' => 80,
                    'rows' => 30,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => VhostCommonDto::class,
        ]);
    }
}
