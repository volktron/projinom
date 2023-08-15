<?php declare(strict_types=1);

namespace Projinom;

class App
{
    protected array $config;
    protected string $sourcePath;
    protected string $distPath;

    protected array $output = [
        'versions' => []
    ];

    public function __construct()
    {
        $args = $_SERVER['argv'];
        $this->sourcePath = $args[1] ?? '';
        $this->distPath = $args[2] ?? '';

        if(!is_dir($this->sourcePath)) {
            echo 'Invalid Source Path';
            return;
        }

        if(empty($this->distPath)) {
            echo 'Invalid Distribution Path';
            return;
        }

        $configPath = $this->sourcePath . DIRECTORY_SEPARATOR . 'projinom.php';
        if(!file_exists($configPath)) {
            echo 'projinom.php not found';
            return;
        }

        $this->config = require $configPath;
        $this->generatePages();
    }

    protected function generatePages(): void
    {
        $version_directories = scandir($this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory']);
        $version_directories = array_filter($version_directories, fn($item) => $item !== '.' && $item !== '..');

        foreach($version_directories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->ensureDistPathExists();
        $this->writeFiles();
    }

    protected function writeFiles()
    {
        foreach($this->output['versions'] as $version => $html) {
            file_put_contents(
                $this->distPath . DIRECTORY_SEPARATOR . $version . '.html',
                $html
            );
        }
    }

    protected function generateVersionDocument(string $version): void
    {
        $config = $this->config;
        ob_start();
        require __DIR__ . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'page.php';
        $html = ob_get_contents();
        ob_end_clean();
        $this->output['versions'][$version] = $html;
    }

    protected function ensureDistPathExists(): void
    {
        if(!is_dir($this->distPath)) {
            mkdir($this->distPath);
        }
    }
}
