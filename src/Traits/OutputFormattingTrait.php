<?php declare(strict_types=1);

namespace Projinom\Traits;

trait OutputFormattingTrait
{
    public array $cliColors = [
        'default' => 39,
        'black' => 30,
        'red' => 31,
        'green' => 32,
        'yellow' => 33,
        'blue' => 34,
        'magenta' => 35,
        'cyan' => 36,
        'light_gray' => 37,
        'dark_gray' => 90,
        'light_red' => 91,
        'light_green' => 92,
        'light_yellow' => 93,
        'light_blue' => 94,
        'light_magenta' => 95,
        'light_cyan' => 96,
        'white' => 97,
    ];

    protected function color(string $text, string $color): string
    {
        return "\033[".$this->cliColors[$color]."m".$text."\033[0m";
    }
}
