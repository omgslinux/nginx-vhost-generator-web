<?php

namespace App\DataFixtures;

use App\Entity\VhostType;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class VhostTypeFixtures extends Fixture
{
    private string $projectDir;

    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    public function load(ObjectManager $manager): void
    {
        $vhostTypeDataPath = $this->projectDir . '/config/data/VhostTypeData.php';
        $templatesDir = $this->projectDir . '/templates/vhost_templates';

        if (!file_exists($vhostTypeDataPath)) {
            // Este mensaje informa si el archivo generado no existe, lo que significa
            // que el comando app:vhosttype:dump no se ha ejecutado.
            throw new \RuntimeException('The VhostType fixture data file does not exist. ' .
                 'Please run the app:vhosttype:dump command first.');
        }

        $vhostTypeData = require $vhostTypeDataPath;

        foreach ($vhostTypeData as $name => $data) {
            $templateFile = $name . '_template.twig';
            $templatePath = $templatesDir . '/' . $templateFile;

            // Cargar el contenido de la plantilla del archivo
            $templateContent = 'Missing template file: ' . $templateFile;
            if (file_exists($templatePath)) {
                $templateContent = file_get_contents($templatePath);
            }

            // Instancia de la entidad VhostType
            $vhostType = new VhostType();
            $vhostType->setName($name)
            ->setDescription($data['description'])
            ->setCopy($data['copy'])
            ->setTemplate($templateContent)
            ->setParameters($data['parameters']);

            $manager->persist($vhostType);
        }

        $manager->flush();
    }
}
