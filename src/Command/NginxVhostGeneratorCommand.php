<?php

namespace App\Command;

use App\Entity\Vhost;
use App\Repository\VhostRepository;
use App\Service\VhostConfigGenerator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:nginx:generate-vhosts',
    description: 'Genera la configuración de Nginx para los Vhosts.'
)]
class NginxVhostGeneratorCommand extends Command
{
    private VhostRepository $vhostRepository;
    private VhostConfigGenerator $configGenerator;
    private Filesystem $filesystem;
    private string $projectDir;

    public function __construct(VhostRepository $vhostRepository, VhostConfigGenerator $configGenerator, KernelInterface $kernel)
    {
        parent::__construct();
        $this->vhostRepository = $vhostRepository;
        $this->configGenerator = $configGenerator;
        $this->filesystem = new Filesystem();
        $this->projectDir = $kernel->getProjectDir();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::OPTIONAL, 'Nombre del vhost a generar. Si no se especifica, se generarán todos.')
            ->addOption('dry-run', null, InputOption::VALUE_NONE, 'Simula la ejecución sin hacer cambios.')
            ->addOption('base-dir', null, InputOption::VALUE_OPTIONAL, 'Directorio base para generar los archivos.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $isDryRun = $input->getOption('dry-run');

        $privileged = is_writable('/etc/nginx/sites-available');
        $baseDir = $input->getOption('base-dir');
        $logDirBase = '/var/log/nginx';

        if (null === $baseDir) {
            if ($privileged) {
                $baseDir = '/etc/nginx';
            } else {
                $baseDir = 'var/nginx-test';
                $logDirBase = $baseDir . '/var/log/nginx';
                $io->comment('No se tienen permisos de escritura en /etc/nginx/sites-available. Usando "' . $baseDir . '" para pruebas.');
            }
        }

        if ($name) {
            $vhost = $this->vhostRepository->findOneBy(['name' => $name]);
            if (!$vhost) {
                $io->error('Vhost con el nombre "' . $name . '" no encontrado.');
                return Command::FAILURE;
            }
            $vhosts = [$vhost];
        } else {
            $vhosts = $this->vhostRepository->findAll();
        }

        $io->title('Generador de Nginx Vhosts');

        foreach ($vhosts as $vhost) {
            $io->section('Procesando Vhost: ' . $vhost->getName());

            if ($vhostType = $vhost->getVhostType()) {
                foreach ($vhostType->getCopy() as $copy) {
                    $sourcePath = $this->projectDir . '/templates/copy/' . $copy;
                    $destinationPath = $baseDir . '/' . $copy;

                    if (!$this->filesystem->exists($sourcePath)) {
                        $io->warning('Archivo de copia no encontrado: ' . $sourcePath);
                        continue;
                    }

                    if ($this->filesystem->exists($destinationPath)) {
                        $io->text('   Archivo de copia ya existe, se omite: ' . $destinationPath);
                        continue;
                    }

                    if ($isDryRun) {
                        $io->text('   (Dry Run) Copia de archivo: ' . $sourcePath . ' a ' . $destinationPath);
                        continue;
                    }

                    if (!$this->filesystem->exists(dirname($destinationPath))) {
                        $this->filesystem->mkdir(dirname($destinationPath));
                    }
                    $this->filesystem->copy($sourcePath, $destinationPath, true);
                    $io->text('   Copia de archivo creada en: ' . $destinationPath);
                }
            }

            $dto = $this->vhostRepository->createDtoFromVhost($vhost);
            $configString = $this->configGenerator->generateConfig($dto);

            $logDirFormat = $dto->getCommonParameters()->getLogDirFormat();
            $serverName = $dto->getCommonParameters()->getServerName();
            $domainSuffix = $dto->getCommonParameters()->getDomainSuffix();

            $logPath = $logDirBase . '/' . str_replace(['server', 'suffix'], [$serverName, $domainSuffix], $logDirFormat);

            $sitesAvailablePath = $baseDir . '/sites-available/' . $vhost->getName();
            $sitesEnabledPath = $baseDir . '/sites-enabled/' . $vhost->getName();
            $symlinkTarget = '../sites-available/' . $vhost->getName();

            if ($isDryRun) {
                $io->text('   (Dry Run) Configuración generada.');
                $io->listing([
                    'Fichero de configuración: ' . $sitesAvailablePath,
                    'Directorio de logs: ' . $logPath,
                    'Enlace simbólico apunta a: ' . $symlinkTarget,
                ]);
                continue;
            }

            if (!$this->filesystem->exists($logPath)) {
                $this->filesystem->mkdir($logPath);
                $io->text('   Directorio de logs creado: ' . $logPath);
            }

            $this->filesystem->dumpFile($sitesAvailablePath, $configString);
            $io->text('   Fichero de configuración creado: ' . $sitesAvailablePath);

            $this->filesystem->symlink($symlinkTarget, $sitesEnabledPath);
            $io->text('   Enlace simbólico creado en: ' . $sitesEnabledPath);
        }

        if (!$privileged) {
            $io->comment('No se puede verificar la configuración de Nginx sin permisos de root.');
            return Command::SUCCESS;
        }

        $io->section('Verificando la configuración de Nginx');
        $process = new Process(['nginx', '-t']);
        $process->run();

        if (!$process->isSuccessful()) {
            $io->error('Error en la configuración de Nginx.');
            $io->error($process->getErrorOutput());
            return Command::FAILURE;
        }

        $io->success('Configuración de Nginx válida.');
        $io->note('Recuerda recargar Nginx: sudo systemctl reload nginx');

        return Command::SUCCESS;
    }
}
