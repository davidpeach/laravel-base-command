<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage\Steps;

use DavidPeach\BaseCommand\IO;
use DavidPeach\BaseCommand\StepBinary;

class ExampleStepBinary extends StepBinary
{
    public function question(): string
    {
        return 'ExampleStepBinary question';
    }

    public function handle(IO $io)
    {
        $io->note('Output from the example binary handle method');
    }
}
