<?php
namespace Commands;
use Interfaces\Command;
use MainCli;

class MigrationCreate extends  MigrationBase implements Command
{
    private function checkMigrationDir(){
        if(!file_exists(self::$migrationDir)){
            mkdir(self::$migrationDir);
        }
    }

    public function __construct(public MainCli $cli, public array $args = []){
        parent::__construct();
    }

    private function cleanMigrationName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9_\-]/', '_', $name);
    }

    private function createMigration(){
        $name = time() . '_' . $this->cleanMigrationName($this->args[0]);
        file_put_contents(self::$migrationDir . '/' . $name . '.sql', '');
        $this->cli->info("File $name was created");
    }

    public function run(){
        $this->checkMigrationDir();
        $this->createMigration();
    }
}