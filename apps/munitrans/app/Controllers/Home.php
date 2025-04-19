<?php

namespace App\Controllers;

use Core\CoreBaseController;

class Home extends CoreBaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
}
