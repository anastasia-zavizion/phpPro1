<?php
namespace Commands;
use Dotenv\Dotenv;

abstract class MigrationBase
{
    protected static $migrationDir;
    protected static $migrationsTable;

    public function __construct()
    {
        loadEnv();

        if (self::$migrationDir === null) {
            $folderName = getenv('MIGRATION_FOLDER');
            self::$migrationDir = BASE_DIR . '/' . $folderName;
            self::$migrationsTable = $folderName;
        }
    }

    protected function tableExist($name){
        $sql = "SELECT 1 FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = :tableName";
        $stmt = db()->prepare($sql);
        $stmt->execute([':tableName' => $name]);
        return $stmt->rowCount() > 0;
    }
}