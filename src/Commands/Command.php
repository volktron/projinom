<?php declare(strict_types=1);

namespace Projinom\Commands;

abstract class Command
{
    public function __construct(public array $args)
    {
    }
}
