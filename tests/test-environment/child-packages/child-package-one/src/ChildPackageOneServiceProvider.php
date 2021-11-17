<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne;

use DavidPeach\BaseCommand\BaseCommandServiceProvider;

class ChildPackageOneServiceProvider extends BaseCommandServiceProvider
{
    public function registerArtisanCommand()
    {
        $this->commands([
            ChildPackageOneCommand::class,
        ]);
    }
}
