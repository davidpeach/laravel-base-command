<?php

namespace DavidPeach\BaseCommand\Tests\ChildPackage;

use DavidPeach\BaseCommand\Commands\BaseCommand;
use DavidPeach\BaseCommand\Tests\ChildPackage\Steps\ExampleStepAlways;
use DavidPeach\BaseCommand\Tests\ChildPackage\Steps\ExampleStepBinary;
use DavidPeach\BaseCommand\Tests\ChildPackage\Steps\ExampleStepChoice;

class ChildPackageCommand extends BaseCommand
{
    protected $signature = 'child-package:test-command';

    protected string $startTitle = 'Test start title';

    protected string $startSubtitle = 'Test start subtitle';

    protected string $finalSuccessMessage = 'Test final success message';

    protected array $commands = [
        ExampleStepAlways::class,
        ExampleStepBinary::class,
        ExampleStepChoice::class,
    ];
}
