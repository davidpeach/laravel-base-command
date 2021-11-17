<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class IO
{
    private ?ProgressBar $progressBar = null;

    public function __construct(
        private InputInterface  $input,
        private OutputInterface $output
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

    public function withProgressBar(int $numOfSteps): self
    {
        $this->progressBar = new ProgressBar($this->output);
        $this->progressBar->setMaxSteps($numOfSteps);

        return $this;
    }
}
