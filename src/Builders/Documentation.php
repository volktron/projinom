<?php declare(strict_types=1);

namespace Projinom\Builders;

class Documentation extends AbstractBuilder
{
    public function generatePages(): bool
    {
        $versionDirectories = scandir($this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory']);
        $this->versionDirectories = array_filter($versionDirectories, fn($item) => $item !== '.' && $item !== '..');
        krsort($this->versionDirectories);

        $this->generateContentPage('index');

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->writeFiles();

        return true;
    }
}
