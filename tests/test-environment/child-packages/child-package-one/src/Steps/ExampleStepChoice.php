<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps;

use DavidPeach\BaseCommand\StepChoices;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExampleStepChoice extends StepChoices
{
    public function question(): string
    {
        return 'ExampleStepChoice question';
    }

    public function choices(): array
    {
        return [
            'choice one',
            'choice two',
        ];
    }

    public function handleChoiceOne(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(messages: 'Output from the example choice handle "choice one" method');
    }

    public function handleChoiceTwo(InputInterface $input, OutputInterface $output)
    {
        $output->writeln(messages: 'Output from the example choice handle "choice two" method');
    }

    public function handle(InputInterface $input, OutputInterface $output)
    {
        // TODO: Implement handle() method.
    }
}
