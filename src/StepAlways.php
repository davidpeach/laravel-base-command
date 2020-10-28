<?php

namespace DavidPeach\BaseCommand;

abstract class StepAlways extends Step
{
    protected $type = self::TYPE_ALWAYS;

    public abstract function handle();
}
