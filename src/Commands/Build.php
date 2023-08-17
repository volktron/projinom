<?php

namespace Projinom\Commands;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Build extends Command
{
    protected array $config;

    protected string $sourcePath;
    protected string $distPath;

    protected array $versionDirectories = [];
    protected array $output = [
        'versions' => []
    ];

    public function build()
    {
        $this->sourcePath = $this->args[2] ?? '';
        $this->distPath = $this->args[3] ?? '';

        if(!is_dir($this->sourcePath)) {
            echo 'Invalid Source Path';
            return false;
        }

        if(empty($this->distPath)) {
            echo 'Invalid Distribution Path';
            return false;
        }

        $configPath = $this->sourcePath . DIRECTORY_SEPARATOR . 'projinom.php';
        if(!file_exists($configPath)) {
            echo 'projinom.php not found';
            return false;
        }

        $this->config = require $configPath;
        $this->generatePages();

        return true;
    }

    protected function generatePages(): void
    {
        $versionDirectories = scandir($this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory']);
        $this->versionDirectories = array_filter($versionDirectories, fn($item) => $item !== '.' && $item !== '..');

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->ensureDistPathExists();
        $this->writeFiles();
    }

    protected function generateVersionDocument(string $version): void
    {
        $parsedown = new \Parsedown();

        $versionPath = $this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory'];
        $versionPath .= DIRECTORY_SEPARATOR . $version . DIRECTORY_SEPARATOR;
        $versionIndexPath = $versionPath . 'index.php';
        $versionConfig = require $versionIndexPath;

        $numSections = count($versionConfig['directory']);
        for($i = 0; $i < $numSections; $i++) {
            $versionConfig['directory'][$i]['pageContent'] = [];
            foreach($versionConfig['directory'][$i]['pages'] as $page) {
                $contentPath = $versionPath . $versionConfig['directory'][$i]['name'] . DIRECTORY_SEPARATOR . $page . '.md';
                $rawContent = file_get_contents($contentPath);
                $content = $parsedown->parse($rawContent);
                $versionConfig['directory'][$i]['pageContent'][$page] = $content;
            }
        }

        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'page.twig');
        $twig = new Environment(new ArrayLoader(['template' => $template]));

        $html = $twig->load('template')->render([
            'config' => $this->config,
            'version' => $version,
            'versionConfig' => $versionConfig,
            'versionDirectories' => $this->versionDirectories,
        ]);

        $this->output['versions'][$version] = $html;
    }

    protected function ensureDistPathExists(): void
    {
        if(!is_dir($this->distPath)) {
            mkdir($this->distPath);
        }
    }

    protected function writeFiles(): void
    {
        foreach($this->output['versions'] as $version => $html) {
            file_put_contents(
                $this->distPath . DIRECTORY_SEPARATOR . $version . '.html',
                $html
            );
        }
    }
}
