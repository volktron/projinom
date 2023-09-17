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

        $indexHtml = $this->generateContentPage('index');
        $versionsHtml = $this->generateVersionsPage();

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        if(!$this->writeFiles([...$this->output['versions'], ...['index' => $indexHtml, 'versions' => $versionsHtml]])) {
            return false;
        }

        $projectRoot = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..';
        $jsSrc = $projectRoot . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'main.js';
        $cssSrc = $projectRoot . DIRECTORY_SEPARATOR . 'js' . DIRECTORY_SEPARATOR . 'dist' . DIRECTORY_SEPARATOR . 'main.css';

        $result = copy($jsSrc, $this->distPath . DIRECTORY_SEPARATOR . 'main.js');
        $result &= copy($cssSrc, $this->distPath . DIRECTORY_SEPARATOR . 'main.css');

        if(file_exists($this->sourcePath . DIRECTORY_SEPARATOR . 'favicon.ico')) {
            $result &= copy($this->sourcePath . DIRECTORY_SEPARATOR . 'favicon.ico', $this->distPath . DIRECTORY_SEPARATOR . 'favicon.ico');
        }

        if(!$result) {
            echo $this->color("Something went wrong while copying precompiled resources.\n", 'red');
            return false;
        }

        return true;
    }
}
