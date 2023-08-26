<?php declare(strict_types=1);

namespace Projinom\Builders;

class Documentation extends AbstractBuilder
{
    public function generatePages(): bool
    {
        $versionDirectories = scandir($this->sourcePath . DIRECTORY_SEPARATOR . $this->config['versions_directory']);
        $this->versionDirectories = array_filter($versionDirectories, fn($item) => $item !== '.' && $item !== '..');

        uksort($this->versionDirectories, function($left, $right) {
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
        });

        $this->generateContentPage('index');

        foreach($this->versionDirectories as $version_directory) {
            $this->generateVersionDocument($version_directory);
        }

        $this->writeFiles();

        return true;
    }
}
