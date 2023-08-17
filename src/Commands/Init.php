<?php declare(strict_types=1);

namespace Projinom\Commands;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class Init extends Command
{
    protected array $defaults = [
        'path' => 'docs',
        'type' => 'documentation',
        'versions_directory' => 'versions'
    ];

    protected string $name;
    protected string $path;
    protected string $versions_directory;

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

        $this->ensurePathExists($this->path);
        $this->ensurePathExists($this->path . DIRECTORY_SEPARATOR . $this->versions_directory);

        // Copy default template, config, index
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'page.twig';
        file_put_contents(
            $this->path . DIRECTORY_SEPARATOR . 'page.twig',
            file_get_contents($templatePath)
        );

        $template = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR . 'projinom.php.twig');
        $twig = new Environment(new ArrayLoader(['template' => $template]));

        $projinom = $twig->load('template')->render([
            'name' => $this->name,
            'type' => $this->defaults['type'],
            'versions_directory' => $this->versions_directory
        ]);

        file_put_contents($this->path . DIRECTORY_SEPARATOR . 'projinom.php', $projinom);
        return true;
    }
}
