<?php declare(strict_types=1);

namespace Projinom\Commands;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Init extends Command
{
    protected array $defaults = [
        'path' => 'docs',
        'type' => 'documentation',
        'initial_version' => '1.0.0',
        'versions_directory' => 'versions'
    ];

    protected string $name;
    protected string $path;
    protected string $versions_directory;
    protected string $initial_version;

    public function init()
    {
        echo $this->color("Pat yourself on the back, you're actually trying to document your project!\n\n", 'light_green');

        $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
        $this->defaults['name'] = $cwd[count($cwd) - 1];
        $this->name = readline(
            "Enter the name of your project [".$this->color($this->defaults['name'], 'yellow')."]:"
        );
        $this->name = empty($this->name) ? $this->defaults['name'] : $this->name;

        $this->path = readline(
            "Enter the path for your documentation [".$this->color($this->defaults['path'], 'yellow')."]:"
        );
        $this->path = empty($this->path) ? $this->defaults['path'] : $this->path;

        $this->versions_directory = readline(
            "Enter the versions directory for your documentation [".$this->color($this->defaults['versions_directory'], 'yellow')."]:"
        );
        $this->versions_directory = empty($this->versions_directory) ? $this->defaults['versions_directory'] : $this->versions_directory;

        $this->initial_version = readline(
            "Enter the first version of the project you are creating documentation for [".$this->color($this->defaults['initial_version'], 'yellow')."]:"
        );
        $this->initial_version = empty($this->initial_version) ? $this->defaults['initial_version'] : $this->initial_version;

        $this->ensurePathExists($this->path);
        $this->ensurePathExists($this->path . DIRECTORY_SEPARATOR . $this->versions_directory);
        $this->ensurePathExists($this->path . DIRECTORY_SEPARATOR . $this->versions_directory . DIRECTORY_SEPARATOR . $this->initial_version);

        // Copy default template, config, index
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR;
        file_put_contents(
            $this->path . DIRECTORY_SEPARATOR . 'page.twig',
            file_get_contents($templatePath . 'page.twig')
        );

        $indexTemplate = file_get_contents($templatePath . 'version_index.php.twig');
        $twig = new Environment(new ArrayLoader(['template' => $indexTemplate]));

        $projinom = $twig->load('template')->render([]);

        $versionsPath = $this->path . DIRECTORY_SEPARATOR . $this->versions_directory . DIRECTORY_SEPARATOR;
        $initialVersionPath = $versionsPath . $this->initial_version . DIRECTORY_SEPARATOR;
        file_put_contents($initialVersionPath . 'index.php', $projinom);

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

        $projinomTemplate = file_get_contents($templatePath . 'projinom.php.twig');
        $twig = new Environment(new ArrayLoader(['template' => $projinomTemplate]));

        $projinom = $twig->load('template')->render([
            'name' => $this->name,
            'type' => $this->defaults['type'],
            'versions_directory' => $this->versions_directory
        ]);

        file_put_contents($this->path . DIRECTORY_SEPARATOR . 'projinom.php', $projinom);

        echo "\nDocumentation successfully initialized under ".$this->color($this->path, 'light_green')."\n";
        return true;
    }
}
