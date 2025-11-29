<?php

namespace App\Controllers;

class Recruitment extends BaseController
{
    public function index(): string
    {
        return view('Recruitment/index');
    }
}
