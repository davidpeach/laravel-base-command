<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage\Steps;

use DavidPeach\BaseCommand\IO;
use DavidPeach\BaseCommand\StepChoices;

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

    public function handleChoiceOne(IO $io)
    {
        $io->note(message: 'Output from the example choice handle "choice one" method');
    }

    public function handleChoiceTwo(IO $io)
    {
        $io->note(message: 'Output from the example choice handle "choice two" method');
    }
}
