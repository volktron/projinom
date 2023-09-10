<?php declare(strict_types=1);

namespace Projinom\Helpers;

use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TwigLoader
{
    protected Environment $twig;

    public function __construct(array $content)
    {
        $this->twig = new Environment(new ArrayLoader($content));
    }

    public function render(string $templateName, array $params = []): string
    {
        return $this->twig->load($templateName)->render($params);
    }
}
