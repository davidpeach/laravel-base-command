<?php

namespace DavidPeach\BaseCommand\Tests;

use Orchestra\Testbench\TestCase;

class BaseTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            'DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\ChildPackageOneServiceProvider',
        ];
    }
}
