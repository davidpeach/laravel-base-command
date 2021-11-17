<?php

namespace DavidPeach\BaseCommand;

abstract class StepBinary extends Step
{
    public function confirmationAnswer(): string
    {
        return 'Yes';
    }

    public function declineAnswer(): string
    {
        return 'No';
    }

    abstract public function question(): string;

    abstract public function handle(IO $io);
}
