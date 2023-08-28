<?php declare(strict_types=1);

namespace Projinom\Builders;

use Projinom\Traits\OutputFormattingTrait;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

abstract class AbstractBuilder
{
    use OutputFormattingTrait;

    protected \Parsedown $parsedown;

    protected array $template;

    protected array $output = [
        'versions' => []
    ];

    protected array $versionDirectories = [];

    public function __construct(
        public array $config,
        public string $sourcePath,
        public string $distPath
    ) {
        $this->parsedown = new \Parsedown();
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

    protected function getTemplate(string $templateName = 'page.twig'): string {
        if(!empty($this->template[$templateName])) {
            return $this->template[$templateName];
        }

        var_dump($templateName);
        $sourceTemplatePath = $this->sourcePath . DIRECTORY_SEPARATOR . $templateName;
        if(file_exists($sourceTemplatePath)) {
            echo 'Using template found in ' . $this->color($this->sourcePath, 'yellow');
            $this->template[$templateName] = file_get_contents($sourceTemplatePath);
        } else {
            echo 'No template found in ' . $this->color($this->sourcePath, 'yellow') . ', using default template.';
            $this->template[$templateName] = file_get_contents(
                __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . $templateName
            );
        }

        return $this->template[$templateName];
    }

    protected function writeFiles(array $content): void
    {
        foreach($content as $page => $html) {
            file_put_contents(
                $this->distPath . DIRECTORY_SEPARATOR . $page . '.html',
                $html
            );
        }
    }

    protected static function rVersionSort($left, $right): int
    {
        $leftPieces = explode('.', $left);
        $rightPieces = explode('.', $right);

        $numPieces = count($leftPieces);
        for($i = 0; $i < $numPieces; $i++) {
            if($leftPieces[$i] == ($rightPieces[$i] ?? 0)) {
                continue;
            }

            return ($rightPieces[$i] ?? 0) <=> $leftPieces[$i];
        }

        return 0;
    }
}
