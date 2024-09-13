<?php

use App\Kernel\Routing\Route;
use App\Controllers\HomeController;

Route::get("/", [HomeController::class, 'index'])->middleware(['auth']);
