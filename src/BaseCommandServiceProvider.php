<?php

namespace DavidPeach\BaseCommand;

use Illuminate\Support\ServiceProvider;

abstract class BaseCommandServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerArtisanCommand();
    }

    public function registerArtisanCommand()
    {
        throw new \Exception('

Please implement the registerArtisanCommand() method in your service provider.
This should register a command class that extends \DavidPeach\BaseCommand\Commands\BaseCommand.

For example: $this->commands([MyCommand::class]);',
            1);

    }
}
