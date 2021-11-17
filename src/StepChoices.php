<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Console\Output\OutputInterface;

abstract class StepChoices extends Step
{
    protected string $type = self::TYPE_CHOICES;

    abstract public function question(): string;

    abstract public function choices(): array;
}
