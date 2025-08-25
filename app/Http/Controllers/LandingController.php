<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function home()
    {
        return view('pages.landing.home');
    }

    public function about()
    {
        return view('pages.landing.about');
    }

    public function order()
    {
        return view('pages.landing.order');
    }

    public function form()
    {
        return view('pages.landing.form');
    }

    public function invoice()
    {
        return view('pages.landing.invoice');
    }
}
