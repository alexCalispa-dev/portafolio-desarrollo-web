<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use RuntimeException;

final class Migrator
{
    public static function install(): void
    {
        self::createDatabase();
        self::up();
    }

    public static function up(): array
    {
        $pdo = Database::connection();
        self::createMigrationsTable($pdo);
        $applied = self::applied($pdo);
        $executed = [];

        foreach (self::files() as $file) {
            $name = basename($file, '.php');
            if (in_array($name, $applied, true)) {
                continue;
            }

            self::runUp($pdo, $file);
            $executed[] = $name;
        }

        return $executed;
    }

    public static function down(): array
    {
        $pdo = Database::connection();
        self::createMigrationsTable($pdo);
        $reverted = [];

        foreach (array_reverse(self::applied($pdo)) as $name) {
            $file = self::migrationPath($name);
            if (!is_file($file)) {
                continue;
            }

            self::runDown($pdo, $file, $name);
            $reverted[] = $name;
        }

        return $reverted;
    }

    public static function status(): array
    {
        $pdo = Database::connection();
        self::createMigrationsTable($pdo);
        $applied = self::applied($pdo);
        $status = [];

        foreach (self::files() as $file) {
            $name = basename($file, '.php');
            $status[] = [
                'name' => $name,
                'applied' => in_array($name, $applied, true),
            ];
        }

        return $status;
    }

    public static function createDatabase(): void
    {
        $config = require dirname(__DIR__, 2) . '/config/database.php';
        $name = (string) $config['name'];
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new RuntimeException('Nombre de base de datos no valido.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;charset=%s',
            $config['host'],
            $config['port'],
            $config['charset']
        );
        $pdo = new PDO($dsn, $config['user'], $config['pass'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$name}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    private static function createMigrationsTable(PDO $pdo): void
    {
        $pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255) NOT NULL UNIQUE,
            executed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
    }

    private static function applied(PDO $pdo): array
    {
        return $pdo->query('SELECT migration FROM migrations ORDER BY migration')->fetchAll(PDO::FETCH_COLUMN);
    }

    private static function files(): array
    {
        $files = glob(dirname(__DIR__, 2) . '/migrations/*.php') ?: [];
        sort($files);

        return $files;
    }

    private static function migrationPath(string $name): string
    {
        if (!preg_match('/^[A-Za-z0-9_]+$/', $name)) {
            throw new RuntimeException('Nombre de migracion no valido.');
        }

        return dirname(__DIR__, 2) . '/migrations/' . $name . '.php';
    }

    private static function runUp(PDO $pdo, string $file): void
    {
        require_once $file;
        $class = self::classFromFile($file);
        $migration = new $class();
        $migration->up($pdo);

        $statement = $pdo->prepare('INSERT INTO migrations (migration) VALUES (?)');
        $statement->execute([basename($file, '.php')]);
    }

    private static function runDown(PDO $pdo, string $file, string $name): void
    {
        require_once $file;
        $class = self::classFromFile($file);
        $migration = new $class();
        $migration->down($pdo);

        $statement = $pdo->prepare('DELETE FROM migrations WHERE migration = ?');
        $statement->execute([$name]);
    }

    private static function classFromFile(string $file): string
    {
        $name = basename($file, '.php');

        return 'Migration' . str_replace(' ', '', ucwords(str_replace('_', ' ', $name)));
    }
}
