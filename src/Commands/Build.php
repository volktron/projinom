<?php

namespace Projinom\Commands;

use Projinom\Builders\Documentation;

class Build extends AbstractCommand
{
    protected array $config;

    public function __construct(array $args)
    {
        parent::__construct($args);
    }

    public function build(): bool
    {
        $sourcePath = $this->args[2] ?? '';
        $distPath = $this->args[3] ?? null;

        if(!is_dir($sourcePath)) {
            echo 'Invalid Source Path';
            return false;
        }

        $configPath = $sourcePath . DIRECTORY_SEPARATOR . 'projinom.php';
        if(!file_exists($configPath)) {
            echo 'projinom.php not found';
            return false;
        }

        $this->config = require $configPath;
        $distPath ??= $this->config['dist_path'] ?? null;

        if(empty($distPath)) {
            echo 'Invalid Distribution Path';
            return false;
        }

        $this->ensurePathExists($distPath);

        return match ($this->config['type']) {
            'documentation' => (new Documentation($this->config, $sourcePath, $distPath))->generatePages(),
            default => true,
        };
    }
}
