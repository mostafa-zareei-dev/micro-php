<?php

namespace App\Kernel\Views;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class TwigView extends IView
{
    private $twig;
    protected string $ext = ".html.twig";

    public function __construct()
    {
        parent::__construct();
        $loader = new FilesystemLoader($this->rootPath);
        $this->twig = new Environment($loader);
    }

    public function render(string $fileName, array $data): void
    {
        $fileName = $fileName . $this->ext;
        echo $this->twig->render($fileName, $data);
    }
}
