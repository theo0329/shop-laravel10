<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function getCSRFToken()
    {
        return csrf_token();
    }
}
