<?php declare(strict_types=1);

namespace Projinom\Helpers;

use Projinom\Traits\OutputFormattingTrait;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\ArrayLoader;

class TwigLoader
{
    use OutputFormattingTrait;

    protected Environment $twig;

    public function __construct(array $content)
    {
        $this->twig = new Environment(new ArrayLoader($content));
    }

    public function render(string $templateName, array $params = []): ?string
    {
        try {
            $out = $this->twig->load($templateName)->render($params);
        } catch (LoaderError $e) {
            echo $this->color("An error occurred while loading the template.\n", 'red');
            print_r($e->getMessage());
        } catch (RuntimeError $e) {
            echo $this->color("An error occurred while processing the template.\n", 'red');
            print_r($e->getMessage());
        } catch (SyntaxError $e) {
            echo $this->color("There is a syntax error in the template.\n", 'red');
            print_r($e->getMessage());
        }

        return $out ?? null;
    }
}
