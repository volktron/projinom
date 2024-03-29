<?php declare(strict_types=1);

namespace Projinom\Commands;

use Projinom\Helpers\TwigLoader;

class Init extends AbstractCommand
{
    protected array $defaults = [
        'source_path' => 'docsource',
        'dist_path' => 'docs',
        'type' => 'documentation',
        'initial_version' => '1.0.0',
        'versions_directory' => 'versions'
    ];

    protected string $name;
    protected string $sourcePath;
    protected string $distPath;
    protected string $versions_directory;
    protected string $initial_version;

    public function init(): bool
    {
        echo $this->color("Pat yourself on the back, you're actually trying to document your project!\n\n", 'light_green');

        $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
        $this->defaults['name'] = $cwd[count($cwd) - 1];
        $this->name = readline(
            "Enter the name of your project [".$this->color($this->defaults['name'], 'yellow')."]:"
        );
        $this->name = empty($this->name) ? $this->defaults['name'] : $this->name;

        $this->sourcePath = readline(
            "Enter the source path for your documentation [".$this->color($this->defaults['source_path'], 'yellow')."]:"
        );
        $this->sourcePath = empty($this->sourcePath) ? $this->defaults['source_path'] : $this->sourcePath;

        $this->distPath = readline(
            "Enter the source path for your documentation (use ".$this->color('docs', 'green')." for github pages) [".$this->color($this->defaults['dist_path'], 'yellow')."]:"
        );
        $this->distPath = empty($this->distPath) ? $this->defaults['dist_path'] : $this->distPath;

        $this->versions_directory = readline(
            "Enter the versions directory for your documentation [".$this->color($this->defaults['versions_directory'], 'yellow')."]:"
        );
        $this->versions_directory = empty($this->versions_directory) ? $this->defaults['versions_directory'] : $this->versions_directory;

        $this->initial_version = readline(
            "Enter the first version of the project you are creating documentation for [".$this->color($this->defaults['initial_version'], 'yellow')."]:"
        );
        $this->initial_version = empty($this->initial_version) ? $this->defaults['initial_version'] : $this->initial_version;

        return $this->initializeProject();
    }

    public function initializeProject(): bool
    {
        $this->ensurePathExists($this->sourcePath);
        $this->ensurePathExists($this->sourcePath . DIRECTORY_SEPARATOR . $this->versions_directory);
        $this->ensurePathExists($this->sourcePath . DIRECTORY_SEPARATOR . $this->versions_directory . DIRECTORY_SEPARATOR . $this->initial_version);

        // Copy default template, config, index
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR;
        file_put_contents(
            $this->sourcePath . DIRECTORY_SEPARATOR . 'page.twig',
            file_get_contents($templatePath . 'page.twig')
        );

        $indexTemplate = file_get_contents($templatePath . 'version_index.php.twig');
        $projinomTemplate = file_get_contents($templatePath . 'projinom.php.twig');
        $twig = new TwigLoader([
            'index' => $indexTemplate,
            'projinom' => $projinomTemplate
        ]);

        $twigs = [
            'versionIndex' => $twig->render('index'),
            'projinom' => $twig->render('projinom', [
                'name' => $this->name,
                'type' => $this->defaults['type'],
                'dist_path' => $this->distPath,
                'versions_directory' => $this->versions_directory
            ])
        ];

        if($twig->hasErrored) {
            return false;
        }

        $versionsPath = $this->sourcePath . DIRECTORY_SEPARATOR . $this->versions_directory . DIRECTORY_SEPARATOR;
        $initialVersionPath = $versionsPath . $this->initial_version . DIRECTORY_SEPARATOR;

        $indexConfig = require $initialVersionPath . 'index.php';
        foreach($indexConfig['directory'] as $section) {
            $this->ensurePathExists($initialVersionPath . DIRECTORY_SEPARATOR . $section['name']);
            foreach($section['pages'] as $page) {
                file_put_contents(
                    $initialVersionPath . DIRECTORY_SEPARATOR . $section['name'] . DIRECTORY_SEPARATOR . $page . '.md',
                    "# $page"
                );
            }
        }

        file_put_contents($initialVersionPath . 'index.php', $twigs['versionIndex']);
        file_put_contents($this->sourcePath . DIRECTORY_SEPARATOR . 'projinom.php', $twigs['projinom']);
        file_put_contents($this->sourcePath . DIRECTORY_SEPARATOR . 'index.md', 'Hello, world!');

        echo "\nDocumentation successfully initialized under " . $this->color($this->sourcePath, 'light_green') . "\n";
        return true;
    }
}
