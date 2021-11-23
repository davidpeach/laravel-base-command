<?php

namespace DavidPeach\BaseCommand\Tests\Feature;

use DavidPeach\BaseCommand\Tests\BaseTest;

/*
|
| Laravel Base Command is a base package, which is meant to be extended from.
| I have added a child package in /tests/test-environment/child-package.
| This child package only has Step classes which write to the console.
| This is just for ease of testing that those Steps were called.
| The functionality being tested is actually Base Command's.
|
*/
class ChildPackageCommandTest extends BaseTest
{
    /**
     * @test
     * @child-package
     */
    public function it_runs_the_correct_commands_in_order()
    {
        $this->artisan(command: 'child-package:test-command')
            ->expectsOutput(output: 'Test start title')
            ->expectsOutput(output: 'Test start subtitle')

            ->expectsOutput(output: 'Output from the example always handle method')

            ->expectsQuestion(question: 'ExampleStepBinary question', answer: 'Yes')
            ->expectsOutput(output: 'Output from the example binary handle method')

            ->expectsChoice(question: 'ExampleStepChoice question', answer: 'choice two', answers: [
                'choice one',
                'choice two',
            ])
            ->expectsOutput(output: 'Output from the example choice handle "choice two" method')

            ->expectsOutput(output: 'Test final success message')

            ->assertSuccessful();
    }

    /**
     * @test
     * @child-package
     */
    public function it_runs_the_correct_commands_in_order_missing_binary_when_answered_as_no()
    {
        $this->artisan(command: 'child-package:test-command')
            ->expectsOutput(output: 'Test start title')
            ->expectsOutput(output: 'Test start subtitle')

            ->expectsOutput(output: 'Output from the example always handle method')

            ->expectsQuestion(question: 'ExampleStepBinary question', answer: 'No')
            ->doesntExpectOutput(output: 'Output from the example binary handle method')

            ->expectsChoice(question: 'ExampleStepChoice question', answer: 'choice two', answers: [
                'choice one',
                'choice two',
            ])
            ->expectsOutput(output: 'Output from the example choice handle "choice two" method')

            ->expectsOutput(output: 'Test final success message')

            ->assertSuccessful();
    }
}
