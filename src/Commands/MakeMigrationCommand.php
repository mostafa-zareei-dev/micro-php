<?php

namespace App\Kernel\Commands;

use App\Kernel\Infrastructures\Database\Schema\Blueprint;
use App\Kernel\Migrations\Migration;
use App\Kernel\Migrations\Schema;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'make:migration')]
class MakeMigrationCommand extends Command
{
    private string $rootPath = ROOT_PATH . "database" . DIRECTORY_SEPARATOR . "migrations" . DIRECTORY_SEPARATOR;

    protected function configure()
    {
        $this
            ->setDescription('Create migration file...')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the migration')
            ->addOption("table", null, InputOption::VALUE_REQUIRED,  'table name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln("Create migration file...");

        $name = $input->getArgument('name');
        $tableName = $input->getOption('table');

        if (!$tableName) {
            $output->writeln('<error>Invalid option! table option not provided!</error>');
            $output->writeln('<comment>Set table options for table name.(example: --table=table-name)</comment>');
            return Command::FAILURE;
        }

        $filePath = $this->rootPath . $this->generateFileName($name);

        file_put_contents($filePath, $this->getFileContent($tableName));

        $output->writeln("Create migration file successfully in:");
        $output->writeln($filePath);

        return Command::SUCCESS;
    }

    private function generateFileName(string $name): string
    {
        $date = date('Y_m_d_His') . "_";
        $formattedName = strtolower(trim(preg_replace('/[^A-Za-z0-9]+/', '_', $name)));
        return $date . $formattedName . ".php";
    }

    private function getFileContent(string $tableName = 'table-name'): string
    {
        $blueprintClassName = Blueprint::class;
        $migrationClassName = Migration::class;
        $schemaClassName = Schema::class;
        return <<<EOD
<?php

use $blueprintClassName;
use $migrationClassName;
use $schemaClassName;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('{$tableName}', function(Blueprint \$table) {
            \$table->id();
            \$table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::drop('{$tableName}'); 
    }
};
EOD;
    }
}
