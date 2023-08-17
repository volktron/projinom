<?php declare(strict_types=1);

namespace Projinom;

use Projinom\Commands\Build;

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
            'build' => (new Build($this->args))->build(),
            default => true
        };
    }
}
