<?php

namespace DavidPeach\BaseCommand;

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
        $this->registerArtisanCommand();
    }

    public abstract function registerArtisanCommand();
}
