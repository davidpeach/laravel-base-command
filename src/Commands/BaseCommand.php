<?php

namespace DavidPeach\BaseCommand\Commands;

use DavidPeach\BaseCommand\Step;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class BaseCommand extends Command
{
    protected $signature = 'basecommand:signature';

    protected $commands = [];

    protected $steps;

    public function __construct()
    {
        parent::__construct();

        $this->steps = collect();

        $this->registerCommands();
    }

    public function registerCommands()
    {
        $this->commands = collect($this->commands)->map(function($command) {
            return new $command($this);
        });
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->commands->each(function (Step $command) {

            switch ($command->getType()) {
                case $command::TYPE_ALWAYS:
                    $this->steps->push($command);
                    break;

                case $command::TYPE_BINARY:
                    $choice = $this->choice(
                        $command->question(),
                        [
                            $command->confirmationAnswer(),
                            $command->declineAnswer()
                        ],
                        $command->choiceDefault()
                    );

                    if ($choice === $command->confirmationAnswer()) {
                        $this->steps->push($command);
                    }

                    break;

                case $command::TYPE_CHOICES:
                    $choice = $this->choice(
                        $command->question(),
                        $command->choices(),
                        $command->choiceDefault()
                    );

                    $handler = 'handle' . Str::studly($choice);

                    if (! method_exists($command, $handler)) {
                        $this->info(get_class($command) . '::' . $handler . ' does not exist. :(');
                        break;
                    }

                    $this->steps->push($command->setHandlerMethod($handler));

                    break;

                default:
                    // Nothing
                    break;

            }
        });

        $this->steps->each(function ($command) {
            call_user_func_array([$command, $command->getHandlerMethod()], []);
        });
    }
}
