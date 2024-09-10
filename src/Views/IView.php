<?php

namespace App\Kernel\Views;

abstract class IView
{
    protected string $rootPath = ROOT_PATH . "views/";
    protected string $ext = ".php";

    public function __construct() {}

    /**
     * Renders a view.
     *
     * @param string $fileName The view file name
     * @param array $data the variables passed to the view, where the key is the variable name and the value is the variable value
     *
     * @return void
     */
    abstract function render(string $fileName, array $data): void;
}
