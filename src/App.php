<?php declare(strict_types=1);

namespace Projinom;

class App
{
    protected array $args;
    protected string $command;

    public function __construct()
    {
        $this->args = $_SERVER['argv'];
        $this->command = $this->args[1] ?? '';

        $this->processCommand();
    }

    protected function processCommand(): bool
    {
        return match($this->command) {
            'build' => (new DocBuilder($this->args))->build(),
            default => true
        };
    }
}
