<?php

namespace DavidPeach\BaseCommand;

use Symfony\Component\Process\Process;

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

    public function ask(string $question)
    {
        return $this->commander->ask('❓ ' . $question);
    }

    public function confirm(string $question, bool $default = true)
    {
        return $this->commander->confirm('🤔 ' . $question, $default);
    }

    public function ensurePrefixedWith(string $string, string $prefix)
    {
        if (strpos(trim($string), $prefix) !== 0) {
            return $prefix . $string;
        }

        return $string;
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

    protected function asyncProcess(array $command, callable $callback)
    {
        $process = new Process($command);
        $process->start();
        $process->waitUntil(function ($type, $output) use ($callback) {
            return $callback($output);
        });
        return $process->getOutput();
    }

    protected function updateFile($fileToUpdate, $hookString, $toInsert)
    {
        $fileContents = file_get_contents(
            $fileToUpdate
        );

        if (strpos($fileContents, $toInsert) !== false) {
            return;
        }

        $fileContents = str_replace(
            $hookString,
            $hookString . $toInsert,
            $fileContents
        );

        file_put_contents($fileToUpdate, $fileContents);
    }
}
