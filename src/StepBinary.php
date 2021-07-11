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

    abstract public function question();

    abstract public function handle($string, $next);
}
