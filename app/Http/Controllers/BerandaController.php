<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BerandaController extends Controller
{
    //
    function index()
    {



        return view('frontend.home');
    }

    // Tampilan untuk melihat lembar daftar hadir sebelum action
    function lembar($slug)
    {
        dd($slug);
    }
}
