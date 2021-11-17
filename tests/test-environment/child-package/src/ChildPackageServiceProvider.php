<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage;

use DavidPeach\BaseCommand\BaseCommandServiceProvider;

class ChildPackageServiceProvider extends BaseCommandServiceProvider
{
    public function registerArtisanCommand()
    {
        $this->commands([
            ChildPackageCommand::class,
        ]);
    }
}
