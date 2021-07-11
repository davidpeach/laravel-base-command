<?php

namespace DavidPeach\BaseCommand;

class FeedbackManager
{
    public function __construct($io)
    {
        $this->io = $io;
    }

    public function note(string $text)
    {
        $this->io->newLine();
        $this->io->newLine();
        $this->io->note($text);
    }

    public function caution(string $text)
    {
        $this->io->caution($text);
    }

    public function start(int $numSteps)
    {
        $this->io->newLine();
        $this->io->title('Should we begin?');
        $this->io->progressStart($numSteps);
        $this->io->newLine();
        $this->io->newLine();
    }

    public function advance($text = '', $title = '', $advanceBy = 1)
    {
        if ($title) {
            $this->io->newLine();
            $this->io->title(' ' . $title);
        }
        if ($text) {
            $this->io->text($text . PHP_EOL);
        }
        if ($advanceBy > 0) {
            $this->io->newLine();
            $this->io->progressAdvance($advanceBy);
            $this->io->newLine();
            $this->io->newLine();
        }

        sleep(1);
    }

    public function feedback($text = '', $title = '')
    {
        return $this->advance($text, $title, 0);
    }

    public function abort()
    {
        $this->io->title('🔌 Aborted');
        $this->io->progressFinish();
    }

    public function finish()
    {
        $this->io->title('🎉 Setup steps complete');
        $this->io->text('👩‍💻 Now go forth and make');
        $this->io->progressFinish();
    }
}
