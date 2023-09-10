<?php declare(strict_types=1);

namespace Projinom\Commands;

class Help extends AbstractCommand
{
    protected array $commands = [
        'build' => [
            'summary' => 'build <source> <destination>',
            'description' => 'Builds a Projinom',
        ],
        'help' => [
            'summary' => 'help',
            'description' => 'Displays help',
        ],
        'init' => [
            'summary' => 'init <destination>',
            'description' => 'Initializes a new Projinom',
        ],
    ];

    public function displayHelp(): true
    {
        $max = array_reduce($this->commands, fn($carry, $item) => max($carry, strlen($item['summary'])));

        foreach($this->commands as $command) {
            echo str_pad($command['summary'], $max) . " - " . $command['description'] . "\n";
        }

        return true;
    }
}
