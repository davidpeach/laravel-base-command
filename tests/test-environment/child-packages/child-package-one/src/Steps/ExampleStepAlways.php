<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps;

use DavidPeach\BaseCommand\StepAlways;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleStepAlways extends StepAlways
{
    public function handle(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(messages: 'Output from the example always handle method');
    }
}
