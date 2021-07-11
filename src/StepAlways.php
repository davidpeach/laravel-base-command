<?php

namespace DavidPeach\BaseCommand;

abstract class StepAlways extends Step
{
    protected $type = self::TYPE_ALWAYS;

    abstract public function handle($feedback, $next);
}
