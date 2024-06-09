<?php
const BASE_DIR = __DIR__;

require BASE_DIR . '/vendor/autoload.php';
use splitbrain\phpcli\CLI;
use splitbrain\phpcli\Options;
use Commands\MigrationCreate;
use Commands\MigrationRun;
use Interfaces\Command;

class MainCli extends CLI
{
    protected function setup(Options $options)
    {
        $options->registerCommand('migration:create', 'Create migration file');
        $options->registerCommand('migration:run', 'Run migrations files');
        $options->registerArgument('name', 'Migration file name',true, 'migration:create');
    }

    protected function main(Options $options)
    {
        $command = match ($options->getCmd()){
          'migration:create'=>new MigrationCreate($this, $options->getArgs()),
          'migration:run'=>new MigrationRun($this, $options->getArgs()),
          default=>null
        };
        if($command && $command instanceof Command){
            call_user_func([$command, 'run']);
        }else{
            $this->fatal('Not command found');
        }
    }
}

// execute it
$cli = new MainCli();
$cli->run();