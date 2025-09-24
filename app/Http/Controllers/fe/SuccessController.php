<?php

namespace App\Http\Controllers\fe;

use App\Http\Controllers\Controller;


class SuccessController extends Controller
{


    public function index()
    {

        return view('frontend.isi-kehadiran.success');
    }
}
