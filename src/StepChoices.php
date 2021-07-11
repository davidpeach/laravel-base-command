<?php

namespace DavidPeach\BaseCommand;

abstract class StepChoices extends Step
{
    protected $type = self::TYPE_CHOICES;

    abstract public function question();

    abstract public function choices();

    public function handle($feedback, $next)
    {
        $handler = $this->getHandlerMethod();

        if (!method_exists($this, $handler)) {
            throw new \Exception(get_class($this) . '::' . $handler . ' does not exist. :(', 1);
        }

        call_user_func_array([$this, $handler], [$feedback]);

        return $next($feedback);
    }
}
