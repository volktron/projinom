<?php declare(strict_types=1);

namespace Projinom;

use Projinom\Commands\Build;
use Projinom\Commands\Help;
use Projinom\Commands\Init;

class App
{
    protected array $args;
    protected string $command;

    public function __construct()
    {
        $this->args = $_SERVER['argv'];
        $this->command = $this->args[1] ?? '';
    }

    public function processCommand(): bool
    {
        return match($this->command) {
            'build' => (new Build($this->args))->build(),
            'init'  => (new Init($this->args))->init(),
            default  => (new Help($this->args))->displayHelp(),
        };
    }
}
