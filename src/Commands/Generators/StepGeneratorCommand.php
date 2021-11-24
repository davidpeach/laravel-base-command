<?php

namespace DavidPeach\BaseCommand\Commands\Generators;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class StepGeneratorCommand extends GeneratorCommand
{
    protected $name = 'base-command:make:step';

    protected $description = 'Create a new Base Command step class';

    protected $type = 'Step';

    protected string $stub;

    public function handle(): ?bool
    {
        $type = $this->choice(
            question: 'What type of step do you want to make?',
            choices: [
                'Always',
                'Binary',
                'Choice',
            ],
            default: 'Always'
        );

        $this->setStub(match($type) {
            'Always' => __DIR__ . '/../../stubs/StepAlways.stub',
            'Binary' => __DIR__ . '/../../stubs/StepBinary.stub',
            'Choice' => __DIR__ . '/../../stubs/StepChoice.stub',
        });

        return parent::handle();
    }

    private function setStub(string $stub): void
    {
        $this->stub = $stub;
    }

    protected function getStub(): string
    {
        return $this->stub;
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return Config::get(key: 'base_command.steps_namespace');
    }

    protected function rootNamespace(): string
    {
        return Config::get(key: 'base_command.steps_namespace');
    }

    protected function getPath($name): string
    {
        $name = Str::replaceFirst(search: $this->rootNamespace(), replace: '', subject: $name);

        return Config::get(key: 'base_command.steps_directory') .
            str_replace(search: '\\', replace: '/', subject: $name) . '.php';
    }
}
