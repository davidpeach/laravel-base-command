<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Console\Output\OutputInterface;

abstract class StepChoice extends Step
{
    abstract public function question(): string;

    abstract public function choices(): array;
}
