<?php

namespace App\Controllers;

use App\Kernel\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view->render('home', [
            'page_title' => 'Home Page',
            'page_subject' => 'Home',
        ]);
    }
}
