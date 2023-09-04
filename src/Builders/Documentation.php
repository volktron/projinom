<?php declare(strict_types=1);

namespace Projinom\Builders;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Documentation extends AbstractBuilder
{
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

        $projectRoot = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
        $jsSrc = $projectRoot . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'main.js';
        copy($jsSrc, $this->distPath . DIRECTORY_SEPARATOR . 'main.js');

        return true;
    }
}
