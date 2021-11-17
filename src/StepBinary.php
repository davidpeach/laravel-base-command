<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class StepBinary extends Step
{
    protected string $type = self::TYPE_BINARY;

    public function confirmationAnswer(): string
    {
        return 'Yes';
    }

    public function declineAnswer(): string
    {
        return 'No';
    }

    abstract public function question(): string;

    abstract public function handle(InputInterface $input, OutputInterface $output);
}
