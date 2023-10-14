<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

final class HomeController extends Controller
{
    public function __invoke()
    {
        return view('front.home');
    }
}