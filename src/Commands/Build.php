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

    public function build()
    {
        $sourcePath = $this->args[2] ?? '';
        $distPath = $this->args[3] ?? '';

        if(!is_dir($sourcePath)) {
            echo 'Invalid Source Path';
            return false;
        }

        if(empty($distPath)) {
            echo 'Invalid Distribution Path';
            return false;
        }

        $this->ensurePathExists($distPath);

        $configPath = $sourcePath . DIRECTORY_SEPARATOR . 'projinom.php';
        if(!file_exists($configPath)) {
            echo 'projinom.php not found';
            return false;
        }

        $this->config = require $configPath;

        switch($this->config['type']) {
            case 'documentation': return (new Documentation($this->config, $sourcePath, $distPath))->generatePages();
        }

        return true;
    }
}
