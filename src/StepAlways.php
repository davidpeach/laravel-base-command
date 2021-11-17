<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class StepAlways extends Step
{
    protected string $type = self::TYPE_ALWAYS;

    abstract public function handle(InputInterface $input, OutputInterface $output);
}
