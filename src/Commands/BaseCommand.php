<?php

namespace DavidPeach\BaseCommand\Commands;

use DavidPeach\BaseCommand\IO;
use DavidPeach\BaseCommand\Step;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

class BaseCommand extends Command
{
    protected $signature = 'namespace:command';

    protected Collection|array $commands = [];

    protected Collection $steps;

    public function __construct()
    {
        parent::__construct();

        $this->steps = collect();

        $this->registerCommands();
    }

    public function registerCommands()
    {
        $this->commands = collect(value: $this->commands)->map(callback: function ($command) {
            return new $command(commander: $this);
        });
    }

    /**
     * Execute the command
     */
    public function handle(): int
    {
        $this->commands->each(callback: function (Step $command) {
            switch ($command->getType()) {
                case $command::TYPE_ALWAYS:
                    $this->steps->push(command: $command);

                    break;

                case $command::TYPE_BINARY:
                    $choice = $this->choice(
                        question: $command->question(),
                        choices: [
                            $command->confirmationAnswer(),
                            $command->declineAnswer()
                        ],
                        default: $command->choiceDefault()
                    );

                    if ($choice === $command->confirmationAnswer()) {
                        $this->steps->push(command: $command);
                    }

                    break;

                case $command::TYPE_CHOICES:
                    $choice = $this->choice(
                        question: $command->question(),
                        choices: $command->choices(),
                        default: $command->choiceDefault()
                    );

                    $this->steps->push(
                        $command->setHandlerMethod(handler: 'handle' . Str::studly($choice))
                    );

                    break;

                default:
                    break;
            }
        });

        try {
            app(abstract: Pipeline::class)
                ->send(
                    (new IO(
                        input: $this->input,
                        output: $this->output,
                    ))->withProgressBar(numOfSteps: 15)
                )
                ->through(pipes: $this->steps->toArray())
                ->via(method: 'pipelineHandler')
                ->then(destination: function (IO $io) {
                    $io->output()->writeln(messages: 'DONE');
                });
        } catch (\Throwable $e) {
//            dd($e->getMessage());
            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }
}
