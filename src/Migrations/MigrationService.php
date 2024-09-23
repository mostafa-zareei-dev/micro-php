<?php

namespace App\Kernel\Migrations;

use App\Kernel\Infrastructures\Database\IDatabaseProvider;

class MigrationService
{
    protected string $migrationRootDirectory = ROOT_PATH . "database" . DIRECTORY_SEPARATOR . "migrations" . DIRECTORY_SEPARATOR;
    protected string $tableName = "migrations";
    protected IDatabaseProvider $dbProvider;

    public function __construct(IDatabaseProvider $dbProvider)
    {
        $this->dbProvider = $dbProvider;
    }

    public  function migrate()
    {
        $fileNames = $this->getMigrationFileNames();

        foreach ($fileNames as $fileName) {
            $migration = require_once $this->migrationRootDirectory . $fileName;

            $fileName = pathinfo($fileName, PATHINFO_FILENAME);
            if (!$this->migrationExist($fileName)) {
                $migration->up();
                $this->saveMigration($fileName);
            }
        }
    }

    public  function rollback()
    {
        $lastMigrationFileName = $this->getLastMigrationFileName();
        
        $migrationFilePath = $this->migrationRootDirectory . $lastMigrationFileName . ".php";
        
        if (!file_exists($migrationFilePath)) {
            throw new \InvalidArgumentException("$lastMigrationFileName not exist in $migrationFilePath");
        }

        $migration = require_once $migrationFilePath;
        $migration->down();
        $this->removeMigration($lastMigrationFileName);
    }

    public  function createMigrationTable()
    {
        $tableName = $this->tableName;
        $query = "CREATE TABLE IF NOT EXISTS $tableName (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration_name VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        $this->dbProvider->query($query, []);
    }

    private function getLastMigrationFileName(): string
    {
        $nestedQuery = "(SELECT max(id) FROM {$this->tableName})";
        $migration = $this->dbProvider->table($this->tableName)->find(["*"], [], "id=$nestedQuery");

        return !empty($migration) ? $migration['migration_name'] : "";
    }

    private  function migrationExist(string $migrationFileName): bool
    {
        $migration = $this->dbProvider->table($this->tableName)->find(["*"], [
            'migration_name' => $migrationFileName
        ], "migration_name=:migration_name");

        return !empty($migration);
    }

    private  function saveMigration(string $migrationFileName): void
    {
        $this->dbProvider->table($this->tableName)->save([
            "migration_name" => $migrationFileName
        ]);
    }

    private  function removeMigration(string $migrationFileName): void
    {
        $this->dbProvider->table($this->tableName)->delete([
            'migration_name' => $migrationFileName
        ], "migration_name=:migration_name");
    }

    private  function getMigrationFileNames(): array
    {
        $fileNames = array_diff(scandir($this->migrationRootDirectory), array('.', '..'));
        return array_values($fileNames);
    }
}
