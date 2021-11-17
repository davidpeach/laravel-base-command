<?php

namespace DavidPeach\BaseCommand\Tests\Feature;

use DavidPeach\BaseCommand\Tests\BaseTest;

class ChildPackageCommandTest extends BaseTest
{
    /**
     * @test
     * @child-package-one
     */
    public function it_runs_the_correct_commands_in_order()
    {
        $this->artisan(command: 'child-package-one:test-command')
            ->expectsOutput(output: 'Output from the example always handle method')

            ->expectsQuestion(question: 'ExampleStepBinary question', answer: 'Yes')
            ->expectsOutput(output: 'Output from the example binary handle method')

            ->expectsChoice(question: 'ExampleStepChoice question', answer: 'choice two', answers: [
                'choice one',
                'choice two',
            ])
            ->expectsOutput(output: 'Output from the example choice handle "choice two" method')

            ->assertSuccessful();
    }

    /**
     * @test
     * @child-package-one
     */
    public function it_runs_the_correct_commands_in_order_missing_binary_when_answered_as_no()
    {
        $this->artisan(command: 'child-package-one:test-command')
            ->expectsOutput(output: 'Output from the example always handle method')

            ->expectsQuestion(question: 'ExampleStepBinary question', answer: 'No')
            ->doesntExpectOutput(output: 'Output from the example binary handle method')

            ->expectsChoice(question: 'ExampleStepChoice question', answer: 'choice two', answers: [
                'choice one',
                'choice two',
            ])
            ->expectsOutput(output: 'Output from the example choice handle "choice two" method')

            ->assertSuccessful();
    }
}
