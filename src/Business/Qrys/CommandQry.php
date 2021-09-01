<?php


namespace AlirezaH\LaravelDevTools\Business\Qrys;


use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

class CommandQry extends Qry
{
    public function getCommands(): array
    {
        $commands = [];
        /** @var Command $command */
        foreach (Artisan::all() as $command) {
            $commands[str_replace(':', '-', $command->getName())] = [
                'name' => $command->getName(),
                'synopsis' => $command->getSynopsis(),
                'description' => $command->getDescription(),
                'args' => $this->getArgs($command),
                'options' => $this->getOptions($command)
            ];
        }

        return $commands;
    }

    public function run(string $command)
    {
        $this->assert403(!$this->isProduction());

        ob_start();
        Artisan::call(addslashes($command));
        echo Artisan::output();
        return ob_get_clean();
    }

    private function getArgs(Command $command): array
    {
        $args = [];

        foreach ($command->getDefinition()->getArguments() as $arg) {
            $args[$arg->getName()] = [
                'description' => $arg->getDescription(),
                'default' => $arg->getDefault(),
                'isRequired' => $arg->isRequired(),
                'isArray' => $arg->isArray()
            ];
        }

        return $args;
    }

    private function getOptions(Command $command): array
    {
        $options = [];

        foreach ($command->getDefinition()->getOptions() as $option) {
            $options[$option->getName()] = [
                'description' => $option->getDescription(),
                'shortcut' => $option->getShortcut(),
                'default' => $option->getDefault()
            ];
        }

        return $options;
    }
}
