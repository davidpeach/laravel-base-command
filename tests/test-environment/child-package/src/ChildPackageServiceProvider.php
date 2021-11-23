<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage;

use DavidPeach\BaseCommand\BaseCommandServiceProvider;

class ChildPackageServiceProvider extends BaseCommandServiceProvider
{
    protected function getCommandClass(): string
    {
        return ChildPackageCommand::class;
    }
}
