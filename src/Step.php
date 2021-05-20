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

    protected function updateFile($fileToUpdate, $hookString, $toInsert)
    {
        $fileContents = file_get_contents(
            $fileToUpdate
        );

        if (! strpos($fileContents, $toInsert) !== false) {

            $fileContents = str_replace(
                $hookString,
                $hookString . $toInsert,
                $fileContents
            );

            file_put_contents($fileToUpdate, $fileContents);

            $this->report($fileToUpdate . ' updated with ' . $toInsert);

        } else {

            $this->report($fileToUpdate . ' already contains "' . $toInsert . '"');

        }
    }
}
