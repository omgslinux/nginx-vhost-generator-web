<?php

namespace App\Command;

use App\Entity\VhostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\KernelInterface;

#[AsCommand(
    name: 'app:vhosttype:dump',
    description: 'Dumps VhostType entities from the database to a PHP fixture array.'
)]
class VhostTypeDumpCommand extends Command
{
    private EntityManagerInterface $entityManager;
    private string $projectDir;

    public function __construct(EntityManagerInterface $entityManager, KernelInterface $kernel)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->projectDir = $kernel->getProjectDir();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Dumping VhostType Data');

        $vhostTypeRepository = $this->entityManager->getRepository(VhostType::class);
        $vhostTypes = $vhostTypeRepository->findAll();

        if (empty($vhostTypes)) {
            $io->warning('No VhostType entities found in the database. Nothing to dump.');
            return Command::SUCCESS;
        }

        $vhostTypeMap = [];
        foreach ($vhostTypes as $vhostType) {
            $parameters = [];
            // Convert each DTO object into a simple associative array
            foreach ($vhostType->getParameters() as $parameterDto) {
                $parameters[] = [
                    'name' => $parameterDto->getName(),
                    'description' => $parameterDto->getDescription(),
                    'dataType' => $parameterDto->getDataType(),
                    'defaultValue' => $parameterDto->getDefaultValue(),
                ];
            }

            $vhostTypeMap[$vhostType->getName()] = [
                'parameters' => $parameters,
                'description' => $vhostType->getDescription(),
                'copy' => $vhostType->getCopy(),
            ];
        }

        $outputContent = "<?php\n\nreturn " . var_export($vhostTypeMap, true) . ";\n";
        $filePath = $this->projectDir . '/src/DataFixtures/VhostTypeData.php';

        file_put_contents($filePath, $outputContent);

        $io->success(sprintf('VhostType data has been successfully dumped to %s', $filePath));
        $io->note('Commit this file to your repository to share the fixture data.');

        return Command::SUCCESS;
    }
}
