<?php

namespace DavidPeach\BaseCommand;

abstract class Step
{
    const TYPE_ALWAYS = 'always';

    const TYPE_BINARY = 'yes_no';

    const TYPE_CHOICES = 'choices';

    const DEFAULT_ANSWER_INDEX = 0;

    protected $type = self::TYPE_ALWAYS;

    protected $handler = 'handle';

    protected $commander;

    public function __construct($commander)
    {
        $this->commander = $commander;
    }

    public function choiceDefault(): int
    {
        return static::DEFAULT_ANSWER_INDEX;
    }

    public function report(string $toReport): void
    {
        $this->commander->info($toReport);
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
}
