<?php declare(strict_types=1);

namespace Projinom;

class App
{
    public function __construct()
    {
        $args = $_SERVER['argv'];
        $path = $args[1];

        if(!is_dir($path)) {
            echo 'Invalid Path';
            return;
        }

        $configPath = $path . DIRECTORY_SEPARATOR . 'projinom.php';
        if(!file_exists($configPath)) {
            echo 'projinom.php not found';
            return;
        }

        $config = require $configPath;
        var_dump($config);
    }
}