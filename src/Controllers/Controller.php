<?php

namespace App\Kernel\Controllers;

use App\Kernel\Views\IView;

abstract class Controller {
    protected IView $view;

    public function __construct(IView $view)
    {
        $this->view = $view;
    }
}