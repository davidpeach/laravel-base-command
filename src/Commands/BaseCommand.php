<?php

namespace DavidPeach\BaseCommand\Commands;

use DavidPeach\BaseCommand\Step;
use DavidPeach\EscAppScaffolder\FeedbackManager;
use Illuminate\Console\Command;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;
use Symfony\Component\Console\Style\SymfonyStyle;

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
        $this->commands = collect($this->commands)->map(function ($command) {
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
                    $this->steps->push(
                        $command->setHandlerMethod('handle' . Str::studly($choice))
                    );
                    break;

                default:
                    break;
            }
        });

        $feedback = tap(new FeedbackManager(
            new SymfonyStyle($this->input, $this->output)
        ))->start($this->steps->count());

        app(Pipeline::class)->send($feedback)
            ->through($this->steps->toArray())
            ->then(function ($feedback) {
                $feedback->finish();
            });
    }
}
