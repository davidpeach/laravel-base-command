<?php

namespace DavidPeach\BaseCommand;

abstract class StepChoices extends Step
{
    protected $type = self::TYPE_MULTIPLE;

    public abstract function question();

    public abstract function choices();
}
