<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne;

use DavidPeach\BaseCommand\Commands\BaseCommand;
use DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps\ExampleStepAlways;
use DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps\ExampleStepBinary;
use DavidPeach\BaseCommand\Tests\ChildPackages\ChildPackageOne\Steps\ExampleStepChoice;
use Illuminate\Support\Collection;

class ChildPackageOneCommand extends BaseCommand
{
    protected $signature = 'child-package-one:test-command';

    protected Collection|array $commands = [
        ExampleStepAlways::class,
        ExampleStepBinary::class,
        ExampleStepChoice::class,
    ];
}
