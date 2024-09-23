<?php

namespace App\Kernel\Commands;

use App\Kernel\Core\App;
use App\Kernel\Migrations\MigrationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'migration:migrate')]
class RunMigrateCommand extends Command
{
    protected function configure()
    {
        $this->setDescription('run migrations...');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Run migrations',
            '============',
        ]);

        $migrationService = App::resolve(MigrationService::class);

        $migrationService->migrate();

        $output->writeln([
            '============',
            'Run migrations successfully.',
        ]);

        return Command::SUCCESS;
    }
}
