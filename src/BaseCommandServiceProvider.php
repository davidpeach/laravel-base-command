<?php

namespace DavidPeach\BaseCommand;

use DavidPeach\BaseCommand\Commands\Generators\StepGeneratorCommand;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

abstract class BaseCommandServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->commands([
            $this->getCommandClass(),
        ]);

        Config::set('base_command.steps_directory', $this->getStepsDirectory());
        Config::set('base_command.steps_namespace', $this->getStepsNamespace());
        $this->registerGeneratorCommands();

    }

    protected abstract function getCommandClass(): string;

    protected abstract function getStepsDirectory(): string;

    protected abstract function getStepsNamespace(): string;

    private function registerGeneratorCommands()
    {
        $this->commands([
            StepGeneratorCommand::class,
        ]);
    }
}
