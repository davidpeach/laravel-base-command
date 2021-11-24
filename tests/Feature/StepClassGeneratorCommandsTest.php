<?php

namespace DavidPeach\BaseCommand\Tests\Feature;

use DavidPeach\BaseCommand\Tests\BaseTest;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;

class StepClassGeneratorCommandsTest extends BaseTest
{
    /** @test */
    public function it_can_generate_a_new_step_always_class()
    {
        (new Filesystem)->delete([
            __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedAlwaysStep.php',
        ]);

        $this->artisan(command: 'base-command:make:step MyGeneratedAlwaysStep')
            ->expectsChoice(
                question: 'What type of step do you want to make?',
                answer: 'Always',
                answers: ['Always', 'Binary', 'Choice']
            )
            ->assertSuccessful();

        $this->assertTrue(
            (new Filesystem)->exists(
                path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedAlwaysStep.php'
            )
        );

        try {
            $this->assertStringContainsString(
                needle: 'class MyGeneratedAlwaysStep extends StepAlways',
                haystack: (new Filesystem)->get(path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedAlwaysStep.php')
            );
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }
    }

    /** @test */
    public function it_can_generate_a_new_step_binary_class()
    {
        (new Filesystem)->delete([
            __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedBinaryStep.php',
        ]);

        $this->artisan(command: 'base-command:make:step MyGeneratedBinaryStep')
            ->expectsChoice(
                question: 'What type of step do you want to make?',
                answer: 'Binary',
                answers: ['Always', 'Binary', 'Choice']
            )
            ->assertSuccessful();

        $this->assertTrue(
            (new Filesystem)->exists(
                path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedBinaryStep.php'
            )
        );

        try {
            $this->assertStringContainsString(
                needle: 'class MyGeneratedBinaryStep extends StepBinary',
                haystack: (new Filesystem)->get(path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedBinaryStep.php')
            );
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }
    }

    /** @test */
    public function it_can_generate_a_new_step_choice_class()
    {
        (new Filesystem)->delete([
            __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedChoiceStep.php',
        ]);

        $this->artisan(command: 'base-command:make:step MyGeneratedChoiceStep')
            ->expectsChoice(
                question: 'What type of step do you want to make?',
                answer: 'Choice',
                answers: ['Always', 'Binary', 'Choice']
            )
            ->assertSuccessful();

        $this->assertTrue(
            (new Filesystem)->exists(
                path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedChoiceStep.php'
            )
        );

        try {
            $this->assertStringContainsString(
                needle: 'class MyGeneratedChoiceStep extends StepChoice',
                haystack: (new Filesystem)->get(path: __DIR__ . '/../test-environment/child-package/src/Steps/MyGeneratedChoiceStep.php')
            );
        } catch (FileNotFoundException $e) {
            $this->fail($e->getMessage());
        }
    }
}
