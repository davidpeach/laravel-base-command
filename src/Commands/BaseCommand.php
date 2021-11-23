<?php

namespace DavidPeach\BaseCommand\Commands;

use DavidPeach\BaseCommand\Exceptions\StepHandlerMethodMissing;
use DavidPeach\BaseCommand\IO;
use DavidPeach\BaseCommand\Step;
use DavidPeach\BaseCommand\StepAlways;
use DavidPeach\BaseCommand\StepBinary;
use DavidPeach\BaseCommand\StepChoice;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Throwable;

class BaseCommand extends Command
{
    protected $signature = 'namespace:command';

    protected string $startTitle = '';

    protected string $startSubtitle = '';

    protected string $finalSuccessMessage = '';

    protected array $commands = [];

    private Collection $commandClasses;

    protected Collection $steps;

    public function __construct()
    {
        parent::__construct();

        $this->steps = collect();

        $this->registerCommands();
    }

    public function registerCommands()
    {
        $this->commandClasses = collect(value: $this->commands)->map(callback: function ($command) {
            return new $command;
        });
    }

    /**
     * Execute the command
     */
    public function handle(): int
    {
        $io = new IO(
            input: $this->input,
            output: $this->output,
            command: $this,
        );

        $io->withProgressBar(numOfSteps: $this->steps->count());

        $io->start(title: $this->getStartTitle(), subtitle: $this->getStartSubtitle());

        $this->commandClasses->each(callback: function (Step $command) {
            switch (true) {
                case $command instanceof StepAlways:
                    $this->steps->push(command: $command);

                    break;

                case $command instanceof StepBinary:
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

                case $command instanceof StepChoice:
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
                ->send(passable: $io)
                ->through(pipes: $this->steps->toArray())
                ->via(method: 'pipelineHandler')
                ->then(destination: function (IO $io) {
                    $io->progressBar()->finish();
                    $io->success(message: $this->getFinalSuccessMessage());
                });
        } catch (StepHandlerMethodMissing) {
            return SymfonyCommand::INVALID;
        } catch (Throwable) {
            return SymfonyCommand::FAILURE;
        }

        return SymfonyCommand::SUCCESS;
    }

    private function getStartTitle(): string
    {
        return $this->startTitle;
    }

    private function getStartSubtitle(): string
    {
        return $this->startSubtitle;
    }

    private function getFinalSuccessMessage(): string
    {
        return $this->finalSuccessMessage;
    }
}
