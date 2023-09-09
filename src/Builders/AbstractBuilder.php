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
    protected array $majorVersions;

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
            'majorVersions' => $this->majorVersions,
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
            'majorVersions' => $this->majorVersions,
        ]);

        $this->output['versions'][$version] = $html;
    }

    protected function generateVersionsPage(): void
    {
        $twig = new Environment(new ArrayLoader([
            'template' => $this->getTemplate(),
            'versions' => $this->getTemplate('versions.twig')
        ]));

        $versions = $twig->load('versions')->render([
            'config' => $this->config,
            'majorVersions' => $this->majorVersions,
        ]);

        $html = $twig->load('template')->render([
            'config' => $this->config,
            'mode' => 'standalone',
            'standaloneContent' => $versions,
            'majorVersions' => $this->majorVersions,
        ]);

        file_put_contents($this->distPath . DIRECTORY_SEPARATOR . 'versions.html', $html);
    }

    protected function bucketVersions(array $versions, int $levels = 1, string $separator = '.'): array
    {
        $out = [];

        foreach($versions as $version) {
            $parts = explode($separator, $version);
            $pointer = &$out;

            for($i = 0; $i < $levels; $i++) {
                if($i == $levels - 1) {
                    $pointer[$parts[$i]][] = $version;
                    break;
                }

                $pointer[$parts[$i]] ??= [];
                $pointer = &$pointer[$parts[$i]];
            }
        }

        return $out;
    }

    protected function getTemplate(string $templateName = 'page.twig'): string {
        if(!empty($this->template[$templateName])) {
            return $this->template[$templateName];
        }

        $sourceTemplatePath = $this->sourcePath . DIRECTORY_SEPARATOR . $templateName;
        $formattedTemplateName = $this->color(explode('.', $templateName)[0], 'green');
        if(file_exists($sourceTemplatePath)) {
            echo 'Using template for ' . $formattedTemplateName . ' found in ' . $this->color($this->sourcePath, 'yellow') . ".\n";
            $this->template[$templateName] = file_get_contents($sourceTemplatePath);
        } else {
            echo 'No template for ' . $formattedTemplateName . ' found in ' . $this->color($this->sourcePath, 'yellow') . ", using default template.\n";
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
