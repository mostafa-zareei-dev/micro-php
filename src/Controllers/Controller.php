<?php

namespace App\Kernel\Controllers;

use App\Kernel\Http\Response;
use App\Kernel\Views\IView;

abstract class Controller {
    protected IView $view;
    protected Response $response;

    public function __construct(IView $view, Response $response)
    {
        $this->view = $view;
        $this->response = $response;
    }
}