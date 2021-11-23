<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage\Steps;

use DavidPeach\BaseCommand\IO;
use DavidPeach\BaseCommand\StepAlways;

class ExampleStepAlways extends StepAlways
{
    public function handle(IO $io)
    {
        $io->note(message: 'Output from the example always handle method');
    }
}
