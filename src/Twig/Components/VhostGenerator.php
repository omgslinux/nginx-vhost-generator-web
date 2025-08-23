<?php

namespace App\Twig\Components;

use App\Entity\Initial;
use App\Entity\Vhost;
use App\Form\Dto\DefaultParameterDto;
use App\Form\Dto\VhostCommonDto;
use App\Form\Dto\VhostGeneratorDto;
use App\Form\VhostGeneratorType;
use App\Repository\InitialRepository;
use App\Repository\VhostRepository;
use App\Service\VhostConfigGenerator;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Form\FormInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Twig\Environment;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

#[AsLiveComponent]
final class VhostGenerator extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp(writable: true)]
    public VhostGeneratorDto $vhostGeneratorDto;

    #[LiveProp]
    public ?Vhost $vhost = null;

    private ?Initial $initial = null;

    public function __construct(
        private VhostConfigGenerator $service,
        private VhostRepository $vhostRepository,
        private InitialRepository $IR
    ) {
        $initials=$IR->findAll();
        if (count($initials)) {
            $this->initial = $initials[0];
        } else {
            $this->initial = new Initial();
        }
    }

    public function mount(?Vhost $vhost = null): void
    {
        $this->vhost = $vhost;
        $this->vhostGeneratorDto = $this->vhostRepository->createDtoFromVhost(
            $vhost,
            $this->formValues['vhostType'] ?? null,
            $this->initial,
        );
    }

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(VhostGeneratorType::class, $this->vhostGeneratorDto);
    }

    #[LiveAction]
    public function checkHttpRedirect()
    {
        if ($this->formValues['commonParameters']['useHttpRedirect']) {
            $this->formValues['commonParameters']['useHttps'] = true;
        }
    }

    #[LiveAction]
    public function checkSslMode()
    {
        if ($this->formValues['commonParameters']['sslMode'] == 'letsencrypt') {
            $letsencryptBase = '/etc/letsencrypt/live/' . $this->formValues['commonParameters']['serverName'] . '.' . $this->formValues['commonParameters']['domainSuffix'] . '/';
            $this->formValues['commonParameters']['sslCertificate'] = $letsencryptBase . 'fullchain.pem';
            $this->formValues['commonParameters']['sslCertificateKey'] = $letsencryptBase . 'privkey.pem';
        }
    }

    #[LiveAction]
    public function checkVerifyClient()
    {
        if ($this->formValues['commonParameters']['sslVerifyClient'] == 'off') {
            $this->formValues['commonParameters']['sslClientFastcgi'] = false;
            $this->formValues['commonParameters']['sslClientCertificate'] = null;
        }
    }

    #[LiveAction]
    public function updateSpecific()
    {
        if (!$this->formValues['commonParameters']['serverName']) {
            $this->formValues['commonParameters']['serverName'] = $this->formValues['name'];
        }
        $this->vhostGeneratorDto = $this->vhostRepository->createDtoFromVhost(
            $this->vhost,
            $this->formValues['vhostType'],
            $this->initial,
        );
    }

    public function renderVhostTemplate(): ?string
    {
        $dto = $this->vhostGeneratorDto;

        if (null === $dto
            || null === $dto->getVhostType()
            || ([]==$dto->getSpecificParameters())
        ) {
            return ''; // Retornar una cadena vacía o un mensaje de espera
        }

        return $this->service->generateConfig($dto);
    }

    #[LiveAction]
    public function save()
    {
        // Submit the form! If validation fails, an exception is thrown
        // and the component is automatically re-rendered with the errors
        $this->submitForm();

        $this->dto = $this->getForm()->getData();
        $this->vhostRepository->submitForm($this->dto, $this->vhost);

        $this->addFlash('success', 'Vhost saved!');

        return $this->redirectToRoute('app_vhost_index');
    }
}
