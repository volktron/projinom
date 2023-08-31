<?php declare(strict_types=1);

namespace Projinom\Builders;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Documentation extends AbstractBuilder
{
    protected array $majorVersions;

    public function generatePages(): bool
    {
        $versionDirectories = scandir($this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory']);
        $this->versionDirectories = array_filter($versionDirectories, fn($item) => $item !== '.' && $item !== '..');

        usort($this->versionDirectories, ['Projinom\Builders\AbstractBuilder', 'rVersionSort']);
        $this->majorVersions = $this->bucketVersions($this->versionDirectories);

        $this->generateContentPage('index');
        $this->generateVersionsPage();

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->writeFiles($this->output['versions']);

        return true;
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
            'versionDirectories' => $this->versionDirectories,
        ]);

        $html = $twig->load('template')->render([
            'config' => $this->config,
            'mode' => 'standalone',
            'standaloneContent' => $versions,
            'versionDirectories' => $this->versionDirectories,
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
}
