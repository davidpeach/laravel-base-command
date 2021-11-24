<?php

namespace DavidPeach\BaseCommand;

use DavidPeach\BaseCommand\Exceptions\StepHandlerMethodMissing;
use Throwable;

abstract class Step
{
    const DEFAULT_ANSWER_INDEX = 0;

    protected string $handler = 'handle';

    public function choiceDefault(): int
    {
        return static::DEFAULT_ANSWER_INDEX;
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

    /**
     * @throws StepHandlerMethodMissing
     * @throws Throwable
     */
    public function pipelineHandler(IO $io, callable $next)
    {
        $handler = $this->getHandlerMethod();

        if (!method_exists($this, $handler)) {
            throw new StepHandlerMethodMissing(
                message: get_class($this) . '::' . $handler . ' does not exist.',
                code: 1
            );
        }

        try {
            call_user_func_array(
                callback: [$this, $handler],
                args: [
                    $io,
                ]
            );
        } catch (Throwable $e) {
            $io->finishProgressBar();
            throw $e;
        }

        $io->advanceProgressBar();

        return $next($io);
    }
}
