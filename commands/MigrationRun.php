<?php
namespace Commands;
use Interfaces\Command;
use MainCli;
use PDO;
use Exception;

class MigrationRun extends MigrationBase implements Command
{
    public function __construct(public MainCli $cli, public array $args = [])
    {
        parent::__construct();
    }



    private function createMigrationTable(): void
    {
        if (!$this->tableExist(self::$migrationsTable)) {
            $query = db()->prepare("
            CREATE TABLE IF NOT EXISTS migrations (
                id INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL UNIQUE
            )
        ");
            if (!$query->execute()) {
                throw new Exception("Migrations table query error");
            } else {
                $query->closeCursor();
                $this->cli->success("Created migrations table");
            }
        }
    }

    private function handledMigrations(): array
    {
        $query = db()->prepare("SELECT name FROM migrations");
        $query->execute();
        $handledMigrations = $query->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($item) => $item['name'], $handledMigrations);
    }

    private function runMigrations(): void
    {
        $this->cli->info("Running migrations...");

        $migrations = $this->getMigrationFiles();
        $handledMigrations = $this->handledMigrations();
        foreach ($migrations as $migration) {
            if (!in_array($migration, $handledMigrations)) {
                $this->executeMigration($migration);
            }
        }
        $this->cli->info("Migrations process done");
    }

    private function getMigrationFiles(): array
    {
        $files = scandir(self::$migrationDir);
        return array_values(array_diff($files, ['.', '..']));
    }

    private function executeMigration(string $migration): void
    {
        $sql = file_get_contents(self::$migrationDir . "/$migration");
        $query = db()->prepare($sql);
        if ($query->execute()) {
            $this->cli->success("$migration migrated");
            if ($this->createMigrationRecord($migration)) {
                $this->cli->success("$migration was saved in the database");
            } else {
                $this->cli->warning("$migration was not saved in the database!");
            }
        } else {
            throw new Exception("Error executing migration: $migration");
        }
    }

    private function createMigrationRecord(string $name): bool
    {
        $query = db()->prepare("INSERT INTO migrations (name) VALUES (:name)");
        $query->bindParam(':name', $name);
        if ($query->execute()) {
            $query->closeCursor();
            return true;
        }
        return false;
    }

    public function run()
    {
        try {
            db()->beginTransaction();
            $this->cli->info("Starting migrations");
            $this->createMigrationTable();
            $this->runMigrations();
            if(db()->inTransaction()){
                db()->commit();
            }
            $this->cli->info("Finished migrations");
        } catch (Exception $exception) {
            if (db()->inTransaction()) {
                db()->rollback();
            }
            $this->cli->fatal("Migration failed: " . $exception->getMessage());
        }
    }
}