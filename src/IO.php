<?php

namespace DavidPeach\BaseCommand;

use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IO
{
    private ?ProgressBar $progressBar = null;

    public function __construct(
        private InputInterface  $input,
        private OutputInterface $output,
        private Command $command,
    )
    {
    }

    public function input(): InputInterface
    {
        return $this->input;
    }

    public function output(): OutputInterface
    {
        return $this->output;
    }

    public function progressBar(): ?ProgressBar
    {
        return $this->progressBar;
    }

    public function advanceProgressBar(int $step = 1)
    {
        $this->progressBar()->advance($step);
        $this->progressBar()->clear();
        $this->progressBar()->display();
    }

    public function finishProgressBar()
    {
        $this->progressBar()->finish();
    }

    public function withProgressBar(int $numOfSteps): self
    {
        $this->progressBar = new ProgressBar($this->output);
        $this->progressBar->setMaxSteps($numOfSteps);

        return $this;
    }

    public function start(string $title='', string $subtitle=''): void
    {

        if ($title) {
            $this->command->newLine(count: 2);
            $this->command->warn(string: '=================');
            $this->command->warn(string: $title);
            $this->command->warn(string: '=================');
        }

        if ($subtitle) {
            $this->command->newLine();
            $this->command->line(string: $subtitle);
        }

    }

    public function success(string $message): void
    {
        $this->command->newLine(count: 2);
        $this->command->info(string: $message);
        $this->command->newLine();
    }

    public function note(string|array $message): void
    {
        if (! is_array($message)) {
            $message = [$message];
        }

        $this->command->newLine(count: 2);

        foreach ($message as $line) {
            $this->command->line(string: $line, style: 'info');
        }

        $this->command->newLine();
    }
}
