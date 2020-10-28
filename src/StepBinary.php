<?php

namespace DavidPeach\BaseCommand;

abstract class StepBinary extends Step
{
    protected $type = self::TYPE_BINARY;

    public function confirmationAnswer()
    {
        return 'Yes';
    }

    public function declineAnswer()
    {
        return 'No';
    }

    public abstract function question();

    public abstract function handle();
}
