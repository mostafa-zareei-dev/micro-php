<?php

namespace App\Kernel\Commands;

use App\Kernel\Core\App;
use App\Kernel\Migrations\MigrationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'migration:rollback')]
class RollbackMigrationCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('Create migration file...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Rollback last migration',
            '============',
        ]);

        $migrationService = App::resolve(MigrationService::class);

        $migrationService->rollback();

        $output->writeln([
            'Rollback last migration successfully',
            '============',
        ]);


        return Command::SUCCESS;
    }
}
