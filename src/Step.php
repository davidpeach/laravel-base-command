<?php

namespace DavidPeach\BaseCommand;

use DavidPeach\BaseCommand\Exceptions\StepHandlerMethodMissing;
use Illuminate\Console\Command;

abstract class Step
{
    const TYPE_ALWAYS = 'always';

    const TYPE_BINARY = 'yes_no';

    const TYPE_CHOICES = 'choices';

    const DEFAULT_ANSWER_INDEX = 0;

    protected string $type = self::TYPE_ALWAYS;

    protected string $handler = 'handle';

    protected Command $commander;

    public function __construct(Command $commander)
    {
        $this->commander = $commander;
    }

    public function choiceDefault(): int
    {
        return static::DEFAULT_ANSWER_INDEX;
    }

    public function ask(string $question): mixed
    {
        return $this->commander->ask('❓ ' . $question);
    }

    public function confirm(string $question, bool $default = true): bool
    {
        return $this->commander->confirm('🤔 ' . $question, $default);
    }

    public function setHandlerMethod(string $handler): self
    {
        $this->handler = $handler;

        return $this;
    }

    public function getHandlerMethod(): string
    {
        return $this->handler;
    }

    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @throws StepHandlerMethodMissing
     */
    public function pipelineHandler(IO $io, Callable $next)
    {
        $handler = $this->getHandlerMethod();

//        dd($this);
        // DEFINE IF A STEP SHOULD CEASE REMAINING STEPS
        // MAYBE DEFINE ROLEBACK STEPS WITH A `handleRollback` method?
        if (!method_exists($this, $handler)) {
            throw new StepHandlerMethodMissing(
                message: get_class($this) . '::' . $handler . ' does not exist. :(',
                code: 1
            );
        }

        call_user_func_array(
            callback: [$this, $handler],
            args: [
                $io->input(),
                $io->output(),
            ]
        );

        return $next($io);
    }
}
