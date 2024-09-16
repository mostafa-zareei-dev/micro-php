<?php

namespace App\Kernel\Infrastructures\Database\Connections;

use App\Kernel\Infrastructures\Database\IDatabaseConnection;
use PDO;
use RuntimeException;

class PDOConnection implements IDatabaseConnection
{
    private PDO $connection;
    private string $dsn = '';

    public function connect(array $configs): void
    {
        $this->connection = $this->connectToDB($configs);
    }

    public function getConnection(): mixed
    {
        return $this->connection;
    }

    private function connectToDB(array $configs)
    {
        $params = [
            'host' => $configs['host'],
            'port' => $configs['port'],
            'dbname' => $configs['db_name'],
            'charset' => $configs['charset'],
            'user' => $configs['user'],
            'password' => $configs['password'],
        ];

        $driver = configs("database.driver");
        $this->dsn($driver, $params);

        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];

        try {
            return new PDO(
                $this->dsn,
                null,
                null,
                $options
            );
        } catch (\PDOException $e) {
            throw new RuntimeException("Database connection failed: " . $e->getMessage());
        }
    }

    private function dsn(string $driver, array $params): void
    {
        $params = http_build_query($params, "", ";");
        $dsnConfigs = [$driver, $params];
        $this->dsn = implode(":", $dsnConfigs);
    }
}
