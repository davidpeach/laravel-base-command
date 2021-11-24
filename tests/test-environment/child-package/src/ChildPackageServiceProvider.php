<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage;

use DavidPeach\BaseCommand\BaseCommandServiceProvider;

class ChildPackageServiceProvider extends BaseCommandServiceProvider
{
    protected function getCommandClass(): string
    {
        return ChildPackageCommand::class;
    }

    protected function getStepsDirectory(): string
    {
        return  __DIR__ . '/Steps';
    }

    protected function getStepsNamespace(): string
    {
        return  'DavidPeach\BaseCommand\Tests\ChildPackage\Steps';
    }
}
