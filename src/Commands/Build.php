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

    protected string $template;

    protected \Parsedown $parsedown;

    public function __construct(array $args)
    {
        parent::__construct($args);
        $this->parsedown = new \Parsedown();
    }

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

        $this->generateContentPage('index');

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->ensurePathExists($this->distPath);
        $this->writeFiles();
    }

    protected function generateContentPage(string $pageName): void
    {
        $twig = new Environment(new ArrayLoader(['template' => $this->getTemplate()]));

        $contentPath = $this->sourcePath . DIRECTORY_SEPARATOR . $pageName . '.md';
        $rawContent = file_get_contents($contentPath);
        $content = $this->parsedown->parse($rawContent);

        $html = $twig->load('template')->render([
            'config' => $this->config,
            'mode' => 'standalone',
            'standaloneContent' => $content,
            'versionDirectories' => $this->versionDirectories,
        ]);

        file_put_contents($this->distPath . DIRECTORY_SEPARATOR . $pageName . '.html', $html);
    }

    protected function generateVersionDocument(string $version): void
    {
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
                $content = $this->parsedown->parse($rawContent);
                $versionConfig['directory'][$i]['pageContent'][$page] = $content;
            }
        }

        $twig = new Environment(new ArrayLoader(['template' => $this->getTemplate()]));

        $html = $twig->load('template')->render([
            'config' => $this->config,
            'mode' => 'version',
            'version' => $version,
            'versionConfig' => $versionConfig,
            'versionDirectories' => $this->versionDirectories,
        ]);

        $this->output['versions'][$version] = $html;
    }

    protected function getTemplate(): string {
        if(!empty($this->template)) {
            return $this->template;
        }

        $sourceTemplatePath = $this->sourcePath . DIRECTORY_SEPARATOR . 'page.twig';
        if(file_exists($sourceTemplatePath)) {
            echo 'Using template found in ' . $this->color($this->sourcePath, 'yellow');
            $this->template = file_get_contents($sourceTemplatePath);
        } else {
            echo 'No template found in ' . $this->color($this->sourcePath, 'yellow') . ', using default template.';
            $this->template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'page.twig');
        }

        return $this->template;
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
