<?php

namespace DavidPeach\BaseCommand;

abstract class StepAlways extends Step
{
    abstract public function handle(IO $io);
}
