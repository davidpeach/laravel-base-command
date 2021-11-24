<?php

namespace DavidPeach\BaseCommand;

abstract class StepChoice extends Step
{
    abstract public function question(): string;

    abstract public function choices(): array;
}
