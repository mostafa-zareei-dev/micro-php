<?php

namespace App\Kernel\ServiceProviders;

use App\Kernel\Container\ServiceContainer;
use App\Kernel\Infrastructures\Database\Connections\PDOConnection;
use App\Kernel\Infrastructures\Database\IDatabaseConnection;
use App\Kernel\Infrastructures\Database\IDatabaseProvider;
use App\Kernel\Infrastructures\Database\Providers\PDOProvider;
use App\Kernel\Migrations\MigrationService;
use App\Kernel\Migrations\SchemaManager;

class DatabaseServiceProvider implements IServiceProvider
{
    public function register(ServiceContainer $container): void
    {
        $container->singleton(IDatabaseConnection::class, PDOConnection::class);
        $container->bind(IDatabaseProvider::class, PDOProvider::class);
        $container->singleton(SchemaManager::class, SchemaManager::class);
        $container->bind(MigrationService::class, MigrationService::class);
    }

    public function boot(ServiceContainer $container): void
    {
        $dbConfigs = configs("database.configs");
        $dbConnection = $container->resolve(IDatabaseConnection::class);

        $dbConnection->connect($dbConfigs);

        $migrationService = $container->resolve(MigrationService::class);
        $migrationService->createMigrationTable();
    }
}
