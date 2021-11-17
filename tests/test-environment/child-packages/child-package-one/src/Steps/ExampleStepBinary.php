<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps;

use DavidPeach\BaseCommand\StepBinary;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleStepBinary extends StepBinary
{
    public function question(): string
    {
        return 'ExampleStepBinary question';
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Output from the example binary handle method');
    }
}
